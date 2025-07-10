<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Edit Event</h3>

                    <form action="{{ route('event.update', $event->id_event) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $salah)
                                        <li>{{ $salah }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="px-6 py-4 mb-6 bg-zinc-100 rounded-[10px]">
                            <h3 class="mb-4 text-black font-medium">Informasi Dasar</h3>
                            {{-- Nama Event --}}
                            <div class="mb-4">
                                <label for="nama_event" class="block text-sm font-medium text-gray-700">Nama Event</label>
                                <input type="text" name="nama_event" id="nama_event"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                    value="{{ $event->nama_event }}" required>
                            </div>

                            {{-- Deskripsi --}}
                            <div class="mb-4">
                                <label for="deskripsi_event" class="block text-sm font-medium text-gray-700">Deskripsi
                                    Event</label>
                                <textarea name="deskripsi_event" id="deskripsi_event" rows="4"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>{{ $event->deskripsi_event }}</textarea>
                            </div>

                            {{-- Thumbnail --}}
                            <div class="">
                                <label for="thumbnail_event" class="block text-sm font-medium text-gray-700">Thumbnail
                                    Event</label>
                                @if ($event->thumbnail_event)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $event->thumbnail_event) }}" alt="Flyer"
                                            class="w-32 h-32 object-cover rounded">
                                        <button type="button" id="hapus-flyer"
                                            class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                            Hapus Thumbnail
                                        </button>
                                    </div>
                                @endif
                                <div id="unggah-flyer" class="mt-4 {{ $event->thumbnail_event ? 'hidden' : '' }}">
                                    <input type="file" name="thumbnail_event" id="thumbnail_event"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    <p class="text-xs text-gray-500 mt-1">Unggah flyer baru (JPG, PNG). Maksimal 2MB.</p>
                                </div>
                            </div>
                        </div>

                        <div class="px-6 py-4 mb-6 bg-zinc-100 rounded-[10px]">
                            <h3 class="mb-4 text-black font-medium">Waktu & Tempat</h3>
                            {{-- Tanggal & Waktu --}}
                            <div class="mb-4">
                                <label for="tanggal_event" class="block text-sm font-medium text-gray-700">Tanggal
                                    Event</label>
                                <input type="date" name="tanggal_event" id="tanggal_event"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                    value="{{ $event->tanggal_event }}" required>
                            </div>

                            <div class="mb-4">
                                <label for="waktu_event" class="block text-sm font-medium text-gray-700">Waktu Event</label>
                                <input type="time" name="waktu_event" id="waktu_event"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                    value="{{ \Carbon\Carbon::parse($event->waktu_event)->format('H:i') }}" required>
                            </div>
                        </div>

                        <div class="px-6 py-4 mb-6 bg-zinc-100 rounded-[10px]">
                            <h3 class="mb-4 text-black font-medium">Kategori & Detail</h3>
                            {{-- Jenis Event --}}
                            <div class="mb-4">
                                <label for="jenis_event" class="block text-sm font-medium text-gray-700">Jenis Event</label>
                                <select name="jenis_event" id="jenis_event"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                    <option value="" disabled>Pilih Jenis Event</option>
                                    <option value="seminar" {{ $event->jenis_event == 'seminar' ? 'selected' : '' }}>Seminar
                                    </option>
                                    <option value="workshop" {{ $event->jenis_event == 'workshop' ? 'selected' : '' }}>
                                        Workshop</option>
                                    <option value="bootcamp" {{ $event->jenis_event == 'bootcamp' ? 'selected' : '' }}>
                                        Bootcamp</option>
                                    <option value="pameran" {{ $event->jenis_event == 'pameran' ? 'selected' : '' }}>Pameran
                                    </option>
                                    <option value="konferensi" {{ $event->jenis_event == 'konferensi' ? 'selected' : '' }}>
                                        Konferensi</option>
                                </select>
                            </div>

                            {{-- Penyelenggara --}}
                            <div class="mb-4">
                                <label for="penyelenggara_event"
                                    class="block text-sm font-medium text-gray-700">Penyelenggara Event</label>
                                <select name="penyelenggara_event" id="penyelenggara_event"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required
                                    onchange="toggleFields()">
                                    <option value="" disabled>Pilih Penyelenggara</option>
                                    <option value="internal"
                                        {{ $event->penyelenggara_event == 'internal' ? 'selected' : '' }}>Internal</option>
                                    <option value="eksternal"
                                        {{ $event->penyelenggara_event == 'eksternal' ? 'selected' : '' }}>Eksternal
                                    </option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="nama_penyelenggara" class="block text-sm font-medium text-gray-700">Nama
                                    Penyelenggara</label>
                                <input type="text" name="nama_penyelenggara" id="nama_penyelenggara"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                    value="{{ $event->nama_penyelenggara }}" required>
                            </div>

                            {{-- Tautan (Eksternal) --}}
                            <div id="tautan-field"
                                class="mb-4 {{ $event->penyelenggara_event == 'eksternal' ? '' : 'hidden' }}">
                                <label for="tautan_event" class="block text-sm font-medium text-gray-700">Tautan
                                    Event</label>
                                <input type="url" name="tautan_event" id="tautan_event"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                    value="{{ $event->tautan_event }}">
                            </div>

                            {{-- Harga --}}
                            <div class="mb-4">
                                <label for="harga_event" class="block text-sm font-medium text-gray-700">Harga Event</label>
                                <input type="number" name="harga_event" id="harga_event"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                    value="{{ $event->harga_event }}" required onchange="toggleFields()">
                            </div>

                            {{-- Kuota (Internal saja) --}}
                            <div id="kuota-field" class="{{ $event->penyelenggara_event == 'internal' ? '' : 'hidden' }}">
                                <div class="mb-4">
                                    <label for="kuota_event" class="block text-sm font-medium text-gray-700">Kuota
                                        Event</label>
                                    <input type="number" name="kuota_event" id="kuota_event"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                        value="{{ $event->kuota_event }}">
                                </div>
                            </div>

                            {{-- Promo Fields (Internal + Harga > 0) --}}
                            <div id="promo-fields"
                                class="{{ $event->penyelenggara_event == 'internal' && $event->harga_event > 0 ? '' : 'hidden' }}">
                                <div class="mb-4">
                                    <label for="kode_promo" class="block text-sm font-medium text-gray-700">Kode Promo
                                        (Opsional)</label>
                                    <input type="text" name="kode_promo" id="kode_promo"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                        value="{{ $event->promo->kode_promo ?? '' }}">
                                </div>

                                <div class="mb-4">
                                    <label for="jenis_promo" class="block text-sm font-medium text-gray-700">Jenis
                                        Promo</label>
                                    <select name="jenis_promo" id="jenis_promo"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                        onchange="updateIncrement()">
                                        <option value="" disabled>Pilih Jenis Promo</option>
                                        <option value="Persentase"
                                            {{ optional($event->promo)->jenis_promo == 'Persentase' ? 'selected' : '' }}>
                                            Persentase</option>
                                        <option value="Potongan Harga"
                                            {{ optional($event->promo)->jenis_promo == 'Potongan Harga' ? 'selected' : '' }}>
                                            Potongan Harga</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label for="nilai_promo" class="block text-sm font-medium text-gray-700">Nilai
                                        Promo</label>
                                    <input type="number" name="nilai_promo" id="nilai_promo"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                        value="{{ optional($event->promo)->nilai_promo ?? 0 }}" step="1">
                                </div>

                                <div class="mb-4">
                                    <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700">Tanggal
                                        Mulai Promo</label>
                                    <input type="date" name="tanggal_mulai" id="tanggal_mulai"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                        value="{{ optional($event->promo)->tanggal_mulai ?? '' }}">
                                </div>

                                <div class="mb-4">
                                    <label for="tanggal_berakhir" class="block text-sm font-medium text-gray-700">Tanggal
                                        Berakhir Promo</label>
                                    <input type="date" name="tanggal_berakhir" id="tanggal_berakhir"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                        value="{{ optional($event->promo)->tanggal_berakhir ?? '' }}">
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <button type="submit"
                                class="px-6 py-3 font-medium bg-blue-500 text-white rounded hover:bg-blue-600">Simpan
                                Perubahan
                            </button>
                            <a href="{{ route('event.show', $event->id_event) }}"
                                class="px-6 py-3 font-medium bg-gray-500 text-white rounded hover:bg-gray-600">Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Script --}}
    <script>
        function toggleFields() {
            const penyelenggara = document.getElementById('penyelenggara_event').value;
            const hargaEvent = parseFloat(document.getElementById('harga_event').value || 0);
            const tautanField = document.getElementById('tautan-field');
            const kuotaField = document.getElementById('kuota-field');
            const promoFields = document.getElementById('promo-fields');

            if (penyelenggara === 'eksternal') {
                tautanField.classList.remove('hidden');
                kuotaField.classList.add('hidden');
                promoFields.classList.add('hidden');
            } else if (penyelenggara === 'internal') {
                tautanField.classList.add('hidden');
                kuotaField.classList.remove('hidden');

                if (hargaEvent > 0) {
                    promoFields.classList.remove('hidden');
                } else {
                    promoFields.classList.add('hidden');
                }
            } else {
                tautanField.classList.add('hidden');
                kuotaField.classList.add('hidden');
                promoFields.classList.add('hidden');
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

        document.addEventListener('DOMContentLoaded', function() {
            toggleFields();

            const hapusFlyerBtn = document.getElementById('hapus-flyer');
            const unggahFlyerDiv = document.getElementById('unggah-flyer');

            if (hapusFlyerBtn) {
                hapusFlyerBtn.addEventListener('click', function() {
                    if (confirm('Apakah Anda yakin ingin menghapus thumbnail ini?')) {
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'hapus_flyer';
                        hiddenInput.value = '1';

                        const form = hapusFlyerBtn.closest('form');
                        form.appendChild(hiddenInput);

                        hapusFlyerBtn.closest('div').style.display = 'none';
                        unggahFlyerDiv.classList.remove('hidden');
                    }
                });
            }
        });
    </script>
</x-app-layout>