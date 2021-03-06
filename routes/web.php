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
    Route::resource('configuracion/departamento','DepartamentoController');

    Route::resource('empleado','EmpleadoController',[
        'names' => [
            'index' => 'empleados',
            'create' => 'empleado_nuevo',
            'store' => 'guardar_empelado',
            'edit' => 'editar_empleado',
            'update' => 'update_empleado',
        ]
    ]);

    Route::resource('configuracion/cargo','CargoController',[
        'names' => [
            'index' => 'cargos',
            'store' => 'guardar_cargo',
            'edit' => 'cargo_editar',
            'update' => 'cargo_update',
        ]
    ]);

    Route::resource('configuracion/factor','FactorDeEvaluacionController',[
        'names' => [
            'index' => 'factores',
            'store' => 'guardar_factor',
            'edit' => 'editar_factor',
            'update' => 'update_factor',
            'destroy' => 'eliminar_factor'
        ]
    ]);

    Route::get('configuracion/item_factor/{factor}/crear',[
        'uses' => 'ItemFactorController@crear',
        'as'    => 'crear_item'
    ]);

    Route::resource('configuracion/item_factor','ItemFactorController',[
        'names' => [
            'store' => 'guardar_item'
        ]
    ]);

    Route::get('perfil',[
        'uses' => 'UsuarioController@perfil',
        'as'   => 'perfil'
    ]);

    Route::post('perfil/{usuario}',[
        'uses' => 'UsuarioController@avatar',
        'as'   => 'avatar'
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

    Route::get('evaluaciones/ver_empleados',[
        'uses' => 'EvaluacionController@ver_empleados',
        'as'   => 'ver_empleados'
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

    Route::get('procesar_evaluaciones',[
        'uses' => 'EvaluacionController@procesar_index',
        'as'   => 'procesar_index'
    ]);

    Route::get('procesar_evaluaciones/{evaluacion}',[
        'uses' => 'EvaluacionController@procesar_una',
        'as'   => 'procesar_una'
    ]);

    Route::post('procesar_evaluaciones',[
        'uses' => 'EvaluacionController@procesar_varias',
        'as'   => 'procesar_varias'
    ]);

    Route::get('evaluacion/eliminar/{evaluacion}',[
        'uses' => 'EvaluacionController@eliminar',
        'as'   => 'eliminar evaluación'
    ]);


    Route::resource('evaluar','EvaluacionController',[
        'names' => [
            'index' => 'index_evaluar',
            'store' => 'guardar_evaluacion',
            'update'=> 'update_evaluacion',
        ],
    ]);

    Route::get('operaciones_masivas',[
        'uses' => 'OperacionesMasivasController@index',
        'as'   => 'operaciones_masivas'
    ]);

    Route::post('operaciones_masivas',[
        'uses' => 'OperacionesMasivasController@procesar_subida',
        'as'   => 'procesar_om'
    ]);

    Route::get('material/crear/{departamento}',[
        'uses'  => 'MaterialController@create',
        'as'    => 'crear_material'
    ]);

    Route::resource('material','MaterialController',[
        'names' => [
            'index' => 'materiales',
            'store' => 'guardar_material',
            'edit'  => 'editar_material',
            'update'=> 'update_material',
            'show'  => 'mostrar_material'
        ]
    ]);

    Route::resource('configuracion/sanciones','ArticuloController',[
        'names' => [
            'index' => 'articulos',
            'create'=> 'articulo_nuevo',
            'store' => 'guardar_articulo',
            'edit'  => 'editar_articulo',
            'update'=> 'update_articulo',
        ],
        'parameters' => [
            'sanciones' => 'articulo'
        ]
    ]);

    Route::get('acta/{empleado}/nueva',[
        'uses'  => 'ActaController@crear',
        'as'    => 'acta_nueva'
    ]);

    Route::get('acta/{empleado}/ver',[
        'uses'  => 'ActaController@ver',
        'as'    => 'ver_actas'
    ]);

    Route::get('imprimir_acta/{acta}',[
        'uses'  => 'ActaController@imprimir_acta',
        'as'    => 'imprimir_acta'
    ]);

    Route::get('procesar_actas',[
        'uses' => 'ActaController@procesar_index',
        'as'   => 'procesar_actas'
    ]);

    Route::get('procesar_actas/{acta}',[
        'uses' => 'ActaController@procesar_una',
        'as'   => 'procesar_acta'
    ]);

    Route::post('procesar_actas',[
        'uses' => 'ActaController@procesar_varias',
        'as'   => 'procesar_varias_actas'
    ]);

    Route::get('actas_llamados',[
        'uses'  => 'ActaController@index',
        'as'    => 'actas'
    ]);

    Route::resource('acta', 'ActaController',[
        'names' => [
            'store' => 'guardar_acta',
            'edit'  => 'editar_acta',
            'update'=> 'update_acta',
        ],
        'parameters' => [
            'acta' => 'acta'
        ]
    ]);

    Route::get('llamado/{empleado}/nuevo',[
        'uses'  => 'LlamadoController@crear',
        'as'    => 'llamado_nuevo'
    ]);

    Route::get('llamado/{empleado}/ver',[
        'uses'  => 'LlamadoController@ver',
        'as'    => 'ver_llamados'
    ]);

    Route::get('imprimir_llamado/{llamado}',[
        'uses'  => 'LlamadoController@imprimir_llamado',
        'as'    => 'imprimir_llamado'
    ]);

    Route::resource('llamados','LlamadoController',[
        'names' => [
            'store' => 'guardar_llamado',
            'edit'  => 'editar_llamado',
            'update'=> 'update_llamado',
        ]
    ]);
    Route::get('backup', [
        'uses' => 'BackupController@index',
        'as' => 'backup'
    ]);

    Route::put('backup/create', [
        'uses'=> 'BackupController@create',
        'as'=>'crear_backup'
    ]);

    Route::get('backup/descargar/{file_name?}', [
        'uses' => 'BackupController@download',
        'as'=>'descargar_b'
    ]);
    Route::delete('backup/delete/{file_name?}', 'BackupController@delete')->where('file_name', '(.*)');
    
});
