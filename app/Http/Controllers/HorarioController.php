<?php

namespace App\Http\Controllers;

use App\Interfaces\ScheduleServiceInterface;
use App\Models\Horario;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class HorarioController extends Controller
{
    private $dias = [
        'Lunes',
        'Martes',
        'Miércoles',
        'Jueves',
        'Viernes',
        // 'Sábado',
        // 'Domingo'
    ];

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $horarios = Horario::where('clinica_id', $id)->get();

        if ( count($horarios) > 0 ) {

            $horarios->map( function ( $horario ) {

                $horario->manana_inicio = ( new Carbon($horario->manana_inicio) )->format('g:i A');
                $horario->manana_fin = ( new Carbon($horario->manana_fin) )->format('g:i A');
                $horario->tarde_inicio = ( new Carbon($horario->tarde_inicio) )->format('g:i A');
                $horario->tarde_fin = ( new Carbon($horario->tarde_fin) )->format('g:i A');

                return $horario;
            });
        } else {

            $horarios = collect();

            for ( $i = 0; $i < 5; ++$i ) {
                $horarios->push( new Horario() );
            }
        }

        $dias = $this->dias;

        return view('admin.horarios.create', compact('id', 'horarios', 'dias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $estado = $request->estado ?: [];
        $manana_inicio = $request->manana_inicio;
    	$manana_fin = $request->manana_fin;
    	$tarde_inicio = $request->tarde_inicio;
    	$tarde_fin = $request->tarde_fin;

        $errors = [];

        for ( $i = 0; $i < 5; $i++ ) {

            if ($manana_inicio[$i] > $manana_fin[$i]) {
                $errors [] = 'Las horas del turno mañana son inconsistentes para el día ' . $this->dias[$i] . '.';
            }

            if ($tarde_inicio[$i] > $tarde_fin[$i]) {
                $errors [] = 'Las horas del turno tarde son inconsistentes para el día ' . $this->dias[$i] . '.';
            }

            Horario::updateOrCreate(
                [
                    'dia_semana' => $i,
                    'clinica_id' => $request->clinica_id
                ],
                [
                    'estado' => in_array( $i, $estado ),
                    'manana_inicio' => $manana_inicio[$i],
                    'manana_fin' => $manana_fin[$i],
                    'tarde_inicio' => $tarde_inicio[$i],
                    'tarde_fin' => $tarde_fin[$i],
                ]
            );

        }

        if ( count($errors) > 0 )
            return back()->with(compact('errors'));

        return back()->withSuccess('El horario fue agregado correctamente');
    }

    public function hours(Request $request, ScheduleServiceInterface $scheduleService)
    {
        $rules = [
            'fecha' => 'required|date_format:"Y-m-d"',
            'clinica_id' => 'required|exists:clinicas,id'
        ];

        $request->validate( $rules );

        $fecha = $request->fecha;
        $clinica_id = $request->clinica_id;

        return $scheduleService->getAvailableIntervals( $fecha, $clinica_id);
    }
}
