<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Inertia\Inertia;

class CustomerController extends Controller
{
    function createCustomer(Request $request){
      $user_id = $request->header('user_id');
      $customer=Customer::create([
          'name'=>$request->input('name'),
          'email'=>$request->input('email'),
          'mobile'=>$request->input('mobile'),
          'user_id'=>$user_id
      ]);
      if($customer){
          $data=['message'=>'Customer created successfully','status'=>true,'error'=>''];
          return redirect()->route('CustomerPage')->with($data);
      }else{
         $data=['message'=>'Customer creation fail','status'=>false,'error'=>''];
         return redirect()->route('CustomerPage')->with($data);
      }
    }

    function deleteCustomer(Request $request){
        try{
            $customer_id = $request->id;
            $user_id = $request->header('user_id');
            $delete = Customer::where('user_id','=',$user_id)->where('id','=',$customer_id)->delete();
            $data=['message'=>'Customer deleted successfully','status'=>true,'error'=>''];
            return redirect()->route('CustomerPage')->with($data);
        }catch(Exception $e){
            $data=['message'=>'Customer deletion fail','status'=>false,'error'=>''];
            return redirect()->route('CustomerPage')->with($data);
        }

    }

    function updateCustomer(Request $request){
        $user_id = $request->header('user_id');
        $customer_id = $request->input('id');
        $customer=Customer::where('user_id','=',$user_id)->where('id','=',$customer_id)->update([
            'name'=>$request->input('name'),
            'email'=>$request->input('email'),
            'mobile'=>$request->input('mobile')
        ]);

        if($customer){
          $data=['message'=>'Customer updated successfully','status'=>true,'error'=>''];
          return redirect()->route('CustomerPage')->with($data);
        }else{
            $data=['message'=>'Customer  updatation fail','status'=>false,'error'=>''];
            return redirect()->route('CustomerPage')->with($data);
        }
    }

    function CustomerPage(Request $request){
        $user_id = $request->header('user_id');
        $customers =Customer::where('user_id','=',$user_id)
             ->orderBy('id','desc')
             ->get();
        return Inertia::render('CustomerPage',['list'=>$customers]);
    }
    function CustomerSavePage(Request $request){
        $user_id = $request->header('user_id');
        $customer_id = $request->query('id');
        $customer = Customer::where('user_id',$user_id)->where('id',$customer_id)->first();
        return Inertia::render('CustomerSavePage',['list'=>$customer]);
    }

}
