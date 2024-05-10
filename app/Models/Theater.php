<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Theater extends Model
{
    use HasFactory, SoftDeletes;

    //timestamp false
    // fillable name e photo_filename
    //belongs to with trasher
    //has many para os seats
    // has many para os screenings



}
