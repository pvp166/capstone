<?php

namespace App\Http\Controllers\OrderManage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerManage\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    |   Address Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling address page
    |
    */

    /**
     * This function help to find id
     * @var int $id
     * @var array $address
     * @return array $address
     */
    public function index()
    {


        $id = Auth::id(); // if not redirect to the login page


        $address = DB::table('addresses')
            ->select('*')
            ->where('user_id', $id)

            ->get();
        return $address;
    }
    /**
     * This function responsilbe for handling store new address
     * @param Illuminate\Http\Request $request
     * @var App\Models\CustomerManage\Address $address
     * @return int 204
     */
    public function store(Request $request)
    {   
        // get id from Auth
        $id = Auth::id(); // if not redirect to the login page
        // create the new address for user
        $address = new Address;
        $address->full_name = $request->full_name;
        $address->address_line_1 = $request->address_line_1;
        $address->address_line_2 = $request->address_line_2;
        $address->city = $request->city;
        $address->province = $request->province;
        $address->other_address = $request->other_address;
        $address->customer_phone = $request->customer_phone;
        $address->postal_code = $request->postal_code;
        $address->user_id = $id;
        $address->save();
        
    }
    /**
     * This function responsilbe for deleting an item
     * @param int $id
     */
    public function delete($id)
    {
        $address = Address::findOrFail($id); //find or fail handle the 404 exception
        $address->delete();
    }
    /**
     * This function responsilbe for showing an item by id
     * @param int $id
     * @return App\Models\CustomerManage\Address $address
     */
    public function show($id)
    {
        $address = Address::findOrFail($id); //find or fail handle the 404 exception
        return $address;
    }
    /**
     * This function responsilbe for updating existed item by id
     * @param int $id
     * @param Illuminate\Http\Request $request
     * @return App\Models\CustomerManage\Address $address
     */
    public function update(Request $request, $id)
    {
        $address = Address::findOrFail($id); //find or fail handle the 404 exception
        $address->update($request->all());

        return $address;
    }
}
