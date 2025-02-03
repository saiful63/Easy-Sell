<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Invoice;

class DashboardController extends Controller
{
    function DashboardPage(Request $request){
        $user_id = $request->header('user_id');
        $Product = Product::where('user_id','=',$user_id)->count();
        $Category = Category::where('user_id','=',$user_id)->count();
        $Customer = Customer::where('user_id','=',$user_id)->count();
        $Invoice = Invoice::where('user_id','=',$user_id)->count();
        $total = Invoice::where('user_id','=',$user_id)->sum('total');
        $vat = Invoice::where('user_id','=',$user_id)->sum('vat');
        $payable = Invoice::where('user_id','=',$user_id)->sum('payable');
        $data = [
            'Product'=>$Product,
            'Category'=>$Category,
            'Customer'=>$Customer,
            'Invoice'=>$Invoice,
            'total'=>$total,
            'vat'=>$vat,
            'payable'=>$payable
        ];
        return Inertia::render('DashboardPage',['list'=>$data]);
    }
}
