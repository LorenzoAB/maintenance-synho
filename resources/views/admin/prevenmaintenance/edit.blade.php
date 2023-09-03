@extends('adminlte::page')

@section('title', 'SYNHO | Edit Mantenimiento Preventivo')

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
                        <li class="breadcrumb-item active">Editar Registro</li>
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
                    <h3 class="card-title">Editar Mantenimiento Preventivo</h3>

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
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <!--validar error-->
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
                                                    <form enctype="multipart/form-data"
                                                        action="{{ url('/admin/prevenmaintenance/createdetail') }}"
                                                        method="POST">
                                                        @csrf
                                                        <td>
                                                            <input type="hidden" id="prevenmaintenance_id" name="prevenmaintenance_id"
                                                            value="{{ $prevenmaintenance->id }}" class="form-control">
                                                            <select name="maquina" id="maquina" class="form-control">
                                                                <option value="0">SELECCIONAR</option>
                                                                <option value="MP1">MP1</option>
                                                                <option value="MP3">MP3</option>
                                                                <option value="DESTINTADO">DESTINTADO</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control txt-right"
                                                                name="elementos" id="elementos">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control txt-right"
                                                                name="revision" id="revision">
                                                        </td>
                                                        <td>
                                                            <input type="datetime-local" class="form-control txt-right"
                                                                name="fechaprogramada" id="fechaprogramada">
                                                        </td>


                                                        <td>
                                                            <button type="submit" class="link_add btn btn-success"
                                                                id="add_detail" disabled>
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                        </td>
                                                    </form>
                                                </tr>
                                            </thead>

                                            <!--Detalle de gastos-->
                                            <tbody id="detalle_detail">
                                                <!--Contenido AJAX-->
                                                @foreach ($detailprevenmaintenance as $item)
                                                    <tr class="detail-tr">
                                                        <td>
                                                            <input type="text"
                                                                class="form-control txt-right detailMaquina"
                                                                value="{{ $item->maquina }}">
                                                        </td>
                                                        <td>
                                                            <input type="text"
                                                                class="form-control txt-right detailElementos"
                                                                value="{{ $item->elementos }}">
                                                        </td>
                                                        <td>
                                                            <input type="text"
                                                                class="form-control txt-right detailRevision"
                                                                value="{{ $item->revision }}">
                                                        </td>
                                                        <td>
                                                            <input type="text"
                                                                class="form-control txt-right detailFechaprogramada"
                                                                value="{{ $item->fechaprogramada }}">
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-warning updateDetailBtn" type="button"
                                                                value="{{ $item->iddetail }}"><i
                                                                    class="fas fa-edit"></i></button>
                                                            <button class="btn btn-danger deleteDetailBtn" type="button"
                                                                value="{{ $item->iddetail }}"><i
                                                                    class="far fa-trash-alt"></i></button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div><!-- /.row -->


                            <form  action="{{ url('admin/prevenmaintenance/' . $prevenmaintenance->id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

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
                                                value="{{ $prevenmaintenance->parametro }}" class="form-control"
                                                placeholder="Confirmacion de tiempo ...">
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label for="factibilidad_revision">Factibilidad de la Revisión</label>
                                            <input type="text" id="factibilidad_revision" name="factibilidad_revision"
                                                value="{{ $prevenmaintenance->factibilidad_revision }}"
                                                class="form-control" placeholder="Confirmacion de tiempo ...">
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label for="personal">Personal a cargo</label>
                                            <input type="text" id="personal" name="personal"
                                                value="{{ $prevenmaintenance->personal }}" class="form-control"
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
                                            <textarea name="pruebas" class="form-control" cols="2" rows="2"
                                                placeholder="Procedimiento a realizar por tarea  ...">{{ $prevenmaintenance->pruebas }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <label for="estado">Estado previo</label>
                                        <select class="form-control" name="estado">
                                            @if ($prevenmaintenance->estado == 'Activo')
                                                <option value="Activo" selected>Activo</option>
                                                <option value="En Proceso">En Proceso</option>
                                                <option value="Solucionado">Solucionado</option>
                                            @elseif($prevenmaintenance->estado == 'En Proceso')
                                                <option value="Activo">Activo</option>
                                                <option value="En Proceso" selected>En Proceso</option>
                                                <option value="Solucionado">Solucionado</option>
                                            @elseif($prevenmaintenance->estado == 'Solucionado')
                                                <option value="Activo">Activo</option>
                                                <option value="En Proceso">En Proceso</option>
                                                <option value="Solucionado" selected>Solucionado</option>
                                            @else
                                                <option value="" >Selecciona Estado</option>
                                                <option value="Anulado" selected>Anulado</option>
                                            @endif
                                        </select>

                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label for="solucion">Solucion efectuada</label>
                                            <input type="text" id="solucion" name="solucion"
                                                value="{{ $prevenmaintenance->solucion }}" class="form-control"
                                                placeholder="Solucion efectuada ...">
                                        </div>
                                    </div>


                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label for="observacion">Observaciones y Recomendaciones</label>
                                            <input type="text" id="observacion" name="observacion"
                                                class="form-control" value="{{ $prevenmaintenance->observacion }}"
                                                placeholder="Observaciones y Recomendaciones ...">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <button class="btn btn-primary" type="submit" id="btn_add_detail">
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
    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Función que verifica si todos los campos tienen un valor y habilita/deshabilita el botón según corresponda
            function checkInputs() {
                var maquina = $("#maquina").val();
                var elementos = $("#elementos").val();
                var revision = $("#revision").val();
                var fechaprogramada = $("#fechaprogramada").val();

                if (maquina && elementos && revision && fechaprogramada) {
                    $("#add_detail").removeAttr("disabled");
                } else {
                    $("#add_detail").attr("disabled", "disabled");
                }
            }

            // Evento change para el select y el input de fecha
            $("#maquina, #fechaprogramada").change(checkInputs);

            // Evento keyup para los inputs de texto
            $("#elementos, #revision, #fechaprogramada").keyup(checkInputs);


            // UPDATE
            $(document).on('click', '.updateDetailBtn', function() {

                var prevenmaintenance_id = "{{ $prevenmaintenance->id }}";
                var detail_id = $(this).val();

                //var qty = $(this).closest('.prod-color-tr').find('.productColorQuantity').val();
                var maquina = $(this).closest('.detail-tr').find('.detailMaquina').val();
                var elementos = $(this).closest('.detail-tr').find('.detailElementos').val();
                var revision = $(this).closest('.detail-tr').find('.detailRevision').val();
                var fechaprogramada = $(this).closest('.detail-tr').find('.detailFechaprogramada').val();

                if (maquina == '' || elementos == '' || revision == '' || fechaprogramada == '') {
                    alert('Todos los campos son requeridos');
                    return false;
                }

                var data = {
                    'prevenmaintenance_id': prevenmaintenance_id,
                    'maquina': maquina,
                    'elementos': elementos,
                    'revision': revision,
                    'fechaprogramada': fechaprogramada
                };

                $.ajax({
                    type: "POST",
                    url: "/admin/prevenmaintenance/" + detail_id + "/update",
                    data: data,
                    success: function(response) {
                        alert(response.message)
                    }
                });
            });

            //DELETE
            $(document).on('click', '.deleteDetailBtn', function() {

                var id_detail = $(this).val();
                var thisClick = $(this);

                $.ajax({
                    type: "GET",
                    url: "/admin/prevenmaintenance/" + id_detail + "/delete",
                    success: function(response) {
                        thisClick.closest('.detail-tr').remove();
                        alert(response.message)
                    }
                });
            });

        });
    </script>
@stop
