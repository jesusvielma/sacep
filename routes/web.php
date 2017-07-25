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

Route::get('/entrar',[
    'uses' => 'LoginController@mostrarFormularioLogin',
    'as'   => 'mostrar_login'
]);

Route::post('/entrar',[
    'uses' => 'LoginController@postLogin',
    'as'   => 'post_login'
]);

Route::group(['middleware'=>'auth'], function (){

    Route::get('/salir', [
        'uses' => 'LoginController@salir',
        'as'   => 'salir',
    ]);

    Route::get('/', [
        'uses' => 'InicioController@index',
        'as'   => 'pagina_inicio',
    ]);
    Route::resource('departamento','DepartamentoController');

    Route::resource('empleado','EmpleadoController',[
        'names' => [
            'index' => 'empleados',
            'create' => 'empleado_nuevo',
            'store' => 'guardar_empelado',
            'edit' => 'editar_empleado',
            'update' => 'update_empleado'
        ]
    ]);

    Route::resource('cargo','CargoController',[
        'names' => [
            'index' => 'cargos',
            'store' => 'guardar_cargo',
            'edit' => 'cargo_editar',
            'update' => 'cargo_update',
        ]
    ]);
});
