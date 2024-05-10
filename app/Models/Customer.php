<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory,SoftDeletes;
    public $incrementing=false;
    protected $fillable=['id', 'nif','payment_type', 'payment_ref'];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'id')->withTrashed();
    }
}
