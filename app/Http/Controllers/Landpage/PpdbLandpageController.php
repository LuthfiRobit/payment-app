<?php

namespace App\Http\Controllers\Landpage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PpdbLandpageController extends Controller
{
    public function index()
    {
        return view('landpage.ppdb.views.index');
    }
}
