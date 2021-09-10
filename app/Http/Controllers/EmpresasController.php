<?php

namespace App\Http\Controllers;

use App\Empresa;
use Illuminate\Http\Request;

class EmpresasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empresas = Empresa::all();
        return view('empresas', compact('empresas'));
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
            'nombre_empresa'   => 'required',
            'email'    => 'required|email|unique:empresas',
            'logotipo_empresa' => 'required',
            'web_empresa'      => 'required',
        ],
        [
            'nombre_empresa.required'    => 'Nombre es requerido',
            'email.email' => 'Introducir email valido',
            'email.unique' => 'Email ya existente, introducir otro email valido',        
            'email.required' => 'Email es requerido',
            'logotipo_empresa.required'    => 'Logo es requerido',
            'web_empresa.required'    => 'Sitio web es requerido',
            ]
        );

        $path = $request->file('logotipo_empresa')->store('/public');
        $empresa = Empresa::create([
            'nombre' => $request->nombre_empresa,
            'email' => $request->email,
            'logotipo' => $path,
            'sitio_web' => $request->web_empresa
        ]);

        return redirect()->back()->with('message', 'Empresa guardada con exito.'); 
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
        $empresa = Empresa::find($id);
        if($empresa->email != $request->email){
            $request->validate([
                'nombre_empresa'   => 'required',
                'email'    => 'required|email|unique:empresas',
                'web_empresa'      => 'required',
            ],
            [
                'nombre_empresa.required'    => 'Nombre es requerido',
                'email.email' => 'Introducir email valido',
                'email.unique' => 'Email ya existente, introducir otro email valido',        
                'email.required' => 'Email es requerido',
                'web_empresa.required'    => 'Sitio web es requerido',
                ]
            );
        }else{
            $request->validate([
                'nombre_empresa'   => 'required',
                'web_empresa'      => 'required',
            ],
            [
                'nombre_empresa.required'    => 'Nombre es requerido',
                'web_empresa.required'    => 'Sitio web es requerido',
                ]
            );
        }
        $empresa->update([
            'nombre' => $request->nombre_empresa,
            'email' => $request->email,
            'sitio_web' => $request->web_empresa
        ]);

        if($request->file('logotipo_empresa')){
            $path = $request->file('logotipo_empresa')->store('/public');
            $empresa->update([
                'logotipo' => $path
            ]);
        }
        
        return redirect()->back()->with('message', 'Empresa actualizada con exito.'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Empresa::destroy($id);
        return $id;
    }

    public function getDataEmpresa($id){
        $empresa = Empresa::find($id);

        return $empresa;
    }
}
