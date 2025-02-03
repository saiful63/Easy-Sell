<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Inertia\Inertia;

class CustomerController extends Controller
{
     function createCustomer(Request $request){
      $user_id = $request->header('id');
      return Customer::create([
          'name'=>$request->input('name'),
          'email'=>$request->input('email'),
          'mobile'=>$request->input('mobile'),
          'user_id'=>$user_id
      ]);
    }

    function listCustomer(Request $request){
      $user_id = $request->header('id');
      return Customer::where('user_id','=',$user_id)->get();
    }

    function deleteCustomer(Request $request){
        $customer_id = $request->input('id');
        $user_id = $request->header('id');
        return Customer::where('user_id','=',$user_id)->where('id','=',$customer_id)->delete();

    }

    function updateCustomer(Request $request){
        $user_id = $request->header('id');
        $customer_id = $request->input('id');
        return Customer::where('user_id','=',$user_id)->where('id','=',$customer_id)->update([
            'name'=>$request->input('name'),
            'email'=>$request->input('email'),
            'mobile'=>$request->input('mobile')
        ]);
    }

    function customerById(Request $request){
        $user_id = $request->header('id');
        $customer_id = $request->input('id');
        return Customer::where('user_id','=',$user_id)->where('id','=',$customer_id)->first();
    }

    function CustomerPage(){
        return Inertia::render('CustomerPage');
    }

}
