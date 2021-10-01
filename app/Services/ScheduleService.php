<?php

namespace App\Services;

use App\Interfaces\ScheduleServiceInterface;
use Carbon\Carbon;
use App\Models\Horario;
use App\Models\Cita;

class ScheduleService implements ScheduleServiceInterface
{
    public function isAvailableInterval($date, $clinica_id, Carbon $start)
    {
        $exists = Cita::where('clinica_id', $clinica_id)
                    ->where('fecha_cita', $date)
                    ->where('hora_cita', $start->format('H:i:s'))
                    ->exists();

        return !$exists; // available if already none exists
    }

    public function getAvailableIntervals($date, $clinica_id)
    {
        $horario = Horario::where('estado', true)
                        ->where('dia_semana', $this->getDayFromDate($date))
                        ->where('clinica_id', $clinica_id)
                        ->first([
                            'manana_inicio',
                            'manana_fin',
                            'tarde_inicio',
                            'tarde_fin',
                        ]);

        if ( $horario ) {

            $mananaIntervals = $this->getIntervals(
                $horario->manana_inicio,
                $horario->manana_fin,
                $date,
                $clinica_id
            );

            $tardeIntervals = $this->getIntervals(
                $horario->tarde_inicio,
                $horario->tarde_fin,
                $date,
                $clinica_id
            );

        } else {

            $mananaIntervals = [];
            $tardeIntervals = [];

        }

        $data = [];

        $data['manana'] = $mananaIntervals;
        $data['tarde'] = $tardeIntervals;

        return $data;
    }

    private function getDayFromDate($date)
	{
    	$dateCarbon = new Carbon($date);

    	// dayofWeek
    	// Carbon: 0 (sunday) - 6 (saturday)
    	// WorkDay: 0 (monday) - 6 (sunday)
    	$i = $dateCarbon->dayOfWeek;
    	$day = ($i==0 ? 6 : $i-1);
    	return $day;
	}

    private function getIntervals($start, $end, $date, $clinica_id) {
		$start = new Carbon($start);
    	$end = new Carbon($end);

    	$intervals = [];

    	while ($start < $end) {
    		$interval = [];

    		$interval['start']  = $start->format('g:i A');

            $available = $this->isAvailableInterval($date, $clinica_id, $start);

    		$start->addMinutes(30);
    		$interval['end']  = $start->format('g:i A');

            if ($available) {
                $intervals []= $interval;
            }
    	}

    	return $intervals;
    }
}
