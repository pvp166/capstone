<?php

namespace App\Models\OrderManage;

use Illuminate\Database\Eloquent\Model;

class CustomizePizza extends Model
{
    // allow to use the eloquent in these fields
    protected $fillable = [
    'order_item_id' ,
    'item_price_id'];   
    // prevent time stamps errors
    public $timestamps = false;
     /**
     * This function responsilbe for presenting foreign key on the order item table.
     * @return function relationship between order table and order item table
     */
    public function order(){
        return $this->belongsTo(OrderItem::class,'order_item_id');
    }
}