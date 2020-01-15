<?php

use Illuminate\Database\Seeder;
use App\Models\Perfil;


class PerfilTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Truncate all previous records
        DB::table('perfils')->truncate();

        //Make new entries
        Perfil::create([
            'id'            => 1,
            'perfil'        => 'Administrador'
        ]);
        Perfil::create([
            'id'            => 2,
            'perfil'        => 'Usuario Móvil'
        ]);
        Perfil::create([
            'id'            => 3,
            'perfil'        => 'Ventas'
        ]);
        Perfil::create([
            'id'            => 4,
            'perfil'        => 'Gerente'
        ]);
        Perfil::create([
            'id'            => 5,
            'perfil'        => 'Analista'
        ]);
        Perfil::create([
            'id'            => 6,
            'perfil'        => 'Atención a Clientes'
        ]);
    }
}
