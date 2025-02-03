<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Inertia\Inertia;
use Log;
use App\Facade\FileDelete;

class ProductController extends Controller
{

    function createProduct(Request $request){
      $user_id = $request->header('user_id');
      if($request->hasFile('img_url')){
          $file = $request->file('img_url');
          $imageName = $user_id.time().$file->getClientOriginalName();
          $destination = public_path('images/products');
          $file->move($destination,$imageName);

      $product=Product::create([
          'name'=>$request->input('name'),
          'price'=>$request->input('price'),
          'unit'=>$request->input('unit'),
          'img_url'=>$imageName,
          'category_id'=>$request->input('category_id'),
          'user_id'=>$user_id
      ]);
      if($product){
          $data=['message'=>'Product created successfully','status'=>true,'error'=>''];
          return redirect()->route('ProductPage')->with($data);
      }else{
         $data=['message'=>'Product creation fail','status'=>false,'error'=>''];
         return redirect()->route('ProductPage')->with($data);
      }
    }
    }

    function deleteProduct(Request $request){
        try{
            $product_id = $request->id;
            $user_id = $request->header('user_id');
            $delete = Product::where('user_id','=',$user_id)->where('id','=',$product_id)->delete();
            $data=['message'=>'Product deleted successfully','status'=>true,'error'=>''];
            return redirect()->route('ProductPage')->with($data);
        }catch(Exception $e){
            $data=['message'=>'Product deletion fail','status'=>false,'error'=>''];
            return redirect()->route('ProductPage')->with($data);
        }

    }

    function updateProduct(Request $request){
        $user_id = $request->header('user_id');
        $product_id = $request->input('id');
        $img_url =$request->input('prev_img');
        if($request->hasFile('img_url')){
            $file = $request->file('img_url');
            $img_url = $user_id.time().$file->getClientOriginalName();
            $destination = public_path('images/products');
            if($request->input('prev_img') && file_exists(public_path('images/products/').$request->input('prev_img'))){
                FileDelete::DeleteImg(public_path('images/products/').$request->input('prev_img'));
            }

            $file->move($destination,$img_url);
        }
        $product=Product::where('user_id','=',$user_id)->where('id','=',$product_id)->update([
            'name'=>$request->input('name'),
            'price'=>$request->input('price'),
            'unit'=>$request->input('unit'),
            'img_url'=>$img_url,
            'category_id'=>$request->input('category_id')
        ]);

        if($product){
          $data=['message'=>'Product updated successfully','status'=>true,'error'=>''];
          return redirect()->route('ProductPage')->with($data);
        }else{
            $data=['message'=>'Product  updatation fail','status'=>false,'error'=>''];
            return redirect()->route('ProductPage')->with($data);
        }
    }

    function ProductPage(Request $request){
        $user_id = $request->header('user_id');
        $products =Product::where('user_id','=',$user_id)
             ->orderBy('id','desc')
             ->get();
        return Inertia::render('ProductPage',['list'=>$products]);
    }

    function ProductSavePage(Request $request){
        $user_id = $request->header('user_id');
        $product_id = $request->query('id');
        $product = Product::where('user_id',$user_id)->where('id',$product_id)->first();
        $categories = Category::where('user_id',$user_id)->select('id','name')->get();
        return Inertia::render('ProductSavePage',['list'=>$product,'categories'=>$categories]);
    }

    function SalePage(){
        return Inertia::render('SalePage');
    }
}
