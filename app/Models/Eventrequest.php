<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Eventrequest extends Model
{
    protected $table = 'eventrequest';

    protected $fillable = [
        'name',
        'description',
        'user_id',
        'venue_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }
}
