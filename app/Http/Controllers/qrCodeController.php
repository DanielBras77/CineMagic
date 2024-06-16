<?php
//code from https://www.binaryboxtuts.com/php-tutorials/laravel-tutorials/laravel-11-qr-code-generator-tutorial/
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;

class qrCodeController extends Controller
{
    public function generate() {
        $qrCodes = [];
        $qrCodes['simple'] = QrCode::size(120)->generate(mt_rand(0, 255));
        $content = Str::random(45);
        $url = url("/qr-codes/{$content}");


        return view('qrcode.index', $qrCodes,compact('url'));

    }
}
