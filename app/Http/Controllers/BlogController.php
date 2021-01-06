<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BlogStoreRequest;
use App\Http\Requests\BlogUpdateRequest;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use App\Blog;

class BlogController extends Controller
{
    function create(){

        return view("blogs.create");

    }

    function list(){
        return view("blogs.list");
    }

    function store(BlogStoreRequest $request){
        ini_set('max_execution_time', 0);

        try{

            $imageData = $request->get('image');

            if(strpos($imageData, "svg+xml") > 0){

                $data = explode( ',', $imageData);
                $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.'."svg";
                $ifp = fopen($fileName, 'wb' );
                fwrite($ifp, base64_decode( $data[1] ) );
                rename($fileName, 'images/blogs/'.$fileName);

            }else{

                $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
                Image::make($request->get('image'))->save(public_path('images/blogs/').$fileName);

            }
            

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Hubo un problema con la imagen", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }


        try{

            $slug = str_replace(" ","-", $request->title);
            $slug = str_replace("/", "-", $slug);

            if(Blog::where("slug", $slug)->count() > 0){
                $slug = $slug."-".uniqid();
            }

            $blog = new Blog;
            $blog->title = $request->title;
            $blog->description = $request->description;
            $blog->image = url('/').'/images/blogs/'.$fileName;
            $blog->slug = $slug;
            $blog->created_date = $request->createdDate;
            $blog->save();

            return response()->json(["success" => true, "msg" => "Blog creado"]);

        }catch(\Exception $e){
            return response()->json(["success" => true, "false" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

    function fetch($page,Request $request){

        try{

            $dataAmount = 20;
            $skip = ($page - 1) * $dataAmount;
        
            $blogs = Blog::skip($skip)->take($dataAmount)->orderBy("created_at", $request->orderBy)->get();
            $blogsCount = Blog::count();

            return response()->json(["success" => true, "blogs" => $blogs, "blogsCount" => $blogsCount, "dataAmount" => $dataAmount]);

        }catch(\Exception $e){
            return response()->json(["success" => true, "false" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

    function edit($id){

        $blog = Blog::where("id", $id)->first();

        return view("blogs.edit", ["blog" => $blog]);

    }

    function update(blogUpdateRequest $request){
        ini_set('max_execution_time', 0);


        if($request->get("image") != null){

            try{

                $imageData = $request->get('image');
    
                if(strpos($imageData, "svg+xml") > 0){
    
                    $data = explode( ',', $imageData);
                    $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.'."svg";
                    $ifp = fopen($fileName, 'wb' );
                    fwrite($ifp, base64_decode( $data[1] ) );
                    rename($fileName, 'images/blogs/'.$fileName);
    
                }else{
    
                    $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
                    Image::make($request->get('image'))->save(public_path('images/blogs/').$fileName);
    
                }
                
    
            }catch(\Exception $e){
    
                return response()->json(["success" => false, "msg" => "Hubo un problema con la imagen", "err" => $e->getMessage(), "ln" => $e->getLine()]);
    
            }

        }

        try{

            $blog = Blog::find($request->id);
            $blog->title = $request->title;
            $blog->description = $request->description;
            if($request->get("image") != null){
                $blog->image =  url('/').'/images/blogs/'.$fileName;
            }
            $blog->created_date = $request->createdDate;
            $blog->update();

            return response()->json(["success" => true, "msg" => "Blog actualizado"]);

        }catch(\Exception $e){
            return response()->json(["success" => true, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

    function delete(Request $request){

        try{

            Blog::where("id", $request->id)->delete();

            return response()->json(["success" => true, "msg" => "Blog eliminado"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }
}
