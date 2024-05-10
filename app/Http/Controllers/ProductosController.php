<?php

namespace App\Http\Controllers;

use App\Models\Negocios;
use App\Models\Productos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductosController extends Controller
{
    public function index(){

        //Opción 1
        // $productos = Productos::with('negocio')
        // ->whereHas('negocio', function($query){
        //     $query->where('usuario_id', auth()->user()->id)
        // })
        // ->orderBy('id', 'DESC')->paginate(10);

        //Opción 2
        // $negocios = Negocios::where('usuario_id', auth()->user()->id)->get();
        // $arrayNegocios = [];
        // foreach($negocios as $value){
        //     $arraNegocios[]= $value->id;
        // }
        // $productos = Productos::whereIn('negocio_id', $arrayNegocios)->orderBy('id', 'DESC')->paginate(10);

        //Opción 3
        $arrayNeg = Negocios::where('usuario_id', auth()->user()->id)->get()->pluck('id');
        $productos = Productos::whereIn('negocio_id', $arrayNeg)->orderBy('id', 'DESC')->paginate(10);


        return view('productos.index', compact('productos'));
    }
    public function create()
    {
        $negocios = Negocios::where('usuario_id', auth()->user()->id)->get();
        return view('productos.create', compact('negocios'));
    }
    public function store(Request $request)
    {
        $this->validate($request, [

            'nombre' => 'required',
            'imagen' => 'nullable|image|mimes:png,jpg,jpeg',
            'descripcion' => 'nullable|string|min:10|max:500',
            'costo'=> 'required|numeric',
            'negocio_id'=>'required|exists:negocios,id',

        ]);

        if($request->file('imagen')){
            $imagen = $request->file('imagen');
            $nombreImagen = uniqid('producto_') . '.png';
            if(!is_dir(public_path('/imagenes/productos/'))){
                // mkdir(public_path('/imagenes/categorias/') , 0777);
                File::makeDirectory(public_path().'/imagenes/productos/',0777,true);
            }
            $subido = $imagen->move(public_path().'/imagenes/productos/', $nombreImagen);
        } else {
            $nombreImagen = 'default.png';
        }

    $negocio = new Productos();
    $negocio->nombre = $request->nombre;
    $negocio->imagen = $nombreImagen;
    $negocio->descripcion = $request->descripcion;
    $negocio->costo = $request->costo;
    $negocio->estado = true;
    $negocio->negocio_id = $request->negocio_id;
    if($negocio->save()){
        return redirect('/productos')->with('success', 'Registro agregado ');

    }else{
        return back()->with('error', 'El campo registro no fué realizado');
    }
}
public function edit($id){
    $negocios = Negocios::where('usuario_id', auth()->user()->id)->get();
    $producto = Productos::find ($id);
    return view('productos.edit', compact('negocios', 'producto'));
}
public function update(Request $request, $id){
    $this->validate($request, [

        'nombre' => 'required',
        'imagen' => 'nullable|image|mimes:png,jpg,jpeg',
        'descripcion' => 'nullable|string|min:10|max:500',
        'costo'=> 'required|numeric',
        'negocio_id'=>'required|exists:negocios,id',

    ]);
    $producto = Productos::find($id);

    if($request->file('imagen')){
        if($producto->image != 'default.png'){
            if(file_exists(public_path().'/imagenes/producto/'.$producto->imagen)){
                unlink(public_path().'/imagenes/producto/'.$producto->imagen);
            }
        }
        $imagen = $request->file('imagen');
        $nombreImagen = uniqid('productos_') . '.png';
        if(!is_dir(public_path('/imagenes/productos/'))){
            // mkdir(public_path('/imagenes/categorias/') , 0777);
            File::makeDirectory(public_path().'/imagenes/productos/',0777,true);
        }
        $subido = $imagen->move(public_path().'/imagenes/productos/', $nombreImagen);
        $producto->imagen = $nombreImagen;
    }
    $producto->nombre = $request->nombre;
    $producto->costo = $request->costo;
    $producto->estado = true;
    $producto->descripcion = $request->descripcion;
    $producto->negocio_id = $request->negocio_id;
    if($producto->save()){
        return redirect('/productos')->with('success', 'Registro actualizado correctamente');
    }else{
        return back()->with('error', 'El registro no fué actualizado');
    }
}
public function estado($id){
    $producto = Productos::find($id);
    $producto->estado = !$producto->estado;
    if($producto->save()){
        return redirect('/productos')->with('success', 'Estado actualizado correctamente');
    }else{
        return back()->with('error', 'El estado no fué actualizado');
    }

}
}
