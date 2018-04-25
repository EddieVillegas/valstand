<?php

namespace App\Http\Controllers;

use App\Noticia;
use App\Http\Requests\NoticiaStoreRequest;
use App\Http\Requests\NoticiaUpdateRequest;
use Illuminate\Http\Request;

class NoticiaController extends Controller
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
    public function index() {
        return view('noticias.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $noticias = Noticia::paginate(8);
        $response = [
            'pagination' => [
                'total' => $noticias->total(),
                'per_page' => $noticias->perPage(),
                'current_page' => $noticias->currentPage(),
                'last_page' => $noticias->lastPage(),
                'from' => $noticias->firstItem(),
                'to' => $noticias->lastItem()
            ],
            'data' => $noticias
        ];
        return response()->json($response, 200);
    }   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NoticiaStoreRequest $request){
        $imagen = $_FILES['file'];
        $nombre = uniqid() . $imagen['name'];
        $dir = public_path().'\\img\\';
        $new_nombre = $dir.$nombre;
        Noticia::create([
            'caratula' => $nombre,
            'titulo' => $request['titulo'],
            'tema' => $request['tema'],
            'contenido' => $request['contenido'],
        ]);
        $subir = move_uploaded_file($imagen['tmp_name'], $dir.$nombre);
        return response()->json('OK', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Noticia  $noticia
     * @return \Illuminate\Http\Response
     */
    public function show(Noticia $noticia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Noticia  $noticia
     * @return \Illuminate\Http\Response
     */
    public function edit(Noticia $noticia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Noticia  $noticia
     * @return \Illuminate\Http\Response
     */
    public function update(NoticiaStoreRequest $request, Noticia $noticia){
        $imagen = $_FILES['file'];
        $nombre = uniqid() . $imagen['name'];
        $dir = public_path().'\\img\\';
        $new_nombre = $dir.$nombre;
        $noticia->update([
            'caratula' => $nombre,
            'titulo' => $request['titulo'],
            'tema' => $request['tema'],
            'contenido' => $request['contenido'],
        ]);
        $subir = move_uploaded_file($imagen['tmp_name'], $dir.$nombre);
        return response()->json('OK', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Noticia  $noticia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Noticia $noticia) {
        $noticia->delete();
        return response()->json('Se elimino la noticia', 200);
    }

    public function buscar(Request $request){
        $noticias = Noticia::buscar($request['nombre']);
        return response()->json($noticias, 200);
    }
}
