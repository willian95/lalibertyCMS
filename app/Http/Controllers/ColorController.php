<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ColorStoreRequest;
use App\Http\Requests\ColorUpdateRequest;
use App\Color;

class ColorController extends Controller
{
    function index(){
        return view("colors.index");
    }

    function all(){
        return response()->json(["colors" => Color::all()]);
    }

    function store(ColorStoreRequest $request){

        try{

            $color = new Color;
            $color->name = $request->name;
            $color->save();

            return response()->json(["success" => true, "msg" => "Color creada"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }
        
    }

    function fetch($page = 1){

        try{

            $dataAmount = 20;
            $skip = ($page - 1) * $dataAmount;

            $colors = Color::skip($skip)->take($dataAmount)->get();
            $colorsCount = Color::count();

            return response()->json(["success" => true, "colors" => $colors, "colorsCount" => $colorsCount, "dataAmount" => $dataAmount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }

    }

    function update(ColorUpdateRequest $request){

        try{

            if(Color::where('name', $request->name)->where('id', '<>', $request->id)->count() == 0){
                
                $color = Color::find($request->id);
                $color->name = $request->name;
                $color->update();

                return response()->json(["success" => true, "msg" => "Color actualizado"]);
            
            }else{

                return response()->json(["success" => false, "msg" => "Este nombre ya existe"]);

            }

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }
        
    }

    function delete(Request $request){

        try{

            $format = Color::find($request->id);
            $format->delete();

            return response()->json(["success" => true, "msg" => "Color eliminado"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }

    }
}
