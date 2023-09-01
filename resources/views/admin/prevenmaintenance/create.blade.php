@extends('adminlte::page')

@section('title', 'SYNHO | Crear Mantenimiento Preventivo')

@section('content_header')
@stop

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Mantenimiento Preventivo</h1>
                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a>Mantenimiento Preven</a></li>
                        <li class="breadcrumb-item active">Nuevo Registro</li>
                    </ol>
                </div>

            </div>

        </div>
    </div>

    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <!-- /.card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Nuevo Mantenimiento Preventivo</h3>

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
                    @if (session('message'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <!--validar error-->
                            <form enctype="multipart/form-data" action="{{ url('admin/prevenmaintenance') }}"
                                method="post">
                                @csrf

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card-header bg-primary">
                                            <h6 class="mb-0 text-white">INSTALACION/MAQUINA</h6>
                                        </div>
                                    </div>
                                </div>
                                <br>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table id="carrito" class="table table-bordered">
                                                <thead class="table-active">
                                                    <tr>
                                                        <th>MAQUINA</th>
                                                        <th>ELEMENTOS</th>
                                                        <th>REVISION</th>
                                                        <th>FECHA PROGRAMADA</th>
                                                        <th>ACCIONES</th>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <select name="pmaquina" id="pmaquina" class="form-control">
                                                                <option value="0">SELECCIONAR</option>
                                                                <option value="MP1">MP1</option>
                                                                <option value="MP3">MP3</option>
                                                                <option value="DESTINTADO">DESTINTADO</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control txt-right"
                                                                name="pelementos" id="pelementos">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control txt-right" name="prevision" id="prevision">
                                                         </td>
                                                        <td>
                                                            <input type="datetime-local" class="form-control txt-right"
                                                                name="pfechaprogramada" id="pfechaprogramada">
                                                        </td>


                                                        <td>
                                                            <button class="link_add btn btn-success" id="add_detail"
                                                                disabled>
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </thead>

                                                <!--Detalle de gastos-->
                                                <tbody id="detalle_detail">
                                                    <!--Contenido AJAX-->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div><!-- /.row -->

                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card-header bg-primary">
                                            <h6 class="mb-0 text-white">PARAMETROS A CONTROLAR</h6>
                                        </div>
                                    </div>
                                </div>
                                <br>

                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label for="parametro">Enumerar Parametro</label>
                                            <input type="text" id="parametro" name="parametro" class="form-control"
                                                placeholder="Confirmacion de tiempo ...">
                                            @error('parametro')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label for="factibilidad_revision">Factibilidad de la Revisión</label>
                                            <input type="text" id="factibilidad_revision" name="factibilidad_revision" class="form-control"
                                                placeholder="Confirmacion de tiempo ...">
                                            @error('factibilidad_revision')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label for="personal">Personal a cargo</label>
                                            <input type="text" id="personal" name="personal" class="form-control"
                                                placeholder="Confirmacion de tiempo ...">
                                            @error('personal')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card-header bg-primary">
                                            <h6 class="mb-0 text-white">PRUEBAS A EJECUTAR</h6>
                                        </div>
                                    </div>
                                </div>
                                <br>

                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="pruebas">Enumerar Pruebas</label>
                                            <textarea name="pruebas" class="form-control" cols="2" rows="2"
                                                placeholder="Procedimiento a realizar por tarea  ..."></textarea>
                                            @error('pruebas')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <label for="estado">Estado previo</label>
                                        <select class="form-control" name="estado">
                                            <option selected value="">Selecciona Estado</option>
                                            <option value="Activo">Activo</option>
                                            <option value="En Proceso">En Proceso</option>
                                            <option value="Solucionado">Solucionado</option>
                                        </select>
                                        @error('estado')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label for="solucion">Solucion efectuada</label>
                                            <input type="text" id="solucion" name="solucion" class="form-control"
                                                placeholder="Solucion efectuada ...">
                                            @error('solucion')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label for="observacion">Observaciones y Recomendaciones</label>
                                            <input type="text" id="observacion" name="observacion"
                                                class="form-control" placeholder="Observaciones y Recomendaciones ...">
                                            @error('observacion')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <button class="btn btn-primary" type="submit" id="btn_add_detail"
                                            style="display: none;">
                                            <i class="fas fa-edit"></i> Guardar
                                        </button>
                                        <a href="{{ url('admin/prevenmaintenance') }}" class="btn btn-danger" id="btncancel"><i
                                                class="fas fa-backward"></i> Cancelar</a>
                                    </div>
                                </div>


                            </form><!-- /.FORMULARIO -->
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
    <style>
        .txt-right {
            text-align: left;
        }

        .table-bordered {
            border: 1 !important;
        }

        .table-bordered>thead>tr>th {
            border: 1 !important;
            border-bottom: solid 1px #343a40 !important;
            text-align: left;
        }

        table.table-bordered tbody td {
            border-bottom-width: 1px !important;
        }

        .table-bordered>tbody>tr>td {
            border: 1 !important;
            border-bottom: 1px solid #cccccc !important;
        }

        .table-md th,
        .table-md td {}
    </style>
@stop

@section('js')
    <script src="{{ asset('js/prevenmaintenance.js') }}"></script>
    <script>
        //showdate();
        var cont = 0;
        total = 0;
    </script>
@stop
