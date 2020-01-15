<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Screenshot extends Model
{
    protected $fillable = ['nome', 'imagem_caminho', 'id_projeto'];
}
