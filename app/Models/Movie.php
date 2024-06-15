<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Movie extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable=['title','genre_code', 'year', 'poster_filename', 'synopsis', 'trailer_url'];


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
        return $this->hasMany(Screening::class);
    }

    public function getNextScreeningsAttribute()
    {
        return $this->screenings()->where('date', '>=', Carbon::today())
        ->where('date', '<=', Carbon::today()->addWeek(2))->orderBy('date')->orderBy('start_time')->get();
    }
    public function getPosterEncode64Attribute(){
        $path = $this->posterFullUrl;
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }

}
