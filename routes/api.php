<?php

use Illuminate\Http\Request;
use App\Http\Middleware\TokenAuth;


// Autenticação do usuário
Route::post("auth", "UsuariosController@auth");

// Rotas gerais do usuário (CRUD + listagem)
Route::get("usuarios", "UsuariosController@list");
Route::get("usuarios/{usuario}", "UsuariosController@show");
Route::post("usuarios", "UsuariosController@store")->Middleware(TokenAuth::class);
Route::patch("usuarios/{usuario}", "UsuariosController@update")->Middleware(TokenAuth::class);
Route::delete("usuarios/{usuario}", "UsuariosController@delete")->Middleware(TokenAuth::class);

Route::get("categorias", "CategoriasController@list");
Route::get("categorias/{categoria}", "CategoriasController@show");
Route::post("categorias", "CategoriasController@store")->Middleware(TokenAuth::class);
Route::patch("categorias/{categoria}", "CategoriasController@update")->Middleware(TokenAuth::class);
Route::delete("categorias/{categoria}", "CategoriasController@delete")->Middleware(TokenAuth::class);

Route::get("projetos", "ProjetosController@list");
Route::post("projetos", "ProjetosController@store")->Middleware(TokenAuth::class);
// Route::get("projetos/{categoria}", "ProjetosController@showCategory")->Middleware(TokenAuth::class);
Route::get("projeto/{projeto}", "ProjetosController@showProject");
Route::get("projetos/next/{projeto}", "ProjetosController@next");
Route::patch("projetos/{projeto}", "ProjetosController@update")->Middleware(TokenAuth::class);
Route::delete("projetos/{projeto}", "ProjetosController@delete")->Middleware(TokenAuth::class);

Route::get("screenshots", "ScreenshotsController@list");
Route::post("screenshots", "ScreenshotsController@store")->Middleware(TokenAuth::class);
Route::get("screenshots/{projeto}", "ScreenshotsController@showProjects");
Route::patch("screenshots/{screenshot}", "ScreenshotsController@update")->Middleware(TokenAuth::class);
Route::delete("screenshots/{screenshot}", "ScreenshotsController@delete")->Middleware(TokenAuth::class);

Route::get("backgrounds", "BackgroundsController@list");
Route::post("backgrounds", "BackgroundsController@store")->Middleware(TokenAuth::class);
Route::delete("backgrounds/{background}", "BackgroundsController@delete")->Middleware(TokenAuth::class);
//-> listar screenshots, visualizar screenshots do projeto, visualizar screenshot especifico, deletar screenshot, atualizar screenshot

// cuidados screenshot > quando for salvar o projeto, primeiro precisa enviar a requisicao do projeto, pra depois salvar os prints, 