<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\WorkStoreRequest;
use App\Http\Requests\WorkUpdateRequest;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use App\Work;
use App\WorkImage;
use Cloudinary;

class WorkController extends Controller
{
    function create(){

        return view("works.create");

    }

    function list(){
        return view("works.list");
    }

    function store(WorkStoreRequest $request){
        ini_set('max_execution_time', 0);


        try{

            $slug = str_replace(" ","-", $request->title);
            $slug = str_replace("/", "-", $slug);

            if(Work::where("slug", $slug)->count() > 0){
                $slug = $slug."-".uniqid();
            }

            $sanitizedDescription = str_replace("\n", "", $request->description);

            $work = new work;
            $work->title = $request->title;
            $work->client_name = $request->clientName;
            $work->description = $sanitizedDescription;
            $work->main_image = $request->image;
            $work->slug = $slug;
            $work->is_fashion_merch = $request->isFashionMerch;
            $work->created_date = $request->createdDate;
            $work->save();

            foreach($request->workImages as $workImage){

                $image = new WorkImage;
                $image->work_id = $work->id;
                $image->image = $workImage['finalName'];
                $image->file_type = $workImage['type'];
                $image->save();

            }

            return response()->json(["success" => true, "msg" => "Producto creado"]);

        }catch(\Exception $e){
            return response()->json(["success" => true, "false" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

    function fetch($page, Request $request){

        try{

            $dataAmount = 20;
            $skip = ($page - 1) * $dataAmount;
           
            $works = Work::skip($skip)->take($dataAmount)->orderBy("created_date", $request->orderBy)->get();
            $worksCount = Work::count();

            return response()->json(["success" => true, "works" => $works, "worksCount" => $worksCount, "dataAmount" => $dataAmount]);

        }catch(\Exception $e){
            return response()->json(["success" => true, "false" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

    function edit($id){

        $product = Work::where("id", $id)->with("workImages")->first();

        return view("works.edit", ["product" => $product]);

    }

    function update(WorkUpdateRequest $request){
        ini_set('max_execution_time', 0);


        if($request->get("image") != null){

            try{

                $imageData = $request->get('image');
    
                if(strpos($imageData, "svg+xml") > 0){
    
                    $fileName=Cloudinary::upload($request->get('image'))->getSecurePath();
    
                }
                else if(strpos($imageData, "gif") > 0){

                    $fileName=Cloudinary::upload($request->get('image'))->getSecurePath();
    
                }
                else{
    
                    $fileName=Cloudinary::upload($request->get('image'))->getSecurePath();
    
                }
                
    
            }catch(\Exception $e){
    
                return response()->json(["success" => false, "msg" => "Hubo un problema con la imagen", "err" => $e->getMessage(), "ln" => $e->getLine()]);
    
            }

        }

        try{

            $sanitizedDescription = str_replace("\n", "", $request->description);

            $work = Work::find($request->id);
            $work->title = $request->title;
            $work->client_name = $request->clientName;
            $work->description = $sanitizedDescription;
            if($request->get("image") != null){
                $product->main_image =  $fileName;
            }
            $work->is_fashion_merch = $request->isFashionMerch;
            $work->created_date = $request->createdDate;
            $work->update();

            $WorkImagesArray = [];
            $workImages = WorkImage::where("work_id", $work->id)->get();
            foreach($workImages as $productType){
                array_push($WorkImagesArray, $productType->id);
            }

            $requestArray = [];
            foreach($request->workImages as $image){
                if(array_key_exists("id", $image)){
                    array_push($requestArray, $image["id"]);
                }
            }

            $deleteWorkImages = array_diff($WorkImagesArray, $requestArray);
            
            foreach($deleteWorkImages as $imageDelete){
                WorkImage::where("id", $imageDelete)->delete();
            }

            foreach($request->workImages as $image){
                
                $isVideo = false;
                if($image["image"] != null && !array_key_exists("id", $image)){

                    try{
        
                        $imageData = $image['image'];
                        
                        if(explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[0] == "video"){
                            $isVideo = true;
                            $fileName=Cloudinary::uploadVideo($request->get('image'))->getSecurePath();
                        }
                        if(strpos($imageData, "svg+xml") > 0){
            
                            $fileName=Cloudinary::upload($request->get('image'))->getSecurePath();
            
                        }
                        else if(strpos($imageData, "gif") > 0){

                            $fileName=Cloudinary::upload($request->get('image'))->getSecurePath();
            
                        }
                        else{
            
                            $fileName=Cloudinary::upload($request->get('image'))->getSecurePath();
            
                        }
                        
            
                    }catch(\Exception $e){
                     
                        return response()->json(["success" => false, "msg" => "Hubo un problema con la imagen", "err" => $e->getMessage(), "ln" => $e->getLine()]);
            
                    }

                    $workImage = new WorkImage;
                    $workImage->work_id = $work->id;
                    $workImage->image = $fileName;
                    if($isVideo == true){
                        $workImage->file_type = "video";
                    }
                    $workImage->save();
        
                }

            }

            return response()->json(["success" => true, "msg" => "Work actualizado"]);

        }catch(\Exception $e){
            return response()->json(["success" => true, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

    function delete(Request $request){

        try{

            Work::where("id", $request->id)->delete();
            WorkImage::where("work_id", $request->id)->delete();

            return response()->json(["success" => true, "msg" => "Work eliminado"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

}
