<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Inertia\Inertia;
use Log;


class CategoryController extends Controller
{
    function createCategory(Request $request){
      $user_id = $request->header('user_id');
      $category=Category::create([
          'name'=>$request->input('name'),
          'user_id'=>$user_id
      ]);
      if($category){
          $data=['message'=>'Category created successfully','status'=>true,'error'=>''];
          return redirect()->route('CategoryPage')->with($data);
      }else{
         $data=['message'=>'Category creation fail','status'=>false,'error'=>''];
         return redirect()->route('CategoryPage')->with($data);
      }
    }

    function deleteCategory(Request $request){
        try{
            $category_id = $request->id;
            $user_id = $request->header('user_id');
            $delete = Category::where('user_id','=',$user_id)->where('id','=',$category_id)->delete();
            $data=['message'=>'Category deleted successfully','status'=>true,'error'=>''];
            return redirect()->route('CategoryPage')->with($data);
        }catch(Exception $e){
            $data=['message'=>'Category deletion fail','status'=>false,'error'=>''];
            return redirect()->route('CategoryPage')->with($data);
        }

    }

    function updateCategory(Request $request){
        $user_id = $request->header('user_id');
        $category_id = $request->input('id');
        $category=Category::where('user_id','=',$user_id)->where('id','=',$category_id)->update([
            'name'=>$request->input('name')
        ]);

        if($category){
          $data=['message'=>'Category updated successfully','status'=>true,'error'=>''];
          return redirect()->route('CategoryPage')->with($data);
        }else{
            $data=['message'=>'Category  updatation fail','status'=>false,'error'=>''];
            return redirect()->route('CategoryPage')->with($data);
        }
    }

    function CategoryPage(Request $request){
        $user_id = $request->header('user_id');
        $categories =Category::where('user_id','=',$user_id)
             ->orderBy('id','desc')
             ->get();
        return Inertia::render('CategoryPage',['list'=>$categories]);
    }

    function CategorySavePage(Request $request){
        $user_id = $request->header('user_id');
        $category_id = $request->query('id');
        $category = Category::where('user_id',$user_id)->where('id',$category_id)->first();
        return Inertia::render('CategorySavePage',['list'=>$category]);
    }
}
