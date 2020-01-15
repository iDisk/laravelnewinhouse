<?php

use Illuminate\Database\Seeder;
use App\Models\PerfilMenu;

class PerfilMenuTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('perfil_menus')->truncate();

        PerfilMenu::create([
            'id'        => 1,
            'menu_id'   => 1,
            'perfil_id' => 1
        ]);
        PerfilMenu::create([
            'id'        => 2,
            'menu_id'   => 2,
            'perfil_id' => 1
        ]);
        PerfilMenu::create([
            'id'        => 3,
            'menu_id'   => 3,
            'perfil_id' => 1
        ]);
        PerfilMenu::create([
            'id'        => 4,
            'menu_id'   => 4,
            'perfil_id' => 1
        ]);
        PerfilMenu::create([
            'id'        => 5,
            'menu_id'   => 5,
            'perfil_id' => 1
        ]);
        PerfilMenu::create([
            'id'        => 6,
            'menu_id'   => 6,
            'perfil_id' => 1
        ]);
        PerfilMenu::create([
            'id'        => 7,
            'menu_id'   => 7,
            'perfil_id' => 1
        ]);
        PerfilMenu::create([
            'id'        => 8,
            'menu_id'   => 8,
            'perfil_id' => 1
        ]);
        PerfilMenu::create([
            'id'        => 9,
            'menu_id'   => 9,
            'perfil_id' => 1
        ]);
        PerfilMenu::create([
            'id'        => 10,
            'menu_id'   => 10,
            'perfil_id' => 1
        ]);
        PerfilMenu::create([
            'id'        => 11,
            'menu_id'   => 11,
            'perfil_id' => 1
        ]);
        PerfilMenu::create([
            'id'        => 13,
            'menu_id'   => 13,
            'perfil_id' => 1
        ]);
        PerfilMenu::create([
            'id'        => 14,
            'menu_id'   => 14,
            'perfil_id' => 1
        ]);
        PerfilMenu::create([
            'id'        => 15,
            'menu_id'   => 15,
            'perfil_id' => 1
        ]);
        PerfilMenu::create([
            'id'        => 16,
            'menu_id'   => 16,
            'perfil_id' => 1
        ]);
        PerfilMenu::create([
            'id'        => 17,
            'menu_id'   => 17,
            'perfil_id' => 1
        ]);
        PerfilMenu::create([
            'id'        => 18,
            'menu_id'   => 18,
            'perfil_id' => 1
        ]);
        PerfilMenu::create([
            'id'        => 19,
            'menu_id'   => 19,
            'perfil_id' => 1
        ]);
        PerfilMenu::create([
            'id'        => 20,
            'menu_id'   => 20,
            'perfil_id' => 1
        ]);
        PerfilMenu::create([            
            'menu_id'   => 23,
            'perfil_id' => 1
        ]);
        PerfilMenu::create([            
            'menu_id'   => 24,
            'perfil_id' => 1
        ]);
        PerfilMenu::create([            
            'menu_id'   => 25,
            'perfil_id' => 1
        ]);
        PerfilMenu::create([            
            'menu_id'   => 26,
            'perfil_id' => 1
        ]);
    }

}
