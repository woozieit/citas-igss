<?php

namespace App\Interfaces;

use Carbon\Carbon;

interface ScheduleServiceInterface
{
    public function isAvailableInterval($date, $clinica_id, Carbon $start);
    public function getAvailableIntervals($date, $clinica_id);
}
