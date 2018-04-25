<?php

namespace App\Http\Controllers;

use App\imagen;
use Illuminate\Http\Request;

class ImagenController extends Controller
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
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\imagen  $imagen
     * @return \Illuminate\Http\Response
     */
    public function show(imagen $imagen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\imagen  $imagen
     * @return \Illuminate\Http\Response
     */
    public function edit(imagen $imagen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\imagen  $imagen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, imagen $imagen)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\imagen  $imagen
     * @return \Illuminate\Http\Response
     */
    public function destroy(imagen $imagene)
    {
        $imagene->delete();
        return response()->json('OK', 200);
    }
}
