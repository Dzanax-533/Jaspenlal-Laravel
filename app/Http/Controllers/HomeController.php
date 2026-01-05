<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $role = auth()->user()->role;

        if ($role == 'admin') return redirect()->route('admin.dashboard');
        if ($role == 'keuangan') return redirect()->route('keuangan.dashboard');
        if ($role == 'konsultan') return redirect()->route('konsultan.dashboard');
        if ($role == 'klien') return redirect()->route('klien.dashboard');

        return redirect('/'); // fallback
    }
}
