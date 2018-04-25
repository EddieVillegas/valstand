<?php

namespace App\Http\Controllers;

use App\Subasta;
use Illuminate\Http\Request;

class SubastaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('subastas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subastas = Subasta::paginate(8);
        $response = [
            'pagination' => [
                'total' => $subastas->total(),
                'per_page' => $subastas->perPage(),
                'current_page' => $subastas->currentPage(),
                'last_page' => $subastas->lastPage(),
                'from' => $subastas->firstItem(),
                'to' => $subastas->lastItem()
            ],
            'data' => $subastas
        ];
        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $imagen = $request->file("file");
        $nombre = uniqid() . $imagen->getClientOriginalName();
        $extencion = $imagen->guessExtension();
        $dir = public_path().'/img';
        $subir = $imagen->move($dir, $nombre);
        Subasta::create([
            'nombre' => $request['nombre'],
            'descripcion' => $request['descripcion'],
            'caratula' => $nombre,
        ]);
        return response()->json('Se agrego el socio con exito', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subasta  $subasta
     * @return \Illuminate\Http\Response
     */
    public function show(Subasta $subasta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subasta  $subasta
     * @return \Illuminate\Http\Response
     */
    public function edit(Subasta $subasta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subasta  $subasta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subasta $subasta){
        if(!$request->file('file')){
            $subasta->update($request->all());
            return response()->json('Se actualizo la subasta con exito', 200);
        }
        $imagen = $request->file("file");
        $nombre = uniqid() . $imagen->getClientOriginalName();
        $extencion = $imagen->guessExtension();
        $dir = public_path().'/img';
        $subir = $imagen->move($dir, $nombre);
        $subasta->update([
            'nombre' => $request['nombre'],
            'descripcion' => $request['descripcion'],
            'caratula' => $nombre,
        ]);
        return response()->json('Se actualizo el socio con exito', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subasta  $subasta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subasta $subasta){
        $subasta->delete();
        return response()->json("Se elimino la subasta", 200);
    }

    public function buscar(Request $request) {
        $subastas = Subasta::buscar($request['nombre']);
        return response()->json($subastas, 200);
    }
}
