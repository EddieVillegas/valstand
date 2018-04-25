<?php

namespace App\Http\Controllers;

use App\socio;
use Illuminate\Http\Request;

class SocioController extends Controller
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
        return view('socios.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $socios = Socio::paginate(8);
        $response = [
            'pagination' => [
                'total' => $socios->total(),
                'per_page' => $socios->perPage(),
                'current_page' => $socios->currentPage(),
                'last_page' => $socios->lastPage(),
                'from' => $socios->firstItem(),
                'to' => $socios->lastItem()
            ],
            'data' => $socios
        ];
        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $imagen = $request->file("file");
        $nombre = uniqid() . $imagen->getClientOriginalName();
        $extencion = $imagen->guessExtension();
        $dir = public_path().'/img';
        $subir = $imagen->move($dir, $nombre);
        Socio::create([
            'nombre' => $request['nombre'],
            'logotipo' => $nombre,
        ]);
        return response()->json('Se agrego el socio con exito', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\socio  $socio
     * @return \Illuminate\Http\Response
     */
    public function show(socio $socio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\socio  $socio
     * @return \Illuminate\Http\Response
     */
    public function edit(socio $socio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\socio  $socio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, socio $socio) {
        $imagen = $request->file("file");
        $nombre = uniqid() . $imagen->getClientOriginalName();
        $extencion = $imagen->guessExtension();
        $dir = public_path().'/img';
        $subir = $imagen->move($dir, $nombre);
        $socio->update([
            'nombre' => $request['nombre'],
            'logotipo' => $nombre,
        ]);
        return response()->json('Se actualizo el socio con exito', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\socio  $socio
     * @return \Illuminate\Http\Response
     */
    public function destroy(socio $socio) {
        $socio->delete();
    }
}
