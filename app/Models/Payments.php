<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    protected $fillable = ['booking_id', 'amount', 'method', 'status', 'date'];
    
    protected $casts = [
        'date' => 'date',
    ];
    
    public $timestamps = false;
}
