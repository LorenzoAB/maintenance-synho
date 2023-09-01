<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Prevenmaintenance;
use App\Models\Detailprevenmaintenance;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;

class PrevenmaintenanceController extends Controller
{
    public function index()
    {
        return view('admin/prevenmaintenance/index');
    }

    public function list_ajax_prevenmaintenance()
    {
        $data = DB::table('prevenmaintenance as p')
            ->join('users as u', 'p.user_id', '=', 'u.id')
            ->select('p.id', 'u.name as user', 'p.created_at', 'p.estado')
            ->orderBy('p.id', 'desc')->get();

        if ($data->count() > 0) {
            $array = array(
                'message' => 'Data Found',
                'code' => 200,
                'data' => $data,
            );
        } else {
            $array = array(
                'message' => 'No Data Found',
                'code' => 404,
                'data' => []
            );
        }
        return response()->json($array);
    }

    public function create()
    {
        return view('admin/prevenmaintenance/create');
    }

    public function store(Request $request)
    {
        try {
            //validar Formulario
            $validator = Validator::make($request->all(), [
                'parametro' => 'required',
                'factibilidad_revision' => 'required',
                'personal' => 'required',
                'pruebas' => 'required',
                'estado' => 'required',
                'solucion' => 'required',
                'observacion' => 'required'
            ]);

            //Esto es para que lleve donde está el formulario
            if ($validator->fails()) {
                return redirect(url()->previous())
                    ->withErrors($validator)
                    ->withInput();
            }

            // Resto de tu lógica de creación de viatico...
            $prevenmaintenance = new Prevenmaintenance();
            //Guardar el usuario
            $user = Auth::user();
            $prevenmaintenance->user_id = $user->id;
            $prevenmaintenance->parametro = $request->input('parametro');
            $prevenmaintenance->factibilidad_revision = $request->input('factibilidad_revision');
            $prevenmaintenance->personal = $request->input('personal');
            $prevenmaintenance->pruebas = $request->input('pruebas');
            if (empty($request->input('estado'))) {
                $prevenmaintenance->estado = 'Activo';
            } else {
                $prevenmaintenance->estado = $request->input('estado');
            }
            $prevenmaintenance->solucion = $request->input('solucion');
            $prevenmaintenance->observacion = $request->input('observacion');
            $prevenmaintenance->save();

            //Guardar en el detalle de la venta
            $maquina = $request->get('maquina');
            $elementos = $request->get('elementos');
            $revision = $request->get('revision');
            $fechaprogramada = $request->get('fechaprogramada');

            $cont = 0;

            while ($cont < count($maquina)) {
                $detalle = new Detailprevenmaintenance();
                $detalle->prevenmaintenance_id = $prevenmaintenance->id;
                $detalle->maquina = $maquina[$cont];
                $detalle->elementos = $elementos[$cont];
                $detalle->revision = $revision[$cont];
                $detalle->fechaprogramada = $fechaprogramada[$cont];
                $detalle->save();
                $cont = $cont + 1;
            }


            return redirect()->route('list_prevenmaintenance')->with(
                array(
                    'message' => 'Mantenimiento Preventivo creado Correctamente!!!'
                )
            );

        } catch (\Exception $e) {
            \Log::error("Error al crear Mantenimiento Preventivo: " . $e->getMessage());

            return redirect()->back()->with([
                'message' => 'Ocurrió un error al intentar crear el Mantenimiento Preventivo. Inténtalo de nuevo.'
            ]);
        }
    }

    public function edit($id)
    {
        $prevenmaintenance = DB::table('prevenmaintenance as p')
            ->join('users as u', 'p.user_id', '=', 'u.id')
            ->select('p.id', 'p.parametro', 'p.factibilidad_revision', 'p.personal', 'p.pruebas', 'p.estado', 'p.solucion', 'p.observacion')
            ->where('p.id', '=', $id)
            ->first();
    

        $detailprevenmaintenance = DB::table('detailprevenmaintenance as d')
        ->join('prevenmaintenance as p', 'd.prevenmaintenance_id', '=', 'p.id')
        ->select('d.id as iddetail','d.maquina', 'd.elementos', 'd.revision','d.fechaprogramada')
        ->where('p.id', '=', $id)
        ->get();


        return view('admin/prevenmaintenance/edit')->with(
            array(
                'prevenmaintenance' => $prevenmaintenance,
                'detailprevenmaintenance' => $detailprevenmaintenance,
            )
        );
    }


    public function update($id, request $request)
    {
        try {
            //validar Formulario
            $validator = Validator::make($request->all(), [
                'parametro' => 'required',
                'factibilidad_revision' => 'required',
                'personal' => 'required',
                'pruebas' => 'required',
                'estado' => 'required',
                'solucion' => 'required',
                'observacion' => 'required'
            ]);

            //Esto es para que lleve donde está el formulario
            if ($validator->fails()) {
                return redirect(url()->previous())
                    ->withErrors($validator)
                    ->withInput();
            }
            $prevenmaintenance = Prevenmaintenance::findOrFail($id);
            $prevenmaintenance->parametro = $request->input('parametro');
            $prevenmaintenance->factibilidad_revision = $request->input('factibilidad_revision');
            $prevenmaintenance->personal = $request->input('personal');
            $prevenmaintenance->pruebas = $request->input('pruebas');
            $prevenmaintenance->estado = $request->input('estado');
            $prevenmaintenance->solucion = $request->input('solucion');
            $prevenmaintenance->observacion = $request->input('observacion');
            $prevenmaintenance->update();

            return redirect()->route('list_prevenmaintenance')->with(
                array(
                    'message' => 'Mantenimiento Preventivo Editado Correctamente!!!'
                )
            );

        } catch (\Exception $e) {
            \Log::error("Error al Editar Mantenimiento Preventivo: " . $e->getMessage());

            return redirect()->back()->with([
                'message' => 'Ocurrió un error al intentar Editar el Mantenimiento Preventivo. Inténtalo de nuevo.'
            ]);
        }
    }

    public function show($id)
    {
        $prevenmaintenance = DB::table('prevenmaintenance as p')
            ->join('users as u', 'p.user_id', '=', 'u.id')
            ->select('p.id', 'p.parametro', 'p.factibilidad_revision', 'p.personal', 'p.pruebas', 'p.estado', 'p.solucion', 'p.observacion')
            ->where('p.id', '=', $id)
            ->first();
    

        $detailprevenmaintenance = DB::table('detailprevenmaintenance as d')
        ->join('prevenmaintenance as p', 'd.prevenmaintenance_id', '=', 'p.id')
        ->select('d.maquina', 'd.elementos', 'd.revision','d.fechaprogramada')
        ->where('p.id', '=', $id)
        ->get();


        return view('admin/prevenmaintenance/show')->with(
            array(
                'prevenmaintenance' => $prevenmaintenance,
                'detailprevenmaintenance' => $detailprevenmaintenance,
            )
        );
    }
    public function report($id)
    {
        $prevenmaintenance = DB::table('prevenmaintenance as p')
            ->join('users as u', 'p.user_id', '=', 'u.id')
            ->select('p.id', 'p.parametro', 'p.factibilidad_revision', 'p.personal', 'p.pruebas', 'p.estado', 'p.solucion', 'p.observacion')
            ->where('p.id', '=', $id)
            ->first();
    

        $detailprevenmaintenance = DB::table('detailprevenmaintenance as d')
        ->join('prevenmaintenance as p', 'd.prevenmaintenance_id', '=', 'p.id')
        ->select('d.maquina', 'd.elementos', 'd.revision','d.fechaprogramada')
        ->where('p.id', '=', $id)
        ->get();

        $data = ['prevenmaintenance' => $prevenmaintenance,'detailprevenmaintenance'=>$detailprevenmaintenance];

        $pdf = Pdf::loadView('admin/prevenmaintenance/report', $data);

        $todayDate = Carbon::now()->format('d-m-Y');
        return $pdf->download('invoice-' . $id . '-' . $todayDate . '.pdf');
    }

    public function destroy(request $request)
    {
        //validar Formulario
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $id = $request->input('id');
        $prevenmaintenance = Prevenmaintenance::find($id);
        //validar Formulario
        $prevenmaintenance->estado = 'Anulado';
        $prevenmaintenance->update();

        if ($prevenmaintenance) {
            $array = array(
                'message' => 'Anulado Correctamente',
                'code' => 200,
                'error' => false,
            );
        } else {
            $array = array(
                'message' => 'Error al anular',
                'code' => 500,
                'error' => true
            );
        }
        return response()->json($array);
    }
    // DETAIL
    public function create_detail(Request $request){
        $detailprevenmaintenance = new Detailprevenmaintenance();


        $detailprevenmaintenance->prevenmaintenance_id = $request->input('prevenmaintenance_id');
        $detailprevenmaintenance->maquina = $request->input('maquina');
        $detailprevenmaintenance->elementos = $request->input('elementos');
        $detailprevenmaintenance->revision = $request->input('revision');
        $detailprevenmaintenance->fechaprogramada = $request->input('fechaprogramada');
        $detailprevenmaintenance->save();

        return redirect()->back()->with('message', 'Detalle Agregado');
    }

    public function update_detail(Request $request, $id_detail)
    {
        $detailprevenmaintenance = Prevenmaintenance::findOrFail($request->prevenmaintenance_id)
            ->Detailprevenmaintenance()->where('id', $id_detail)->first();

        $detailprevenmaintenance->update([
            'maquina' => $request->maquina,
            'elementos' => $request->elementos,
            'revision' => $request->revision,
            'fechaprogramada' => $request->fechaprogramada,
        ]);

        return response()->json(['message' => 'Detalle actualizado']);
    }

    public function destroy_detail(int $id_detail){
        //validar Formulario
        $detailprevenmaintenance = Detailprevenmaintenance::findOrFail($id_detail);
        $detailprevenmaintenance->delete();
        return response()->json(['message' => 'Detalle Eliminado']);
    }
}
