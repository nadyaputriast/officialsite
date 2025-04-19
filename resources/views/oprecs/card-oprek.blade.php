<div class="border border-gray-200 rounded p-4 mb-4 shadow-sm hover:shadow-md transition">
    <h4 class="text-xl font-semibold text-gray-800">{{ $oprek->nama_project }}</h4>
    <p class="text-sm text-gray-500 mb-1">Diselenggarakan oleh: <span class="font-medium">{{ $oprek->penyelenggara }}</span></p>
    <p class="mb-2 text-gray-700">{{ $oprek->deskripsi_project }}</p>
    <p class="text-sm text-gray-600 mb-2">
        Deadline: <span class="font-medium">{{ \Carbon\Carbon::parse($oprek->deadline_project)->format('d M Y') }}</span>
    </p>
    <a href="{{ $oprek->tautan_oprek }}" class="inline-block mt-1 text-blue-600 hover:text-blue-800 hover:underline" target="_blank" rel="noopener noreferrer">
        Lihat Detail
    </a>
</div>