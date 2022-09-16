<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class productController extends Controller
{
    public function getProducts(){
        $product = Product::all();
        return response()->json($product, 200);
    }

    public function getProduct($id){
        
        $product = Product::find($id);

        return response()->json($product, 200);
    }
    
    public function addProduct(Request $request){
        
       
        if($request->hasFile('image')){
             $complateFileName = $request->file('image')->getClientOriginalName();
             $fileNameOnly = pathinfo($complateFileName, PATHINFO_FILENAME);
             $extension = $request->file('image')->getClientOriginalExtension();
             $compPic= str_replace(' ', '_', $fileNameOnly ).'-'.rand().'-'.time().'.'.$extension;
             $path = $request->file('image')->storeAs('public/products',$compPic);
 
             $request->image = $compPic;
         }
 
 
         $product = Product::create(
             [
                 'title'=> $request->title,
                 'description'=> $request->description,
                 'price'=> $request->price,
                 'image'=> $request->image,
                 'stock'=>$request->isInStock,
                 'brand_id'=>$request->brandId,
                 'category_id'=>$request->categoryId

             ]
         );
         return response()->json($product,201);
     }
}
