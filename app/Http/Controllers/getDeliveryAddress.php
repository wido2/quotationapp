<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class getDeliveryAddress extends Controller
{

    public static function getAddress(){
        $results =  DB::table('customers')
        ->join('addresses', function ($join) {
            $join->on('customers.id', '=', 'addresses.customer_id');
                    })// and you add more joins here
    ->get();
    return $results;


    }

}
