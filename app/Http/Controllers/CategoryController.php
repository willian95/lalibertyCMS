<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use App\Category;
use Cloudinary;

class CategoryController extends Controller
{
    function index(){
        return view("categories.index");
    }

    function all(){
        
        return response()->json(["categories" => Category::all()]);

    }

    function store(CategoryStoreRequest $request){

        try{

            $imageData = $request->get('image');

            if(strpos($imageData, "svg+xml") > 0){

                $fileName=Cloudinary::upload($request->get('image'))->getSecurePath();

            }else{

                $fileName=Cloudinary::upload($request->get('image'))->getSecurePath();

            }

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Hubo un problema con la imágen", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

        try{

            $slug = str_replace(" ", "-", $request->name);
            $slug = str_replace("/", "-", $slug);

            if(Category::where("slug", $slug)->count() > 1){
                $slug = $slug."-".uniqid();
            }

            $category = new Category;
            $category->name = $request->name;
            $category->image = $fileName;
            $category->slug = $slug;
            $category->save();

            return response()->json(["success" => true, "msg" => "Categoría creada"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }
        
    }

    function fetch($page = 1){

        try{

            $dataAmount = 20;
            $skip = ($page - 1) * $dataAmount;

            $categories = Category::skip($skip)->take($dataAmount)->get();
            $categoriesCount = Category::count();

            return response()->json(["success" => true, "categories" => $categories, "categoriesCount" => $categoriesCount, "dataAmount" => $dataAmount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }

    }

    function update(CategoryUpdateRequest $request){

        if($request->get('image') != null){

            try{

                $imageData = $request->get('image');
    
                if(strpos($imageData, "svg+xml") > 0){
    
                    $fileName=Cloudinary::upload($request->get('image'))->getSecurePath();
    
                }else{
    
                    $fileName=Cloudinary::upload($request->get('image'))->getSecurePath();
    
                }
    
            }catch(\Exception $e){
    
                return response()->json(["success" => false, "msg" => "Hubo un problema con la imágen", "err" => $e->getMessage(), "ln" => $e->getLine()]);
    
            }

        }

        try{

            if(Category::where('name', $request->name)->where('id', '<>', $request->id)->count() == 0){
                
                $category = Category::find($request->id);
                $category->name = $request->name;
                if($request->get('image') != null){
                    $category->image = $fileName;
                }
                $category->update();

                return response()->json(["success" => true, "msg" => "Categoría actualizada"]);
            
            }else{

                return response()->json(["success" => false, "msg" => "Este nombre ya existe"]);

            }

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }
        
    }

    function delete(Request $request){

        try{

            $category = Category::find($request->id);
            $category->delete();

            return response()->json(["success" => true, "msg" => "Categoría eliminada"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }

    }
}
