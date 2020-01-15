<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Projeto extends Model
{
    protected $fillable = ['nome', 'descricao', 'imagem_caminho', 'id_categoria', 'vimeo', 'vimeo_descricao'];
}

