<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'title', 'customer_id', 'home_id', 'user_id', 'note', 'start'
    ];
}
