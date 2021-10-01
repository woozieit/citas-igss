<?php

namespace Database\Seeders;

use App\Models\Clinica;
use Illuminate\Database\Seeder;

class ClinicasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Clinica::create([
            'nombre' => 'Clínica la Luz',
            'created_by' => 1
        ]);
    }
}
