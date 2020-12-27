<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkImage extends Model
{
    public function workImage(){
        return $this->belongsTo(Work::class);
    }
}
