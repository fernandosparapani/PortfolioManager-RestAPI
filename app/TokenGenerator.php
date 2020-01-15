<?php

namespace App;

class TokenGenerator 
{
    public static function GeraHash($login, $senha_decryptada, $qtd){
        //Under the string $Caracteres you write all the characters you want to be used to randomly generate the code.
        $Caracteres = 'ABCDEFGHIJKLMOPQRSTUVXWYZ0123456789';
        $QuantidadeCaracteres = strlen($Caracteres);
        $QuantidadeCaracteres--;
        
        $Hash=NULL;
            for($x=1;$x<=$qtd;$x++){
                $Posicao = rand(0,$QuantidadeCaracteres);
                $Hash .= substr($Caracteres,$Posicao,1);
            }

            date_default_timezone_set('America/Sao_Paulo');
            $date = date('Y-m-d H:i:s');

            $Hash .= '.' . $login . ';' . $senha_decryptada . '*' . $date;
            $encrypted_hash = openssl_encrypt($Hash,"AES-128-ECB",'n1tr4t0');
        
        return $encrypted_hash;
    }
}