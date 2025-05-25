@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto mt-8">
    <h2 class="text-xl font-bold mb-4">Notifikasi Anda</h2>
    @forelse($notifs as $notif)
        <div class="p-4 mb-2 rounded border @if(!$notif->is_read) bg-yellow-50 @endif">
            <div>{{ $notif->isi_notifikasi }}</div>
            <div class="text-xs text-gray-500">{{ $notif->created_at->diffForHumans() }}</div>
            @if(!$notif->is_read)
                <form action="{{ route('notifikasi.read', $notif->id_notifikasi) }}" method="POST" class="inline">
                    @csrf
                    <button class="text-blue-500 text-xs" type="submit">Tandai sudah dibaca</button>
                </form>
            @endif
        </div>
    @empty
        <div class="text-gray-500">Tidak ada notifikasi.</div>
    @endforelse
</div>
@endsection