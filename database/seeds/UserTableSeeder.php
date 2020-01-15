<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
                'id'            => 1,
                'name'          => 'Administrador starterkit 5.5',
                'email'			=> 'admin@atrix.com',
                'password'		=> bcrypt('atrix'),
                'perfil_id'		=> 1		
            ]);
    }
}
