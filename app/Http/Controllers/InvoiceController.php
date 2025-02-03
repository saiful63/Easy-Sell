<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Models\Invoice;
use App\Models\Customer;
use App\Models\InvoiceProduct;
use Log;
use Inertia\Inertia;

class InvoiceController extends Controller
{
    function CreateInvoice(Request $request){

      DB::beginTransaction();
      try{
         $user_id = $request->header('user_id');
         $total = $request->input('total');
         $discount = $request->input('totalDiscount');
         $vat = $request->input('totalVat');
         $payable = $request->input('afterDiscount');
         $customer_id = $request->customerToInvoice['id'];

         $invoice = Invoice::create([
           'user_id'=>$user_id,
           'total'=>$total,
           'discount'=>$discount,
           'vat'=>$vat,
           'payable'=>$payable,
           'customer_id'=>$customer_id
         ]);

         $invoice_id = $invoice->id;
         $products = $request->input('invoiceListProduct');

         foreach($products as $each_products){
            InvoiceProduct::create([
                'invoice_id'=>$invoice_id,
                'product_id'=>$each_products['product_id'],
                'user_id'=>$user_id,
                'qty'=>$each_products['qty'],
                'sale_price'=>$each_products['price']
            ]);
         }

         DB::commit();
         return 1;
      }catch(Exception $e){
         DB::rollback();
         return $e->getMessage().$e->getLine();
      }
    }

    function SelectInvoice(Request $request){
         $user_id = $request->header('id');
         return Invoice::where('user_id','=',$user_id)->with('customer')->get();
    }

    function InvoiceDetail(Request $request){
        try{
            $user_id = $request->header('user_id');
            $InvoiceProduct = InvoiceProduct::where('user_id','=',$user_id)->select('id','product_id')->where('invoice_id','=',$request->query('inv_id'))
                            ->with(['product:id,name,price,unit'])->get();
            return array(
                'InvoiceProduct'=>$InvoiceProduct
            );
        }catch(Exception $e){
            return $e->getMessage().$e->getLine();
        }

    }

    function DeleteInvoice(Request $request){
        $user_id = $request->header('user_id');
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

    function InvoicePage(Request $request){
        $user_id = $request->header('user_id');
        $invoices =Invoice::select('id','total','discount','vat','payable','customer_id')
             ->where('user_id','=',$user_id)
             ->with(['customer:id,name,mobile'])
             ->orderBy('id','desc')
             ->get();
        return Inertia::render('InvoicePage',['invoices'=>$invoices]);
    }

     function InvoiceList(Request $request){
        $user_id = $request->header('user_id');
        $invoices =Invoice::select('id','total','discount','vat','payable','customer_id')
             ->where('user_id','=',$user_id)
             ->with(['customer:id,name,mobile'])
             ->orderBy('id','desc')
             ->get();
        return response()->json([
            'invoices'=>$invoices
        ]);
    }
}
