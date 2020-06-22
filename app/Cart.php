<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    function productTypeSize(){

        return $this->belongsTo(ProductTypeSize::class);

    }
}
