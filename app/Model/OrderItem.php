<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    public function Product()
    {
        return $this->belongsTo('App\Model\Product');
    }

    public function order()
    {
        return $this->hasMany('App\Model\Order');
    }
}
