<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        if($request->search == ''){
            $categorias = Categoria::latest('id')->paginate(2);
        }else{
            $categorias = Categoria::where($request->tipoBusq, 'like', '%'.$request->search.'%')
                                            ->latest('id')->paginate(2);
        }
        return $categorias;
    }

    public function selectCategoria(Request $request){
        if(!$request->ajax()) return redirect('/');
        $categorias = Categoria::where('condicion', '=', '1')
                                ->select('id','nombre')
                                ->orderBy('nombre','asc')->get();
        return $categorias;
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
        if(!$request->ajax()) return redirect('/');
        $categorias = new Categoria();
        $categorias->nombre = $request->nombre;
        $categorias->descripcion = $request->descripcion;
        $categorias->condicion = '1';
        $categorias->save();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $categorias = Categoria::findOrFail($request->id);
        $categorias->nombre = $request->nombre;
        $categorias->descripcion = $request->descripcion;
        $categorias->condicion = '1';
        $categorias->save();
    }

    /**
     * Desative the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function Desactivar(Request $request)
    {
        //
        if(!$request->ajax()) return redirect('/');
        $categorias = Categoria::findOrFail($request->id);
        $categorias->condicion = '0';
        $categorias->save();
    }

    /**
     * Active the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function Activar(Request $request)
    {
        //
        if(!$request->ajax()) return redirect('/');
        $categorias = Categoria::findOrFail($request->id);
        $categorias->condicion = '1';
        $categorias->save();
    }
}
