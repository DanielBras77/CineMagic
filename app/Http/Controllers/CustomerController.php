<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\CustomerFormRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CustomerController extends Controller
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

        // Next 3 lines are required when sorting by name:
        // ->join is necessary so that we have access to the users.name - to be able to order by "users.name"
        // ->select avoids bringing to many fields (that may conflict with each other)
        $customersQuery
            ->join('users', 'users.id', '=', 'customers.user_id')
            ->select( 'customers.*')
            ->orderBy('users.name');

        // Since we are joining customers and users, we can simplify the code to search by name
        if ($filterByName !== null) {
            $customersQuery
                ->where('users.type', 'S')
                ->where('users.name', 'like', "%$filterByName%");
        }
        // Next line were used to filter by name, when there were no join clauses
        // if ($filterByName !== null) {
        //     $usersIds = User::where('type', 'S')
        //         ->where('name', 'like', "%$filterByName%")
        //         ->pluck('id')
        //         ->toArray();
        //     $customersIds = Customer::whereIntegerInRaw('user_id', $usersIds)
        //         ->pluck('id')
        //         ->toArray();
        //     $customersQuery->whereIntegerInRaw('customers.id', $customersIds);
        // }

        $customers = $customersQuery
            ->with('user', 'courseRef', 'disciplines')
            ->paginate(20)
            ->withQueryString();

        return view(
            'customers.index',
            compact('customers', 'courseOptions', 'filterByCourse', 'filterByName') //Não é Courseeeeeeeeeeeeeeeeeeeeeee
        );
    }

    public function show(Customer $customer): View
    {
        return view('customers.show')->with('customer', $customer);
    }

    public function create(): View
    {
        $newCustomer = new Customer();
        // Next 2 lines ensure that the expression $newCustomer->user->name is valid
        $newUser = new User();
        $newUser->type= 'C';
        $newCustomer->user = $newUser;
        return view('customers.create')
            ->with('customer', $newCustomer);
    }

    public function store(CustomerFormRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $newCustomer = DB::transaction(function () use ($validatedData, $request) {
            $newUser = new User();
            $newUser->type = 'C';
            $newUser->name = $validatedData['name'];
            $newUser->email = $validatedData['email'];
            // Customer is never an administrator
            $newUser->admin = 0;
            $newUser->gender = $validatedData['gender'];
            // Initial password is always 123
            $newUser->password = bcrypt('123');
            $newUser->save();
            $newCustomer = new Customer();
            $newCustomer->user_id = $newUser->id;
            $newCustomer->course = $validatedData['course'];  // Courseeeeeeeeeeeeeeee
            $newCustomer->number = $validatedData['number'];
            $newCustomer->save();
            if ($request->hasFile('photo_file')) {
                $path = $request->photo_file->store('public/photos');
                $newUser->photo_url = basename($path);
                $newUser->save();
            }
            return $newCustomer;
        });
        $url = route('customers.show', ['customer' => $newCustomer]);
        $htmlMessage = "Customer <a href='$url'><u>{$newCustomer->user->name}</u></a> has been created successfully!";
        return redirect()->route('customers.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
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
            //$customer->course = $validatedData['course'];
            $customer->number = $validatedData['number'];
            $customer->save();
            $customer->user->type = 'S';
            $customer->user->name = $validatedData['name'];
            $customer->user->email = $validatedData['email'];
            // Customer is never an administrator
            $customer->user->admin = 0;
            $customer->user->gender = $validatedData['gender'];
            $customer->user->save();
            if ($request->hasFile('photo_file')) {
                // Delete previous file (if any)
                if (
                    $customer->user->photo_url &&
                    Storage::fileExists('public/photos/' . $customer->user->photo_url)
                ) {
                    Storage::delete('public/photos/' . $customer->user->photo_url);
                }
                $path = $request->photo_file->store('public/photos');
                $customer->user->photo_url = basename($path);
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
        try {
            $url = route('customers.show', ['customer' => $customer]);
            $totalCustomersDisciplines = DB::scalar(
                'select count(*) from customers_disciplines where customers_id = ?',
                [$customer->id]
            );
            if ($totalCustomersDisciplines == 0) {
                DB::transaction(function () use ($customer) {
                    $fileToDelete = $customer->user->photo_url;
                    $customer->delete();
                    $customer->user->delete();
                    if ($fileToDelete) {
                        if (Storage::fileExists('public/photos/' . $fileToDelete)) {
                            Storage::delete('public/photos/' . $fileToDelete);
                        }
                    }
                });
                $alertType = 'success';
                $alertMsg = "Customer {$customer->user->name} has been deleted successfully!";
            } else {
                $alertType = 'warning';
                $gender = $customer->user->gender == 'M' ? 'he' : 'she';
                $justification = match (true) {
                    $totalCustomersDisciplines <= 0 => "",
                    $totalCustomersDisciplines == 1 => "$gender is enrolled in 1 discipline",
                    $totalCustomersDisciplines > 1 => "$gender is enrolled in $totalCustomersDisciplines disciplines",
                };
                $alertMsg = "Customer <a href='$url'><u>{$customer->user->name}</u></a> cannot be deleted because $justification.";
            }
        } catch (\Exception $error) {
            $alertType = 'danger';
            $alertMsg = "It was not possible to delete the customer
                            <a href='$url'><u>{$customer->user->name}</u></a>
                            because there was an error with the operation!";
        }
        return redirect()->route('customers.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }

    public function destroyPhoto(Customer $customer): RedirectResponse
    {
        if ($customer->user->photo_url) {
            if (Storage::fileExists('public/photos/' . $customer->user->photo_url)) {
                Storage::delete('public/photos/' . $customer->user->photo_url);
            }
            $customer->user->photo_url = null;
            $customer->user->save();
            return redirect()->back()
                ->with('alert-type', 'success')
                ->with('alert-msg', "Photo of customer {$customer->user->name} has been deleted.");
        }
        return redirect()->back();
    }

}
