@extends('adminlte::page')

@section('title', 'SYNHO | Mi Perfil')

@section('content_header')
@stop

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Mi Perfil</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a>Configuración</a></li>
                        <li class="breadcrumb-item active">Mi perfil</li>
                    </ol>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>

    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <!-- /.card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Actualizar perfil</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip"
                            title="Remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <!--CONTENIDO-->
                    @error('errors')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <!--validar error-->
                            <form id="registro_usuario" action="{{ url('home/user/profile/' . $user->id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="name">Nombre</label>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ $user->name }}" placeholder="Nombre...">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" class="form-control"
                                            value="{{ $user->email }}" placeholder="Email...">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="phone">Telefono</label>
                                        <input type="text" name="phone" class="form-control"
                                            value="{{ $user->phone }}" placeholder="Telefono...">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="password">Password</label>
                                        <input type="password" name="password" class="form-control"
                                            value="" placeholder="Password...">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="password_confirmation">Password Confirm</label>
                                        <input type="password" name="password_confirmation" class="form-control"
                                            value="" placeholder="Password Confirm...">
                                    </div>

                                </div>

                                <br>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" id="save_data"><i
                                            class="fas fa-save"></i> Guardar</button>
                                    <a href="{{ url('/home') }}" class="btn btn-danger" id="btncancel"><i
                                            class="fas fa-backward"></i> Cancelar</a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!--FIN DE CONTENIDO-->
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    Leyenda
                </div>
                <!-- /.card-footer-->
            </div>
        </div>
        <!-- /.card -->
    </section>
@stop

@section('css')
    
@stop

@section('js')

@stop
