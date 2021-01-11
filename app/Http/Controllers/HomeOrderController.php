<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Work;
use App\Product;
use App\Blog;
use App\HomeOrder;

class HomeOrderController extends Controller
{
    
    function index(){

        return view("homeOrder.index");

    }

    function fetchWorks(){

        $works = Work::with("workImages")->where("is_fashion_merch", 0)->get();
        return response()->json(["works" => $works]);

    }

    function fetchFashionMerch(){

        $fashionMerch = Work::with("workImages")->where("is_fashion_merch", 1)->get();
        return response()->json(["fashionMerch" => $fashionMerch]);

    }

    function fetchProducts(){

        $products = Product::with("secondaryImages")->get();
        return response()->json(["products" => $products]);

    }

    function fetchBlogs(){

        $blogs = Blog::all();
        return response()->json(["blogs" => $blogs]);

    }

    function store(Request $request){

        $homeOrder = new HomeOrder;
        if($request->type == "works" || $request->type == "fashion merch"){

            if(isset($request->element["work_id"])){
                $homeOrder->work_image_id = $request->element["id"];
            }else{
                $homeOrder->work_id = $request->element["id"];
            }

        }else if($request->type == "products"){

            if(isset($request->element["product_id"])){
                $homeOrder->product_secondary_image_id = $request->element["id"];
            }else{
                $homeOrder->product_id = $request->element["id"];
            }

        }else if($request->type == "blogs"){

            $homeOrder->blog_id = $request->element["id"];

        }

        $homeOrder->order = $request->order;
        $homeOrder->save();

        return response()->json(["success" => true, "msg" => "Elemento agregado al home"]);

    }

    function fetchElements(){

        $elements = HomeOrder::with("work", "workImage", "product", "productImage", "blog")->orderBy("order")->get();
        return response()->json(["elements" => $elements]);

    }

    function delete(Request $request){

        $homeOrder = HomeOrder::find($request->id);
        $homeOrder->delete();

        return response()->json(["success" => true, "msg" => "Elemento eleminado del home"]);

    }

    function update(Request $request){


        $homeOrder = HomeOrder::find($request->orderId);
        $homeOrder->order = $request->order;
        $homeOrder->update();

        return response()->json(["success" => true, "msg" => "Elemento actualizado"]);

    }

}
