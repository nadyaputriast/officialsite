<?php

namespace App\Http\Controllers;

use App\Models\Download;
use App\Models\Event;
use App\Models\KategoriPortofolio;
use App\Models\Notifikasi;
use App\Models\OprekLokerProject;
use App\Models\Portofolio;
use App\Models\Pengabdian;
use App\Models\Prestasi;
use App\Models\Sertifikasi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $isAdmin = $user->hasRole('admin');

        // Get base data berdasarkan role
        $baseData = $this->getBaseData($isAdmin);

        // Get additional data
        $additionalData = $this->getAdditionalData();

        // Apply filters to main sections
        $filteredData = $this->applyFilters($request, $isAdmin);

        $paginatedEvents = $isAdmin ? $this->getPaginatedEventPayments() : null;
        
        $users = $isAdmin ? User::with('roles')->orderBy('nama_pengguna')->paginate(15) : null;

        return view('dashboard', array_merge($baseData, $additionalData, $filteredData, [
            'paginatedEvents' => $paginatedEvents,
            'users' => $users,]));
    }

    /**
     * Get base data berdasarkan role admin atau user
     */
    private function getBaseData($isAdmin)
    {
        $paginationCount = 10;

        if ($isAdmin) {
            return [
                'dataPrestasi' => Prestasi::latest()->paginate($paginationCount),
                'dataPengabdian' => Pengabdian::latest()->paginate($paginationCount),
                'dataSertifikasi' => Sertifikasi::latest()->paginate($paginationCount),
                'notifs' => []
            ];
        }

        return [
            'dataPrestasi' => Prestasi::where('status_prestasi', 1)->latest()->paginate($paginationCount),
            'dataPengabdian' => Pengabdian::where('status_pengabdian', 1)->latest()->paginate($paginationCount),
            'dataSertifikasi' => Sertifikasi::where('status_sertifikasi', 1)->latest()->paginate($paginationCount),
            'notifs' => Notifikasi::where('id_pengguna', auth()->id())->where('is_read', false)->latest()->get()
        ];
    }

    /**
     * Get additional data (top portfolio, prestasi, kategori stats)
     */
    private function getAdditionalData()
    {
        $now = Carbon::now();
        $month = $now->month;
        $year = $now->year;

        // Top Portfolio
        $topPortofolio = $this->getTopPortofolio($month, $year);
        if ($topPortofolio->isEmpty()) {
            $prev = $now->copy()->subMonth();
            $topPortofolio = $this->getTopPortofolio($prev->month, $prev->year);
        }

        // Top Prestasi
        $topPrestasi = $this->getTopPrestasi($month, $year);
        if (!$topPrestasi) {
            $prev = $now->copy()->subMonth();
            $topPrestasi = $this->getTopPrestasi($prev->month, $prev->year);
        }

        // Kategori Stats
        $kategoriStats = $this->getKategoriStats();

        return compact('topPortofolio', 'topPrestasi', 'kategoriStats');
    }

    /**
     * Apply filters untuk setiap section
     */
    private function applyFilters(Request $request, $isAdmin)
    {
        return [
            'dataPortofolio' => $this->filterPortofolio($request),
            'dataEvent' => $this->filterEvent($request, $isAdmin),
            'dataOprek' => $this->filterOprek($request, $isAdmin),
            'dataDownload' => $this->filterDownload($request, $isAdmin)
        ];
    }

    /**
     * Filter portofolio dengan search dan kategori
     */
    private function filterPortofolio(Request $request)
    {
        $query = Portofolio::with(['owner', 'taggedUsers', 'kategori', 'gambar'])
            ->where('status_portofolio', true);

        // Search filter
        if ($request->filled('search')) {
            $query->where('nama_portofolio', 'like', '%' . $request->search . '%');
        }

        // Kategori filter - multiple selection
        if ($request->filled('kategori') && is_array($request->kategori)) {
            $query->whereHas('kategori', function ($q) use ($request) {
                $q->whereIn('kategori_portofolio', $request->kategori);
            });
        }

        // Sort filter
        $this->applySorting($query, $request->get('sort', 'latest'), [
            'popular' => ['view_count', 'desc'],
            'liked' => ['banyak_upvote', 'desc'],
            'latest' => ['created_at', 'desc']
        ]);

        return $query->paginate(9);
    }

    /**
     * Filter event dengan berbagai kriteria
     */
    private function filterEvent(Request $request, $isAdmin)
    {
        $query = Event::query();

        // Base filter untuk non-admin
        if (!$isAdmin) {
            $query->where('status_event', 1);
        }

        // Search filter
        if ($request->filled('search_event')) {
            $query->where('nama_event', 'like', '%' . $request->search_event . '%');
        }

        // Date filter
        $this->applyDateFilter($query, $request->get('date_filter'), 'tanggal_event');

        // Other filters
        $this->applySimpleFilters($query, $request, [
            'penyelenggara' => 'penyelenggara_event',
            'jenis_event' => 'jenis_event'
        ]);

        // Status filter (khusus admin)
        if ($request->filled('status') && $isAdmin) {
            $status = $request->status == 'validated' ? 1 : 0;
            $query->where('status_event', $status);
        }

        return $query->latest()->paginate(9);
    }

    /**
     * Filter oprek dengan berbagai kriteria
     */
    private function filterOprek(Request $request, $isAdmin)
    {
        $query = OprekLokerProject::query();

        // Base filter untuk non-admin
        if (!$isAdmin) {
            $query->where('status_project', 1);
        }

        // Search filter
        if ($request->filled('search_oprek')) {
            $query->where('nama_project', 'like', '%' . $request->search_oprek . '%');
        }

        // Deadline filter
        $this->applyDateFilter($query, $request->get('deadline_filter'), 'deadline_project');

        // Multiple selection filters
        $this->applyMultipleFilters($query, $request, [
            'kategori_project' => 'kategori_project',
            'penyelenggara_project' => 'penyelenggara_project'
        ]);

        // Single filters
        $this->applySimpleFilters($query, $request, [
            'output_project' => 'output_project'
        ]);

        // Sort
        $this->applySorting($query, $request->get('sort_oprek', 'latest'), [
            'oldest' => ['created_at', 'asc'],
            'deadline' => ['deadline_project', 'asc'],
            'name' => ['nama_project', 'asc'],
            'latest' => ['created_at', 'desc']
        ]);

        return $query->paginate(9);
    }

    /**
     * Filter download dengan berbagai kriteria
     */
    private function filterDownload(Request $request, $isAdmin)
    {
        $query = Download::query();

        // Base filter untuk non-admin
        if (!$isAdmin) {
            $query->where('status_download', 1);
        }

        // Search filter
        if ($request->filled('search_download')) {
            $query->where('nama_download', 'like', '%' . $request->search_download . '%');
        }

        // Multiple selection filters
        $this->applyMultipleFilters($query, $request, [
            'jenis_konten' => 'jenis_konten'
        ]);

        // Status download filter
        if ($request->filled('status_download')) {
            $status = $request->status_download == 'validated' ? 1 : 0;
            $query->where('status_download', $status);
        }

        // Sort
        $this->applySorting($query, $request->get('sort_download', 'latest'), [
            'oldest' => ['created_at', 'asc'],
            'name' => ['nama_download', 'asc'],
            'latest' => ['created_at', 'desc']
        ]);

        return $query->paginate(9);
    }

    /**
     * Helper method untuk apply date filter
     */
    private function applyDateFilter($query, $filter, $column)
    {
        if (!$filter) return;

        $today = now();
        switch ($filter) {
            case 'today':
                $query->whereDate($column, $today);
                break;
            case 'this_week':
                $query->whereBetween($column, [$today->startOfWeek(), $today->endOfWeek()]);
                break;
            case 'this_month':
                $query->whereMonth($column, $today->month)
                    ->whereYear($column, $today->year);
                break;
            case 'upcoming':
                $query->where($column, '>=', $today->toDateString());
                break;
            case 'expired':
                $query->where($column, '<', $today->toDateString());
                break;
        }
    }

    /**
     * Helper method untuk apply simple filters
     */
    private function applySimpleFilters($query, Request $request, array $filters)
    {
        foreach ($filters as $requestKey => $dbColumn) {
            if ($request->filled($requestKey)) {
                $query->where($dbColumn, $request->get($requestKey));
            }
        }
    }

    /**
     * Helper method untuk apply multiple selection filters
     */
    private function applyMultipleFilters($query, Request $request, array $filters)
    {
        foreach ($filters as $requestKey => $dbColumn) {
            if ($request->filled($requestKey)) {
                $query->whereIn($dbColumn, $request->get($requestKey));
            }
        }
    }

    /**
     * Helper method untuk apply sorting
     */
    private function applySorting($query, $sortType, array $sortOptions)
    {
        if (isset($sortOptions[$sortType])) {
            [$column, $direction] = $sortOptions[$sortType];
            $query->orderBy($column, $direction);
        } else {
            $query->latest();
        }
    }

    /**
     * Get top portfolio berdasarkan view count
     */
    private function getTopPortofolio($month, $year)
    {
        return Portofolio::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->orderByDesc('view_count')
            ->take(3)
            ->get();
    }

    /**
     * Get kategori statistics
     */
    private function getKategoriStats()
    {
        $kategoriEnum = [
            'UI/UX Design',
            'Website Development',
            'Mobile Development',
            'Game Development',
            'Internet of Things',
            'ML/AI',
            'Blockchain',
            'Cyber Security'
        ];

        $kategoriStats = [];
        foreach ($kategoriEnum as $kategori) {
            $count = KategoriPortofolio::where('kategori_portofolio', $kategori)->count();
            $kategoriStats[] = [
                'nama' => $kategori,
                'jumlah' => $count
            ];
        }

        return $kategoriStats;
    }

    /**
     * Mendapatkan prestasi terbaik dengan logika berjenjang
     */
    private function getTopPrestasi($month, $year)
    {
        $tingkatanPrioritas = ['Internasional', 'Nasional', 'Regional'];

        foreach ($tingkatanPrioritas as $tingkatan) {
            $prestasi = Prestasi::where('status_prestasi', 1)
                ->where('tingkatan_prestasi', $tingkatan)
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->with('owner')
                ->latest()
                ->first();

            if ($prestasi) {
                return $prestasi;
            }
        }

        return null;
    }

    private function getPaginatedEventPayments()
    {
        // Ambil semua pembayaran beserta relasi event dan user
        $allPayments = \App\Models\PembayaranEvent::with(['registration.event', 'registration.user'])
            ->get()
            ->groupBy(function ($item) {
                return $item->registration->event->id_event ?? 0;
            });

        // Paginasi manual per event
        $perPage = 20;
        $currentPage = request('page', 1);
        $events = $allPayments->values();
        $paginatedEvents = new \Illuminate\Pagination\LengthAwarePaginator(
            $events->forPage($currentPage, $perPage),
            $events->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return $paginatedEvents;
    }
}
