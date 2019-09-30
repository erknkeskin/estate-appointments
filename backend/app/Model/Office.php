<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    protected $fillable = [
        'title', 'address', 'latitude', 'longitude'
    ];
}
