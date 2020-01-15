<?php

namespace App\Http\Controllers;

use App\Projeto;
use App\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\Validator;

class ProjetosController extends Controller
{
    public function list(Request $request){
            
        $projetos = DB::table('projetos')
        ->join('categorias', 'projetos.id_categoria', '=', 'categorias.id')
        ->select('projetos.*', 'categorias.nome as nome_categoria')
        ->get();

        $categorias = DB::table('categorias')->get();
        $collection = collect($projetos);
        $grouped = $collection->groupBy('nome_categoria');
        $grouped->toArray();

        return $grouped;

    }

    public function store(Request $request){

        $request->validate([
            'nome'=>'required|max:255',
            'id_categoria'=>'required',
            'imagem_caminho'=>'required'
        ]);

        $projeto = Projeto::create([
            'nome'=>$request->input('nome'),
            'descricao'=>$request->input('descricao'),
            'id_categoria'=>$request->input('id_categoria'),
            'imagem_caminho'=>$request->input('imagem_caminho'),
            'vimeo'=>$request->input('vimeo'),
            'vimeo_descricao'=>$request->input('vimeo_descricao')
        ]);

        return $projeto;
    }

    public function showCategory($id_categoria){

        $projetos = DB::table('projetos')->where('id_categoria', '=', $id_categoria)->get();
        return $projetos;
    }

    public function showProject($id_projeto){

        $projetos = DB::table('projetos')
        ->join('categorias', 'projetos.id_categoria', '=', 'categorias.id')
        ->select('projetos.*', 'categorias.nome as nome_categoria')
        ->where('projetos.id', '=', $id_projeto)
        ->get();

        return $projetos;
    }

    public function update(Request $request, Projeto $projeto){

        $nome = $request->input('nome');
        $descricao = $request->input('descricao');
        $vimeo = $request->input('vimeo');
        
        $imagem_caminho = $request->input('imagem_caminho');
        
        $id_categoria = $request->input('id_categoria');
        $vimeo_descricao = $request->input('vimeo_descricao');

        if((!isset($nome)) or (!isset($id_categoria)) or (!isset($vimeo)) or (!isset($descricao)) ){
            return response()->json(['message' => 'JSON incorreto', 'status' => 'error']);
        }

        $projeto->nome = $nome;
        $projeto->descricao = $descricao;

        if (!is_null($imagem_caminho)) {
            $projeto->imagem_caminho = $imagem_caminho;
        }        

        $projeto->id_categoria = $id_categoria;
        $projeto->vimeo = $vimeo;
        $projeto->vimeo_descricao = $vimeo_descricao;

        if($projeto->save()){
            return response()->json(['message' => 'Registro alterado com sucesso', 'status' => 'ok']);
        }else{
            return response()->json(['message' => 'Ocorreu um erro ao alterar o registro', 'status' => 'error']);
        }
    }

    public function delete(Projeto $projeto){
        $projeto->delete();
        return response()->json(['message' => 'Registro deletado com sucesso', 'status' => 'ok']);
    }

    public function next($id_projeto){
        $projetos = DB::table('projetos')->where('id', '<>', $id_projeto)->inRandomOrder()->limit(2)->get();
        return $projetos;
    }

}
