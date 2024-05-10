<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movie extends Model
{
    use HasFactory, SoftDeletes;

    // protected $fillable=['title','genre_code', 'poster_filename', 'synopsis', 'trailer_url'];




    public function getPosterFullUrlAttribute()
    {
        debug($this->poster_filename);

        if ($this->poster_filename && Storage::exists("public/posters/{$this->poster_filename}")) {
            return asset("storage/posters/{$this->poster_filename}");
        } else {
            return asset("img/_no_poster_1.png");
        }
    }

    //genre this seta belongs to with trashed

    //has many screeeningsssssssssssss
}
