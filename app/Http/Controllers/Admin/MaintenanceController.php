<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use App\Models\maintenance;
use Illuminate\Support\Facades\Mail;
use App\Mail\MaintenancealertMail;
use Carbon\Carbon;


class MaintenanceController extends Controller
{
    public function index()
    {
        return view('home.maintenance.index');
    }

    public function list_ajax()
    {
        $data = DB::table('maintenance as m')
            ->join('users as u', 'm.user_id', '=', 'u.id')
            ->select('m.id', 'm.user_id', 'u.name as user', 'm.fecha_inicio', 'm.estado')
            ->orderBy('id', 'desc')->get();

        if ($data) {
            $array = array(
                'message' => 'Data Found',
                'code' => 200,
                'data' => $data,
            );
        } else {
            $array = array(
                'message' => 'Internal Data error',
                'code' => 500,
                'data' => ''
            );
        }
        return response()->json($array);
    }

    public function create()
    {
        return view('home.maintenance.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // Simplificar la validación
        $validator = Validator::make($request->all(), [
            'maquina' => 'required',
            'proceso' => 'required',
            'descripcion' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Guardar el registro
            $maintenance = new maintenance();
            $maintenance->user_id = $user->id;
            $maintenance->fecha_inicio = now();
            $maintenance->fecha_final = $request->input('fecha_final');
            $maintenance->maquina = $request->input('maquina');
            $maintenance->proceso = $request->input('proceso');
            $maintenance->descripcion = $request->input('descripcion');
            if ($request->input('estado') != '') {
                $maintenance->estado = $request->input('estado');
            }
            $maintenance->nivel_criticidad = $request->input('nivel_criticidad');
            $maintenance->ejecutor = $request->input('ejecutor');
            $maintenance->estado_previo = $request->input('estado_previo');
            $maintenance->solucion_efectuada = $request->input('solucion_efectuada');
            $maintenance->estado_actual = $request->input('estado_actual');
            $maintenance->observacion = $request->input('observacion');
            $maintenance->save();

        } catch (\Exception $e) {
            return redirect('home/maintenance')->with('message', 'Error al guardar en la base de datos: ' . $e->getMessage());
        }

        try {
            // Enviar el correo
            $data = [
                'fecha_inicio' => now(),
                'usuario' => $user->name,
                'maquina' => $request->input('maquina'),
                'proceso' => $request->input('proceso'),
                'descripcion' => $request->input('descripcion')
            ];
            Mail::to('synhogestion@gmail.com')->send(new MaintenancealertMail($data));
        } catch (\Exception $e) {
            return redirect('home/maintenance')->with('message', 'Error al enviar el correo: ' . $e->getMessage());
        }

        try {
            $formattedDate = now()->format('d/m/Y h:i:s A');
        
            $token = 'EAAO7NfOyfqABO0dH7q8SOATvUlVxp6YJtnE6kafGRUNsKVd7u8NZB9PZC8PGRZBBoVauvuQD0BkVo96UpqL8QUFO39SQEgzDI7UH7E7heCy44R7Etn7LRlL7Tk0qk1IOB8jBXZBxc1hDiUofuFAzMXFYxtMHVfhdsozCb0q8OEuHVLepGJFgj0RHQomHFUQB';
            $phoneId = '120058534419147';
            $version = 'v17.0';
        
            $phones = ['51946569795', '51975390060'];
        
            foreach ($phones as $phone) {
                $payload = [
                    'messaging_product' => 'whatsapp',
                    'to' => $phone,
                    'type' => 'template',
                    'template' => [
                        'name' => 'alerta_reporte_mensaje',
                        'language' => [
                            'code' => 'es'
                        ],
                        'components' => [
                            [
                                'type' => 'body',
                                'parameters' => [
                                    [
                                        'type' => 'text',
                                        'text' => $formattedDate,
                                    ],
                                    [
                                        'type' => 'text',
                                        'text' => 'Activo',
                                    ],
                                    [
                                        'type' => 'text',
                                        'text' => 'El usuario ' . $user->name . ' ha reportado un problema en la máquina ' . $request->input('maquina') . '.',
                                    ],
                                ]
                            ]
                        ]
                    ]
                ];
                $message = Http::withToken($token)->post('https://graph.facebook.com/' . $version . '/' . $phoneId . '/messages', $payload)->throw()->json();
            }
            
        } catch (\Exception $e) {
            return redirect('home/maintenance')->with('message', 'Error al enviar el Whatsapp: ' . $e->getMessage());
        }
        

        return redirect('home/maintenance')->with('message', 'Registrado y notificado correctamente.');
    }


    public function show($id)
    {
        $maintenance = Maintenance::findOrFail($id);
        return view('home.maintenance.show', compact('maintenance'));
    }

    public function edit($id)
    {
        //Usuario
        $user = Auth::user();

        if ($user->role_as == 0) {
            // ID del usuario logueado
            $user_id = Auth::user()->id;

            // Buscar el registro en la tabla 'maintenance' que tenga el ID proporcionado y cumpla con las condiciones
            $maintenance = Maintenance::where('id', $id)
                ->where('estado', 'Activo')
                ->where('user_id', $user_id)
                ->first();

            // Si se encontró el registro y cumple con las condiciones
            if ($maintenance) {
                return view('home.maintenance.edit', compact('maintenance'));
            } else {
                return redirect('home/maintenance')->with('message', 'No tiene permiso para Actualizar ese documento');
            }
        } else {
            $maintenance = Maintenance::findOrFail($id);
            return view('home.maintenance.edit', compact('maintenance'));
        }
    }

    public function update($id, request $request)
    {
        //Usuario
        $user = Auth::user();

        if ($user->role_as == 0) {
            //validar Formulario
            $validator = Validator::make($request->all(), [
                'maquina' => 'required',
                'proceso' => 'required',
                'descripcion' => 'required',
            ]);

            //Esto es para que lleve donde esta el formulario
            if ($validator->fails()) {
                return redirect(url()->previous())
                    ->withErrors($validator)
                    ->withInput();
            }

            $maintenance = Maintenance::find($id);

            $maintenance->maquina = $request->input('maquina');
            $maintenance->proceso = $request->input('proceso');
            $maintenance->descripcion = $request->input('descripcion');

            $maintenance->update();

            return redirect('home/maintenance')->with('message', 'Actualizado Correctamente');

        } else {

            $validator = Validator::make($request->all(), [
                'estado' => 'required',
                'nivel_criticidad' => 'required',
                'ejecutor' => 'required',
                'estado_previo' => 'required',
                'solucion_efectuada' => 'required',
                'estado_actual' => 'required',
                'observacion' => 'required',
            ]);

            //Esto es para que lleve donde esta el formulario
            if ($validator->fails()) {
                return redirect(url()->previous())
                    ->withErrors($validator)
                    ->withInput();
            }

            $maintenance = Maintenance::find($id);

            $maintenance->fecha_final = $request->input('fecha_final');
            $maintenance->estado = $request->input('estado');
            $maintenance->nivel_criticidad = $request->input('nivel_criticidad');
            $maintenance->ejecutor = $request->input('ejecutor');
            $maintenance->estado_previo = $request->input('estado_previo');
            $maintenance->solucion_efectuada = $request->input('solucion_efectuada');
            $maintenance->estado_actual = $request->input('estado_actual');
            $maintenance->observacion = $request->input('observacion');

            $maintenance->update();

            return redirect('home/maintenance')->with('message', 'Actualizado Correctamente');

        }
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

        $maintenance = Maintenance::find($id);
        $maintenance->estado = 'Anulado';
        $maintenance->update();

        if ($maintenance) {
            $array = array(
                'message' => 'Eliminado Correctamente',
                'code' => 200,
                'error' => false,
            );
        } else {
            $array = array(
                'message' => 'Error al eliminar',
                'code' => 500,
                'error' => true
            );
        }
        return response()->json($array);
    }

}