<?php

namespace App\Http\Controllers;

use App\Proyecto;
use Illuminate\Http\Request;

class ProyectoController extends Controller
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
    public function index(){
        return view('proyectos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $proyectos = Proyecto::paginate(8);
        foreach ($proyectos as $proyecto) {
            $proyecto->imagenes;
        }
        $response = [
            'pagination' => [
                'total' => $proyectos->total(),
                'per_page' => $proyectos->perPage(),
                'current_page' => $proyectos->currentPage(),
                'last_page' => $proyectos->lastPage(),
                'from' => $proyectos->firstItem(),
                'to' => $proyectos->lastItem()
            ],
            'data' => $proyectos
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
        $imagenes = $request->file("file");
        $proyecto = Proyecto::create([
            'nombre' => $request['nombre'],
            'descripcion' => $request['descripcion'],
        ]);
        foreach ($imagenes as $imagen) {
            $nombre = uniqid() . $imagen->getClientOriginalName();
            $extencion = $imagen->guessExtension();
            $dir = public_path().'/img';
            $subir = $imagen->move($dir, $nombre);
            $proyecto->imagenes()->create([
                'nombre' => $nombre
            ]);
        }
        return response()->json($request, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Proyecto  $proyecto
     * @return \Illuminate\Http\Response
     */
    public function show(Proyecto $proyecto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Proyecto  $proyecto
     * @return \Illuminate\Http\Response
     */
    public function edit(Proyecto $proyecto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Proyecto  $proyecto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proyecto $proyecto){
        $imagenes = $request->file("file");
        $proyecto-> update([
            'nombre' => $request['nombre'],
            'descripcion' => $request['descripcion'],
        ]);
        foreach ($imagenes as $imagen) {
            $nombre = uniqid() . $imagen->getClientOriginalName();
            $extencion = $imagen->guessExtension();
            $dir = public_path().'/img';
            $subir = $imagen->move($dir, $nombre);
            $proyecto->imagenes()->create([
                'nombre' => $nombre
            ]);
        }
        return response()->json('OK', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Proyecto  $proyecto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proyecto $proyecto)
    {
        $proyecto->delete();
        return response()->json('OK', 200);
    }
}
