<?php

namespace App\Models\OrderManage;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // allow to use the eloquent in these fields
    protected $fillable = [
    'created_at' ,
    'finished_at' ,
    'order_status'];   
    // allow to the time stamp 
    public $timestamps = false;
    /**
     * This function responsilbe for presenting foreign key on the order item table.
     * @return function relationship between order table and order item table
     */
    public function orderItem(){
        return $this->hasMany(Order::class,'id');
    }
}
