<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Halls extends Model
{
    protected $fillable = ['cinema_id', 'name', 'capacity'];
    public $timestamps = false;

    public function cinema()
    {
        return $this->belongsTo(Cinemas::class, 'cinema_id');
    }

    public function seats()
    {
        return $this->hasMany(Seats::class, 'hall_id');
    }
}
