<?php

namespace App\Models\MenuManage;

use Illuminate\Database\Eloquent\Model;

class ItemPrice extends Model
{
    /*
    |--------------------------------------------------------------------------
    |   Item Price Model
    |--------------------------------------------------------------------------
    |
    | This model is responsible for storing information in item's price
    |
    */

    // fix the time stamp bug
    public $timestamps = false;
    // allow to use eloquent on these fields
    protected $fillable = ['menu_item_id', 'size', 'price'];
    /**
     * This function responsilbe for presenting foreign key on the Menu Item table.
     * @return function relationship between item price and menu item
     */
    public function itemType(){
        return $this->belongsTo(MenuItem::class, 'menu_item_id');
    }
}
