<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Buat Event Baru</h3>
                    <form action="{{ route('event.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if ($errors->any())
                            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
                                <ul class="list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (Session::has('error'))
                            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
                                {{ Session::get('error') }}
                            </div>
                        @endif

                        {{-- Nama Event --}}
                        <div class="mb-4">
                            <label for="nama_event" class="block text-sm font-medium text-gray-700">Nama Event <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_event" id="nama_event"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                value="{{ old('nama_event') }}" required>
                        </div>

                        {{-- Jenis Event --}}
                        <div class="mb-4">
                            <label for="jenis_event" class="block text-sm font-medium text-gray-700">Jenis Event <span class="text-red-500">*</span></label>
                            <select name="jenis_event" id="jenis_event"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                <option value="" disabled {{ !old('jenis_event') ? 'selected' : '' }}>Pilih Jenis Event</option>
                                <option value="seminar" {{ old('jenis_event') == 'seminar' ? 'selected' : '' }}>Seminar</option>
                                <option value="workshop" {{ old('jenis_event') == 'workshop' ? 'selected' : '' }}>Workshop</option>
                                <option value="bootcamp" {{ old('jenis_event') == 'bootcamp' ? 'selected' : '' }}>Bootcamp</option>
                                <option value="pameran" {{ old('jenis_event') == 'pameran' ? 'selected' : '' }}>Pameran</option>
                                <option value="konferensi" {{ old('jenis_event') == 'konferensi' ? 'selected' : '' }}>Konferensi</option>
                            </select>
                        </div>

                        {{-- Deskripsi Event --}}
                        <div class="mb-4">
                            <label for="deskripsi_event" class="block text-sm font-medium text-gray-700">Deskripsi Event <span class="text-red-500">*</span></label>
                            <textarea name="deskripsi_event" id="deskripsi_event" rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                required>{{ old('deskripsi_event') }}</textarea>
                        </div>

                        {{-- Tanggal Event --}}
                        <div class="mb-4">
                            <label for="tanggal_event" class="block text-sm font-medium text-gray-700">Tanggal Event <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_event" id="tanggal_event"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                value="{{ old('tanggal_event') }}" min="{{ date('Y-m-d') }}" required>
                        </div>

                        {{-- Waktu Event --}}
                        <div class="mb-4">
                            <label for="waktu_event" class="block text-sm font-medium text-gray-700">Waktu Event <span class="text-red-500">*</span></label>
                            <input type="time" name="waktu_event" id="waktu_event"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                value="{{ old('waktu_event') }}" required>
                        </div>

                        {{-- Penyelenggara Event --}}
                        <div class="mb-4">
                            <label for="penyelenggara_event" class="block text-sm font-medium text-gray-700">Penyelenggara Event <span class="text-red-500">*</span></label>
                            <select name="penyelenggara_event" id="penyelenggara_event"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                required onchange="toggleFields()">
                                <option value="" disabled {{ !old('penyelenggara_event') ? 'selected' : '' }}>Pilih Penyelenggara</option>
                                <option value="internal" {{ old('penyelenggara_event') == 'internal' ? 'selected' : '' }}>Internal</option>
                                <option value="eksternal" {{ old('penyelenggara_event') == 'eksternal' ? 'selected' : '' }}>Eksternal</option>
                            </select>
                            <p class="mt-1 text-xs text-gray-500">
                                • <strong>Internal:</strong> Event dikelola oleh organisasi internal<br>
                                • <strong>Eksternal:</strong> Event dikelola oleh pihak luar (redirect ke link eksternal)
                            </p>
                        </div>

                        {{-- Nama Penyelenggara --}}
                        <div class="mb-4">
                            <label for="nama_penyelenggara" class="block text-sm font-medium text-gray-700">Nama Penyelenggara <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_penyelenggara" id="nama_penyelenggara"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                value="{{ old('nama_penyelenggara') }}" required>
                        </div>

                        {{-- Tautan Event (Hanya untuk Eksternal) --}}
                        <div id="tautan-field" class="mb-4 {{ old('penyelenggara_event') == 'eksternal' ? '' : 'hidden' }}">
                            <label for="tautan_event" class="block text-sm font-medium text-gray-700">
                                Tautan Event <span class="text-red-500">* (untuk eksternal)</span>
                            </label>
                            <input type="url" name="tautan_event" id="tautan_event"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                value="{{ old('tautan_event') }}" placeholder="https://example.com/event-registration">
                            <p class="mt-1 text-xs text-gray-500">Link pendaftaran event eksternal (contoh: Google Form, Eventbrite, dll)</p>
                        </div>

                        {{-- Harga Event --}}
                        <div class="mb-4">
                            <label for="harga_event" class="block text-sm font-medium text-gray-700">Harga Event <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute left-3 top-2 text-gray-500">Rp</span>
                                <input type="number" name="harga_event" id="harga_event"
                                    class="mt-1 block w-full pl-8 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                    value="{{ old('harga_event', 0) }}" min="0" step="1000" required onchange="toggleFields()">
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Masukkan 0 jika event gratis</p>
                        </div>

                        <div id="internal-fields" class="{{ old('penyelenggara_event') == 'internal' ? '' : 'hidden' }}">
                            <div class="mb-4">
                                <label for="kuota_event" class="block text-sm font-medium text-gray-700">
                                    Kuota Event <span class="text-red-500">* (untuk internal)</span>
                                </label>
                                <input type="number" name="kuota_event" id="kuota_event"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    value="{{ old('kuota_event') }}" min="1" placeholder="Contoh: 100">
                                <p class="mt-1 text-xs text-gray-500">Jumlah maksimal peserta yang dapat mendaftar</p>
                            </div>

                            <div id="promo-section" class="{{ old('harga_event', 0) > 0 ? '' : 'hidden' }}">
                                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-4">
                                    <h4 class="font-medium text-blue-800 mb-2">Pengaturan Promo (Opsional)</h4>
                                    <p class="text-sm text-blue-700">Atur promo untuk event berbayar</p>
                                </div>

                                <div class="mb-4">
                                    <label for="kode_promo" class="block text-sm font-medium text-gray-700">Kode Promo (Opsional)</label>
                                    <input type="text" name="kode_promo" id="kode_promo"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        value="{{ old('kode_promo') }}" placeholder="DISKON2024" maxlength="50">
                                    <p class="mt-1 text-xs text-gray-500">Kode unik untuk promo (contoh: DISKON2024, EARLY50)</p>
                                </div>

                                {{-- Nilai Promo --}}
                                <div class="mb-4">
                                    <label for="nilai_promo" class="block text-sm font-medium text-gray-700">Nilai Promo</label>
                                    <div class="flex gap-2">
                                        <input type="number" name="nilai_promo" id="nilai_promo" 
                                            class="flex-1 mt-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                            value="{{ old('nilai_promo', 0) }}" min="0" step="1" onchange="calculatePromo()">
                                        <span id="promo-unit" class="mt-1 px-3 py-2 bg-gray-100 border border-gray-300 rounded-md text-sm">%</span>
                                    </div>
                                    <div id="promo-info" class="mt-2 text-sm text-gray-600 hidden"></div>
                                </div>

                                {{-- Masa Berlaku Promo --}}
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700">Tanggal Mulai Promo</label>
                                        <input type="date" name="tanggal_mulai" id="tanggal_mulai"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                            value="{{ old('tanggal_mulai') }}">
                                    </div>
                                    <div>
                                        <label for="tanggal_berakhir" class="block text-sm font-medium text-gray-700">Tanggal Berakhir Promo</label>
                                        <input type="date" name="tanggal_berakhir" id="tanggal_berakhir"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                            value="{{ old('tanggal_berakhir') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Thumbnail Event --}}
                        <div class="mb-6">
                            <label for="thumbnail_event" class="block text-sm font-medium text-gray-700">
                                Thumbnail Event <span class="text-red-500">*</span>
                            </label>
                            <input type="file" name="thumbnail_event" id="thumbnail_event"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                accept="image/*" required>
                            <p class="mt-1 text-xs text-gray-500">Upload gambar thumbnail (JPG, PNG, GIF, maksimal 2MB)</p>
                        </div>

                        {{-- Submit Buttons --}}
                        <div class="flex gap-4">
                            <button type="submit"
                                class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 font-medium">
                                Simpan Event
                            </button>
                            <a href="{{ route('dashboard') }}" 
                               class="px-6 py-3 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50 font-medium">
                                Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            toggleFields();
            calculatePromo();
        });

        function toggleFields() {
            const penyelenggara = document.getElementById('penyelenggara_event').value;
            const hargaEvent = parseFloat(document.getElementById('harga_event').value || 0);
            
            const tautanField = document.getElementById('tautan-field');
            const internalFields = document.getElementById('internal-fields');
            const promoSection = document.getElementById('promo-section');
            const kuotaInput = document.getElementById('kuota_event');
            const tautanInput = document.getElementById('tautan_event');

            console.log('Toggle Fields:', {penyelenggara, hargaEvent});

            if (penyelenggara === 'eksternal') {
                tautanField.classList.remove('hidden');
                internalFields.classList.add('hidden');
                
                tautanInput.required = true;
                kuotaInput.required = false;
                
            } else if (penyelenggara === 'internal') {
                tautanField.classList.add('hidden');
                internalFields.classList.remove('hidden');
                
                tautanInput.required = false;
                kuotaInput.required = true;
                
                if (hargaEvent > 0) {
                    promoSection.classList.remove('hidden');
                } else {
                    promoSection.classList.add('hidden');
                    clearPromoFields();
                }
            } else {
                tautanField.classList.add('hidden');
                internalFields.classList.add('hidden');
                
                tautanInput.required = false;
                kuotaInput.required = false;
            }

            updateValidationHints();
        }

        function calculatePromo() {
            const nilaiPromo = parseFloat(document.getElementById('nilai_promo').value || 0);
            const hargaEvent = parseFloat(document.getElementById('harga_event').value || 0);
            const promoUnit = document.getElementById('promo-unit');
            const promoInfo = document.getElementById('promo-info');

            if (nilaiPromo === 0 || hargaEvent === 0) {
                promoInfo.classList.add('hidden');
                return;
            }

            let jenisPromo, hargaPromo, penghematan;

            if (nilaiPromo <= 100) {
                jenisPromo = 'Persentase';
                hargaPromo = Math.max(0, hargaEvent * (100 - nilaiPromo) / 100);
                penghematan = hargaEvent - hargaPromo;
                promoUnit.textContent = '%';
            } else {
                jenisPromo = 'Potongan Harga';
                hargaPromo = Math.max(0, hargaEvent - nilaiPromo);
                penghematan = Math.min(nilaiPromo, hargaEvent);
                promoUnit.textContent = 'Rp';
            }

            // Show promo calculation
            promoInfo.innerHTML = `
                <div class="p-3 bg-green-50 border border-green-200 rounded">
                    <strong>Preview Promo:</strong><br>
                    Jenis: ${jenisPromo}<br>
                    Harga Asli: Rp${hargaEvent.toLocaleString('id-ID')}<br>
                    Penghematan: Rp${penghematan.toLocaleString('id-ID')}<br>
                    <span class="text-green-700 font-semibold">Harga Promo: Rp${hargaPromo.toLocaleString('id-ID')}</span>
                </div>
            `;
            promoInfo.classList.remove('hidden');
        }

        function clearPromoFields() {
            document.getElementById('kode_promo').value = '';
            document.getElementById('nilai_promo').value = 0;
            document.getElementById('tanggal_mulai').value = '';
            document.getElementById('tanggal_berakhir').value = '';
            document.getElementById('promo-info').classList.add('hidden');
        }

        function updateValidationHints() {
            const penyelenggara = document.getElementById('penyelenggara_event').value;
            
            console.log('Validation updated for:', penyelenggara);
        }

        document.querySelector('form').addEventListener('submit', function(e) {
            const penyelenggara = document.getElementById('penyelenggara_event').value;
            const kuotaEvent = document.getElementById('kuota_event').value;
            const tautanEvent = document.getElementById('tautan_event').value;

            if (penyelenggara === 'internal' && (!kuotaEvent || kuotaEvent <= 0)) {
                e.preventDefault();
                alert('Kuota event harus diisi untuk event internal!');
                document.getElementById('kuota_event').focus();
                return;
            }

            if (penyelenggara === 'eksternal' && !tautanEvent) {
                e.preventDefault();
                alert('Tautan event harus diisi untuk event eksternal!');
                document.getElementById('tautan_event').focus();
                return;
            }

            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.innerHTML = 'Menyimpan...';
            submitBtn.disabled = true;
        });

        document.getElementById('harga_event').addEventListener('input', function() {
            setTimeout(toggleFields, 100);
        });

        document.getElementById('nilai_promo').addEventListener('input', function() {
            setTimeout(calculatePromo, 100);
        });
    </script>
</x-app-layout>