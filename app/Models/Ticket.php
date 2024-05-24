<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = ['screening_id', 'seat_id', 'purchase_id', 'price', 'qrcode_url', 'status'];

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class);
    }

    public function seat(): BelongsTo
    {
        return $this->belongsTo(Seat::class)->withTrashed();
    }

    public function screening(): BelongsTo
    {
        return $this->belongsTo(Screening::class);
    }
}
