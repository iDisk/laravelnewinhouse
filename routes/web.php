<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | En este archivo se describen las routes que reciben la peticion de la
  | aplicacion , es importante mantener la estructara correcta
  |
 */

Auth::routes();


Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('/register', function()
{
    abort(404);
});

//View logs
Route::get('pwm-logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->middleware('auth');

//Change language
Route::get('language/{idioma}', 'HomeController@idioma');

//landing page
Route::get('/', 'HomeController@index');

Route::get('error', 'HomeController@noAccess');

Route::get('client_registration/{id}', 'Web\ClientRegistrationController@registration');
Route::post('client_registration/{id}', 'Web\ClientRegistrationController@ajax_checkvaliduser');
Route::post('ajax_check_otp/{id}', 'Web\ClientRegistrationController@ajax_check_otp');
Route::post('ajax_check_user/{id}', 'Web\ClientRegistrationController@ajax_check_user');
Route::post('ajax_save_user_security/{id}', 'Web\ClientRegistrationController@ajax_save_user_security');

Route::group(['middleware' => ['preventBackHistory', 'check_backend_user']], function ()
{

    Route::get('/home', 'HomeController@home')->name('home');

    //Profiles
    Route::get('datatable/perfiles', 'Web\PerfilController@dataperfil');
    Route::resource('perfiles', 'Web\PerfilController');

    Route::get('showmenus/{profile_id}/assign', 'Web\PerfilController@showRolmenu');
    Route::post('asignamenus', 'Web\PerfilController@asignaMenu');
    //Admin user
    Route::get('datatable/usuarios', 'Web\UsuarioController@datausers');
    Route::resource('usuarios', 'Web\UsuarioController');

    //Security questions
    Route::get('datatable/security_questions', 'Web\SecurityQuestionController@datasecurityquestions');
    Route::resource('security_questions', 'Web\SecurityQuestionController');

    //Security images
    Route::get('datatable/security_images', 'Web\SecurityImageController@datasecurityimages');
    Route::resource('security_images', 'Web\SecurityImageController');

    Route::get('getstatelist/{id}', 'Web\ClientController@getStatelist');
    Route::get('getcitylist/{id}', 'Web\ClientController@getcitylist');
    Route::get('getbrokercolor/{id}', 'Web\ClientController@getbrokercolor');

    //Client
    Route::get('datatable/clients', 'Web\ClientController@dataclients');
    Route::resource('clients', 'Web\ClientController');

    //Transaction
    Route::get('datatable/transactions/{id?}', 'Web\TransactionController@dataaaccounttransactions');
    Route::resource('transactions', 'Web\TransactionController');
    Route::get('account_transactions/{id}', 'Web\TransactionController@account_transactions_list');
    Route::get('create_transaction/{id}', 'Web\TransactionController@create_transaction');

    //Instruments
    Route::get('datatable/instruments', 'Web\InstrumentController@datainstruments');
    Route::resource('instruments', 'Web\InstrumentController');

    //Items
    Route::get('datatable/items', 'Web\ItemController@dataitems');
    Route::resource('items', 'Web\ItemController');

    //Leverages
    Route::get('datatable/leverages', 'Web\LeverageController@dataleverages');
    Route::resource('leverages', 'Web\LeverageController');
    Route::get('ajax_getleverages/{id}', 'Web\LeverageController@ajax_getleverages');


    //Commission fees
    Route::get('datatable/commission_fees', 'Web\CommissionFeeController@datacommission_fees');
    Route::resource('commission_fees', 'Web\CommissionFeeController');

    //Type of Movimientos
    Route::get('datatable/movimientos_tipos', 'Web\MovimientosTipoController@datamovimientos_tipos');
    Route::resource('movimientos_tipos', 'Web\MovimientosTipoController');

    //Description of Movimientos
    Route::get('datatable/movimientos_descripcions', 'Web\MovimientosDescripcionController@datamovimientos_descripcions');    
    Route::resource('movimientos_descripcions', 'Web\MovimientosDescripcionController');

    //Transaction of Movimientos
    Route::get('datatable/movimientos_transactions', 'Web\MovimientosTransactionController@datamovimientos_transactions');
    //Check movement by ref. ticket
    Route::post('movimientos_transactions/check_ticket_info', 'Web\MovimientosTransactionController@check_ticket_info');
    Route::resource('movimientos_transactions', 'Web\MovimientosTransactionController');

    //Account Forms
    Route::get('account_forms/{account_type}', 'Web\AccountformController@forms');

    Route::get('client_login', 'Web\ClientLoginController@index');


    Route::get('reporte/trade', 'Web\ReportController@show_trade_report');
    Route::post('reporte/trade', 'Web\ReportController@generate_trade_report');
    Route::any('reporte/generate-trade', 'Web\ReportController@generate_trade_table');

    Route::get('reporte/equity', 'Web\ReportController@show_equity_report');
    Route::get('datatable/equity', 'Web\ReportController@data_equity_report');

    //Branches
    Route::get('datatable/branches', 'Web\BranchController@databranches');
    Route::resource('branches', 'Web\BranchController');

    Route::resource('accounts', 'Web\AccountController');

    Route::post('reporte/send-report', 'Web\ReportController@send_report');

    Route::get('reporte/equity/{id}', 'Web\ReportController@show_equity_details');

    Route::get('reporte/trade/history', 'Web\ReportController@show_trade_report_history');
    Route::get('reporte/trade/history/{id}', 'Web\ReportController@download_trade_report');
    Route::get('reporte/trade/history/{id}/details', 'Web\ReportController@show_trade_report_history_details');
    Route::get('datatable/trade_report_history', 'Web\ReportController@dataTradereportHistory');

    Route::get('configuration', 'Web\SettingController@index');
    Route::post('configuration', 'Web\SettingController@store');

    Route::any('bitacora', 'UserActionLogController@index');

    //Promotion
    Route::get('brands/{brand_id}/promotion', 'Web\PromotionController@index');
    Route::post('brands/{brand_id}/promotion', 'Web\PromotionController@store');
    Route::get('brands/{brand_id}/promotion/create', 'Web\PromotionController@create');
    Route::get('brands/{brand_id}/promotion/{promotion_id}/edit', 'Web\PromotionController@edit');
    Route::put('brands/{brand_id}/promotion/{promotion_id}', 'Web\PromotionController@update');
    Route::delete('brands/{brand_id}/promotion/{promotion_id}', 'Web\PromotionController@destroy');
    Route::get('datatable/brands/{id}/promotion', 'Web\PromotionController@data_promotions');

    Route::get('datatable/brands', 'Web\BrokerController@databrands');
    Route::resource('brands', 'Web\BrokerController');

    //Request (Tramites)
    Route::get('datatable/tramites', 'Web\ClientRequestController@data_client_request');
    Route::resource('tramites', 'Web\ClientRequestController');

    //Estatus
    Route::get('datatable/estatus', 'Web\EstatusController@data_estatus');
    Route::resource('estatus', 'Web\EstatusController');

    //Trade Investment
    Route::get('datatable/trade_investment', 'Web\TradeInvestmentController@data_trade_investment');
    Route::resource('trade_investment', 'Web\TradeInvestmentController');

    //Check Trade opening for account
    Route::get('accounts/{id}/{instrument_id}/check_trade', 'Web\AccountController@check_trade_investment');

    //Users other accounts
    Route::get('datatable/user_other_accounts', 'Web\UserOtherAccountController@datauser_other_accounts');
    Route::resource('user_other_accounts','Web\UserOtherAccountController');
    
    //Get Broker related accounts
    Route::post('accounts/get_broker_accounts', 'HomeController@get_broker_accounts');
});



Route::middleware(['get_theme'])->group(function()
{
    //Admin login as client
    Route::get('master_login', 'UserWeb\ClientController@master_login')->name('master_login');
    Route::post('master_admin_authentication', 'UserWeb\ClientController@master_admin_authentication');
    Route::post('ajax_auth_admin_as_client', 'UserWeb\ClientController@ajax_auth_admin_as_client');

    //Client login
    Route::get('user_login', 'UserWeb\ClientController@client_login')->name('client_login');
    Route::post('user_login', 'UserWeb\ClientController@auth_client');
    Route::post('ajax_user_login', 'UserWeb\ClientController@ajax_auth_client');
    Route::post('user_security_login', 'UserWeb\ClientController@get_client_security_data');

    //Change password
    Route::get('user/forgot-password', 'UserWeb\ClientController@show_forgot_password')->name('forgot_password');
    Route::post('ajax_check_security_question', 'UserWeb\ClientController@ajax_check_security_question');
    Route::get('forgot-password-link/{user_id}/{time}', 'UserWeb\ClientController@forgot_password_link');
    Route::post('forgot-password-link', 'UserWeb\ClientController@forgot_pwd_change');
    Route::post('user_security_questions', 'UserWeb\ClientController@get_client_security_questions');
});


Route::middleware(['preventBackHistory','check_client_user', 'get_theme'])->group(function()
{
    Route::get('user/inicio', 'UserWeb\HomeController@index')->name('client_home');
    //get last ten trade/investment
    Route::get('user/inicio/last_ten/{type}/{instrument_id}', 'UserWeb\MyAccountController@last_ten_records');
    Route::get('user/inicio/record_bydate/{type}/{instrument_id}/{from}/{to}', 'UserWeb\MyAccountController@record_bydate');
    Route::get('user/inicio/view/{type}/{transaction_id}', 'UserWeb\MyAccountController@inicio_view');

    Route::get('user/trade_investment_view/{transaction_id}', 'UserWeb\TradeInvestmentController@trade_investment_view');


    Route::get('user/estado_de_cuenta', 'UserWeb\HomeController@estado_de_cuenta');

    //Fetch trade
    Route::get('user/datatable/get_trade/{instruments}', 'UserWeb\MyAccountController@dataget_trade');

    // /Derivados ETIM CFDS FX
    Route::get('user/derivados_etim', 'UserWeb\HomeController@derivados_etim');
    Route::get('user/derivados_etim_detail/{type}/{transaction_id}', 'UserWeb\MyAccountController@derivados_etim_detail');

    //My account instruments
    Route::get('user/mis_cuentas_instrumentos/{instrumentos}', 'UserWeb\TradeInvestmentController@mis_cuentas_instrumentos');
    Route::get('user/mis_cuentas_instrumentos/{type}/{transaction_id}', 'UserWeb\TradeInvestmentController@cuentas_instrumentos_detalle');
    

    Route::get('user/financiamiento', 'UserWeb\HomeController@financiamiento');

    //cambio de custodio
    Route::get('user/cambio_de_custodio', 'UserWeb\HomeController@cambio_de_custodio');

    //Promociones
    Route::get('user/promociones', 'UserWeb\HomeController@promociones');
    Route::get('user/promociones/{id}', 'UserWeb\HomeController@promociones_detale');

    //handle all requests
    Route::post('user/client_request', 'UserWeb\ClientRequestController@save_request');
    Route::get('user/datatable/client_requests', 'UserWeb\ClientRequestController@dataclient_request');
    Route::post('user/generate_code', 'UserWeb\ClientRequestController@ajax_generate_code');
    Route::post('user/verify_request', 'UserWeb\ClientRequestController@ajax_verify_request');
    Route::delete('user/delete_client_request', 'UserWeb\ClientRequestController@delete_client_request');
    Route::post('user/activate_client_request', 'UserWeb\ClientRequestController@activate_client_request');

    //Display all requests
    Route::get('user/tramites_en_curso', 'UserWeb\ClientRequestController@tramites_en_curso');

    //Administración de cuentas
    Route::get('user/administracion_de_cuentas', 'UserWeb\HomeController@administracion_de_cuentas');

    //Footer Documents
    Route::get('user/privacy', 'UserWeb\HomeController@show_privacy_policy')->name('privacy_policy');
    Route::get('user/tnc', 'UserWeb\HomeController@show_tnc')->name('tnc');

    //solicitar un financiamiento
    Route::get('user/solicitar_un_financiamiento', 'UserWeb\HomeController@solicitar_un_financiamiento');
    
    //Change password
    Route::get('user/change-password', 'UserWeb\HomeController@show_change_password')->name('change_password');
    Route::post('user/change-password', 'UserWeb\HomeController@change_password');
    
    //amplie su financiamiento
    Route::get('user/amplie_su_financiamiento', 'UserWeb\HomeController@amplie_su_financiamiento');
    
    //refinanciamiento
    Route::get('user/refinanciamiento', 'UserWeb\HomeController@refinanciamiento');
    
    //Download statement
    Route::post('user/estado_de_cuenta', 'UserWeb\StatementController@download_statement_pdf');

    //derivados
    Route::get('user/diversify', 'UserWeb\HomeController@diversify');

    //capacidad_de_financiamiento
    Route::get('user/capacidad_de_financiamiento', 'UserWeb\HomeController@capacidad_de_financiamiento');

    //cerrar_un_financiamiento
    Route::get('user/cerrar_un_financiamiento', 'UserWeb\HomeController@cerrar_un_financiamiento');
    
    //entre_mis_cuentas
    Route::get('user/entre_mis_cuentas', 'UserWeb\HomeController@entre_mis_cuentas');
    Route::get('user/pending_internal_transfers', 'UserWeb\MyAccountController@pending_internal_transfers');

    //entre_el_mis_broker
    Route::get('user/entre_el_mis_broker', 'UserWeb\HomeController@entre_el_mis_broker');
    Route::get('user/pending_internal_broker_transfers', 'UserWeb\MyAccountController@pending_internal_broker_transfers');

    //Notifications
    Route::get('user/notifications', 'Web\NotificationController@index');
    Route::get('user/notifications/{id}', 'Web\NotificationController@show');

    //transferencias_internacionales
    Route::get('user/transferencias_internacionales', 'UserWeb\HomeController@transferencias_internacionales');
    Route::get('user/get_user_other_accounts/{id}', 'Web\UserOtherAccountController@ajax_get_user_other_account');
    Route::get('user/pending_international_transfers', 'UserWeb\MyAccountController@pending_international_transfers');

    //envio_de_documentacion
    Route::get('user/envio_de_documentacion', 'UserWeb\HomeController@envio_de_documentacion');

    //datos_personales
    Route::get('user/datos_personales', 'UserWeb\HomeController@datos_personales');

    //Download Statement
    Route::get('user/estado_de_cuenta/trade/history/{id}', 'Web\ReportController@download_trade_report');

    Route::get('user/datatable/baja_de_cuentas', 'UserWeb\ClientRequestController@databaja_de_cuentas');
    Route::get('user/baja_de_cuentas', 'UserWeb\ClientRequestController@baja_de_cuentas');
    
    //alta_de_cuentas
    Route::get('user/alta_de_cuentas', 'UserWeb\HomeController@alta_de_cuentas');
    Route::get('user/pending_account_registrations', 'UserWeb\MyAccountController@pending_account_registrations');

    Route::get('user/getstatelist/{id}', 'Web\ClientController@getStatelist');
    Route::get('user/getcitylist/{id}', 'Web\ClientController@getcitylist');

    // control_de_acceso - request for the updation of user id and password
    Route::get('user/control_de_acceso', 'UserWeb\HomeController@control_de_acceso');
    
    //adjuste_permisos
    Route::get('user/adjuste_de_permisos', 'UserWeb\HomeController@adjuste_de_permisos');             
});