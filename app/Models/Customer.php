<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory,SoftDeletes;
    public $incrementing=false;
    protected $fillable=['id', 'nif','payment_type', 'payment_ref'];

    public function user():BelongsTo
    {
        // O primeiro id é chave estrangeira e o segundo é primária do user:  nome da tabela no singular _ id?
        return $this->belongsTo(User::class, 'id', 'id')->withTrashed();
    }

    public function purchases():HasMany
    {
        // O ticket não pode ser apagado
        return $this->hasMany(Purchase::class, 'customer_id', 'id');
    }
}
