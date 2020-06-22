<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductTypeSize extends Model
{
    protected $table = "product_type_sizes";

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function type(){
        return $this->belongsTo(Type::class);
    }

    public function size(){
        return $this->belongsTo(Size::class);
    }

    public function productPurchases(){
        return $this->hasMany(productPurchase::class);
    }

}
