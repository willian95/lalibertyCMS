<?php

namespace App\Http\Controllers;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use App\Product;
use App\ProductColorSize;
use App\ProductSecondaryImage;
use Cloudinary;

use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductsExport;

class ProductController extends Controller
{
    function create(){

        return view("products.create");

    }

    function list(){
        return view("products.list");
    }

    function store(ProductStoreRequest $request){
        ini_set('max_execution_time', 0);

        foreach($request->productFormatSizes as $test){

            if($test["size"] == null || $test["color"] == null || $test["price"] == null || $test["stock"] == null){
                //return response()->json($test["format"]["name"]);
                return response()->json(["success" => false, "msg" => "Debe completar todos los campos de las presentaciones"]);
            }

        }

        try{

            $slug = str_replace(" ","-", $request->name);
            $slug = str_replace("/", "-", $slug);

            if(Product::where("slug", $slug)->count() > 0){
                $slug = $slug."-".uniqid();
            }

            $sanitizedDescription = str_replace("\n", "", $request->description);

            $product = new Product;
            $product->name = $request->name;
            $product->category_id = $request->category;
            $product->description = $sanitizedDescription;
            $product->image = $request->image;
            $product->main_image_file_type = $request->mainImageFileType;
            $product->slug = $slug;
            $product->save();

            foreach($request->workImages as $workImage){

                $image = new ProductSecondaryImage;
                $image->product_id = $product->id;
                $image->image = $workImage['finalName'];
                $image->file_type=$workImage["type"];
                $image->save();

            }

            foreach($request->productFormatSizes as $productFormatSize){

                $slug = $product->slug."-".$productFormatSize["color"]["name"]."-".$productFormatSize["size"]["size"];

                if(ProductColorSize::where("slug", $slug)->count() > 0){
                    $slug = $slug."-".uniqid();
                }

                $productFormatSizeModel = new ProductColorSize;
                $productFormatSizeModel->product_id = $product->id;
                //$productFormatSizeModel->format_id = $productFormatSize["format"]["id"];
                $productFormatSizeModel->color_id = $productFormatSize["color"]["id"];
                $productFormatSizeModel->size_id = $productFormatSize["size"]["id"];
                $productFormatSizeModel->price = $productFormatSize["price"];
                $productFormatSizeModel->slug = $slug;
                $productFormatSizeModel->stock = $productFormatSize["stock"];
                $productFormatSizeModel->save();

            }

            return response()->json(["success" => true, "msg" => "Producto creado"]);

        }catch(\Exception $e){
            return response()->json(["success" => true, "false" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

    function fetch($page){

        try{

            $dataAmount = 20;
            $skip = ($page - 1) * $dataAmount;

            $query = Product::with(['category' => function ($q) {
                $q->withTrashed();
            }])->with(['productColorSizes' => function ($q) {
                $q->withTrashed();
            }])->with(['productColorSizes.size' => function ($q) {
                $q->withTrashed();
            }])->with(['productColorSizes.color' => function ($q) {
                $q->withTrashed();
            }]);
           
            $products = $query->skip($skip)->take($dataAmount)->get();
            $productsCount = $query->count();

            return response()->json(["success" => true, "products" => $products, "productsCount" => $productsCount, "dataAmount" => $dataAmount]);

        }catch(\Exception $e){
            return response()->json(["success" => true, "false" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

    function edit($id){

        $product = Product::with(['category' => function ($q) {
            $q->withTrashed();
        }])->with(['productColorSizes' => function ($q) {
            $q->withTrashed();
        }])->with(['productColorSizes.size' => function ($q) {
            $q->withTrashed();
        }])->with(['productColorSizes.color' => function ($q) {
            $q->withTrashed();
        }])->with('secondaryImages')->where("id", $id)->first();

        return view("products.edit", ["product" => $product]);

    }

    function update(ProductUpdateRequest $request){
        ini_set('max_execution_time', 0);

        foreach($request->productFormatSizes as $test){

            if($test["size"] == null || $test["price"] == null || $test["color"] == null || $test["stock"] == null){
                //return response()->json($test["format"]["name"]);
                return response()->json(["success" => false, "msg" => "Debe completar todos los campos de las presentaciones"]);
            }

        }

        try{

            $sanitizedDescription = str_replace("\n", "", $request->description);

            $product = Product::find($request->id);
            $product->name = $request->name;
            $product->category_id = $request->category;
            $product->description = $sanitizedDescription;
            if($request->get("image") != null){
                $product->image =  $request->image;
            }
            $product->main_image_file_type = $request->mainImageFileType;
            $product->update();

            $productTypeArray = [];
            $productTypes = ProductColorSize::where("product_id", $product->id)->get();
            foreach($productTypes as $productType){
                array_push($productTypeArray, $productType->id);
            }

            $requestArray = [];
            foreach($request->productFormatSizes as $productTypeSizeRequest){
                if(array_key_exists("id", $productTypeSizeRequest)){
                    array_push($requestArray, $productTypeSizeRequest["id"]);
                }
            }

            $deleteProductTypes = array_diff($productTypeArray, $requestArray);
            
            foreach($deleteProductTypes as $productDelete){
                ProductColorSize::where("id", $productDelete)->delete();
            }

            foreach($request->productFormatSizes as $productTypeSize){
                
                if(array_key_exists("id", $productTypeSize)){

                    if(ProductColorSize::where("id", $productTypeSize["id"])->count() > 0){
                        $productType = ProductColorSize::find($productTypeSize["id"]);
                        $productType->product_id = $product->id;
                        //$productType->format_id = $productTypeSize["format"]["id"];
                        $productType->color_id = $productTypeSize["color"]["id"];;
                        $productType->size_id = $productTypeSize["size"]["id"];
                        $productType->price = $productTypeSize["price"];
                        $productType->update();
                    }

                }else{
                   
                    $slug = $product->slug."-".$productTypeSize["color"]["name"]."-".$productTypeSize["size"]["size"];

                    if(ProductColorSize::where("slug", $slug)->count() > 0){
                        $slug = $slug."-".uniqid();
                    }

                    $productType = new ProductColorSize;
                    $productType->product_id = $product->id;
                    //$productType->format_id = $productTypeSize["format"]["id"];
                    $productType->color_id =  $productTypeSize["color"]["id"];
                    $productType->size_id = $productTypeSize["size"]["id"];
                    $productType->price = $productTypeSize["price"];
                    $productType->slug = $slug;
                    $productType->stock = $productTypeSize["stock"];
                    $productType->save();
                }
                

            }

            $WorkImagesArray = [];
            $workImages = ProductSecondaryImage::where("product_id", $product->id)->get();
            foreach($workImages as $productSecondaryImage){
                array_push($WorkImagesArray, $productSecondaryImage->id);
            }

            $requestArray = [];
            foreach($request->workImages as $image){
                if(array_key_exists("id", $image)){
                    array_push($requestArray, $image["id"]);
                }
            }

            $deleteWorkImages = array_diff($WorkImagesArray, $requestArray);
            
            foreach($deleteWorkImages as $imageDelete){
                ProductSecondaryImage::where("id", $imageDelete)->delete();
            }

            foreach($request->workImages as $workImage){
                if(isset($workImage["finalName"])){
                    
                    $image = new ProductSecondaryImage;
                    $image->product_id = $product->id;
                    $image->image = $workImage['finalName'];
                    $image->file_type = $workImage["type"];
                    $image->save();
                }

            }
       
            return response()->json(["success" => true, "msg" => "Producto actualizado"]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

    function delete(Request $request){

        try{

            Product::where("id", $request->id)->delete();
            ProductColorSize::where("product_id", $request->id)->delete();

            return response()->json(["success" => true, "msg" => "Producto eliminado"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function excelExport(){

        $excel = ProductColorSize::with("product")
        ->with("product", "size", "color")->get();

        //dd($excel);

        return Excel::download(new ProductsExport, 'productos.xlsx');
    }

    function csvExport(){
        return Excel::download(new ProductsExport, 'productos.csv');
    }
}
