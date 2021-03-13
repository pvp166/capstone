<?php

namespace App\Http\Controllers\MenuManage;

use App\Http\Controllers\Controller;
use App\Models\MenuManage\ItemType;
use Illuminate\Http\Request;

class ItemTypeController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    |   Item Type Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling item type
    |
    */
    
     /**
     * Present the item type to the main screen
     *
     * @return App\Models\MenuManage\ItemType $itemTypes
     */
    public function index(){
        $itemTypes = ItemType::all();
        return $itemTypes;
    }
    
}
