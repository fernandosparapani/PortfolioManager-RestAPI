<?php

namespace App\Http\Controllers;

use App\Background;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Validator;

class BackgroundsController extends Controller
{
    public function list(Request $request){
            
        return Background::all();

    }

    public function store(Request $request){

        $request->validate([
            'imagem_caminho'=>'required|max:255',
        ]);

        $background = Background::create([
            'imagem_caminho'=>$request->input('imagem_caminho'),
        ]);

        return $background;
    }

    public function delete(Background $background){
        $background->delete();
        return response()->json(['status'=>'ok']);
    }

}
