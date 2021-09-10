<?php

namespace App\Http\Controllers;

use App\Empleado;
use App\Empresa;
use Illuminate\Http\Request;

class EmpleadosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empleados = Empleado::with('empresa')->get();
        $empresas = Empresa::all();
        return view('empleados', compact('empleados','empresas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_empleado'   => 'required',
            'apellido_empleado'   => 'required',
        ],
        [
            'nombre_empleado.required'    => 'Nombre es requerido',
            'apellido_empleado.required'    => 'Apellido es requerido',
            ]
        );

        Empleado::create([
            'nombre' => $request->nombre_empleado,
            'apellido' => $request->apellido_empleado,
            'empresa_id' => $request->empresa_id,
            'email' => $request->email,
            'telefono' => $request->telefono,
        ]);

        return redirect()->back()->with('message', 'Empleado guardado con exito.'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $empleado = Empleado::find($id);
        $request->validate([
            'nombre_empleado'   => 'required',
            'apellido_empleado'   => 'required',
        ],
        [
            'nombre_empleado.required'    => 'Nombre es requerido',
            'apellido_empleado.required'    => 'Apellido es requerido',
            ]
        );
      
        $empleado->update([
            'nombre' => $request->nombre_empleado,
            'apellido' => $request->apellido_empleado,
            'empresa_id' => $request->empresa_id,
            'email' => $request->email,
            'telefono' => $request->telefono,
        ]);

        return redirect()->back()->with('message', 'Empleado guardado con exito.'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Empleado::destroy($id);
        return $id;
    }

    public function getDataEmpleado($id){
        $empleado = Empleado::find($id);

        return $empleado;
    }
}
