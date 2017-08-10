<?php

namespace sacep\Http\Controllers;

use sacep\ItemFactor;
use Illuminate\Http\Request;

class ItemFactorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function crear($id_factor)
    {
        $data['factor'] = $id_factor;
        return view('item_factor.crear',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        foreach ($request->get('campos') as $campo){
            $data[] = [
                'nombre' => strtoupper($campo['nombre']),
                'visivilidad' => $campo['visibilidad'],
                'informacion' => $campo['informacion'],
                'id_factor' => $request->get('id_factor')
            ];
        }

        ItemFactor::insert($data);

        $msg = [
            'type' => 'success',
            'msg' => 'Se han agregado item al factor seleccionado',
            'title' => 'Item agregados',
        ];

        return redirect()->route('factores')->with('notif', $msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \sacep\ItemFactor  $itemFactor
     * @return \Illuminate\Http\Response
     */
    public function show(ItemFactor $itemFactor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \sacep\ItemFactor  $itemFactor
     * @return \Illuminate\Http\Response
     */
    public function edit(ItemFactor $itemFactor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \sacep\ItemFactor  $itemFactor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ItemFactor $itemFactor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \sacep\ItemFactor  $itemFactor
     * @return \Illuminate\Http\Response
     */
    public function destroy(ItemFactor $itemFactor)
    {
        //
    }
}
