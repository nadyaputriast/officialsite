<?php

namespace App\Http\Controllers;

use App\Models\OprekLokerProject;
use App\Models\Event;
use App\Models\Portofolio;

// class DashboardDosenController
// {
//     public function index()
//     {
// 		$dataEvent = Event::latest()->get();
// 		$dataPortofolio = Portofolio::with(['mahasiswa', 'dosen'])->where('status_portofolio', 'valid')->get();
//         $dataOprek = OprekLokerProject::latest()->get();
//         return view('dashboard', compact('dataOprek', 'dataEvent', 'dataPortofolio'));
//     }
// }