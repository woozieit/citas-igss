<?php

namespace App\Http\Controllers;

use App\Models\Clinica;
use App\Models\Horario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ClinicaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clinicas = Clinica::with('user')->get();

        return view('admin.clinicas.index', compact('clinicas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.clinicas.create');
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
            'nombre' => 'required'
        ]);

        $input = $request->all();

        $input['estado'] = true;
        $input['created_by'] = Auth::id();

        $clinica = new Clinica();
        $clinica->fill( $input )->save();

        return Redirect::route('clinicas.index')->withSuccess('Registro guardo con éxito.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $clinica = Clinica::with(['user', 'horarios'])->findOrFail($id);

        return view('admin.clinicas.show', compact('clinica'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $clinica = Clinica::findOrFail($id);

        return view('admin.clinicas.edit', compact('clinica'));
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
            'nombre' => 'required'
        ]);

        $input = $request->all();

        $input['estado'] = $request->estado === 'on' ? true : false;

        $clinica = Clinica::find($id);
        $clinica->update( $input );

        return Redirect::route('clinicas.index')->withSuccess('Registro actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Clinica::find($id)->delete()
            ? response()->json(['success' => 'Registro eliminado con éxito.'])
            : response()->json(['authorize' => 'Esta acción no está autorizada.']);
    }
}
