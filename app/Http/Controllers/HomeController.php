<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $genres = Genre::orderBy('name')->get();
        return view('home')->with('genres', $genres);
    }
}
