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
use Illuminate\Support\Facades\Mail;
use App\Mail\UserValidatedMail;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $isAdmin = $user && $user->hasRole('admin');

        // Get base data berdasarkan role
        $baseData = $this->getBaseData($isAdmin, $request);

        // Get additional data
        $additionalData = $this->getAdditionalData();

        // Apply filters to main sections
        $filteredData = $this->applyFilters($request, $isAdmin);

        // Get paginated events with request for filtering
        $paginatedEvents = $isAdmin ? $this->getPaginatedEventPayments($request) : null;

        // Get users with filtering and search
        $users = collect([]);
        if ($isAdmin) {
            $usersQuery = User::with('roles')->orderBy('nama_pengguna');

            // Apply search filter
            if ($request->filled('search_user')) {
                $usersQuery->where('nama_pengguna', 'like', '%' . $request->search_user . '%');
            }

            // Apply status validasi filter
            if ($request->filled('status_validasi')) {
                $usersQuery->where('status_validasi', $request->status_validasi);
            }

            // Apply role filter
            if ($request->filled('role_filter')) {
                $usersQuery->whereHas('roles', function ($q) use ($request) {
                    $q->where('name', $request->role_filter);
                });
            }

            $events = Event::with('promo')->get();
            $users = $usersQuery->paginate(9)->appends($request->all());
        }

        return view('dashboard', array_merge(
            $baseData,
            $additionalData,
            $filteredData,
            [
                'paginatedEvents' => $paginatedEvents,
                'users' => $users,
                'events' => $events ?? [],
            ]
        ));
    }

    /**
     * Get base data berdasarkan role admin atau user
     */
    private function getBaseData($isAdmin)
    {
        $paginationCount = 10;

        if ($isAdmin) {
            return [
                'dataPrestasi' => $this->filterPrestasiForAdmin(request()),
                'dataPengabdian' => $this->filterPengabdianForAdmin(request()),
                'dataSertifikasi' => $this->filterSertifikasiForAdmin(request()),
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

    private function filterPengabdianForAdmin(Request $request)
    {
        $query = Pengabdian::with(['owner', 'taggedUsers']);

        // Search by judul_pengabdian
        if ($request->filled('search_pengabdian')) {
            $searchTerm = $request->search_pengabdian;
            $query->where('judul_pengabdian', 'LIKE', '%' . $searchTerm . '%');
        }

        // Filter by status_pengabdian
        if ($request->filled('status_pengabdian')) {
            $query->where('status_pengabdian', $request->status_pengabdian);
        }

        // Apply sorting
        $sortType = $request->get('sort', 'latest');
        switch ($sortType) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'name_asc':
                $query->orderBy('judul_pengabdian', 'asc');
                break;
            case 'latest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        // Paginate with query parameters preserved
        return $query->paginate(10)->appends($request->query());
    }

    /**
     * Filter prestasi untuk admin
     */
    private function filterPrestasiForAdmin(Request $request)
    {
        $query = Prestasi::with(['owner', 'dokumentasi']); // Load relationships

        // Search by nama_prestasi
        if ($request->filled('search_prestasi')) {
            $searchTerm = $request->search_prestasi;
            $query->where('nama_prestasi', 'LIKE', '%' . $searchTerm . '%');
        }

        // Filter by status_prestasi
        if ($request->filled('status_prestasi')) {
            $query->where('status_prestasi', $request->status_prestasi);
        }

        // Filter by tingkatan_prestasi
        if ($request->filled('tingkatan_prestasi')) {
            $query->where('tingkatan_prestasi', $request->tingkatan_prestasi);
        }

        // Filter by jenis_prestasi
        if ($request->filled('jenis_prestasi')) {
            $query->where('jenis_prestasi', $request->jenis_prestasi);
        }

        // Apply sorting
        $sortType = $request->get('sort_prestasi', 'latest');
        switch ($sortType) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'name_asc':
                $query->orderBy('nama_prestasi', 'asc');
                break;
            case 'tingkatan_desc':
                $query->orderByRaw("FIELD(tingkatan_prestasi, 'Internasional', 'Nasional', 'Regional')");
                break;
            case 'latest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        // Paginate with query parameters preserved
        return $query->paginate(10)->appends($request->query());
    }

    /**
     * Filter sertifikasi untuk admin
     */
    private function filterSertifikasiForAdmin(Request $request)
    {
        $query = Sertifikasi::with(['owner']);

        // Search by nama_sertifikasi
        if ($request->filled('search_sertifikasi')) {
            $query->where('nama_sertifikasi', 'LIKE', '%' . $request->search_sertifikasi . '%');
        }

        // Filter by status
        if ($request->filled('status_sertifikasi')) {
            $query->where('status_sertifikasi', $request->status_sertifikasi);
        }

        // Filter by masa_berlaku
        if ($request->filled('masa_berlaku_filter')) {
            $masaBerlakuFilter = $request->masa_berlaku_filter;

            switch ($masaBerlakuFilter) {
                case 'seumur_hidup':
                    $query->where('masa_berlaku', 0);
                    break;
                case 'kurang_dari_5':
                    $query->where('masa_berlaku', '<=', 5);
                    break;
                case 'kurang_dari_10':
                    $query->where('masa_berlaku', '>', 5, 'and', 'masa_berlaku', '<=', 10);
                    break;
                case '10+':
                    $query->where('masa_berlaku', '>=', 10);
                    break;
                default:
                    // For numeric values (alternative version)
                    if (is_numeric($masaBerlakuFilter)) {
                        $query->where('masa_berlaku', (int)$masaBerlakuFilter);
                    } elseif ($masaBerlakuFilter === '5+') {
                        $query->where('masa_berlaku', '>', 5);
                    }
                    break;
            }
        }

        // Apply sorting
        $sortType = $request->get('sort_sertifikasi', 'latest');
        switch ($sortType) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'name_asc':
                $query->orderBy('nama_sertifikasi', 'asc');
                break;
            case 'latest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        return $query->paginate(10)->appends($request->query());
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

        $topPrestasi = $this->getTopPrestasi($month, $year);
        if ($topPrestasi->isEmpty()) {
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
            'dataPortofolio' => $this->filterPortofolio($request, $isAdmin),
            'dataEvent' => $this->filterEvent($request, $isAdmin),
            'dataOprek' => $this->filterOprek($request, $isAdmin),
            'dataDownload' => $this->filterDownload($request, $isAdmin)
        ];
    }

    /**
     * Filter portofolio dengan search dan kategori
     */
    private function filterPortofolio(Request $request, $isAdmin)
    {
        $query = Portofolio::with(['owner', 'taggedUsers', 'kategori', 'gambar']); // Add relationships if needed

        // Base filter untuk non-admin
        if (!$isAdmin) {
            $query->where('status_portofolio', 1);
        }
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

        // Filter berdasarkan view count range
        if ($request->filled('view_count_filter')) {
            switch ($request->view_count_filter) {
                case '0-100':
                    $query->whereBetween('view_count', [0, 100]);
                    break;
                case '100-500':
                    $query->whereBetween('view_count', [100, 500]);
                    break;
                case '500-1000':
                    $query->whereBetween('view_count', [500, 1000]);
                    break;
                case '1000+':
                    $query->where('view_count', '>', 1000);
                    break;
            }
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
        $query = Event::with(['owner']); // Add relationships if needed

        // Base filter untuk non-admin
        if (!$isAdmin) {
            $query->where('status_event', 1);
        }

        // Search filter - nama event
        if ($request->filled('search_event')) {
            $query->where('nama_event', 'like', '%' . $request->search_event . '%');
        }

        // Filter status event (untuk admin)
        if ($request->filled('status_event') && $isAdmin) {
            $query->where('status_event', $request->status_event);
        }

        // Filter penyelenggara
        if ($request->filled('penyelenggara_event')) {
            $query->where('penyelenggara_event', $request->penyelenggara_event);
        }

        // Filter jenis event
        if ($request->filled('jenis_event')) {
            $query->where('jenis_event', $request->jenis_event);
        }

        // Date filter
        $this->applyDateFilter($query, $request->get('date_filter'), 'tanggal_event');

        // Sort filter
        $this->applyEventSorting($query, $request->get('sort_event', 'latest'));

        return $query->paginate(12)->appends($request->query());
    }

    /**
     * Apply sorting khusus untuk event
     */
    private function applyEventSorting($query, $sortType)
    {
        switch ($sortType) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'name_asc':
                $query->orderBy('nama_event', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('nama_event', 'desc');
                break;
            case 'date_asc':
                $query->orderBy('tanggal_event', 'asc');
                break;
            case 'price_asc':
                $query->orderBy('harga_event', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('harga_event', 'desc');
                break;
            case 'latest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
    }

    /**
     * Filter oprek dengan berbagai kriteria
     */
    private function filterOprek(Request $request, $isAdmin)
    {
        $query = OprekLokerProject::with(['owner']);

        // Base filter untuk non-admin
        if (!$isAdmin) {
            $query->where('status_project', 1);
        }

        // Search filter - nama project
        if ($request->filled('search_oprek')) {
            $query->where('nama_project', 'like', '%' . $request->search_oprek . '%');
        }

        // Filter status project (untuk admin)
        if ($request->filled('status_project') && $isAdmin) {
            $query->where('status_project', $request->status_project);
        }

        // Filter kategori project
        if ($request->filled('kategori_project')) {
            if (is_array($request->kategori_project)) {
                $query->whereIn('kategori_project', $request->kategori_project);
            } else {
                $query->where('kategori_project', $request->kategori_project);
            }
        }

        // Filter output project
        if ($request->filled('output_project')) {
            if (is_array($request->output_project)) {
                $query->whereIn('output_project', $request->output_project);
            } else {
                $query->where('output_project', $request->output_project);
            }
        }

        // Filter penyelenggara project
        if ($request->filled('penyelenggara_project')) {
            if (is_array($request->penyelenggara_project)) {
                $query->whereIn('penyelenggara_project', $request->penyelenggara_project);
            } else {
                $query->where('penyelenggara_project', $request->penyelenggara_project);
            }
        }

        // Date filter for deadline
        $this->applyDateFilter($query, $request->get('deadline_filter'), 'deadline_project');

        // Sort filter
        $this->applyOprekSorting($query, $request->get('sort_oprek', 'latest'));

        return $query->paginate(12)->appends($request->query());
    }

    /**
     * Apply sorting khusus untuk oprek
     */
    private function applyOprekSorting($query, $sortType)
    {
        switch ($sortType) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'name_asc':
                $query->orderBy('nama_project', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('nama_project', 'desc');
                break;
            case 'deadline_asc':
                $query->orderBy('deadline_project', 'asc');
                break;
            case 'deadline_desc':
                $query->orderBy('deadline_project', 'desc');
                break;
            case 'latest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
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
        $prestasiList = [];
        $maxSlots = 3;

        // Ambil prestasi berdasarkan prioritas tingkatan
        foreach ($tingkatanPrioritas as $tingkatan) {
            if (count($prestasiList) >= $maxSlots) {
                break; // Sudah cukup 3 slot
            }

            $remainingSlots = $maxSlots - count($prestasiList);

            $prestasi = Prestasi::where('status_prestasi', 1)
                ->where('tingkatan_prestasi', $tingkatan)
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->with('owner')
                ->latest()
                ->take($remainingSlots) // Ambil sebanyak slot yang tersisa
                ->get();

            if ($prestasi->isNotEmpty()) {
                $prestasiList = array_merge($prestasiList, $prestasi->toArray());
            }
        }

        // Jika masih kurang dari 3, ambil prestasi tambahan dari bulan sebelumnya
        if (count($prestasiList) < $maxSlots) {
            $existingIds = collect($prestasiList)->pluck('id_prestasi')->toArray();
            $remainingSlots = $maxSlots - count($prestasiList);

            $additionalPrestasi = Prestasi::where('status_prestasi', 1)
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->whereNotIn('id_prestasi', $existingIds)
                ->with('owner')
                ->latest()
                ->take($remainingSlots)
                ->get();

            if ($additionalPrestasi->isNotEmpty()) {
                $prestasiList = array_merge($prestasiList, $additionalPrestasi->toArray());
            }
        }

        return collect($prestasiList);
    }

    private function getPaginatedEventPayments(Request $request)
    {
        $query = \App\Models\PembayaranEvent::with(['registration.event', 'registration.user']);

        // Filter nama event
        if ($request->filled('search_event')) {
            $query->where(function ($q) use ($request) {
                $q->whereHas('registration.event', function ($q2) use ($request) {
                    $q2->where('nama_event', 'like', '%' . $request->search_event . '%');
                })
                    ->orWhereHas('registration.user', function ($q2) use ($request) {
                        $q2->where('nama_pengguna', 'like', '%' . $request->search_event . '%');
                    });
            });
        }

        // Filter status validasi
        if ($request->filled('status_validasi')) {
            $query->where('status_validasi', $request->status_validasi);
        }

        // Urutkan terbaru
        $query->latest();

        // PAGINATE langsung, JANGAN groupBy!
        return $query->paginate(15)->appends($request->all());
    }

    public function validasiUser(User $user)
    {
        // Hanya admin yang boleh validasi
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        // Update status validasi user
        $user->status_validasi = true;
        $user->save();

        // Kirim email notifikasi ke user
        Mail::to($user->email)->send(new UserValidatedMail($user));

        return back()->with('success', 'User berhasil divalidasi dan email notifikasi telah dikirim.');
    }
}
