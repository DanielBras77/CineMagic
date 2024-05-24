<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Theater extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = false;
    protected $fillable=['name','photo_filename'];


    public function getPhotoFullUrlAttribute()
    {

        if ($this->photo_filename && Storage::exists("public/theaters/{$this->photo_filename}")) {
            return asset("storage/theaters/{$this->photo_filename}");
        } else {
            return asset("img/no_image.jpg");
        }
    }

    public function seats():HasMany
    {
        return $this->hasMany(Seat::class);
    }

    public function screenings():HasMany
    {
        return $this->hasMany(Screening::class);
    }
}
