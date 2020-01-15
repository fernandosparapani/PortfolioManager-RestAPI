<?php

namespace App\Http\Controllers;

use App\Screenshot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\Validator;

class ScreenshotsController extends Controller
{
    public function list(Request $request){
            
        return Screenshot::all();

    }

    public function store(Request $request){

        $request->validate([
            'nome'=>'required|max:255',
            'id_projeto'=>'required',
            'imagem_caminho'=>'required'
        ]);

        $screenshot = Screenshot::create([
            'nome'=>$request->input('nome'),
            'id_projeto'=>$request->input('id_projeto'),
            'imagem_caminho'=>$request->input('imagem_caminho'),
        ]);

        return $screenshot;
    }

    public function showProjects($id_projeto){

        $screenshots = DB::table('screenshots')->where('id_projeto', '=', $id_projeto)->get();
        return $screenshots;
    }

    public function update(Request $request, Screenshot $screenshot){

        $nome = $request->input('nome');
        $imagem_caminho = $request->input('imagem_caminho');
        $id_projeto = $request->input('id_projeto');

        if((!isset($nome) or (!isset($imagem_caminho)) or (!isset($id_projeto)))){
            return response()->json(['message' => 'JSON incorreto', 'status' => 'error']);
        }

        $screenshot->nome = $nome;
        $screenshot->imagem_caminho = $imagem_caminho;
        $screenshot->id_projeto = $id_projeto;

        if($screenshot->save()){
            return response()->json(['message' => 'Registro alterado com sucesso', 'status' => 'ok']);
        }else{
            return response()->json(['message' => 'Ocorreu um erro ao alterar o registro', 'status' => 'error']);
        }
    }

    public function delete(Screenshot $screenshot){
        $screenshot->delete();
        return response()->json(['message' => 'Registro deletado com sucesso', 'status' => 'ok']);
    }
    

}
