<?php

namespace Database\Seeders;

use App\Models\Horario;
use Illuminate\Database\Seeder;

class HorariosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        for ( $i = 0; $i < 5; ++$i ) {
            Horario::create([
		        'clinica_id' => 1, // Clínica Test (ClinicassTableSeeder)
                'dia_semana' => $i,
                'estado' => ( $i == 3), // Miércoles

                'manana_inicio' => ($i==3 ? '07:00:00' : '07:00:00'),
		        'manana_fin' => ($i==3 ? '09:30:00' : '07:00:00'),

		        'tarde_inicio' => ($i==3 ? '15:00:00' : '13:00:00'),
		        'tarde_fin' => ($i==3 ? '14:00:00' : '13:00:00'),

            ]);
        }
    }
}
