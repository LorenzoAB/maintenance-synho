<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//Usar  la base de datos
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
//Modelos
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.user.index');
    }

    public function list_ajax()
    {
        $data = DB::table('users')
            ->select('users.*')
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
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        //validar Formulario
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required',
            'password' => 'min:8|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:8',
            'role_as'     => 'required',
        ]);
        //Esto es para que lleve donde esta el formulario
        if ($validator->fails()) {
            return redirect(url()->previous())
                    ->withErrors($validator)
                    ->withInput();
        }
        
        //validar 
        $validate = \DB::table('users as v')
        ->select('v.id')
        ->where('v.name','=',$request->input('name'))
        ->orwhere('v.email','=',$request->input('email'))
        ->get();

        $validator = array('errors'=>'El nombre o email estan registrados');

        if(count($validate) > 0 ){
            return redirect(url()->previous())
                    ->withErrors($validator)
                    ->withInput();
        }

        $user = new user();
        
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->password);
        $user->role_as = $request->input('role_as');
        $user->phone = $request->input('phone');

        $user->save();
        
        return redirect('admin/user')->with('message', 'Usuario agregado Correctamente');
    }

    public function edit($id)
    {

        $user = user::findOrFail($id);
        return view('admin.user.edit')->with(
            array(
                'user' => $user,
            )
        );
    }

    public function show($id)
    {
        $user = user::findOrFail($id);
        return view('admin.user.show')->with(
            array(
                'user' => $user,
            )
        );
    }

    public function update($id, request $request)
    {
        //validar Formulario
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required',
            'role_as'     => 'required',
        ]);
        //Esto es para que lleve donde esta el formulario
        if ($validator->fails()) {
            return redirect(url()->previous())
                    ->withErrors($validator)
                    ->withInput();
        }


        $user = user::find($id);

        if(empty($request->password)){
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->role_as = $request->input('role_as');
            $user->phone = $request->input('phone');
            $user->update();
        }else{
            $validator = Validator::make($request->all(),[
                'password' => 'min:8|required_with:password_confirmation|same:password_confirmation',
                'password_confirmation' => 'min:8',

            ]);

            if ($validator->fails()) {
                return redirect(url()->previous())
                        ->withErrors($validator)
                        ->withInput();
            }

            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->role_as = $request->input('role_as');
            $user->phone = $request->input('phone');
            $user->password = Hash::make($request->password);
            $user->update();
        }
    
        return redirect('admin/user')->with('message', 'Usuario actualizado Correctamente');
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
        $user = user::find($id);
        $user->delete();

        if ($user) {
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

    public function profile()
    {
        $userauth = \Auth::user();
        $id = strval($userauth->id);

        $user = user::find($id);
        return view('home.user.profile')->with(
            array(
                'user' => $user,
            )
        );
    }

    public function profile_update($id, request $request)
    {
        //validar Formulario
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
        ]);
        //Esto es para que lleve donde esta el formulario
        if ($validator->fails()) {
            return redirect(url()->previous())
                ->withErrors($validator)
                ->withInput();
        }


        $user = user::find($id);

        if (empty($request->password)) {
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->phone = $request->input('phone');
            $user->update();
        } else {
            $validator = Validator::make($request->all(), [
                'password' => 'min:8|required_with:password_confirmation|same:password_confirmation',
                'password_confirmation' => 'min:8',

            ]);

            if ($validator->fails()) {
                return redirect(url()->previous())
                    ->withErrors($validator)
                    ->withInput();
            }

            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->phone = $request->input('phone');
            $user->password = Hash::make($request->password);
            $user->update();
        }

        return redirect('/home')->with('message', 'Perfil actualizado Correctamente');
    }

    
    
}