<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    protected $fillable = [
        'name',
        'city',
        'country',
        'street',
        'zipcode',
        'capacity',
    ];

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
