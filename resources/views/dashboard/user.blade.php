@if (auth()->user()->hasRole('admin'))
<section class="bg-[#DDF1FB]">
    <div id="user-section" class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Daftar User Terdaftar</h3>
                    <table class="table-auto w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 px-4 py-2">Nama</th>
                                <th class="border border-gray-300 px-4 py-2">Email</th>
                                <th class="border border-gray-300 px-4 py-2">Role</th>
                                <th class="border border-gray-300 px-4 py-2">Kode Pengguna</th>
                                <th class="border border-gray-300 px-4 py-2">Alamat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2">{{ $user->nama_pengguna }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $user->email }}</td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        {{ ucfirst($user->getRoleNames()->first() ?? '-') }}
                                    </td>
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
                                    <td class="border border-gray-300 px-4 py-2">{{ $user->alamat ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-gray-500 py-4">Belum ada user terdaftar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif