@extends('adminlte::page')
@section('title', 'SYNHO | Actualizar Mantenimiento')
@section('content_header')
@stop
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Mantenimiento</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a>Mantenimiento</a></li>
                        <li class="breadcrumb-item active">Actualizar Registro</li>
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
                    <h3 class="card-title">Actualizar Registro</h3>
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

                <div class="row">

                    <div class="card-body">

                        <form  action="{{ url('home/maintenance/' . $maintenance->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="solicitante">Nombre</label>
                                    <input type="text" name="solicitante" class="form-control"
                                        value="{{$maintenance->user->name}}" disabled placeholder="Solicitante...">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="created_at">Fecha y Hora (Creado)</label>
                                    <input type="datetime-local" name="created_at" class="form-control"
                                        value="{{ $maintenance->created_at }}" readonly placeholder="Fecha inicio...">
                                    @error('created_at')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="fecha_recibido">Fecha y Hora (Recibido)</label>
                                    <input type="datetime-local" name="fecha_recibido" class="form-control"
                                        value="{{ $maintenance->fecha_recibido }}" readonly placeholder="Fecha inicio...">
                                    @error('fecha_recibido')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="fecha_proceso">Fecha y Hora (Proceso)</label>
                                    <input type="datetime-local" name="fecha_proceso" class="form-control"
                                        value="{{ $maintenance->fecha_proceso }}" readonly placeholder="Fecha final..." {{ Auth::user()->role_as == '1' ? '' : 'disabled' }}>
                                    @error('fecha_proceso')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="fecha_final">Fecha y Hora (Final)</label>
                                    <input type="datetime-local" name="fecha_final" class="form-control"
                                        value="{{ $maintenance->fecha_final }}" readonly placeholder="Fecha final..." {{ Auth::user()->role_as == '1' ? '' : 'disabled' }}>
                                    @error('fecha_final')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <hr>

                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="falla-tab" data-toggle="tab" data-target="#falla"
                                        type="button" role="tab" aria-controls="falla" aria-selected="true">MOTIVO DE
                                        LA
                                        FALLA</button>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="atencion-tab" data-toggle="tab" data-target="#atencion"
                                        type="button" role="tab" aria-controls="atencion"
                                        aria-selected="false">ATENCION</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="realizado-tab" data-toggle="tab" data-target="#realizado"
                                        type="button" role="tab" aria-controls="realizado"
                                        aria-selected="false">TRABAJO
                                        REALIZADO</button>
                                </li>

                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane border p-3 fade show active" id="falla" role="tabpanel"
                                    aria-labelledby="falla-tab">

                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="maquina">Maquina</label>
                                            <textarea name="maquina" class="form-control" cols="2" rows="2" placeholder="Ingrese la maquina" {{ Auth::user()->role_as == '1' ? 'disabled' : ''}} >{{ $maintenance->maquina }}</textarea>
                                            @error('maquina')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="proceso">Proceso</label>
                                            <textarea name="proceso" class="form-control" cols="2" rows="2"
                                                placeholder="Ingrese el proceso de la maquina" {{ Auth::user()->role_as == '1' ? 'disabled' : ''}}>{{ $maintenance->proceso }}</textarea>
                                            @error('proceso')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="descripcion">Descripcion de la Falla</label>
                                            <textarea name="descripcion" class="form-control" cols="2" rows="2" placeholder="Ingrese la falla" {{ Auth::user()->role_as == '1' ? 'disabled' : ''}}>{{ $maintenance->descripcion }}</textarea>
                                            @error('descripcion')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                </div>

                                <div class="tab-pane border p-3 fade show" id="atencion" role="tabpanel"
                                    aria-labelledby="atencion-tab">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="estado">Estado</label>
                                            <select class="form-control" name="estado"
                                                {{ Auth::user()->role_as == '1' ? '' : 'disabled' }}>
                                                @if ($maintenance->estado == 'Recibido')
                                                    <option value="Recibido" selected>Recibido</option>
                                                    <option value="En Proceso">En Proceso</option>
                                                    <option value="Solucionado">Solucionado</option>
                                                @elseif($maintenance->estado == 'En Proceso')
                                                    <option value="Recibido">Recibido</option>
                                                    <option value="En Proceso" selected>En Proceso</option>
                                                    <option value="Solucionado">Solucionado</option>
                                                @elseif($maintenance->estado == 'Solucionado')
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

                                            @error('estado')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="nivel_criticidad">Nivel de Criticidad</label>
                                            <select class="form-control" name="nivel_criticidad" {{ Auth::user()->role_as == '1' ? '' : 'disabled' }}>
                                                @if ($maintenance->nivel_criticidad == 'Bajo (>2 Horas)')
                                                    <option value="Bajo (>2 Horas)" selected>Bajo (>2 Horas)</option>
                                                    <option value="Medio (>4 Horas)">Medio (>4 Horas)</option>
                                                    <option value="Alto (>8 Horas)">Alto (>8 Horas)</option>
                                                @elseif($maintenance->nivel_criticidad == 'Medio (>4 Horas)')
                                                    <option value="Bajo (>2 Horas)">Bajo (>2 Horas)</option>
                                                    <option value="Medio (>4 Horas)" selected>Medio (>4 Horas)</option>
                                                    <option value="Alto (>8 Horas)">Alto (>8 Horas)</option>
                                                @elseif($maintenance->nivel_criticidad == 'Alto (>8 Horas)')
                                                    <option value="Bajo (>2 Horas)">Bajo (>2 Horas)</option>
                                                    <option value="Medio (>4 Horas)">Medio (>4 Horas)</option>
                                                    <option value="Alto (>8 Horas)" selected>Alto (>8 Horas)</option>
                                                @else
                                                    <option value="" selected>Selecciona Nivel de criticidad</option>
                                                    <option value="Bajo (>2 Horas)">Bajo (>2 Horas)</option>
                                                    <option value="Medio (>4 Horas)">Medio (>4 Horas)</option>
                                                    <option value="Alto (>8 Horas)">Alto (>8 Horas)</option>
                                                @endif
                                            </select>
                                            @error('nivel_criticidad')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="ejecutor">Ejecutor</label>
                                            <input type="text" name="ejecutor" class="form-control"
                                                value="{{ $maintenance->ejecutor }}" placeholder="Personal de Synho..." {{ Auth::user()->role_as == '1' ? '' : 'disabled' }}>
                                            @error('ejecutor')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="realizado" role="tabpanel"
                                    aria-labelledby="realizado-tab">
                                    <div class="tab-pane border p-3 fade show" id="atencion" role="tabpanel"
                                        aria-labelledby="atencion-tab">

                                        <div class="form-group col-md-12">
                                            <label for="estado_previo">Estado Previo</label>
                                            <textarea name="estado_previo" class="form-control" placeholder="Estado al momento de la falla" cols="2"
                                                rows="2" {{ Auth::user()->role_as == '1' ? '' : 'disabled' }}>{{ $maintenance->estado_previo }}</textarea>
                                            @error('estado_previo')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="solucion_efectuada">Solucion Efectuada</label>
                                            <textarea name="solucion_efectuada" class="form-control" placeholder="Herramientas usadas" cols="2"
                                                rows="2" {{ Auth::user()->role_as == '1' ? '' : 'disabled' }}>{{ $maintenance->solucion_efectuada }}</textarea>
                                            @error('solucion_efectuada')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="estado_actual">Estado Actual</label>
                                            <textarea name="estado_actual" class="form-control" placeholder="Luego de resolver la falla" cols="2"
                                                rows="2" {{ Auth::user()->role_as == '1' ? '' : 'disabled' }}>{{ $maintenance->estado_actual }}</textarea>
                                            @error('estado_actual')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="observacion">Observaciones / Recomendaciones</label>
                                            <textarea name="observacion" class="form-control" placeholder="Luego de resolver la falla" cols="2"
                                                rows="2" {{ Auth::user()->role_as == '1' ? '' : 'disabled' }}>{{ $maintenance->observacion }}</textarea>
                                            @error('observacion')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" id="save_data"><i
                                        class="fas fa-save"></i> Actualizar</button>
                                <a href="{{ url('home/maintenance') }}" class="btn btn-danger" id="btncancel"><i
                                        class="fas fa-backward"></i> Cancelar</a>
                            </div>
                        </form>
                    </div>
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
