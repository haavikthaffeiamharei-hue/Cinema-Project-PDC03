<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movies extends Model
{
    protected $fillable = ['title', 'description', 'duration', 'release_date', 'genre_id', 'poster'];
    
    protected $casts = [
        'release_date' => 'date',
    ];

    public function genre()
    {
        return $this->belongsTo(Genres::class, 'genre_id');
    }

    public function showtimes()
    {
        return $this->hasMany(Showtimes::class, 'movie_id');
    }

    public function reviews()
    {
        return $this->hasMany(Reviews::class, 'movie_id');
    }

    public $timestamps = false;
}
