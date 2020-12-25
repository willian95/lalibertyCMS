<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public function guestUser(){
        return $this->belongsTo(GuestUser::class);
    }

    public function productPurchases(){
        return $this->hasMany(ProductPurchase::class);
    }
}
