<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Product;
use Inertia\Inertia;
use Log;

class SaleController extends Controller
{
    function listCustomer(Request $request){
        $user_id = $request->header('user_id');
        $customers =Customer::where('user_id','=',$user_id)
             ->orderBy('id','desc')
             ->select('id','name','email','user_id')
             ->get();
        return response()->json(['customers'=>$customers]);
    }

    function listProduct(Request $request){
        $user_id = $request->header('user_id');
        $products =Product::where('user_id','=',$user_id)
             ->orderBy('id','desc')
             ->select('id','name','price','unit')
             ->get();
        return response()->json(['products'=>$products]);
    }
}
