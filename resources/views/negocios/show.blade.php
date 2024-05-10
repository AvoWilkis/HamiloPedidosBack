@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Negocio</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                        <li class="breadcrumb-item active">Negocios</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">Registro de Negocio</div>

                        <div class="card-body">

                            <div class="text-center">
                                <img src="{{$negocio->getImagenUrl()}}" alt="" class="border" height="150px" width="150px">
                            </div>
                            <div class="m-2">
                                <h3>{{$negocio->nombre}}</h3>
                            </div>
                            <div class="m-2">
                                <h3>{{$negocio->descripcion}}</h3>
                            </div>
                            <div class="m-2">
                                <b>Estado:</b>

                                @if($negocio->estado == true)
                                <span class="badge badge-success">Activo</span>
                                @else
                                <span class="badge badge-danger">Inactivo</span>
                                @endif
                            </div>
                            <div class="m-2">
                                <b>Fecha de creación:</b>
                                {{$negocio->created_at}}
                            </div>
                            <div class="text-center mt-3">
                                <a href="{{url('/negocios')}}" class="btn btn-primary">Volver al listado</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <div class="card">
                        <div class="card header">Listado de Productos</div>
                        <div class="card-body"></div>

                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
