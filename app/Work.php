<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    public function workImages(){
        return $this->hasMany(WorkImage::class);
    }
}
