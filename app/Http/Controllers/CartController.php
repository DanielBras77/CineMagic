<?php

namespace App\Http\Controllers;

use App\Models\Seat;
use App\Models\Student;
use App\Models\Screening;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\CartConfirmationFormRequest;

class CartController extends Controller
{
    public function show(): View
    {
        $cart = session('cart', []);
        return view('cart.show', compact('cart'));
    }

    public function addToCart(Request $request, Screening $screening): RedirectResponse
    {
        $cart = session('cart', []);
        $seats = $request->seats ?? [];
        $seats_adicionados = [];

        foreach ($seats as $seat_id) {
            $id = $screening->id . '_' . $seat_id;
            if (!array_key_exists($id, $cart)) {
                $seat = Seat::findOrFail($seat_id);
                $cart[$id] = ["screening" => $screening, "seat" => $seat];
                $seats_adicionados[] = $seat->row . $seat->seat_number;
            }
        }

        if (count($seats_adicionados)) {

            session(['cart' => $cart]);
            $alertType = 'success';
            $htmlMessage = "Seat(s) <strong>" . implode(',', $seats_adicionados) . "</strong> was/were added to the cart.";
            return back()
                ->with('alert-msg', $htmlMessage)
                ->with('alert-type', $alertType);
        } else {
            $alertType = 'warning';
            $htmlMessage = "No seats were added to the cart.";
        }
    }

    public function removeFromCart(Request $request, $id): RedirectResponse
    {
        $cart = session('cart', []);
        if (count($cart) == 0) {
            $alertType = 'warning';
            $htmlMessage = "Cart is empty!";
        } else {
            if (!array_key_exists($id, $cart)){
                $alertType = 'warning';
                $htmlMessage = "Selected item does not exist in the cart.";
            } else{
                $alertType = 'success';
                $htmlMessage = "Seat <strong>".$cart["id"]["seat"]->row.$cart["id"]["seat"]->seat_number."</strong> was removed from the cart.";

                unset($cart[$id]);
                session(['cart'=> $cart]);
            }
            return back()
                ->with('alert-msg', $htmlMessage)
                ->with('alert-type', $alertType);
        }
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->session()->forget('cart');
        return back()
            ->with('alert-type', 'success')
            ->with('alert-msg', 'Shopping Cart has been cleared');
    }


    /*
    public function confirm(CartConfirmationFormRequest $request): RedirectResponse
    {
        $cart = session('cart', null);
        if (!$cart || ($cart->count() == 0)) {
            return back()
                ->with('alert-type', 'danger')
                ->with('alert-msg', "Cart was not confirmed, because cart is empty!");
        } else {
            $student = Student::where('number', $request->validated()['student_number'])->first();
            if (!$student) {
                return back()
                    ->with('alert-type', 'danger')
                    ->with('alert-msg', "Student number does not exist on the database!");
            }
            $insertScreenings = [];
            $screeningsOfStudent = $student->screenings;
            $ignored = 0;
            foreach ($cart as $screening) {
                $exist = $screeningsOfStudent->where('id', $screening->id)->count();
                if ($exist) {
                    $ignored++;
                } else {
                    $insertScreenings[$screening->id] = [
                        "screening_id" => $screening->id,
                        "repeating" => 0,
                        "grade" => null,
                    ];
                }
            }
            $ignoredStr = match($ignored) {
                0 => "",
                1 => "<br>(1 screening was ignored because student was already enrolled in it)",
                default => "<br>($ignored screenings were ignored because student was already enrolled on them)"
            };
            $totalInserted = count($insertScreenings);
            $totalInsertedStr = match($totalInserted) {
                0 => "",
                1 => "1 screening registration was added to the student",
                default => "$totalInserted screenings registrations were added to the student",

            };
            if ($totalInserted == 0) {
                $request->session()->forget('cart');
                return back()
                    ->with('alert-type', 'danger')
                    ->with('alert-msg', "No registration was added to the student!$ignoredStr");
            } else {
                DB::transaction(function () use ($student, $insertScreenings) {
                    $student->screenings()->attach($insertScreenings);
                });
                $request->session()->forget('cart');
                if ($ignored == 0) {
                    return redirect()->route('students.show', ['student' => $student])
                        ->with('alert-type', 'success')
                        ->with('alert-msg', "$totalInsertedStr.");
                } else {
                    return redirect()->route('students.show', ['student' => $student])
                        ->with('alert-type', 'warning')
                        ->with('alert-msg', "$totalInsertedStr. $ignoredStr");
                }
            }
        }

    }
    */
}
