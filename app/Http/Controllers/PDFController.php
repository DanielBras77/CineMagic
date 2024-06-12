<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Storage;

class PDFController extends Controller
{
    public static function generatePDF(Purchase $purchase)
    {
        $data = ['purchase' => $purchase];
        $pdf = PDF::loadView('purchases.receipt', $data);
        $receipt_name = $purchase->id.'.pdf';
        Storage::put("pdf_purchases/$receipt_name", $pdf->download()->getOriginalContent());


        return $receipt_name;
    }
}
