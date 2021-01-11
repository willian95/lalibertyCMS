<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductSecondaryImage extends Model
{
    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function homeOrder(){

        return $this->hasMany(HomeOrder::class, "product_secondary_image_id");

    }
}
