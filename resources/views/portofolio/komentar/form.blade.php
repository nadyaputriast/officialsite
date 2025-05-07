<form action="{{ route('komentar.store', $portofolio->id_portofolio) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-4">
        <label for="komentar" class="block text-sm font-medium text-gray-700">Komentar</label>
        <textarea name="komentar" id="komentar" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required></textarea>
    </div>
    <div class="mb-4">
        <label for="gambar" class="block text-sm font-medium text-gray-700">Lampiran Gambar (Opsional)</label>
        <input type="file" name="gambar[]" id="gambar" multiple class="mt-1 block w-full">
    </div>
    <button type="submit" class="px-4 py-2 bg-blue-500 text-black rounded hover:bg-blue-600">Kirim Komentar</button>
</form>