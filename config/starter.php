<?php

/*
  |--------------------------------------------------------------------------
  | Configuracion de variables del sistema para Laravel 5.5
  |--------------------------------------------------------------------------
  |
  |
  | Aqui se definen variables que puedan ser utilizadas por el sistema
  |
 */

return [
    'api_time'             => 5184000,
    'pusher_active'        => false,
    'dashboard_active'     => false,
    'gcm_key'              => 'AIzaSyD_2BNPLy-gbYYv5pq6lN7FHLd5ZswBSg8',
    'queue_mail'           => false,
    'show_translate'       => true,
    'company_name'         => env('APP_NAME', 'PWM'),
    'charge_code'          => env('CHARGE_CODE', 1),
    'deposit_code'         => env('DEPOSIT_CODE', 2),
    'balance_inicial_code' => env('BALANCE_INICIAL_CODE', 7),
    'credit_code'          => env('CREDIT_CODE', 8),
    'debit_code'           => env('DEBIT_CODE', 9),
    'pl_code'              => env('PL_CODE', 13)
];
