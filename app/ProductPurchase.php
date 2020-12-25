<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductPurchase extends Model
{
    public function payment(){
        return $this->belongsTo(Payment::class);
    }

    public function productColorSize(){
        return $this->belongsTo(ProductColorSize::class);
    }
}
