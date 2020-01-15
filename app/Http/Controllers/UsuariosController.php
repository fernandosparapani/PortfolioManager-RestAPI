<?php

namespace App\Http\Controllers;

use App\Usuario;
use App\TokenGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\Validator;

class UsuariosController extends Controller
{
    public function list(Request $request){

        return Usuario::select('id', 'nome', 'login', 'updated_at')->get();

    }

    public function store(Request $request){

        $request->validate([
            'nome'=>'required|max:255',
            'login'=>'required|unique:usuarios,login',
            'senha'=>'required'
        ]);

        $senha = $request->input('senha');
        $senha_criptada = password_hash($senha, PASSWORD_DEFAULT);

        $usuario = Usuario::create([
            'nome'=>$request->input('nome'),
            'login'=>$request->input('login'),
            'senha'=>$senha_criptada,
        ]);

        return $usuario;
    }

    public function show(Usuario $usuario){
        return $usuario;
    }

    public function auth(Request $request, Usuario $usuario){

        $login = $request->input('login');
        $senha_decryptada = $request->input('senha');
        $usuarios = DB::select('select * from usuarios where login = :login limit 1;', ['login' => $login]);
        
        foreach ($usuarios as $senha) { 
            $senha_cryptada = $senha->senha;
            $id = $senha->id;
        }

        if(!isset($senha_cryptada)){
            return response()->json(['status'=>'error']);
        }

        if (password_verify($senha_decryptada, $senha_cryptada)) {

            $token = TokenGenerator::GeraHash($login, $senha_decryptada, 30);
            // $atualizado = DB::update('update usuarios set last_token = :last_token where id=:id;',['last_token' =>$token, 'id' => $id]);

            // // Retorna erro caso não consiga atualizar o token
            // if($atualizado === 0){
            //     return response()->json(['status'=>'error']);              
            // }

            return response()->json(['status'=>'ok', 'token'=>$token]);
        } else {
            return response()->json(['status'=>'error']);
        }

    }

    public function update(Request $request, Usuario $usuario){
        $usuario->nome = $request->input('nome');
        $usuario->save();
        return $usuario;
    }

    public function delete(Usuario $usuario){
        $usuario->delete();
        return response()->json(['status'=>'ok']);
    }

}
