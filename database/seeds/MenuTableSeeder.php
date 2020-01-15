<?php

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('menus')->truncate();

        Menu::create([
            'id'     => 1,
            'menu'   => 'Administración',
            'es'     => 'Administración',
            'en'     => 'Management',
            'url'    => '#',
            'icon'   => 'mdi mdi-amplifier',
            'parent' => 0,
            'active' => 1,
            'order'  => 3
        ]);

        Menu::create([
            'id'     => 2,
            'menu'   => 'Usuarios',
            'es'     => 'Usuarios',
            'en'     => 'Users',
            'url'    => 'usuarios',
            'icon'   => 'mdi mdi-account-multiple',
            'parent' => 1,
            'active' => 1,
            'order'  => 1
        ]);

        Menu::create([
            'id'     => 3,
            'menu'   => 'Perfiles',
            'es'     => 'Perfiles',
            'en'     => 'Profiles',
            'url'    => 'perfiles',
            'icon'   => 'mdi mdi-face-profile',
            'parent' => 1,
            'active' => 1,
            'order'  => 2
        ]);

        Menu::create([
            'id'     => 4,
            'menu'   => 'Clientes',
            'es'     => 'Clientes',
            'en'     => 'Clients',
            'url'    => 'clients',
            'icon'   => 'mdi mdi-account-circle',
            'parent' => 1,
            'active' => 1,
            'order'  => 4
        ]);

        Menu::create([
            'id'     => 5,
            'menu'   => 'Seguridad Preguntas',
            'es'     => 'Seguridad Preguntas',
            'en'     => 'Security Questions',
            'url'    => 'security_questions',
            'icon'   => 'mdi mdi-comment-question-outline',
            'parent' => 1,
            'active' => 1,
            'order'  => 5
        ]);

        Menu::create([
            'id'     => 6,
            'menu'   => 'Seguridad Imágenes',
            'es'     => 'Seguridad Imágenes',
            'en'     => 'Security Images',
            'url'    => 'security_images',
            'icon'   => 'mdi mdi-image-multiple',
            'parent' => 1,
            'active' => 1,
            'order'  => 6
        ]);

        Menu::create([
            'id'     => 7,
            'menu'   => 'Instrumentos',
            'es'     => 'Instrumentos',
            'en'     => 'Instruments',
            'url'    => 'instruments',
            'icon'   => 'mdi mdi-codepen',
            'parent' => 1,
            'active' => 1,
            'order'  => 7
        ]);

        Menu::create([
            'id'     => 8,
            'menu'   => 'Apalancamientos',
            'es'     => 'Apalancamientos',
            'en'     => 'Leverages',
            'url'    => 'leverages',
            'icon'   => 'mdi mdi-file-export',
            'parent' => 1,
            'active' => 1,
            'order'  => 8
        ]);

        Menu::create([
            'id'     => 9,
            'menu'   => 'Items',
            'es'     => 'Items',
            'en'     => 'Items',
            'url'    => 'items',
            'icon'   => 'mdi mdi-terrain',
            'parent' => 1,
            'active' => 1,
            'order'  => 9
        ]);

        Menu::create([
            'id'     => 10,
            'menu'   => 'Tasas Comision',
            'es'     => 'Tasas Comision',
            'en'     => 'Commission Fees',
            'url'    => 'commission_fees',
            'icon'   => 'mdi mdi-percent',
            'parent' => 1,
            'active' => 1,
            'order'  => 10
        ]);

        Menu::create([
            'id'     => 11,
            'menu'   => 'Movimientos Tipo',
            'es'     => 'Movimientos Tipo',
            'en'     => 'Movements Type',
            'url'    => 'movimientos_tipos',
            'icon'   => 'mdi mdi-format-list-bulleted-type',
            'parent' => 1,
            'active' => 1,
            'order'  => 11
        ]);

        Menu::create([
            'id'     => 13,
            'menu'   => 'Movimientos Administrativos',
            'es'     => 'Movimientos Administrativos',
            'en'     => 'Movements Administrative',
            'url'    => 'movimientos_transactions',
            'icon'   => 'mdi mdi-cash-usd',
            'parent' => 26,
            'active' => 1,
            'order'  => 3
        ]);

        Menu::create([
            'id'     => 14,
            'menu'   => 'Trade',
            'es'     => 'Tasas Comision',
            'en'     => 'Trade',
            'url'    => 'transactions',
            'icon'   => 'mdi mdi-cash-usd',
            'parent' => 26,
            'active' => 1,
            'order'  => 1
        ]);

        Menu::create([
            'id'     => 15,
            'menu'   => 'Reportes',
            'es'     => 'Reportes',
            'en'     => 'Reports',
            'url'    => '#',
            'icon'   => 'fa fa-file-pdf-o',
            'parent' => 0,
            'active' => 1,
            'order'  => 4
        ]);

        Menu::create([
            'id'     => 16,
            'menu'   => 'Trade Reporte',
            'es'     => 'Trade Reporte',
            'en'     => 'Trade Report',
            'url'    => 'reporte/trade',
            'icon'   => 'mdi mdi-cash-multiple',
            'parent' => 15,
            'active' => 1,
            'order'  => 1
        ]);

        Menu::create([
            'id'     => 17,
            'menu'   => 'Equity Reporte',
            'es'     => 'Equity Reporte',
            'en'     => 'Equity Report',
            'url'    => 'reporte/equity',
            'icon'   => 'mdi mdi-cash-multiple',
            'parent' => 15,
            'active' => 1,
            'order'  => 2
        ]);

        Menu::create([
            'id'     => 18,
            'menu'   => 'Branches',
            'es'     => 'Sucursal',
            'en'     => 'Branches',
            'url'    => 'branches',
            'icon'   => 'mdi mdi-source-branch',
            'parent' => 1,
            'active' => 1,
            'order'  => 13
        ]);

        Menu::create([
            'id'     => 19,
            'menu'   => 'Trade Report',
            'es'     => 'Generate Statement',
            'en'     => 'Generate Statement',
            'url'    => 'reporte/trade',
            'icon'   => 'mdi mdi-engine-outline',
            'parent' => 15,
            'active' => 1,
            'order'  => 2
        ]);

        Menu::create([
            'id'     => 20,
            'menu'   => 'Configuration',
            'es'     => 'Configuración',
            'en'     => 'Configuration',
            'url'    => 'configuration',
            'icon'   => 'fa fa-gears',
            'parent' => 1,
            'active' => 1,
            'order'  => 14
        ]);
        
        Menu::create([
            'id'     => 21,
            'menu'   => 'Broker',
            'es'     => 'Marcas',
            'en'     => 'Brands',
            'url'    => 'brands',
            'icon'   => 'mdi mdi-account-star-variant',
            'parent' => 1,
            'active' => 1,
            'order'  => 3
        ]);
        
        Menu::create([
            'id'     => 23,
            'menu'   => 'Request (Tramites)',
            'es'     => 'Request (Tramites)',
            'en'     => 'Request (Tramites)',
            'url'    => 'tramites',
            'icon'   => 'mdi mdi-account-alert',
            'parent' => 0,
            'active' => 1,
            'order'  => 6
        ]);
        
        Menu::create([
            'id'     => 24,
            'menu'   => 'Estatus',
            'es'     => 'Estatus',
            'en'     => 'Estatus',
            'url'    => 'estatus',
            'icon'   => 'mdi mdi-traffic-light',
            'parent' => 1,
            'active' => 1,
            'order'  => 14
        ]);
        
        Menu::create([
            'id'     => 25,
            'menu'   => 'Trade Investment',
            'es'     => 'Transacciones de Inversión',
            'en'     => 'Trade Investment',
            'url'    => 'trade_investment',
            'icon'   => 'mdi mdi-cash-usd',
            'parent' => 26,
            'active' => 1,
            'order'  => 2
        ]);
     
        Menu::create([
            'id'     => 26,
            'menu'   => 'Transactions',
            'es'     => 'Transacciones',
            'en'     => 'Transactions',
            'url'    => '#',
            'icon'   => 'mdi mdi-cash-usd',
            'parent' => 0,
            'active' => 1,
            'order'  => 1
        ]);
    }

}
