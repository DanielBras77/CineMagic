<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\CustomerFormRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CustomerController extends \Illuminate\Routing\Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Customer::class);
    }

    public function index(Request $request): View
    {
        $filterByName = $request->query('name');
        $customersQuery = Customer::query();

        $customersQuery->join('users', 'users.id', '=', 'customers.id')->select('customers.*')->orderBy('users.name');

        if ($filterByName !== null) {
            $customersQuery
                ->where('users.type', 'C')
                ->where('users.name', 'like', "%$filterByName%");
        }

        $customers = $customersQuery->with('user')->paginate(20)->withQueryString();

        return view('customers.index',compact('customers', 'filterByName'));
    }

    public function show(Customer $customer): View
    {
        return view('customers.show')->with('customer', $customer);
    }


    public function edit(Customer $customer): View
    {
        return view('customers.edit')
            ->with('customer', $customer);
    }

    public function update(CustomerFormRequest $request, Customer $customer): RedirectResponse
    {
        $validatedData = $request->validated();
        $customer = DB::transaction(function () use ($validatedData, $customer, $request) {
            $customer->number = $validatedData['nif'];
            $customer->number = $validatedData['payment_type'];
            $customer->number = $validatedData['payment_ref'];
            $customer->save();
            $customer->user->type = 'C';
            $customer->user->name = $validatedData['name'];
            $customer->user->email = $validatedData['email'];

            $customer->user->save();
            if ($request->hasFile('photo_file')) {

                if ($customer->user->photo_filename && Storage::fileExists('public/photos/' . $customer->user->photo_filename)) {
                    Storage::delete('public/photos/' . $customer->user->photo_filename);
                }

                $path = $request->photo_file->store('public/photos');
                $customer->user->photo_filename = basename($path);
                $customer->user->save();
            }
            return $customer;
        });
        $url = route('customers.show', ['customer' => $customer]);
        $htmlMessage = "Customer <a href='$url'><u>{$customer->user->name}</u></a> has been updated successfully!";
        return redirect()->route('customers.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function destroy(Customer $customer): RedirectResponse
    {

        $customer->user->delete();
        $customer->delete();

        $alertType = 'success';
        $alertMsg = "Customer {$customer->user->name} has been deleted successfully!";

        return redirect()->route('customers.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }

    public function destroyPhoto(Customer $customer): RedirectResponse
    {
        if ($customer->user->photo_filename) {
            if (Storage::fileExists('public/photos/' . $customer->user->photo_filename)) {
                Storage::delete('public/photos/' . $customer->user->photo_filename);
            }
            $customer->user->photo_filename = null;
            $customer->user->save();
            return redirect()->back()
                ->with('alert-type', 'success')
                ->with('alert-msg', "Photo of customer {$customer->user->name} has been deleted.");
        }
        return redirect()->back();
    }
}
