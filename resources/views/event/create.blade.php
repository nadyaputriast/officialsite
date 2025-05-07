<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Buat Event Baru</h3>
                    <form action="{{ route('event.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $salah)
                                        <li>{{ $salah }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (Session::has('error'))
                            {{ Session::get('error') }}
                        @endif

                        {{-- Nama Event --}}
                        <div class="mb-4">
                            <label for="nama_event" class="block text-sm font-medium text-gray-700">Nama Event</label>
                            <input type="text" name="nama_event" id="nama_event"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>

                        {{-- Jenis Event --}}
                        <div class="mb-4">
                            <label for="jenis_event" class="block text-sm font-medium text-gray-700">Jenis Event</label>
                            <select name="jenis_event" id="jenis_event"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="" disabled selected>Pilih Jenis Event</option>
                                <option value="seminar">Seminar</option>
                                <option value="workshop">Workshop</option>
                                <option value="bootcamp">Bootcamp</option>
                                <option value="pameran">Pameran</option>
                                <option value="konferensi">Konferensi</option>
                            </select>
                        </div>

                        {{-- Deskripsi Event --}}
                        <div class="mb-4">
                            <label for="deskripsi_event" class="block text-sm font-medium text-gray-700">Deskripsi
                                Event</label>
                            <textarea name="deskripsi_event" id="deskripsi_event" rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required></textarea>
                        </div>

                        {{-- Tanggal Event --}}
                        <div class="mb-4">
                            <label for="tanggal_event" class="block text-sm font-medium text-gray-700">Tanggal
                                Event</label>
                            <input type="date" name="tanggal_event" id="tanggal_event"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>

                        {{-- Waktu Event --}}
                        <div class="mb-4">
                            <label for="waktu_event" class="block text-sm font-medium text-gray-700">Waktu Event</label>
                            <input type="time" name="waktu_event" id="waktu_event"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>

                        {{-- Penyelenggara Event --}}
                        <div class="mb-4">
                            <label for="penyelenggara_event"
                                class="block text-sm font-medium text-gray-700">Penyelenggara Event</label>
                            <select name="penyelenggara_event" id="penyelenggara_event"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required
                                onchange="toggleFields()">
                                <option value="" disabled selected>Pilih Penyelenggara</option>
                                <option value="internal">Internal</option>
                                <option value="eksternal">Eksternal</option>
                            </select>
                        </div>

                        {{-- Nama Penyelenggara --}}
                        <div class="mb-4">
                            <label for="nama_penyelenggara" class="block text-sm font-medium text-gray-700">Nama
                                Penyelenggara</label>
                            <input type="text" name="nama_penyelenggara" id="nama_penyelenggara"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>

                        {{-- Tautan Event (Hanya untuk Eksternal) --}}
                        <div id="tautan-field" class="mb-4 hidden">
                            <label for="tautan_event" class="block text-sm font-medium text-gray-700">Tautan
                                Event</label>
                            <input type="url" name="tautan_event" id="tautan_event"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>

                        {{-- Harga Event --}}
                        <div class="mb-4">
                            <label for="harga_event" class="block text-sm font-medium text-gray-700">Harga Event</label>
                            <input type="number" name="harga_event" id="harga_event"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required
                                onchange="toggleFields()">
                        </div>

                        {{-- Field Tambahan untuk Internal --}}
                        <div id="internal-fields" class="hidden">
                            {{-- Kuota Event --}}
                            <div class="mb-4">
                                <label for="kuota_event" class="block text-sm font-medium text-gray-700">Kuota
                                    Event</label>
                                <input type="number" name="kuota_event" id="kuota_event"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            {{-- Promo --}}
                            <div class="mb-4">
                                <label for="kode_promo" class="block text-sm font-medium text-gray-700">Kode Promo
                                    (Opsional)</label>
                                <input type="text" name="kode_promo" id="kode_promo"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            {{-- Jenis Promo --}}
                            <div class="mb-4">
                                <label for="jenis_promo" class="block text-sm font-medium text-gray-700">Jenis
                                    Promo</label>
                                <select name="jenis_promo" id="jenis_promo"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                    onchange="updateIncrement()">
                                    <option value="" disabled selected>Pilih Jenis Promo</option>
                                    <option value="Persentase">Persentase</option>
                                    <option value="Potongan Harga">Potongan Harga</option>
                                </select>
                            </div>

                            {{-- Nilai Promo --}}
                            <div class="mb-4">
                                <label for="nilai_promo" class="block text-sm font-medium text-gray-700">Nilai
                                    Promo</label>
                                <input type="number" name="nilai_promo" id="nilai_promo" value="0"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" step="1">
                            </div>

                            {{-- Masa Berlaku Promo --}}
                            <div class="mb-4">
                                <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700">Tanggal
                                    Mulai Promo</label>
                                <input type="date" name="tanggal_mulai" id="tanggal_mulai"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            <div class="mb-4">
                                <label for="tanggal_berakhir" class="block text-sm font-medium text-gray-700">Tanggal
                                    Berakhir Promo</label>
                                <input type="date" name="tanggal_berakhir" id="tanggal_berakhir"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                        </div>

                        {{-- Thumbnail Event --}}
                        <div class="mb-4">
                            <label for="thumbnail_event" class="block text-sm font-medium text-gray-700">Thumbnail
                                Event</label>
                            <input type="file" name="thumbnail_event" id="thumbnail_event"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>

                        {{-- Submit Button --}}
                        <button type="submit"
                            class="px-4 py-2 bg-blue-500 text-black rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                            Simpan
                        </button>
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 text-black rounded">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleFields() {
            const penyelenggara = document.getElementById('penyelenggara_event').value;
            const hargaEvent = parseFloat(document.getElementById('harga_event').value || 0);
            const tautanField = document.getElementById('tautan-field');
            const internalFields = document.getElementById('internal-fields');

            if (penyelenggara === 'eksternal') {
                tautanField.classList.remove('hidden');
                internalFields.classList.add('hidden');
            } else if (penyelenggara === 'internal' && hargaEvent > 0) {
                tautanField.classList.add('hidden');
                internalFields.classList.remove('hidden');
            } else {
                tautanField.classList.add('hidden');
                internalFields.classList.add('hidden');
            }
        }

        function updateIncrement() {
            const jenisPromo = document.getElementById('jenis_promo').value;
            const nilaiPromo = document.getElementById('nilai_promo');

            if (jenisPromo === 'Persentase') {
                nilaiPromo.step = 1;
                nilaiPromo.value = 0;
            } else if (jenisPromo === 'Potongan Harga') {
                nilaiPromo.step = 1000;
                nilaiPromo.value = 0;
            }
        }
    </script>
</x-app-layout>
