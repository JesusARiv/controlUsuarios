<?php

namespace Database\Seeders;

use App\Models\UserType;
use Illuminate\Database\Seeder;

class UserTypes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        UserType::create(['type' => 'Administrador']);
        UserType::create(['type' => 'Profesor']);
        UserType::create(['type' => 'Alumno']);
    }
}
