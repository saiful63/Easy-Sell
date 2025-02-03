<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Models\Invoice;
use App\Models\Customer;
use App\Models\InvoiceProduct;
use Log;

class InvoiceController extends Controller
{
    function CreateInvoice(Request $request){
      DB::beginTransaction();
      try{
         $user_id = $request->header('id');
         $total = $request->input('total');
         $discount = $request->input('discount');
         $vat = $request->input('vat');
         $payable = $request->input('payable');
         $customer_id = $request->input('customer_id');

         $invoice = Invoice::create([
           'user_id'=>$user_id,
           'total'=>$total,
           'discount'=>$discount,
           'vat'=>$vat,
           'payable'=>$payable,
           'customer_id'=>$customer_id
         ]);

         $invoice_id = $invoice->id;
         $products = $request->input('products');
         foreach($products as $each_products){

            InvoiceProduct::create([
                'invoice_id'=>$invoice_id,
                'product_id'=>$each_products['product_id'],
                'user_id'=>$user_id,
                'qty'=>$each_products['qty'],
                'sale_price'=>$each_products['sale_price']
            ]);
         }

         DB::commit();
         return 1;
      }catch(Exception $e){
         DB::rollback();
         return $e->getMessage();
      }
    }

    function SelectInvoice(Request $request){
         $user_id = $request->header('id');
         return Invoice::where('user_id','=',$user_id)->with('customer')->get();
    }

    function InvoiceDetail(Request $request){
         $user_id = $request->header('id');
         $CustomerDetail = Customer::where('user_id','=',$user_id)->where('id','=',$request->input('cus_id'))->first();
         $InvoiceTotal = Invoice::where('user_id','=',$user_id)->where('id','=',$request->input('inv_id'))->first();
         $InvoiceProduct = InvoiceProduct::where('user_id','=',$user_id)->where('id','=',$request->input('inv_id'))
                           ->with('product')->get();
         return array(
             'CustomerDetail'=>$CustomerDetail,
             'InvoiceTotal'=>$InvoiceTotal,
             'InvoiceProduct'=>$InvoiceProduct
         );
    }

    function DeleteInvoice(Request $request){
        $user_id = $request->header('id');
        DB::beginTransaction();
        try{
          InvoiceProduct::where('invoice_id','=',$request->input('inv_id'))
                        ->where('user_id','=',$user_id)->delete();

          Invoice::where('id','=',$request->input('inv_id'))->delete();
          DB::commit();
          return 1;
        }catch(Exception $e){
          DB::rollback();
          return 0;
        }
    }
}
