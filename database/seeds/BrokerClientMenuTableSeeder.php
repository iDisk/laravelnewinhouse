<?php

use Illuminate\Database\Seeder;
use App\Models\BrokerClientMenu;

class BrokerClientMenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('broker_client_menus')->truncate();

        BrokerClientMenu::create([
            'id'                => 1,
            'client_menu_id'    => 1,
            'broker_id'         => 1,
            'order'             => 1,
            'parent'            => 0,
        ]);

        BrokerClientMenu::create([
            'id'                => 2,
            'client_menu_id'    => 2,
            'broker_id'         => 1,
            'order'             => 2,
            'parent'            => 0,
        ]);
        BrokerClientMenu::create([
            'id'                => 3,
            'client_menu_id'    => 3,
            'broker_id'         => 1,
            'order'             => 3,
            'parent'            => 2,
        ]);
        BrokerClientMenu::create([
            'id'                => 4,
            'client_menu_id'    => 4,
            'broker_id'         => 1,
            'order'             => 4,
            'parent'            => 2,
        ]);
        BrokerClientMenu::create([
            'id'                => 5,
            'client_menu_id'    => 5,
            'broker_id'         => 1,
            'parent'            => 2,
        ]);
        BrokerClientMenu::create([
            'id'                => 6,
            'client_menu_id'    => 6,
            'broker_id'         => 1,
            'order'             => 6,
            'parent'            => 2,
        ]);
        BrokerClientMenu::create([
            'id'                => 7,
            'client_menu_id'    => 7,
            'broker_id'         => 1,
            'order'             => 7,
            'parent'            => 0,
        ]);
        BrokerClientMenu::create([
            'id'                => 8,
            'client_menu_id'    => 8,
            'broker_id'         => 1,
            'order'             => 8,
            'parent'            => 7,
        ]);
        BrokerClientMenu::create([
            'id'                => 9,
            'client_menu_id'    => 9,
            'broker_id'         => 1,
            'order'             => 9,
            'parent'            => 7,
        ]);
        BrokerClientMenu::create([
            'id'                => 10,
            'client_menu_id'    => 10,
            'broker_id'         => 1,
            'order'             => 10,
            'parent'            => 0,
        ]);
        BrokerClientMenu::create([
            'id'                => 11,
            'client_menu_id'    => 11,
            'broker_id'         => 1,
            'order'             => 11,
            'parent'            => 10,
        ]);
        BrokerClientMenu::create([
            'id'                => 12,
            'client_menu_id'    => 12,
            'broker_id'         => 1,
            'order'             => 12,
            'parent'            => 10,
        ]);
        BrokerClientMenu::create([
            'id'                => 13,
            'client_menu_id'    => 13,
            'broker_id'         => 1,
            'order'             => 13,
            'parent'            => 10,
        ]);
        BrokerClientMenu::create([
            'id'                => 14,
            'client_menu_id'    => 14,
            'broker_id'         => 1,
            'order'             => 14,
            'parent'            => 10,
        ]);
        BrokerClientMenu::create([
            'id'                => 15,
            'client_menu_id'    => 15,
            'broker_id'         => 1,
            'order'             => 15,
            'parent'            => 10,
        ]);
        BrokerClientMenu::create([
            'id'                => 16,
            'client_menu_id'    => 16,
            'broker_id'         => 1,
            'order'             => 16,
            'parent'            => 0,
        ]);
        BrokerClientMenu::create([
            'id'                => 17,
            'client_menu_id'    => 17,
            'broker_id'         => 1,
            'order'             => 17,
            'parent'            => 16,
        ]);
        BrokerClientMenu::create([
            'id'                => 18,
            'client_menu_id'    => 18,
            'broker_id'         => 1,
            'order'             => 18,
            'parent'            => 0,
        ]);
        BrokerClientMenu::create([
            'id'                => 19,
            'client_menu_id'    => 19,
            'broker_id'         => 1,
            'order'             => 19,
            'parent'            => 0,
        ]);
        BrokerClientMenu::create([
            'id'                => 20,
            'client_menu_id'    => 20,
            'broker_id'         => 1,
            'order'             => 20,
            'parent'            => 19,
        ]);

        BrokerClientMenu::create([
            'id'                => 22,
            'client_menu_id'    => 22,
            'broker_id'         => 1,
            'order'             => 22,
            'parent'            => 19,
        ]);
        BrokerClientMenu::create([
            'id'                => 23,
            'client_menu_id'    => 23,
            'broker_id'         => 1,
            'order'             => 23,
            'parent'            => 19,
        ]);
        BrokerClientMenu::create([
            'id'                => 24,
            'client_menu_id'    => 24,
            'broker_id'         => 1,
            'order'             => 24,
            'parent'            => 19,
        ]);
        BrokerClientMenu::create([
            'id'                => 25,
            'client_menu_id'    => 25,
            'broker_id'         => 1,
            'order'             => 25,
            'parent'            => 0,
        ]);
        BrokerClientMenu::create([
            'id'                => 26,
            'client_menu_id'    => 26,
            'broker_id'         => 1,
            'order'             => 26,
            'parent'            => 25,
        ]);
        BrokerClientMenu::create([
            'id'                => 27,
            'client_menu_id'    => 27,
            'broker_id'         => 1,
            'order'             => 27,
            'parent'            => 25,
        ]);
        BrokerClientMenu::create([
            'id'                => 28,
            'client_menu_id'    => 28,
            'broker_id'         => 1,
            'order'             => 28,
            'parent'            => 25,
        ]);
        BrokerClientMenu::create([
            'id'                => 29,
            'client_menu_id'    => 29,
            'broker_id'         => 1,
            'order'             => 29,
            'parent'            => 25,
        ]);
        BrokerClientMenu::create([
            'id'                => 30,
            'client_menu_id'    => 30,
            'broker_id'         => 1,
            'order'             => 30,
            'parent'            => 25,
        ]);
        BrokerClientMenu::create([
            'id'                => 31,
            'client_menu_id'    => 31,
            'broker_id'         => 1,
            'order'             => 31,
            'parent'            => 25,
        ]);
    }

}
