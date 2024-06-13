<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PurchaseController extends Controller
{

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
            $purchasesQuery->where('email', 'like', "%$filterByDate%");
        }

        $purchases = $purchasesQuery->paginate(20)->withQueryString();

        return view('purchases.index',compact('purchases', '$filterByCustomerName', 'filterByDate'));
    }


    public function show(Purchase $purchase)
    {
        return view('purchases.show')->with('purchase', $purchase);
    }


    public function getReceipt(Purchase $purchase){
        if($purchase->receipt_pdf_filename){
            return Storage::response('pdf_purchase/'.$purchase->receipt_pdf_filename);

        }
        return null;
    }
}


/*<?php
namespace App\Http\Controllers;
use App\Http\Requests\PriceRequest;
use App\Models\Price;
use Illuminate\Http\Request;
class PriceController extends Controller
{
    public function edit()
    {
        //
    }
    public function update(PriceRequest $request)
    {
        $prices = Price::first();
        $unitPriceCatalog = $request->input('unit_price_catalog',$prices->unit_price_catalog);
        $unitPriceOwn = $request->input('unit_price_own',$prices->unit_price_own);
        $unitPriceCatalogDiscount = $request->input('unit_price_catalog_discount',$prices->unit_price_catalog_discount);
        $unitPriceOwnDiscount = $request->input('unit_price_own_discount',$prices->unit_price_own_discount);
        $qtyDiscount = $request->input('qty_discount',$prices->qty_discount);
        // Put the value in the DB only if the value was passes in the request
        $unitPriceCatalog == null ?: $prices->unit_price_catalog= $unitPriceCatalog;
        $unitPriceOwn == null ?: $prices->unit_price_own= $unitPriceOwn;
        $unitPriceCatalogDiscount == null ?: $prices->unit_price_catalog_discount= $unitPriceCatalogDiscount;
        $unitPriceOwnDiscount == null ?: $prices->unit_price_own_discount= $unitPriceOwnDiscount;
        $qtyDiscount == null ?: $prices->qty_discount = $qtyDiscount;
        $prices->save();
        $htmlMessage = "Prices was successfully updated!";
        return redirect()
            ->route('dashboard.index')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }
    public static function unitPrice($qtd, $propria){
        $price = Price::first();
        if($propria){
            if($qtd >= $price->qty_discount){
                return $price->unit_price_own_discount;
            }else{
                return $price->unit_price_own;
            }
        }else{
            if($qtd >= $price->qty_discount)
                return $price->unit_price_catalog_discount;
        }
        return $price->unit_price_catalog;
    }
}