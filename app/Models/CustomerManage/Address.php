<?php

namespace App\Models\CustomerManage;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    /*
    |--------------------------------------------------------------------------
    |   Address Model
    |--------------------------------------------------------------------------
    |
    | This model is responsible for storing information in user's address
    |
    */
    // allow to use elloquent on these field
    protected $fillable = ['full_name' ,
    'address_line_1' ,
    'address_line_2' ,
    'city',
    'province' ,
    'other_address',
    'customer_phone',
    'postal_code' ,
    'user_id' ];   
    // $timestamps = false to prevent errors
    public $timestamps = false;
}
