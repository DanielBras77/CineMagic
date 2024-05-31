<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\CourseFormRequest;
use Illuminate\Support\Facades\DB;

class MovieController extends Controller
{
    public function index(): View
    {
        $allMovies = Movie::paginate(20);
        return view('movies.index')->with('allMovies', $allMovies);
    }

    public function showCase(): View
    {
        return view('movies.showcase');
    }

    public function create(): View
    {
        $newMovie = new Movie();
        $genres = Genre::orderBY("name")->pluck('name','code')->toArray();
        return view('movies.create')->with('movie', $newMovie);
    }

    public function store(MovieFormRequest $request): RedirectResponse
    {
        $newMovie = Movie::create($request->validated());
        $url = route('movies.show', ['movie' => $newMovie]);
        $htmlMessage = "Course <a href='$url'><u>{$newMovie->name}</u></a> ({$newMovie->id}) has been created successfully!";
        return redirect()->route('courses.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function edit(Movie $movie): View
    {
        return view('movie.edit')->with('movie', $movie);
    }

    public function update(MovieFormRequest $request, Movie $movie): RedirectResponse
    {
        $movie->update($request->validated());
        $url = route('movies.show', ['movie' => $movie]);
        $htmlMessage = "Movie <a href='$url'><u>{$movie->name}</u></a> ({$movie->id}) has been updated successfully!";
        return redirect()->route('movies.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }
/*
    public function destroy(Movie $movie): RedirectResponse
    {
        try {
            $url = route('movie.show', ['movie' => $movie]);
            $totalStudents = DB::scalar(
                'select count(*) from students where course = ?', // por fazer
                [$course->abbreviation]);
            $totalDisciplines = DB::scalar(
                'select count(*) from disciplines where course = ?',
                [$course->abbreviation]);
            if ($totalStudents == 0 && $totalDisciplines == 0) {
                $course->delete();
                $alertType = 'success';
                $alertMsg = "Course {$course->name} ({$course->abbreviation}) has been deleted successfully!";
            } else {
                $alertType = 'warning';
                $studentsStr = match(true) {
                    $totalStudents <= 0 => "",
                    $totalStudents == 1 => "there is 1 student enrolled in it",
                    $totalStudents > 1 => "there are $totalStudents students enrolled in it",
                };
                $disciplinesStr = match(true) {
                    $totalDisciplines <= 0 => "",
                    $totalDisciplines == 1 => "it already includes 1 discipline",
                    $totalDisciplines > 1 => "it already includes $totalDisciplines disciplines",
                };
                $justification = $studentsStr && $disciplinesStr
                    ? "$disciplinesStr and $studentsStr"
                    : "$disciplinesStr$studentsStr";
                $alertMsg = "Course <a href='$url'><u>{$course->name}</u></a> ({$course->abbreviation}) cannot be deleted because $justification.";
            }
        } catch (\Exception $error) {
            $alertType = 'danger';
            $alertMsg = "It was not possible to delete the course
                            <a href='$url'><u>{$course->name}</u></a> ({$course->abbreviation})
                            because there was an error with the operation!";
        }
        return redirect()->back()
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }
*/
    public function show(Movie $movie): View
    {
        $genres = Genre::orderBY("name")->pluck('name','code')->toArray();
        return view('movies.show',compact('movie', $genres);
    }
}
