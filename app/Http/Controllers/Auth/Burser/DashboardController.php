<?php

namespace App\Http\Controllers\Auth\Burser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index(Request $request)
    {

        return view('burser.vueBase');
    }
}
