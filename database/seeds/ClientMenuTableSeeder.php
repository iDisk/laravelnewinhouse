<?php

use Illuminate\Database\Seeder;
use App\Models\ClientMenu;

class ClientMenuTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('client_menus')->truncate();

        ClientMenu::create([
            'id'     => 1,
            'menu'   => 'INICIO',
            'es'     => 'INICIO',
            'en'     => 'HOME',
            'url'    => 'user/inicio',
            'parent' => 0,
            'active' => 1
        ]);

        ClientMenu::create([
            'id'     => 2,
            'menu'   => 'MIS CUENTAS',
            'es'     => 'MIS CUENTAS',
            'en'     => 'MY ACCOUNTS',
            'url'    => '#',
            'parent' => 0,
            'active' => 1
        ]);

        ClientMenu::create([
            'id'     => 3,
            'menu'   => 'DERIVADOS ETIM CFDS FX',
            'es'     => 'DERIVADOS ETIM CFDS FX',
            'en'     => 'DERIVATIVES ETIM CFDS FX',
            'url'    => 'user/derivados_etim',
            'parent' => 2,
            'active' => 1
        ]);

        ClientMenu::create([
            'id'     => 4,
            'menu'   => 'FONDOS DE INVERSIÓN',
            'es'     => 'FONDOS DE INVERSIÓN',
            'en'     => 'INVESTMENT FUNDS',
            'url'    => 'user/fondos_de_inversion',
            'parent' => 2,
            'active' => 1
        ]);

        ClientMenu::create([
            'id'     => 5,
            'menu'   => 'FINANCIAMIENTO',
            'es'     => 'FINANCIAMIENTO',
            'en'     => 'FINANCING',
            'url'    => 'user/financiamiento',
            'parent' => 2,
            'active' => 1
        ]);

        ClientMenu::create([
            'id'     => 6,
            'menu'   => 'ESTADO DE CUENTA',
            'es'     => 'ESTADO DE CUENTA',
            'en'     => 'ACCOUNT STATEMENTS',
            'url'    => 'user/estado_de_cuenta',
            'parent' => 2,
            'active' => 1
        ]);

        ClientMenu::create([
            'id'     => 7,
            'menu'   => 'TRANSFERENCIAS',
            'es'     => 'TRANSFERENCIAS',
            'en'     => 'TRANSFERS',
            'url'    => '#',
            'parent' => 0,
            'active' => 1
        ]);

        ClientMenu::create([
            'id'     => 8,
            'menu'   => 'ENTRE MIS CUENTAS',
            'es'     => 'ENTRE MIS CUENTAS',
            'en'     => 'BETWEEN MY ACCOUNTS',
            'url'    => '#',
            'parent' => 7,
            'active' => 1
        ]);

        ClientMenu::create([
            'id'     => 9,
            'menu'   => 'TRANSFERENCIAS INTERNACIONALES',
            'es'     => 'TRANSFERENCIAS INTERNACIONALES',
            'en'     => 'INTERNATIONAL TRANSFERS',
            'url'    => '#',
            'parent' => 7,
            'active' => 1
        ]);

        ClientMenu::create([
            'id'     => 10,
            'menu'   => 'FINANCIAMIENTOS',
            'es'     => 'FINANCIAMIENTOS',
            'en'     => 'FINANCING',
            'url'    => '#',
            'parent' => 0,
            'active' => 1
        ]);

        ClientMenu::create([
            'id'     => 11,
            'menu'   => 'SOLICITAR UN FINANCIAMIENTO',
            'es'     => 'SOLICITAR UN FINANCIAMIENTO',
            'en'     => 'REQUEST A FINANCING',
            'url'    => '#',
            'parent' => 10,
            'active' => 1
        ]);

        ClientMenu::create([
            'id'     => 12,
            'menu'   => 'AMPLIACIÓN DE FINANCIAMIENTO',
            'es'     => 'AMPLIACIÓN DE FINANCIAMIENTO',
            'en'     => 'FUNDING EXTENSION',
            'url'    => '#',
            'parent' => 10,
            'active' => 1
        ]);

        ClientMenu::create([
            'id'     => 13,
            'menu'   => 'REFINANCIAMIENTO',
            'es'     => 'REFINANCIAMIENTO',
            'en'     => 'REFINANCING',
            'url'    => '#',
            'parent' => 10,
            'active' => 1
        ]);

        ClientMenu::create([
            'id'     => 14,
            'menu'   => 'CONSULTE SU CAPACIDAD DE FINANCIAMIENTO',
            'es'     => 'CONSULTE SU CAPACIDAD DE FINANCIAMIENTO',
            'en'     => 'CHECK YOUR FINANCING CAPACITY',
            'url'    => '#',
            'parent' => 10,
            'active' => 1
        ]);

        ClientMenu::create([
            'id'     => 15,
            'menu'   => 'CERRAR UN FINANCIAMIENTO',
            'es'     => 'CERRAR UN FINANCIAMIENTO',
            'en'     => 'CLOSE A FINANCING',
            'url'    => '#',
            'parent' => 10,
            'active' => 1
        ]);

        ClientMenu::create([
            'id'     => 16,
            'menu'   => 'INVIERTA',
            'es'     => 'INVIERTA',
            'en'     => 'INVEST',
            'url'    => '#',
            'parent' => 0,
            'active' => 1
        ]);

        ClientMenu::create([
            'id'     => 17,
            'menu'   => 'DERIVADOS',
            'es'     => 'DERIVADOS',
            'en'     => 'DERIVATIVES',
            'url'    => '#',
            'parent' => 16,
            'active' => 1
        ]);

        ClientMenu::create([
            'id'     => 18,
            'menu'   => 'PROMOCIONES',
            'es'     => 'PROMOCIONES',
            'en'     => 'PROMOTIONS',
            'url'    => '#',
            'parent' => 0,
            'active' => 1
        ]);

        ClientMenu::create([
            'id'     => 19,
            'menu'   => 'SEGURIDAD Y ADMINISTRACIÓN',
            'es'     => 'SEGURIDAD Y ADMINISTRACIÓN',
            'en'     => 'SECURITY AND ADMINISTRATION',
            'url'    => '#',
            'parent' => 0,
            'active' => 1
        ]);

        ClientMenu::create([
            'id'     => 20,
            'menu'   => 'DATOS PERSONALES',
            'es'     => 'DATOS PERSONALES',
            'en'     => 'PERSONAL INFORMATION',
            'url'    => '#',
            'parent' => 19,
            'active' => 1
        ]);
        
        ClientMenu::create([
            'id'     => 22,
            'menu'   => 'CONTROL DE ACCESO',
            'es'     => 'CONTROL DE ACCESO',
            'en'     => 'MAINTENANCE',
            'url'    => '#',
            'parent' => 19,
            'active' => 1
        ]);
        ClientMenu::create([
            'id'     => 23,
            'menu'   => 'ADMINISTRACIÓN DE CUENTAS',
            'es'     => 'ADMINISTRACIÓN DE CUENTAS',
            'en'     => 'ACCOUNTS ADMINISTRATION',
            'url'    => '#',
            'parent' => 19,
            'active' => 1
        ]);
        ClientMenu::create([
            'id'     => 24,
            'menu'   => 'AJUSTES DE PERMISOS',
            'es'     => 'AJUSTES DE PERMISOS',
            'en'     => 'PERMIT ADJUSTMENTS',
            'url'    => '#',
            'parent' => 19,
            'active' => 1
        ]);

        ClientMenu::create([
            'id'     => 25,
            'menu'   => 'SERVICIOS',
            'es'     => 'SERVICIOS',
            'en'     => 'SERVICES',
            'url'    => '#',
            'parent' => 0,
            'active' => 1
        ]);

        ClientMenu::create([
            'id'     => 26,
            'menu'   => 'TRÁMITES EN CURSO',
            'es'     => 'TRÁMITES EN CURSO',
            'en'     => 'PROCESSING IN PROGRESS',
            'url'    => '#',
            'parent' => 25,
            'active' => 1
        ]);

        ClientMenu::create([
            'id'     => 27,
            'menu'   => 'ENVÍO DE DOCUMENTACIÓN',
            'es'     => 'ENVÍO DE DOCUMENTACIÓN',
            'en'     => 'DOCUMENT DELIVERY',
            'url'    => 'user/envio_de_documentacion',
            'parent' => 25,
            'active' => 1
        ]);

        ClientMenu::create([
            'id'     => 28,
            'menu'   => 'ALTA DE CUENTAS',
            'es'     => 'ALTA DE CUENTAS',
            'en'     => 'HIGH ACCOUNTS',
            'url'    => '#',
            'parent' => 25,
            'active' => 1
        ]);

        ClientMenu::create([
            'id'     => 29,
            'menu'   => 'BAJA DE CUENTAS',
            'es'     => 'BAJA DE CUENTAS',
            'en'     => 'LOW ACCOUNTS',
            'url'    => 'user/baja_de_cuentas',
            'parent' => 25,
            'active' => 1
        ]);

        ClientMenu::create([
            'id'     => 30,
            'menu'   => 'CAMBIO DE CUSTODIO',
            'es'     => 'CAMBIO DE CUSTODIO',
            'en'     => 'CHANGE OF CUSTODY',
            'url'    => '#',
            'parent' => 25,
            'active' => 1
        ]);

        ClientMenu::create([
            'id'     => 31,
            'menu'   => 'CONTACTO',
            'es'     => 'CONTACTO',
            'en'     => 'CONTACT',
            'url'    => '#',
            'parent' => 25,
            'active' => 1
        ]);
    }

}
