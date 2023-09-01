@extends('adminlte::page')

@section('title', 'SYNHO | Ver Mantenimiento Preventivo')

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
                        <li class="breadcrumb-item active">Ver Registro</li>
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
                    <h3 class="card-title">Ver Mantenimiento Preventivo</h3>

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
                                                    </tr>
                                                </thead>

                                                <!--Detalle de gastos-->
                                                <tbody id="detalle_detail">
                                                    @foreach ($detailprevenmaintenance as $item)
                                                        <tr>
                                                            <td>
                                                                <input type="text" class="form-control txt-right"
                                                                    readonly value="{{ $item->maquina }}">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control txt-right"
                                                                    readonly value="{{ $item->elementos }}">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control txt-right"
                                                                    readonly value="{{ $item->revision }}">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control txt-right"
                                                                    readonly value="{{ $item->fechaprogramada }}">
                                                            </td>
                                                        </tr>
                                                    @endforeach
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
                                            <input type="text" id="parametro" name="parametro"
                                                value="{{ $prevenmaintenance->parametro }}" disabled class="form-control"
                                                placeholder="Confirmacion de tiempo ...">
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label for="factibilidad_revision">Factibilidad de la Revisión</label>
                                            <input type="text" id="factibilidad_revision" name="factibilidad_revision"
                                                value="{{ $prevenmaintenance->factibilidad_revision }}" disabled class="form-control"
                                                placeholder="Confirmacion de tiempo ...">
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label for="personal">Personal a cargo</label>
                                            <input type="text" id="personal" name="personal"
                                                value="{{ $prevenmaintenance->personal }}" disabled class="form-control"
                                                placeholder="Confirmacion de tiempo ...">
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
                                            <textarea name="pruebas" class="form-control" disabled cols="2" rows="2"
                                                placeholder="Procedimiento a realizar por tarea  ...">{{ $prevenmaintenance->pruebas }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <label for="estado">Estado previo</label>
                                        <select class="form-control" name="estado" disabled>
                                            @if ($prevenmaintenance->estado == 'Activo')
                                                <option value="Activo" selected>Activo</option>
                                                <option value="Recibido">Recibido</option>
                                                <option value="En Proceso">En Proceso</option>
                                                <option value="Solucionado">Solucionado</option>
                                            @elseif ($prevenmaintenance->estado == 'Recibido')
                                                <option value="Activo">Activo</option>
                                                <option value="Recibido" selected>Recibido</option>
                                                <option value="En Proceso">En Proceso</option>
                                                <option value="Solucionado">Solucionado</option>
                                            @elseif($prevenmaintenance->estado == 'En Proceso')
                                                <option value="Activo">Activo</option>
                                                <option value="Recibido">Recibido</option>
                                                <option value="En Proceso" selected>En Proceso</option>
                                                <option value="Solucionado">Solucionado</option>
                                            @elseif($prevenmaintenance->estado == 'Solucionado')
                                                <option value="Activo">Activo</option>
                                                <option value="Recibido">Recibido</option>
                                                <option value="En Proceso">En Proceso</option>
                                                <option value="Solucionado" selected>Solucionado</option>
                                            @else
                                                <option value="" selected>Selecciona Estado</option>
                                                <option value="Recibido">Recibido</option>
                                                <option value="En Proceso">En Proceso</option>
                                                <option value="Solucionado">Solucionado</option>
                                            @endif
                                        </select>

                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label for="solucion">Solucion efectuada</label>
                                            <input type="text" id="solucion" name="solucion"
                                                value="{{ $prevenmaintenance->solucion }}" disabled class="form-control"
                                                placeholder="Solucion efectuada ...">
                                        </div>
                                    </div>


                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label for="observacion">Observaciones y Recomendaciones</label>
                                            <input type="text" id="observacion" name="observacion" disabled
                                                class="form-control" value="{{ $prevenmaintenance->observacion }}"
                                                placeholder="Observaciones y Recomendaciones ...">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <button class="btn btn-primary" type="submit" id="btn_add_detail"
                                            style="display: none;">
                                            <i class="fas fa-edit"></i> Guardar
                                        </button>
                                        <a href="{{ url('admin/prevenmaintenance') }}" class="btn btn-danger"
                                            id="btncancel"><i class="fas fa-backward"></i> Cancelar</a>
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
<script></script>
@stop
