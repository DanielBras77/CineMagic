<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $movies = Movie::orderBy('name')->get();
        return view('home')->with('movies', $movies);
    }
}
