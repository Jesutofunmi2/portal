<?php

namespace App\Http\Controllers\Auth\Ministry;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index(Request $request)
    {
        return view('ministry.vueBase');
    }

    public function casIndex(Request $request)
    {
        return view('cas.vueBase');
    }

}
