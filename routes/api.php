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

Route::group(['middleware' => 'auth:api','cors'], function () {


    Route::resource('cliente', 'ClienteController');
    Route::resource('tipo-veiculo', 'TipoVeiculoController');
    Route::resource('veiculo', 'VeiculoController');
    Route::resource('tipo-servico', 'TipoServicoController');
    Route::resource('servico', 'ServicoController');
    Route::get('veiculo/buscar-cliente-por-placa/{placa}', 'VeiculoController@buscarClientePorPlaca');
    Route::get('servico/enviaremailfimservico/{id}', 'ServicoController@enviarEmailFimServico');
    Route::get('relatorio', 'ServicoController@gerarRelatorio');


    Route::post('logout', 'Auth\LoginController@logout');
    Route::patch('settings/profile', 'Settings\ProfileController@update');
    Route::patch('settings/password', 'Settings\PasswordController@update');
    Route::get('/user', 'UserController@auth');
});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::post('check-email', 'UserController@checkEmail');

    Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
    Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');
});
