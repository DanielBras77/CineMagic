<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Mail\PurchaseReceipt;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;

class PDFController extends \Illuminate\Routing\Controller
{
    use AuthorizesRequests;
    protected $qrCodePath;

    public function __construct()
    {
        $this->authorizeResource(PDF::class);
    }

    public function generate() {
        $content = Str::random(45);
        //$qrCodes = [];
        $qrCode = QrCode::size(60)->generate("qr-codes/$content");
        $qrCodePath = 'qrcodes/' . $content . '.png';
        Storage::put($qrCodePath, $qrCode);
        $this->qrCodePath = $qrCodePath;

        return $content;
    }

    public function generatePDF(Purchase $purchase)
    {
        $data = ['purchase' => $purchase,  'qrCodePath' => $this->qrCodePath];
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
