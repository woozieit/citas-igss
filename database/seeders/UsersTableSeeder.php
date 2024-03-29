<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'nombres_apellidos' => 'Josue Carrillo',
            'dpi' => '0000000000000',
            'correo' => 'josuuecarrillo@gmail.com',
            'rol' => User::ADMIN,
            'password' => bcrypt(123456)
        ]);

        User::create([
            'nombres_apellidos' => 'Afiliado 1',
            'dpi' => '0000000000001',
            'correo' => 'afiliado@gmail.com',
            'rol' => User::AFILIADO,
            'password' => bcrypt(123456)
        ]);
    }
}
