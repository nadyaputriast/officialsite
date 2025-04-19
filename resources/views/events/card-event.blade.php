<div class="border border-gray-200 rounded p-4 mb-4 shadow-sm hover:shadow-md transition">
    <h4 class="text-xl font-semibold text-gray-800">{{ $event->nama_event }}</h4>
    <p class="text-sm text-gray-500 mb-1">Diselenggarakan oleh: <span class="font-medium">{{ $event->nama_penyelenggara }}</span></p>
    <p class="mb-2 text-gray-700">{{ $event->deskripsi_event }}</p>
    <p class="text-sm text-gray-600 mb-2">
        Tanggal Event: <span class="font-medium">{{ \Carbon\Carbon::parse($event->tanggal_event)->format('d M Y') }}</span>
    </p>
    <a href="{{ $event->tautan_event }}" class="inline-block mt-1 text-blue-600 hover:text-blue-800 hover:underline" target="_blank" rel="noopener noreferrer">
        Lihat Detail
    </a>
</div>