@extends('adminlte::page')

@section('title', 'SYNHO | Lista Usuario')

@section('content_header')
@stop

@section('content')<div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Usuarios</h1>
                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a>Configuración</a></li>
                        <li class="breadcrumb-item active">Usuarios</li>
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
                    <h3 class="card-title">Lista de Usuarios</h3>

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

                    @if (Auth::check() && Auth::user()->role_as == '1')
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                <h3>
                                    <a href="{{ url('admin/user/create') }}" class="btn btn-primary"><i
                                            class="fas fa-plus"></i>
                                        Nuevo Usuario</a>
                                </h3>
                            </div>
                        </div>
                    @endif
                    <br>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="table-responsive">
                                <table id="lista"
                                    class="table table-striped table-bordered table-condensed table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nª</th>
                                            <th>NOMBRE</th>
                                            <th>EMAIL</th>
                                            <th>TELEFONO</th>
                                            <th>OPCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody id="lista_datos">

                                    </tbody>
                                </table>
                            </div>
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
    <script src="{{ asset('js/functions.js') }}"></script>
    <script>
        $(document).ready(function() {
            list_ajax_user();
        }); //FIN DE AJAX

        function list_ajax_user() {
            $.ajax({
                url: "{{ route('list_ajax_user') }}",
                method: "GET",
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.code == 500) {
                        console.log(data.message);
                    } else {
                        $('#lista').dataTable({
                            "bDestroy": true
                        }).fnDestroy();

                        table = $('#lista').DataTable({
                            "language": {
                                "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                            },
                        });

                        table.clear();
                        var numero = 0;

                        $.each(data.data, function(i, item) {
                            numero = numero + 1
                            show = '<a href="{{ url('/admin/user') }}/' + data.data[i].id + '/show' +
                                '" class="btn btn-success"><i class="fas fa-eye"></i></a>'
                            edit = ''
                            if ({{ Auth::check() }} == true && '{{ Auth::user()->role_as }}' ==
                                '1') {
                                edit = ' <a href="{{ url('/admin/user') }}/' + data.data[i].id +
                                    '/edit' +
                                    '" class="btn btn-warning"><i class="fas fa-edit"></i></a>'
                                delet = ' <a onclick="delete_record(' + data.data[i].id +
                                    ')" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>'
                            } else {
                                delet = ''
                            }
                            table.row.add([
                                numero,
                                data.data[i].name,
                                data.data[i].email,
                                data.data[i].phone,
                                show + edit + delet
                            ]);
                        });
                        table.draw();
                    }
                },
                error: function(data) {
                    console.log('Algo ha salido mal');
                }
            });
        }

        function delete_record(id) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swal.fire({
                title: 'Mensaje del sistema',
                text: "¿Quieres eliminar este registro?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: '<i class="zmdi zmdi-run"></i> Si, Eliminar!',
                cancelButtonText: '<i class="zmdi zmdi-close-circle"></i> No, Eliminar!',
                confirmButtonColor: '#03A9F4',
                cancelButtonColor: '#F44336',
                reverseButtons: true
            }).then((result) => {

                if (result.value) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "{{ route('destroy_user') }}",
                        method: 'POST',
                        data: {
                            id: id
                        },
                        success: function(data) {
                            if (data.errors) {
                                message_error(data.errors)
                            } else if (data.code == 500) {
                                Swal.fire({
                                    type: 'error',
                                    title: 'Oops...',
                                    text: data.message
                                });
                            } else {
                                Swal.fire({
                                    type: 'success',
                                    title: 'Exito',
                                    text: data.message,
                                    timer: 2000
                                });
                                list_ajax_user();
                            }
                        },
                        error: function(data) {
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Algo ha salido mal'
                            });
                        }
                    }); //FIN DE AJAX 
                } else {
                    //Vacio
                }
            });
        }
    </script>
@stop
