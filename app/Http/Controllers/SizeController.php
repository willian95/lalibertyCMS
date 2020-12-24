<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SizeStoreRequest;
use App\Http\Requests\SizeUpdateRequest;
use App\Size;

class SizeController extends Controller
{
    function index(){
        return view("sizes.index");
    }

    function all(){
        return response()->json(["sizes" => Size::all()]);
    }

    function store(SizeStoreRequest $request){

        try{

            $size = new Size;
            $size->size = $request->size;
            $size->save();

            return response()->json(["success" => true, "msg" => "Tamaño creado"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Hubo un problema", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }
        
    }

    function update(SizeUpdateRequest $request){

        try{

            $size = Size::find($request->id);
            $size->size = $request->size;
            $size->update();

            return response()->json(["success" => true, "msg" => "Tamaño actualizado"]);
            
           

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }
        
    }

    function delete(Request $request){

        try{

            $size = Size::find($request->id);
            $size->delete();

            return response()->json(["success" => true, "msg" => "Tamaño eliminado"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }

    }

    function fetch($page = 1){

        try{

            $dataAmount = 20;
            $skip = ($page - 1) * $dataAmount;

            $sizes = Size::skip($skip)->take($dataAmount)->get();
            $sizesCount = Size::count();

            return response()->json(["success" => true, "sizes" => $sizes, "sizesCount" => $sizesCount, "dataAmount" => $dataAmount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }

    }
}
