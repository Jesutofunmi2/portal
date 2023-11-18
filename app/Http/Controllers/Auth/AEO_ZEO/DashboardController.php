<?php

namespace App\Http\Controllers\Auth\AEO_ZEO;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index(Request $request)
    {
        return view('aeo_zeo.vueBase');
    }
}
