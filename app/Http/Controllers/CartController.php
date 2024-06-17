<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Seat;
use App\Models\Ticket;
use App\Models\Purchase;
use App\Models\Screening;
use App\Services\Payment;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Configuration;
use Illuminate\Support\Facades\DB;
use App\View\Components\menus\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\PDFController;
use App\Http\Requests\CartConfirmationFormRequest;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class CartController extends Controller
{

    public function show(): View
    {
        $cart = session('cart', []);
        $configuration = Configuration::first();
        $ticket_price = $configuration->ticket_price;
        $discount = $configuration->registered_customer_ticket_discount;

        $price = Auth::user() ? $ticket_price - $configuration->registered_customer_ticket_discount : $ticket_price;
        $total_price = 0;

        foreach ($cart as $item) {
            $total_price += $price;
        }

        return view('cart.show', compact('cart', 'total_price'));
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
        $request->session()->put('total_seats', 0);

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

            $payment_type = $request->input('payment_type');
            $payment_ref = $request->input('payment_ref');
            $payment_success = false;

            switch ($payment_type) {
                case 'VISA':
                    $card_details = explode(' ', $payment_ref);
                    if (count($card_details) == 2) {
                        list($card_number, $cvc_code) = $card_details;
                        $payment_success = Payment::payWithVisa($card_number, $cvc_code);
                    }
                    break;
                case 'PAYPAL':
                    $payment_success = Payment::payWithPaypal($payment_ref);
                    break;
                case 'MBWAY':
                    $payment_success = Payment::payWithMBway($payment_ref);
                    break;
                default:
                    $payment_success = false;
            }

            if (!$payment_success) {
                return back()
                    ->with('alert-type', 'danger')
                    ->with('alert-msg', "Payment failed! Please check your payment details and try again.");
            }


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
                if (
                    $item['screening']->tickets()->where('seat_id', $item['seat']->id)->count() == 0 &&
                    $item['screening']->date > Carbon::today() ||
                    ($item['screening']->date == Carbon::today() &&
                        $item['screening']->start_time >= Carbon::now()->subMinutes(5)->format("H:i:s"))
                ) {

                    $insertTickets[] = [
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
                        $ticket->save();
                    }

                    $pdfController = new PDFController();
                    $pdfController->generate();
                    $receipt_filename = $pdfController->generatePDF($purchase);
                    $purchase->receipt_pdf_filename = $receipt_filename;
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
