<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Producto;

class ProductoController extends Controller
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
            $productos = Producto::join('categorias','productos.idcategoria','=','categorias.id')
                                    ->select('productos.*','categorias.nombre as categoria')
                                    ->latest('productos.id')->paginate(2);
        }else{
            $productos = Producto::join('categorias','productos.idcategoria','=','categorias.id')
                                    ->select('productos.*','categorias.nombre as categoria')
                                    ->where('productos.'.$request->tipoBusq, 'like', '%'.$request->search.'%')
                                    ->latest('productos.id')->paginate(2);
        }
        return $productos;
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
        $productos = new Producto();
        $productos->idcategoria = $request->idcategoria;
        $productos->codigo = $request->codigo;
        $productos->nombre = $request->nombre;
        $productos->precio_venta = $request->precio_venta;
        $productos->stock = $request->stock;
        $productos->condicion = '1';
        $productos->save();
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
        $productos = Producto::findOrFail($request->id);
        $productos->idcategoria = $request->idcategoria;
        $productos->codigo = $request->codigo;
        $productos->nombre = $request->nombre;
        $productos->precio_venta = $request->precio_venta;
        $productos->stock = $request->stock;
        $productos->condicion = '1';
        $productos->save();
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
        $productos = Producto::findOrFail($request->id);
        $productos->condicion = '0';
        $productos->save();
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
        $productos = Producto::findOrFail($request->id);
        $productos->condicion = '1';
        $productos->save();
    }
}
