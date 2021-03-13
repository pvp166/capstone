<?php

namespace App\Models\MenuManage;

use Illuminate\Database\Eloquent\Model;

class ItemType extends Model
{
    /*
    |--------------------------------------------------------------------------
    |   Item Type Model
    |--------------------------------------------------------------------------
    |
    | This model is responsible for storing information in the item type
    |
    */
    /**
     * This function responsilbe for presenting foreign key on the Menu Item table.
     * @return function relationship between item price and menu item
     */
    public function menuItem(){
        return $this->hasMany(MenuItem::class,'item_type_id');
    }
}
