<?php

namespace App\Http\Controllers\Landpage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LandpageController extends Controller
{
    public function index()
    {
        return view('landpage.beranda.views.index');
    }

    public function registration()
    {
        return view('landpage.registration.views.index');
    }
}
