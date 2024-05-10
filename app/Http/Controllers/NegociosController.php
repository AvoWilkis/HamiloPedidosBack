<?php

namespace App\Http\Controllers;

use App\Models\Negocios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class NegociosController extends Controller
{
    //

    public function index(){

        $negocios = Negocios::orderBy('id', 'DESC')->paginate(10);

        return view('negocios.index', compact('negocios'));
    }
    public function create()
    {
        return view('negocios.create');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'nombre' => 'required|unique:negocios',
            'imagen' => 'nullable|image|mimes:png,jpg,jpeg',
            'descripcion' => 'nullable|string|min:10|max:500',

        ]);

        if($request->file('imagen')){
            $imagen = $request->file('imagen');
            $nombreImagen = uniqid('negocios_') . '.png';
            if(!is_dir(public_path('/imagenes/negocios/'))){
                // mkdir(public_path('/imagenes/categorias/') , 0777);
                File::makeDirectory(public_path().'/imagenes/negocios/',0777,true);
            }
            $subido = $imagen->move(public_path().'/imagenes/negocios/', $nombreImagen);
        } else {
            $nombreImagen = 'default.png';
        }

    $negocio = new Negocios();
    $negocio->nombre = $request->nombre;
    $negocio->imagen = $nombreImagen;
    $negocio->descripcion = $request->descripcion;
    $negocio->estado = true;
    $negocio->usuario_id = auth()->user()->id;
    if($negocio->save()){
        return redirect('/negocios')->with('success', 'Registro agregado ');

    }else{
        return back()->with('error', 'El campo registro no fué realizado');
    }
}
public function edit($id){
    $negocio = Negocios::find($id);
    return view('negocios.edit', compact('negocio'));
}
public function update(Request $request, $id){
    $this->validate($request, [
        'nombre'=> 'required|unique:negocios,nombre,'.$id,
        'imagen'=> 'nullable|image|mimes:png,jpg,jpeg',
        'descricion'=>'required|string|min:10|max:500',
    ]);
    $negocio = Negocios::find($id);

    if($request->file('imagen')){
        if($negocio->image != 'default.png'){
            if(file_exist(public_path().'/imagenes/negocios/'.$negocio->imagen)){
                unlink(public_path().'/imagenes/negocios/'.$negocio->imagen);
            }
        }
        $imagen = $request->file('imagen');
        $nombreImagen = uniqid('negocios_') . '.png';
        if(!is_dir(public_path('/imagenes/negocios/'))){
            // mkdir(public_path('/imagenes/categorias/') , 0777);
            File::makeDirectory(public_path().'/imagenes/negocios/',0777,true);
        }
        $subido = $imagen->move(public_path().'/imagenes/negocios/', $nombreImagen);
        $negocio->imagen = $nombreImagen;
    }
    $negocio->nombre = $request->nombre;
    $negocio->estado = true;
    $negocio->descripcion = $request->descripcion;
    $negocio->usuario_id = auth()->user()->id;
    if($negocio->save()){
        return redirect('/negocios')->with('success', 'Registro actualizado correctamente');
    }else{
        return back()->with('error', 'El registro no fué actualizado');
    }
}
public function estado($id){
    $negocio = Negocios::find($id);
    $negocio->estado = !$negocio->estado;
    if($negocio->save()){
        return redirect('/negocios')->with('success', 'Estado actualizado correctamente');
    }else{
        return back()->with('error', 'El estado no fué actualizado');
    }

}
public function show($id){
    $negocio = Negocios::find($id);
    return view('negocios.show', compact('negocio'));
}

}
