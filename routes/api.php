<?php

use Illuminate\Http\Request;

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


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->get('/user/gestor', function (Request $request) {
    return $request->user()->isAdministratorOuGestor();
});

Route::group(['middleware' => 'auth:api'], function() {
   Route::get('cartoes', 'CartaoController@all');
   
});

Route::get('evento/{evento_id}/terminal/{terminal_id}/menu', [
        'as' => 'menu_evento', 
        'uses' => 'MenuController@getMenu'
]);

Route::get('evento/{evento_id}/menu', 'MenuController@getMenuSite');

Route::delete('user/{id}', ['as' => 'delete_user', 'uses' => 'UserController@delete']);

Route::post('login', 'Auth\LoginController@loginApi');
Route::post('logout', 'Auth\LoginController@logoutApi');


Route::post('cartao', 'CartaoController@store');
Route::get('transacoes', 'TransacaoController@all');
Route::get('transacoes/{id}', 'TransacaoController@show');
Route::post('transacao', 'TransacaoController@store');
Route::put('transacao/{id}', 'TransacaoController@update');
Route::delete('transacao/{id}', 'TransacaoController@delete');
Route::put('transacao/{id}/estorno', 'TransacaoController@estorno');


Route::get('cartao/{id}', 'CartaoController@show');

Route::put('cartao/{id}', 'CartaoController@update');
Route::get('cartao/{id}/block','CartaoController@toogleBlock');
Route::get('cartao/{id}/status', [
    'as' => 'status_cartao', 
    'uses' => 'CartaoController@status'
]);

Route::delete('cartao/{id}', 'CartaoController@delete');
Route::get('evento/{id}/terminais', 'TerminalController@all');
Route::get('user/{id}/cartoes', 'CartaoController@getCartoesPorUser');
Route::post('terminal', 'TerminalController@store');
Route::put('evento/{id}/terminal/{terminal_id}', 'TerminalController@update');
Route::get('terminal/{id}/block', ['as' => 'block_terminal', 'uses' => 'TerminalController@toogleBlock']);
Route::get('terminal/{id}/status', ['as' => 'status_terminal', 'uses' => 'TerminalController@status']);
Route::get('terminal/{id}/status_sync', ['as' => 'status_terminal_sync', 'uses' => 'TerminalController@statusSync']);
Route::delete('terminal/{id}', 'TerminalController@delete');


Route::get('users', 'UserController@index');
Route::get('user/{id}', 'UserController@show');
Route::post('user', 'UserController@store');
Route::put('user/{id}', 'UserController@update');
Route::post('user/role', 'UserController@updateRoles');

Route::get('user/{id}/block', ['as' => 'block_user', 'uses' => 'UserController@toogleBlock']);

Route::delete('evento/{id}', [
    'as' => 'delete_evento', 
    'uses' => 'EventoController@delete'
]);

Route::post('evento', [
    'as' => 'cria_evento', 
    'uses' => 'EventoController@store'
]);

Route::delete('menu/{id}', [
    'as' => 'delete_menu', 
    'uses' => 'MenuController@delete'
]);

Route::get('evento/{id_evento}/menu/{id_menu}', [
    'as' => 'get_menu', 
    'uses' => 'MenuController@show'
]);

Route::get('eventos', 'EventoController@getAtivos');

Route::post('evento/{id_evento}/usuarios', 'EventoController@setFuncionarios');
Route::get('evento/{id_evento}/usuarios', 'EventoController@getFuncionariosApi');



