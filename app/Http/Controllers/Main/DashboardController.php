<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $responseService;

    // Konstruktor untuk menginisialisasi ResponseService
    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    // Menampilkan halaman index dashboard
    public function index()
    {
        // Mengembalikan tampilan index dashboard
        return view('main.dashboard.views.index');
    }
}
