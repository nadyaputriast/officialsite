<?php
namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function index()
    {
        $notifs = Notifikasi::where('id_pengguna', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('notifikasi.index', compact('notifs'));
    }

    public function markAsRead($id)
    {
        $notif = Notifikasi::where('id_pengguna', Auth::id())->findOrFail($id);
        $notif->is_read = true;
        $notif->save();

        return redirect()->back();
    }
}