<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombres_apellidos' => 'required',
            'dpi' => 'required|min:13|max:13|unique:users',
            'correo' => 'required|email|unique:users',
            'rol' => 'required',
            'telefono' => 'nullable|min:8|max:8',
            'password' => 'required|min:6'
        ]);

        $input = $request->all();

        $input['password'] = bcrypt($request->password);
        $input['acreditacion'] = true;

        $user = new User;
        $user->fill( $input )->save();

        return Redirect::route('usuarios.index')->withSuccess('Registro guardo con éxito.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombres_apellidos' => 'required',
            'dpi' => 'required|min:13|max:13|unique:users,dpi,' . $id,
            'correo' => 'required|email|unique:users,correo,' . $id,
            'rol' => 'required',
            'telefono' => 'nullable|min:8|max:8',
            'password' => 'nullable|min:6|confirmed'
        ]);

        $input = $request->all();

        $input['acreditacion'] = $request->acreditacion === 'on' ? true : false;

        $user = User::find($id);

        $input['password'] = !empty($request->password) ? bcrypt($request->password) : $user->password;

        $user->update( $input );

        return Redirect::route('usuarios.index')->withSuccess('Registro actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return User::find($id)->delete()
            ? response()->json(['success' => 'Registro eliminado con éxito.'])
            : response()->json(['authorize' => 'Esta acción no está autorizada.']);
    }
}
