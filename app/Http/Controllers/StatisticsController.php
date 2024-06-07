<?php

namespace App\Http\Controllers;
/*use App\Models\Theater;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\Screening;
use Illuminate\Support\Carbon;*/
//use App\Http\Requests\MovieFormRequest;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
//use App\Http\Requests\TheaterFormRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class StatisticsController extends \Illuminate\Routing\Controller
{
    public function show(): View
    {
        $statistics = session('statistics', []);
        return view('statistics.show', compact('statistics'));
    }


}
