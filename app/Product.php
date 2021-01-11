<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    public function productColorSizes(){
        return $this->hasMany(ProductColorSize::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function secondaryImages(){
        return $this->hasMany(ProductSecondaryImage::class);
    }

}
