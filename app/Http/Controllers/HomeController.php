<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use App\Models\Portofolio;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $catalogs = Catalog::with('category', 'portfolios')->get();
        return view('front.freelance.dashboard.dashboard', compact('catalogs'));
    }
}
