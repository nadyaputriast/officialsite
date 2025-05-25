<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard ' . ucfirst(Auth::user()->getRoleNames()->first())) }}
        </h2>

        {{-- Banner --}}
        <x-banner-component />

        {{-- Section Notifikasi Global --}}
        {{-- @if (isset($notifs) && count($notifs) && !auth()->user()->hasRole('admin'))
            <div class="max-w-7xl mx-auto mt-6">
                @foreach ($notifs as $notif)
                    <div
                        class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-2 flex justify-between items-center">
                        <div>
                            {{ $notif->isi_notifikasi }}
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('oprek.show', $notif->notifiable_id) }}"
                                class="text-xs text-blue-700 underline">Lihat Detail</a>
                            <form action="{{ route('notifikasi.read', $notif->id_notifikasi) }}" method="POST"
                                class="inline">
                                @csrf
                                <button type="submit" class="text-xs text-blue-600 ml-2">Tandai sudah dibaca</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif --}}

    @include ('dashboard.navbar')

    @include('dashboard.notifikasi')

    @include('dashboard.halloffame')

    @include('dashboard.validasi_event_user')

    @include('dashboard.event')

    @include('dashboard.oprek')

    @include('dashboard.portofolio')

    @include('dashboard.pengabdian')

    @include('dashboard.prestasi')

    @include('dashboard.sertifikasi')

    @include('dashboard.download')
</x-app-layout>
