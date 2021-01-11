<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HomeOrder extends Model
{
    function work(){
        return $this->belongsTo(Work::class);
    }

    function workImage(){
        return $this->belongsTo(WorkImage::class);
    }

    function product(){
        return $this->belongsTo(Product::class);
    }

    function productImage(){
        return $this->belongsTo(ProductSecondaryImage::class, "product_secondary_image_id");
    }

    function blog(){
        return $this->belongsTo(Blog::class);
    }
}
