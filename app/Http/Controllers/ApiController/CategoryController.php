<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Inertia\Inertia;


class CategoryController extends Controller
{
    function createCategory(Request $request){
      $user_id = $request->header('id');
      return Category::create([
          'name'=>$request->input('name'),
          'user_id'=>$user_id
      ]);
    }

    function listCategory(Request $request){
      $user_id = $request->header('id');
      return Category::where('user_id','=',$user_id)->get();
    }

    function deleteCategory(Request $request){
        $category_id = $request->input('id');
        $user_id = $request->header('id');
        return Category::where('user_id','=',$user_id)->where('id','=',$category_id)->delete();

    }

    function updateCategory(Request $request){
        $user_id = $request->header('id');
        $category_id = $request->input('id');
        return Category::where('user_id','=',$user_id)->where('id','=',$category_id)->update([
            'name'=>$request->input('name')
        ]);
    }

    function categoryById(Request $request){
        $user_id = $request->header('id');
        $category_id = $request->input('id');
        return Category::where('user_id','=',$user_id)->where('id','=',$category_id)->first();
    }

    function CategoryPage(){
        return Inertia::render('CategoryPage');
    }


}
