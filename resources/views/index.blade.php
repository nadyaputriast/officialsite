{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard ' . ucfirst(Auth::user()->getRoleNames()->first())) }}
        </h2>
    </x-slot>

    <div class="py-12"> --}}
        {{-- Include Oprek --}}
        {{-- @if (auth()->user()->hasRole('admin'))
            @include('dashboard.admin', [
                'dataOprek' => $dataOprek,
                'dataPengabdian' => $dataPengabdian,
                'dataPortofolio' => $dataPortofolio,
                'dataPrestasi' => $dataPrestasi,
                'dataSertifikasi' => $dataSertifikasi,
            ])
        @else
            @include('dashboard.user', [
                'dataOprek' => $dataOprek,
                'dataPengabdian' => $dataPengabdian,
                'dataPortofolio' => $dataPortofolio,
                'dataPrestasi' => $dataPrestasi,
                'dataSertifikasi' => $dataSertifikasi,
            ])
        @endif
    </div>
</x-app-layout> --}}
