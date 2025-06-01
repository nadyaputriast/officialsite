{{-- Navbar --}}

<nav class="bg-white shadow mb-6 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 py-3 flex gap-4">
        <a href="#" class="text-blue-700 font-semibold hover:underline">Home</a>
        @if (auth()->user()->hasRole('admin'))
            <a href="#pembayaran-section" class="text-blue-700 font-semibold hover:underline">Pembayaran Event</a>
            <a href="#user-section" class="text-blue-700 font-semibold hover:underline">User</a>
            <a href="#event-section" class="text-blue-700 font-semibold hover:underline">Event</a>
            <a href="#oprek-section" class="text-blue-700 font-semibold hover:underline">Hiring</a>
            <a href="#portofolio-section" class="text-blue-700 font-semibold hover:underline">Project</a>
            <a href="#pengabdian-section" class="text-blue-700 font-semibold hover:underline">Pengabdian</a>
            <a href="#prestasi-section" class="text-blue-700 font-semibold hover:underline">Prestasi</a>
            <a href="#sertifikasi-section" class="text-blue-700 font-semibold hover:underline">Sertifikasi</a>
            <a href="#download-section" class="text-blue-700 font-semibold hover:underline">Download</a>
        @else
            <a href="#portofolio-section" class="text-blue-700 font-semibold hover:underline">Project</a>
            <a href="#event-section" class="text-blue-700 font-semibold hover:underline">Event</a>
            <a href="#hiring-section" class="text-blue-700 font-semibold hover:underline">Hiring</a>
            <a href="#download-section" class="text-blue-700 font-semibold hover:underline">Download</a>
        @endif
    </div>
</nav>
