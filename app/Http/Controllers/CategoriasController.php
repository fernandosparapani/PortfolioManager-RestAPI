<?php

namespace App\Http\Controllers;

use App\Categoria;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Validator;

class CategoriasController extends Controller
{
    public function list(Request $request){

        return Categoria::all();

    }

    public function store(Request $request){

        $request->validate([
            'nome'=>'required|max:255',
        ]);

        $categoria = Categoria::create([
            'nome'=>$request->input('nome'),
        ]);

        return $categoria;
    }

    public function show(Categoria $categoria){
        return $categoria;
    }

    public function update(Request $request, Categoria $categoria){
        $categoria->nome = $request->input('nome');
        $categoria->save();
        return $categoria;
    }

    public function delete(Categoria $categoria){
        $categoria->delete();
        return response()->json(['status'=>'ok']);
    }

}
