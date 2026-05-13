<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendee extends Model
{
    //
    protected $fillable = ['name', 'email', 'phone'];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
