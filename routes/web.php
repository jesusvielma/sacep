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

Route::get('pdf', 'PdfController@invoice');
Route::get('pdf/ver', function (){
    return view('invoice');
});

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

    Route::resource('factor','FactorDeEvaluacionController',[
        'names' => [
            'index' => 'factores',
            'store' => 'guardar_factor',
            'edit' => 'editar_factor',
            'update' => 'update_factor',
        ]
    ]);

    Route::get('item_factor/{factor}/crear',[
        'uses' => 'ItemFactorController@crear',
        'as'    => 'crear_item'
    ]);

    Route::resource('item_factor','ItemFactorController',[
        'names' => [
            'store' => 'guardar_item'
        ]
    ]);

    Route::resource('usuario','UsuarioController',[
        'names' => [
            'index' => 'usuarios',
            'create'=> 'crear_usuario',
            'store' => 'guardar_usuario',
            'edit'  => 'editar_usuario',
            'update'=> 'update_usuario',
        ]
    ]);

    Route::get('evaluar/{empleado}/evaluar',[
        'uses' => 'EvaluacionController@evaluar',
        'as'   => 'evaluar'
    ]);

    Route::get('evaluaciones/{empleado}',[
        'uses' => 'EvaluacionController@evaluaciones',
        'as'   => 'evaluaciones'
    ]);

    Route::get('evaluar/{evaluacion}/editar',[
        'uses' => 'EvaluacionController@edit',
        'as'   => 'editar_evaluacion'
    ]);

    Route::get('evaluar/{id}/imprimir_evaluacion',[
        'uses' => 'EvaluacionController@imprimir',
        'as'   => 'imprimir_evaluacion'
    ]);

    Route::resource('evaluar','EvaluacionController',[
        'names' => [
            'index' => 'index_evaluar',
            'store' => 'guardar_evaluacion',
            'update'=> 'update_evaluacion',
        ]
    ]);
});
