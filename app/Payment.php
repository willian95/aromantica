<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    
    protected $table = "payments";

    public function productPurchases(){
        return $this->hasMany(ProductPurchase::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
