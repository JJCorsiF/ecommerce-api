<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
// 	return $request->user();
// });

Route::get('/clientes', 'ClienteController@listarClientes');
Route::get('/clientes/{id}', 'ClienteController@buscarCliente');
Route::post('/clientes', 'ClienteController@adicionarCliente');
Route::put('/clientes/{id}', 'ClienteController@atualizarCliente');
Route::delete('/clientes/{id}', 'ClienteController@deletarCliente');

Route::get('/produtos', 'ProdutoController@listarProdutos');
