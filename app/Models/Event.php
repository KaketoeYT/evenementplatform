<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $primaryKey = 'event_id';

    protected $fillable = [
        'datetime',
        'title',
        'duration',
        'description',
        'entry_price',
    ];
}
