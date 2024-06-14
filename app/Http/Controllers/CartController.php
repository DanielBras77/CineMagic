<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Seat;
use App\Models\Ticket;
use App\Models\Purchase;
use App\Models\Screening;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Configuration;
use Illuminate\Support\Facades\DB;
use App\View\Components\menus\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\PDFController;
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
            session(['total_seats' => count($cart)]);
            $alertType = 'success';
            $htmlMessage = "Seat(s) <strong>" . implode(',', $seats_adicionados) . "</strong> was/were added to the cart.";

        } else {
            $alertType = 'warning';
            $htmlMessage = "No seats were added to the cart.";
        }
        return back()
                ->with('alert-msg', $htmlMessage)
                ->with('alert-type', $alertType);
    }

    public function removeFromCart($id): RedirectResponse
    {
        $cart = session('cart', []);
        if (count($cart) == 0) {
            $alertType = 'warning';
            $htmlMessage = "Cart is empty!";
        } else {
            if (!array_key_exists($id, $cart)) {
                $alertType = 'warning';
                $htmlMessage = "Selected item does not exist in the cart.";
            } else {

                $alertType = 'success';
                $htmlMessage = "Seat <strong>" . $cart[$id]["seat"]->row . $cart[$id]["seat"]->seat_number . "</strong> was removed from the cart.";

                unset($cart[$id]);
                session(['cart' => $cart]);
                session(['total_seats' => count($cart)]);
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


    public function confirm(CartConfirmationFormRequest $request): RedirectResponse
    {
        $cart = session('cart', []);

        if (!$cart || (count($cart) == 0)) {
            return back()
                ->with('alert-type', 'danger')
                ->with('alert-msg', "Cart was not confirmed, because cart is empty!");
        } else {
            $purchase = new Purchase();
            $purchase->fill($request->validated());
            $purchase->customer_id = Auth::user() ? Auth::user()->id : null;
            $purchase->date = Carbon::now();
            $ignoredTickets = 0;
            $configuration = Configuration::first();
            $ticket_price = $configuration->ticket_price;
            $price = Auth::user() ? $ticket_price - $configuration->registered_customer_ticket_discount : $ticket_price;
            $total_price = 0;

            foreach ($cart as $item) {
                if ($item['screening']->tickets()->where('seat_id', $item['seat']->id)->count() == 0 &&
                    $item['screening']->date > Carbon::today() ||
                    ($item['screening']->date == Carbon::today() &&
                        $item['screening']->start_time >= Carbon::now()->subMinutes(5)->format("H:i:s"))
                ) {

                    $insertTickets[]= [
                        'screening_id' => $item['screening']->id,
                        'seat_id' => $item['seat']->id,
                        'price' => $price
                    ];

                    $total_price += $price;
                } else {
                    $ignoredTickets++;
                }
            }
            $ignoredStr = match ($ignoredTickets) {
                0 => "",
                1 => "<br>(1 ticket was ignored because screening date or seat is not valid)",
                default => "<br>($ignoredTickets tickets were ignored because user was already enrolled on them)"
            };
            $totalInserted = count($insertTickets);
            $totalInsertedStr = match ($totalInserted) {
                0 => "",
                1 => "1 ticket was bought",
                default => "$totalInserted tickets were bought",
            };
            if ($totalInserted == 0) {
                $request->session()->forget('cart');
                return back()
                    ->with('alert-type', 'danger')
                    ->with('alert-msg', "No tickets bought!");
            } else {
               DB::transaction(function () use ($purchase, $insertTickets, $total_price) {

                    $purchase->total_price = $total_price;
                    $purchase->save();

                    foreach ($insertTickets as $itemT) {
                        $ticket = new Ticket();
                        $ticket->fill($itemT);
                        $ticket->purchase_id = $purchase->id;
                        //$ticket->qrcorde_url=route('tickets.showcase', ['ticket'=>$ticket])
                        $ticket->save();
                    }

                    $purchase->receipt_pdf_filename = PDFController::generatePDF($purchase);
                    $purchase->save();
                });

                $request->session()->forget('cart');
                session()->forget('total_seats');
            }
            if ($ignoredTickets == 0) {
                return redirect()->route('home')
                    ->with('alert-type', 'success')
                    ->with('alert-msg', "$totalInsertedStr.");
            } else {
                return redirect()->route('home')
                    ->with('alert-type', 'warning')
                    ->with('alert-msg', "$totalInsertedStr. $ignoredStr");
            }
        }
    }
}
