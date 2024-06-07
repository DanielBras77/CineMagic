<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ticket;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UserFormRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserController extends \Illuminate\Routing\Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(User::class);
    }

    public function index(Request $request): View
    {
        $usersQuery = User::where('type', 'C')->orderBy('name');
        $filterByName = $request->query('name');

        if ($filterByName) {
            $usersQuery->where('name', 'like', "%$filterByName%");
        }

        $users = $usersQuery->paginate(20)->withQueryString();

        return view('users.index',compact('users', 'filterByName'));
    }


    public function show(User $user): View
    {
        return view('users.show')->with('user', $user);
    }

    //showScreening

    public function create(): View
    {
        $newUser = new User();
        $newUser->type = 'C';
        return view('users.create')->with('user', $newUser);
    }

    public function store(UserFormRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $newUser = new User();
        $newUser->type = 'C';
        $newUser->name = $validatedData['name'];
        $newUser->email = $validatedData['email'];
        $newUser->admin = $validatedData['admin'];
        $newUser->gender = $validatedData['gender'];

        // Initial password is always 123
        $newUser->password = bcrypt('12345678');
        $newUser->save();

        if ($request->hasFile('photo_file')) {
            $path = $request->photo_file->store('public/photos');
            $newUser->photo_filename = basename($path);
            $newUser->save();
        }

        $url = route('users.show', ['user' => $newUser]);
        $htmlMessage = "User <a href='$url'><u>{$newUser->name}</u></a> has been created successfully!";

        return redirect()->route('users.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function edit(User $user): View
    {
        return view('users.edit')
            ->with('user', $user);
    }

    public function update(UserFormRequest $request, User $user): RedirectResponse
    {
        $validatedData = $request->validated();
        $user->type = 'A';
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->admin = $validatedData['admin'];
        $user->gender = $validatedData['gender'];
        $user->save();
        if ($request->hasFile('photo_file')) {

            // Delete previous file (if any)
            if ($user->photo_filename && Storage::fileExists('public/photos/' . $user->photo_filename)){

                Storage::delete('public/photos/' . $user->photo_filename);
            }

            $path = $request->photo_file->store('public/photos');
            $user->photo_filename = basename($path);
            $user->save();
        }

        $url = route('users.show', ['user' => $user]);
        $htmlMessage = "User <a href='$url'><u>{$user->name}</u></a> has been updated successfully!";

        return redirect()->route('users.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function destroyPhoto(User $user): RedirectResponse
    {
        if ($user->photo_filename) {
            if (Storage::fileExists('public/users/' . $user->photo_filename)) {
                Storage::delete('public/users/' . $user->photo_filename);
            }
            $user->photo_filename = null;
            $user->save();
            return redirect()->back()
                ->with('alert-type', 'success')
                ->with('alert-msg', "Photo of user {$user->name} has been deleted.");
        }
        return redirect()->back();
    }

    //updateBlocked
}
