<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductColorSize extends Model
{
    use SoftDeletes;

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function color(){
        return $this->belongsTo(Color::class);
    }

    public function size(){
        return $this->belongsTo(Size::class);
    }

    public function productPurchase(){
        return $this->hasMany(ProductPurchase::class);
    }

}
