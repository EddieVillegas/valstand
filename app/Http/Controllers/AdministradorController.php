<?php

namespace App\Http\Controllers;

use App\Administrador;
use Illuminate\Http\Request;
use App\Http\Requests\AdministradorStoreRequest;
use App\Http\Requests\AdministradorUpdateRequest;

class AdministradorController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('administradores.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $administradores = Administrador::activos();
        $response = [
            'pagination' => [
                'total' => $administradores->total(),
                'per_page' => $administradores->perPage(),
                'current_page' => $administradores->currentPage(),
                'last_page' => $administradores->lastPage(),
                'from' => $administradores->firstItem(),
                'to' => $administradores->lastItem()
            ],
            'data' => $administradores
        ];
        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdministradorStoreRequest $request) {
        Administrador::create([
            'nombre' => $request['nombre'],
            'apellido_paterno' => $request['apellido_paterno'],
            'apellido_materno' => $request['apellido_materno'],
            'usuario' => $request['usuario'],
            'email' => $request['email'],
            'password' => bcrypt($request['password'])
        ]);
        return response()->json('Administrador creado con exito', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Administrador  $administrador
     * @return \Illuminate\Http\Response
     */
    public function show(Administrador $administrador)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Administrador  $administrador
     * @return \Illuminate\Http\Response
     */
    public function edit(Administrador $administrador)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Administrador  $administrador
     * @return \Illuminate\Http\Response
     */
    public function update(AdministradorUpdateRequest $request, Administrador $administradore) {
        
        $administradore->update([
            'nombre' => $request['nombre'],
            'apellido_paterno' => $request['apellido_paterno'],
            'apellido_materno' => $request['apellido_materno'],
            'usuario' => $request['usuario'],
            'email' => $request['email']
        ]);
        return response()->json('Administrador Actualizado con exito', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Administrador  $administrador
     * @return \Illuminate\Http\Response
     */
    public function destroy(Administrador $administradore) {
        $administradore->delete();
        return response()->json('Se elimino correctamente el administrador');
    }

    public function buscar(Request $request) {
        $administradores = Administrador::buscar($request['nombre']);
        return response()->json($administradores, 200);
    }
}
