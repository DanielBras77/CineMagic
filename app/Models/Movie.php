<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Movie extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable=['title','genre_code','year', 'poster_filename', 'synopsis', 'trailer_url'];


    public function getPosterFullUrlAttribute()
    {
        debug($this->poster_filename);

        if ($this->poster_filename && Storage::exists("public/posters/{$this->poster_filename}")) {
            return asset("storage/posters/{$this->poster_filename}");
        } else {
            return asset("img/_no_poster_1.png");
        }
    }


    public function genre():BelongsTo
    {
        return $this->belongsTo(Genre::class, 'genre_code', 'code')->withTrashed();
    }

    public function screenings():HasMany
    {
        return $this->hasMany(Screening::class, 'movie_id', 'id');
    }

}
