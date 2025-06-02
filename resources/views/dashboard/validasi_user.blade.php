@if (auth()->user()->hasRole('admin'))
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Validasi User</h3>
                    <table class="table-auto w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 px-4 py-2">Nama</th>
                                <th class="border border-gray-300 px-4 py-2">Email</th>
                                <th class="border border-gray-300 px-4 py-2">Status</th>
                                <th class="border border-gray-300 px-4 py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2">{{ $user->nama_pengguna }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $user->email }}</td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        @if ($user->status_validasi)
                                            <span class="text-green-600">Tervalidasi</span>
                                        @else
                                            <span class="text-yellow-600">Belum Validasi</span>
                                        @endif
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        @if (!$user->status_validasi)
                                            <form action="{{ route('user.validasi', $user->id_pengguna) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="px-3 py-1 bg-green-500 text-white rounded">Validasi</button>
                                            </form>
                                        @else
                                            <span class="text-green-500">Sudah divalidasi</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif