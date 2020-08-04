<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TopProduct extends Model
{
    public function productTypeSize(){
        return $this->belongsTo(ProductTypeSize::class);
    }
}
