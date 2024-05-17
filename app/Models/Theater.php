<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Theater extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = false;
    // fillable name e photo_filename
    //belongs to with trasher
    /*
    public function genre():BelongsTo
    {
        return $this->belongsTo(Genre::class, '', '')->withTrashed();
    }
    */
    //has many para os seats
    /*
    public function seats():HasMany
    {
        return $this->hasMany(Screening::class, '', '');
    }*/
    // has many para os screenings
    /*
    public function screenings():HasMany
    {
        return $this->hasMany(Screening::class, '', '');
    }*/
}
