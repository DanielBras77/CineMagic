<?php

namespace App\Models;

use App\Models\Theater;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Seat extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = false;
    protected $fillable = ['theather_id', 'row', 'seat_number'];


    public function theather(): BelongsTo
    {
        return $this->belongsTo(Theater::class)->withTrashed();
    }

    public function tickets(): HasMany
    {
        // O ticket não pode ser apagado
        return $this->hasMany(Ticket::class);
    }
}
