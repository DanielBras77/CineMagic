<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;

class qrCodeController extends Controller
{
    public function generate() {

        $content = Str::random(45);
        $url = url("/qr-codes/{$content}");
        $qrCodes = [];
        $qrCodes['simple'] = QrCode::size(60)->generate("qr-codes/$content");


        return view('qrcode.index', $qrCodes,compact('url'));
    }
}
