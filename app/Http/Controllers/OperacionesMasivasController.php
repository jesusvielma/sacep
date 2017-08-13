<?php

namespace sacep\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use sacep\Cargo;
use sacep\Usuario;
use sacep\Empleado;
use sacep\Departamento;

class OperacionesMasivasController extends Controller
{

	/**
	* Muestra el formulario para subir un archivo para carga masiva de data
	* @return \Illuminate\Http\Response
	*/
    public function index()
    {
		$this->authorize('admin',Usuario::class);
    	return view('operaciones_masivas.index');
    }


	/**
	* Procesar la data enviada por el formulario
	* @param \Illuminate\Http\Request $request
	* @return \Illuminate\Http\Response
	*/
	public function procesar_subida(Request $request)
	{
		$archivo = $request->file('archivo');

		if ($archivo->getClientOriginalExtension() != 'csv') {
			return redirect()->route('operaciones_masivas')->withErrors(['error_csv'=> 'El tipo de archivo no puede ser procesado']);
		}

		$data = [];
		$data2 = [];
		$registrados = 0;
		$tipo ='';

		$res=Excel::load($archivo, function ($reader){

		})->get();

		if ($request->get('tipo') == 'coords') {
			foreach ($res as $key => $coord) {
				if ($coord->padre != '') {
					$dep = Departamento::firstOrCreate(['nombre' => $coord->nombre],['padre'=>$coord->padre,'tipo'=>$coord->tipo]);
				}else{
					$dep = Departamento::firstOrCreate(['nombre' => $coord->nombre],['tipo'=>$coord->tipo]);
				}

				if (!$dep->wasRecentlyCreated) {
					$data[$key] = [
						'nombre' => $coord->nombre
					];
				}else{
					$registrados++;
				}
			}
			$tipo='Coordinación/Unidad';
		}
		elseif ($request->get('tipo') == 'cargo') {
			foreach ($res as $key => $coord) {
				$dep = Cargo::firstOrCreate(['nombre' => $coord->nombre],['estado'=>1]);
				if (!$dep->wasRecentlyCreated) {
					$data[$key] = [
						'nombre' => $coord->nombre
					];
				}else{
					$registrados++;
				}
			}
			$tipo='Cargos';
		}
		else{
			foreach ($res as $key => $empleado) {
				$cargo = Cargo::where('nombre','=',$empleado->cargo)->first();
				$dep = Departamento::where('nombre',$empleado->departamento)->first();
				if($cargo && $dep){
					$emp = Empleado::firstOrCreate(['cedula_empleado'=>$empleado->cedula],['nombre_completo'=>$empleado->nombre,'fecha_ingreso'=>$empleado->fecha_ingreso,'fecha_nacimiento'=>$empleado->fecha_nacimiento,'id_cargo'=>$cargo->id_cargo,'id_departamento'=>$dep->id_departamento]);
					if (!$emp->wasRecentlyCreated) {
						$data[$key] = [
							'nombre' => $empleado->nombre,
						];
					}else{
						$registrados++;
					}
				}else{
					if (!$cargo && !$dep){
						$faltantes = 'Cargo y Coordinación/Unidad';
						$suministrado = 'Cargo: '.($empleado->cargo != '' ? $empleado->cargo : 'Vacio').' Coordinación/Unidad: '.($empleado->departamento != '' ? $empleado->depatamento : 'Vacio');
					}
					elseif (!$cargo) {
						$faltantes = 'Cargo';
						$suministrado = 'Cargo: '.($empleado->cargo != '' ? $empleado->cargo : 'Vacio');
					}
					elseif (!$dep) {
						$faltantes = 'Coordinación/uniddad';
						$suministrado = 'Coordinación/Unidad: '.($empleado->departamento != '' ? $empleado->depatamento : 'Vacio');
					}
					$data2[$key] = [
						'nombre' => $empleado->nombre,
						'cedula' => $empleado->cedula,
						'faltantes' => $faltantes,
						'suministrado' => $suministrado
					];
				}
			}
			$tipo='Trabajadores';
		}

		$data_vac = array_filter($data);
		$data2_vac = array_filter($data2);

		if (!empty($data_vac) || !empty($data2_vac) ) {
			$msg = [
	            'type' => 'success',
	            'msg' => 'Se han creado '.$registrados.' registros para el tipo de carga '.$tipo,
	            'title' => 'Cargar masiva completa',
	        ];

			return redirect()->route('operaciones_masivas')->with('no_creados',$data)->with('notif',$msg)->with('nocreado',$data2);
		}

		$msg = [
            'type' => 'success',
            'msg' => 'Se han creado '.$registrados.' registros para el tipo de carga '.$tipo,
            'title' => 'Cargar masiva completa',
        ];

		return redirect()->route('operaciones_masivas')->with('notif',$msg);
	}
}
