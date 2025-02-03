<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Inertia\Inertia;

class ProductController extends Controller
{

     function createProduct(Request $request){
      $user_id = $request->header('id');
      return Product::create([
          'name'=>$request->input('name'),
          'price'=>$request->input('price'),
          'unit'=>$request->input('unit'),
          'img_url'=>$request->input('img_url'),
          'category_id'=>$request->input('category_id'),
          'user_id'=>$user_id
      ]);
    }

    function listProduct(Request $request){
      $user_id = $request->header('id');
      return Product::where('user_id','=',$user_id)->get();
    }

    function deleteProduct(Request $request){
        $product_id = $request->input('id');
        $user_id = $request->header('id');
        return Product::where('user_id','=',$user_id)->where('id','=',$product_id)->delete();

    }

    function updateProduct(Request $request){
        $user_id = $request->header('id');
        $product_id = $request->input('id');
        return Product::where('user_id','=',$user_id)->where('id','=',$product_id)->update([
            'name'=>$request->input('name'),
            'price'=>$request->input('price'),
            'unit'=>$request->input('unit'),
            'img_url'=>$request->input('img_url'),
            'category_id'=>$request->input('category_id')
        ]);
    }

    function ProductById(Request $request){
        $user_id = $request->header('id');
        $product_id = $request->input('id');
        return Product::where('user_id','=',$user_id)->where('id','=',$product_id)->first();
    }

    function ProductPage(){
        return Inertia::render('ProductPage');
    }
}
