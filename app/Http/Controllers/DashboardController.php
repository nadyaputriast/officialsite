<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\OprekLokerProject;
use App\Models\Portofolio;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            $dataOprek = OprekLokerProject::latest()->get();
            $dataPortofolio = Portofolio::latest()->get();
        } else {
            $dataOprek = OprekLokerProject::where('status_project', 1)->latest()->get();
            $dataPortofolio = Portofolio::where('status_portofolio', 1)->latest()->get();
        }

        return view('dashboard', compact('dataOprek', 'dataPortofolio'));
    }
}
