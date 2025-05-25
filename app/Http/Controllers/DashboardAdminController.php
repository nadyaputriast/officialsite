<?php

namespace App\Http\Controllers;

use App\Models\OprekLokerProject;
use App\Models\Event;
use App\Models\Portofolio;

// class DashboardAdminController
// {
//     public function index()
//     {
//         $dataOprek = OprekLokerProject::latest()->get();
// 		$dataEvent = Event::latest()->get();
// 		$dataPortofolio = Portofolio::with(['mahasiswa', 'dosen'])->where('status_portofolio', 'valid')->get();
//         return view('dashboard', compact('dataOprek', 'dataEvent', 'dataPortofolio'));
//     }
// }