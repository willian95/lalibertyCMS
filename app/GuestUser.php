<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GuestUser extends Model
{
    public function payments(){
        return $this->hasMany(Payment::class);
    }
}
