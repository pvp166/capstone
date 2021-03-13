<?php

namespace App\Models\OrderManage;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    //allow to the time stamp 
    public $timestamps = false;
    /**
     * This function responsilbe for presenting foreign key on the order item table.
     * @return function relationship between order table and order item table
     */
    public function order(){
        return $this->belongsTo(Order::class,'order_id');
    }
}
