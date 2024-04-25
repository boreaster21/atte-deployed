<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FortifyController extends Controller
{
    public function index()
    {
        return redirect('/login');
        // return view('auth.login');
    }
}
