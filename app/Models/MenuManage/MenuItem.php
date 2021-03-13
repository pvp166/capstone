<?php

namespace App\Models\MenuManage;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    /*
    |--------------------------------------------------------------------------
    |   Menu Item Model
    |--------------------------------------------------------------------------
    |
    | This model is responsible for storing information in the menu item
    |
    */
    // alllow to use eloquent to edit these fields
    protected $fillable = ['name', 'description', 'item_type_id'];   
    /**
     * This function responsilbe for presenting foreign key on the Menu Item table.
     * @return function relationship between item type and menu item
     */
    public function itemType(){
        return $this->belongsTo(ItemType::class);
    }
     /**
     * This function responsilbe for presenting foreign key on the Menu Item table.
     * @return function relationship between item type and item price
     */
    public function itemPrice(){
        return $this->hasMany(ItemPrice::class,'item_type_id');
    }
}
