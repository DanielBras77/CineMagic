<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Mail\PurchaseReceipt;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PDFController extends \Illuminate\Routing\Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(PDF::class);
    }


    public static function generatePDF(Purchase $purchase)
    {
        $data = ['purchase' => $purchase];
        $pdf = PDF::loadView('purchases.receipt', $data);
        $receipt_name = $purchase->id . '.pdf';
        Storage::put("pdf_purchases/$receipt_name", $pdf->download()->getOriginalContent());

        self::sendPurchaseReceiptEmail($purchase->customer_email, $receipt_name);

        return $receipt_name;
    }



    protected static function sendPurchaseReceiptEmail($customer_email, $receipt_name)
    {
        $file_path = storage_path("app/pdf_purchases/{$receipt_name}");

        Mail::to($customer_email)->send(new PurchaseReceipt($file_path));
    }
}
