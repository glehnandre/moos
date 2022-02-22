<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/teste', function () {
    return view('teste');
});


Auth::routes();


Route::get('/', 'HomeController@index')->middleware('auth');

Route::get('/eventos/detalhe', 'EventoController@detalheEvento')->middleware('auth');
Route::get('/eventos', 'EventoController@index')->middleware('auth');
Route::get('/evento/{id_evento}','EventoController@show')->middleware('auth');
Route::post('/eventos', 'EventoController@store')->middleware('auth');
Route::put('/evento/{id_evento}','EventoController@update')->middleware('auth');
Route::get('/evento/{id_evento}/transacoes','TransacaoController@getTransacoes')->middleware('auth');
Route::get('/evento/{evento_id}/terminal/{terminal_id}/transacoes','TransacaoController@getTransacoesTerminal')->middleware('auth');
Route::get('/evento/{id_evento}/menu','MenuController@index');
Route::post('/evento/{id_evento}/menu', ['uses' =>'MenuController@store'])->middleware('auth');
Route::put('/evento/{id_evento}/menu/{id_menu}', ['uses' =>'MenuController@update'])->middleware('auth');
Route::post('/evento/{id_evento}/menu/{id_menu}/imagem', ['uses' =>'MenuController@saveImage']);
Route::get('/evento/{id_evento}/terminais', 'TerminalController@getTerminaisTodos')->middleware('role:admin|gestor');
Route::get('/evento/{id_evento}/usuarios', 'EventoController@getFuncionarios')->middleware('role:admin|gestor');
Route::get('/evento/{id}/active', 'EventoController@toogleAtivo')->middleware('auth');
Route::get('/menu/restricoes', 'MenuBlacklistController@index')->middleware('auth');
Route::post('/menu/restricoes', 'MenuBlacklistController@salvar')->middleware('auth');
Route::get('/menu/evento/{evento_id}', 'MenuBlacklistController@getEventos')->middleware('auth');
Route::get('/menu/evento/{evento_id}/cartao/{cartao_id}', 'MenuBlacklistController@getMenuBlacklist')->middleware('auth');


Route::get('/cartoes', 'CartaoController@getTableCartoes')->middleware('auth');
Route::get('/cartao/{id}/transacoes', 'TransacaoController@show')->middleware('auth');
Route::get('/cartao/{id}/block', 'CartaoController@toogleBlock')->middleware('auth');
Route::get('/cartao/{id}/inativar', 'CartaoController@delete')->middleware('role:admin|gestor');

Route::get('/users', 'UserController@index')->middleware('auth');
Route::get('/user/{id}/cartoes', 'CartaoController@showForUser')->middleware('auth');
Route::get('/user/{id}/block', 'UserController@toogleBlock')->middleware('auth');
Route::get('user/{id}/delete', 'UserController@delete')->middleware('auth');

Route::get('/terminal/{id}/active', 'TerminalController@toogleAtivo')->middleware('auth');
Route::get('/terminal/{id}/block', 'TerminalController@toogleBlock')->middleware('auth');
Route::get('/terminal/{id}/sync', 'TerminalController@forceSync')->middleware('auth');
Route::get('/terminal/{id}/fechar', 'TerminalController@fechar')->middleware('auth');
Route::post('/terminal/{id}/conferir', 'TerminalController@conferir')->middleware('auth');
Route::get('/terminais', 'TerminalController@getTerminaisAtivos')->middleware('role:admin');

Route::get('/geolocalizacao/creditos', 'GeolocalizacaoCreditosController@index')->middleware('auth');
Route::get('/geolocalizacao/vendas', 'GeolocalizacaoVendasController@index')->middleware('auth');

Route::get('transacoes/valor/{valor}/origem/{cartao_id_origem}/destino/{cartao_id_destino}', 'TransacaoController@transferencia');
