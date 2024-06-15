<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Purchase extends Model
{
    use HasFactory;
    protected $fillable = ['customer_id', 'date', 'total_price', 'customer_name', 'customer_email',
                           'nif', 'payment_type', 'payment_ref', 'receipt_pdf_filename'];


    public function getReceiptPdfFilenameFullUrlAttribute(){
        if($this->receipt_pdf_filename && Storage::exists("pdf_purchases/$this->receipt_pdf_filename}")){
            return route('purchases.receipt');
        }
        else{
            return null;
        }
    }

    public function customer():HasOne
    {
        // Se a chave puder ser apagada temos que conseguir ver o cliente à mesma
        return $this->hasOne(Customer::class, 'id', 'customer_id')->withTrashed();
    }
    public function tickets():HasMany
    {
        // O ticket não pode ser apagado
        return $this->hasMany(Ticket::class);
    }
}
