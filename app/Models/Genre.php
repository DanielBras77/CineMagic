<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Genre extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'code';
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = "string";

    protected $fillable=['code','name'];


    public function movies():HasMany
    {
        return $this->hasMany(Movie::class, 'genre_code', 'code');
    }

    public function screenings(): HasManyThrough{
        return $this->hasManyThrough(Screening::class, Movie::class);
    }
}
