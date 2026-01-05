<?php

namespace App\Http\Controllers;

use App\Models\PaketPendampingan;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index() {
        $pakets = PaketPendampingan::where('status', 'aktif')->get();
        return view('frontend.index', compact('pakets'));
    }

    public function about() {
        return view('frontend.about');
    }

    public function contact() {
        return view('frontend.contact');
    }
}
