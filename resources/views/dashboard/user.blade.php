@if (auth()->user()->hasRole('admin'))
    <div class="py-12">
        <section class="bg-[#DDF1FB]">
            <div id="user-section" class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h3 class="text-lg font-semibold mb-4">Daftar User Terdaftar</h3>

                            {{-- SEARCH & FILTER --}}
                            <form method="GET" class="mb-4 flex flex-wrap gap-3 items-center">
                                <input type="hidden" name="tab" value="user">
                                <input type="text" name="search_user" value="{{ request('search_user') }}"
                                    placeholder="Cari nama pengguna..."
                                    class="border px-3 py-2 rounded focus:ring focus:ring-blue-200">
                                <select name="status_validasi" class="border px-3 py-2 rounded">
                                    <option value="">Status</option>
                                    <option value="1" {{ request('status_validasi') == '1' ? 'selected' : '' }}>
                                        Tervalidasi</option>
                                    <option value="0" {{ request('status_validasi') == '0' ? 'selected' : '' }}>
                                        Belum Divalidasi</option>
                                </select>
                                <select name="role_filter" class="border px-3 py-2 rounded">
                                    <option value="">Role</option>
                                    <option value="admin" {{ request('role_filter') == 'admin' ? 'selected' : '' }}>
                                        Admin</option>
                                    <option value="dosen" {{ request('role_filter') == 'dosen' ? 'selected' : '' }}>
                                        Dosen</option>
                                    <option value="mahasiswa"
                                        {{ request('role_filter') == 'mahasiswa' ? 'selected' : '' }}>
                                        Mahasiswa</option>
                                </select>
                                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Cari</button>
                                <a href="{{ route('dashboard') }}?tab=user"
                                    class="bg-blue-600 text-white px-4 py-2 rounded">Reset</a>
                            </form>

                            <div class="overflow-x-auto">
                                <table class="table-auto w-full border-collapse border border-gray-300">
                                    <thead>
                                        <tr class="bg-gray-100">
                                            <th class="border border-gray-300 px-4 py-2">Nama</th>
                                            <th class="border border-gray-300 px-4 py-2">Email</th>
                                            <th class="border border-gray-300 px-4 py-2">Kode Pengguna</th>
                                            <th class="border border-gray-300 px-4 py-2">Alamat</th>
                                            <th class="border border-gray-300 px-4 py-2">Tanggal Lahir</th>
                                            <th class="border border-gray-300 px-4 py-2">Role</th>
                                            <th class="border border-gray-300 px-4 py-2">File Terkait</th>
                                            <th class="border border-gray-300 px-4 py-2">Status</th>
                                            <th class="border border-gray-300 px-4 py-2">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($users as $user)
                                            <tr>
                                                <td class="border border-gray-300 px-4 py-2">{{ $user->nama_pengguna }}
                                                </td>
                                                <td class="border border-gray-300 px-4 py-2">{{ $user->email }}</td>
                                                <td class="border border-gray-300 px-4 py-2">
                                                    @if ($user->hasRole('admin'))
                                                        {{ $user->admin->kode_admin ?? '-' }}
                                                    @elseif ($user->hasRole('dosen'))
                                                        {{ $user->dosen->nip ?? '-' }}
                                                    @elseif ($user->hasRole('mahasiswa'))
                                                        {{ $user->mahasiswa->nim ?? '-' }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="border border-gray-300 px-4 py-2">{{ $user->alamat ?? '-' }}
                                                </td>
                                                <td class="border border-gray-300 px-4 py-2">
                                                    {{ $user->tanggal_lahir ?? '-' }}</td>
                                                <td class="border border-gray-300 px-4 py-2">
                                                    {{ ucfirst($user->getRoleNames()->first() ?? '-') }}
                                                </td>
                                                <td class="border border-gray-300 px-4 py-2">
                                                    @if ($user->hasRole('mahasiswa') && $user->mahasiswa && $user->mahasiswa->ktm)
                                                        <a href="{{ asset('storage/' . $user->mahasiswa->ktm) }}"
                                                            class="text-blue-500 hover:underline" target="_blank">
                                                            Lihat KTM
                                                        </a>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="border border-gray-300 px-4 py-2">
                                                    @if ($user->status_validasi == 1)
                                                        Sudah Divalidasi
                                                    @else
                                                        Belum Divalidasi
                                                    @endif
                                                </td>
                                                <td class="border border-gray-300 px-4 py-2">
                                                    @if (!$user->status_validasi)
                                                        <form action="{{ route('user.validasi', $user->id_pengguna) }}"
                                                            method="POST">
                                                            @csrf
                                                            <button type="submit"
                                                                class="px-3 py-1 bg-green-500 text-white rounded">Validasi</button>
                                                        </form>
                                                    @else
                                                        <span class="text-green-500">-</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-gray-500 py-4">Belum ada user
                                                    terdaftar.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {{-- PAGINATION --}}
                            <div class="text-sm text-gray-600">
                                Menampilkan <strong>{{ $users->count() }}</strong> dari
                                <strong>{{ $users->total() }}</strong> users
                            </div>
                            {{ $users->links('vendor.pagination.always') }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endif
