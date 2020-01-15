<?php

namespace App\Http\Middleware;

use Closure;
use DateTime;
use Illuminate\Support\Facades\DB;

class TokenAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->input('token');

        if(isset($token)){

            $decrypted_string = openssl_decrypt($token,"AES-128-ECB",'n1tr4t0');
            $login_pos = strpos($decrypted_string, '.');
            $pass_pos = strpos($decrypted_string, ';');
            $hora_pos = strpos($decrypted_string, '*');
            $posicao_login = ($pass_pos-1) - $login_pos;
            $posicao_pass = ($hora_pos-1) - $pass_pos;
            $login = substr($decrypted_string, ($login_pos+1), $posicao_login);
            $pass  = substr($decrypted_string, ($pass_pos+1), $posicao_pass);
            $hora  = substr($decrypted_string, ($hora_pos+1));

            date_default_timezone_set('America/Sao_Paulo');
            $data_atual = new DateTime("now");

            $data_token = DateTime::createFromFormat('Y-m-d H:i:s', $hora);
 
            $interval = date_diff($data_atual, $data_token);

            if($interval->i > 30){
                return response()->json(['status'=>'error, token expirado (30 minutos)']);
            }

            $usuarios = DB::select('select login, senha from usuarios where login = :login limit 1;', 
            [
                'login' => $login,
            ]);

            foreach ($usuarios as $senha) { 
                $senha_cryptada = $senha->senha;
            }

            if(!isset($senha_cryptada)){
                return response()->json(['status'=>'error']);
            }

            if (password_verify($pass, $senha_cryptada)){
                return $next($request);
            }else{
                return response()->json(['message' => 'Autenticação inválida'], 401);
            }
            
        }else{
            return response()->json(['status'=>'error, token inválido']);
        }
    }
}
