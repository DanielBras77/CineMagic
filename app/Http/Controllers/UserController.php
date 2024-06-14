<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
        $usersQuery = User::whereIn('type', ['A','E'])->orderBy('name');
        $filterByName = $request->query('name');
        $filterByEmail = $request->query('email');
        $filterByType = $request->query('type');

        if ($filterByName) {
            $usersQuery->where('name', 'like', "%$filterByName%");
        }

        if ($filterByEmail) {
            $usersQuery->where('email', 'like', "%$filterByEmail%");
        }

        if ($filterByType) {
            $usersQuery->where('type', $filterByType);
        }

        $users = $usersQuery->paginate(20)->withQueryString();

        return view('users.index',compact('users', 'filterByName', 'filterByEmail', 'filterByType'));
    }


    public function show(User $user): View
    {
        return view('users.show')->with('user', $user);
    }

    //showScreening

    public function create(): View
    {
        $newUser = new User();
        return view('users.create')->with('user', $newUser);
    }

    public function store(UserFormRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $newUser = new User();
        $newUser->fill($validatedData);

        $newUser->password = Hash::make($validatedData['password']);
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
        $user->fill( $request->validated());
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

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        $alertType = 'success';
        $alertMsg = "User {$user->user->name} has been deleted successfully!";

        return redirect()->route('users.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);

    }

    public function destroyPhoto(User $user): RedirectResponse
    {
        if (Auth::user()->cannot('delete', $user)){
            abort(403);
        }


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

    public function updatedBlock(User $user){

        if (Auth::user()->cannot('updateBlock', $user)){
            abort(403);
        }

        $user->blocked = !$user->blocked;
        $user->save();
        $msg = $user->blocked?"blocked":"active/unblocked";
        $htmlMessage = "User <u>($user->name)</u> is {$msg} ";

        return redirect()->back()->with('alert-type', 'success')->with('alert-msg', "$htmlMessage");
    }
}
