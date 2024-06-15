<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PurchaseController extends \Illuminate\Routing\Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Purchase::class);
    }

    public function index(Request $request): View
    {
        $purchasesQuery = Purchase::query()->orderBy('date', 'desc');


        if(Auth::user()->type == 'C'){
            $purchasesQuery->where('customer_id', Auth::user()->id);
        }

        $filterByCustomerName = $request->query('customer_name');
        $filterByDate = $request->query('date');

        if ($filterByCustomerName !== null) {
            $purchasesQuery->where('customer_name', 'like', "%$filterByCustomerName%");
        }

        if ($filterByDate) {
            $purchasesQuery->where('date', 'like', "%$filterByDate%");
        }

        $purchases = $purchasesQuery->paginate(20)->withQueryString();

        return view('purchases.index',compact('purchases', 'filterByCustomerName', 'filterByDate'));
    }


    public function show(Purchase $purchase)
    {
        return view('purchases.show')->with('purchase', $purchase);
    }

    public function history(): View
    {
        $user = Auth::user();
        $purchases = Purchase::where('customer_id', $user->id)->orderBy('date', 'desc')->get();

        return view('purchases.showHistory', compact('purchases'));
    }

    public function getReceipt(Purchase $purchase){
        if($purchase->receipt_pdf_filename){
            return Storage::response('pdf_purchases/'.$purchase->receipt_pdf_filename);

        }
        return null;
    }
}
