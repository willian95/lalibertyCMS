<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Size extends Model
{
    use SoftDeletes;

    public function productColorSizes(){
        return $this->hasMany(ProductColorSize::class);
    }

}
