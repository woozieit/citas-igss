<?php

namespace App\Http\Controllers;

use App\Interfaces\ScheduleServiceInterface;
use App\Models\Cita;
use App\Models\Clinica;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class CitaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role = auth()->user()->rol;

        $citas = Cita::with(['afiliado', 'user', 'clinica'])->orderBy('fecha_cita', 'DESC')->get();

        if ( $role === 'Afiliado' ) {
            $citas = $citas->where('afiliado_id', auth()->id())->where('fecha_cita', '>=', Carbon::now()->subDay(7)->format('Y-m-d'));
        }

        return view('admin.citas.index', compact('citas', 'role'));
    }

    public function create(ScheduleServiceInterface $scheduleService)
    {
        $afiliados = User::Afiliados()->get();
        $clinicas = Clinica::where('estado', true)->get();
        $role = auth()->user()->rol;

        $date = old('fecha_cita');
        $clinica_id = old('clinica_id');

        if ( $date && $clinica_id ) {
            $intervals = $scheduleService->getAvailableIntervals( $date, $clinica_id );
        } else {
            $intervals = null;
        }

        return view('admin.citas.create', compact('afiliados', 'clinicas', 'role', 'intervals'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ScheduleServiceInterface $scheduleService)
    {
        $role = auth()->user()->rol;

        if ( $role == 'admin' ) {
            $rules = [
                'clinica_id'=>'exists:clinicas,id',
                'afiliado_id'=>'exists:users,id',
                'hora_cita'=>'required',
            ];
        } else {
            $rules = [
                'clinica_id'=>'exists:clinicas,id',
                'hora_cita'=>'required',
            ];
        }

        $messages = [
            'hora_cita.required' => 'Por favor seleccione una hora válida para su cita'
        ];

        $validator = Validator::make( $request->all(), $rules, $messages );

        $validator->after( function ( $validator ) use ( $request, $scheduleService) {

            $fecha = $request->fecha_cita;
            $clinica_id = $request->clinica_id;
            $hora_cita = $request->hora_cita;

            if ( $fecha && $clinica_id && $hora_cita ) {
                $start = new Carbon( $hora_cita );
            } else {
                return;
            }

            if ( !$scheduleService->isAvailableInterval($fecha, $clinica_id, $start) ) {
                $validator->errors()->add('available_time', 'La hora seleccionada ya se encuentra reservada por otro afiliado.');
            }
        });

        if ( $validator->fails() ) {
            return back()
                    ->withErrors($validator)
                    ->withInput();
        }

        $data = $request->only([
            'clinica_id',
            'fecha_cita',
            'hora_cita'
        ]);

        if ( $role === 'Admin' ) {
            $data['afiliado_id'] = $request->afiliado_id;
        } else {
            $data['afiliado_id'] = auth()->id();
        }

        $validCitaDay = Cita::where('afiliado_id', $data['afiliado_id'])->where('fecha_cita', $request->fecha_cita)->first();

        if ( $validCitaDay ) {
            return back()->withErrors(array('El afiliado ya tiene una cita en la fecha seleccionada'));
        }

        $data['created_by'] = auth()->id();

        $carbonTime = Carbon::createFromFormat( 'g:i A', $data['hora_cita'] );
        $data['hora_cita'] = $carbonTime->format('H:i:s');

        Cita::create($data);

        return Redirect::route('citas.index')->withSuccess('Registro guardo con éxito.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = auth()->user()->rol;
        $citas = Cita::findOrFail($id);

        return view('citas.show', compact('citas', 'role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, ScheduleServiceInterface $scheduleService)
    {
        $cita = Cita::findOrFail($id);
        $afiliados = User::Afiliados()->get();
        $clinicas = Clinica::where('estado', true)->get();
        $role = auth()->user()->rol;

        $intervals = $scheduleService->getAvailableIntervals( $cita->fecha_cita, $cita->clinica_id );

        return view('admin.citas.edit', compact('afiliados', 'clinicas', 'role', 'intervals', 'cita'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, ScheduleServiceInterface $scheduleService)
    {
        $role = auth()->user()->rol;

        if ( $role == 'admin' ) {
            $rules = [
                'clinica_id'=>'exists:clinicas,id',
                'afiliado_id'=>'exists:users,id',
            ];
        } else {
            $rules = [
                'clinica_id'=>'exists:clinicas,id',
            ];
        }

        $messages = [
            'hora_cita.required' => 'Por favor seleccione una hora válida para su cita'
        ];

        $validator = Validator::make( $request->all(), $rules, $messages );

        $cita = Cita::find($id);

        $validator->after( function ( $validator ) use ( $request, $scheduleService, $cita ) {

            $fecha = $request->fecha_cita;
            $clinica_id = $request->clinica_id;
            $hora_cita = !empty($request->hora_cita) ? $request->hora_cita : $cita->hora_cita;

            if ( $fecha && $clinica_id && $hora_cita ) {
                $start = new Carbon( $hora_cita );
            } else {
                return;
            }

            if ( !$scheduleService->isAvailableInterval($fecha, $clinica_id, $start) ) {
                $validator->errors()->add('available_time', 'La hora seleccionada ya se encuentra reservada por otro afiliado.');
            }
        });

        if ( $validator->fails() ) {
            return back()
                    ->withErrors($validator)
                    ->withInput();
        }

        $data = $request->only([
            'clinica_id',
            'fecha_cita',
            'hora_cita'
        ]);

        if ( $role === 'Admin' ) {
            $data['afiliado_id'] = $request->afiliado_id;
        } else {
            $data['afiliado_id'] = auth()->id();
        }

        $validCitaDay = Cita::where('afiliado_id', $data['afiliado_id'])->where('fecha_cita', $request->fecha_cita)->first();

        if ( $validCitaDay ) {
            return back()->withErrors(array('El afiliado ya tiene una cita en la fecha seleccionada'));
        }

        $carbonTime = Carbon::createFromFormat( 'g:i A', $data['hora_cita'] );
        $data['hora_cita'] = $carbonTime->format('H:i:s');

        $cita->update($data);

        return Redirect::route('citas.index')->withSuccess('Registro actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Cita::find($id)->delete()
            ? response()->json(['success' => 'Registro eliminado con éxito.'])
            : response()->json(['authorize' => 'Esta acción no está autorizada.']);
    }
}
