<?php
/*
* File          PushObserver.php
* Autor         Dante Robles
* Description   Clase con metodos que mapean un evento de Eloquent
* Fecha         20/Septiembre/2017
*/

namespace App\Observers;

use App\Models\User;
use App\Models\Dispositivo;
use App\Models\Push;
use App\Support\Util;
use Log;

class PushObserver
{
    /**
     * Listen to the User created event.
     *
     * @param  User  $user
     * @return void
     */
    public function created(Push $push)
    {
        $this->actualizaDashboard();
    }

    /**
     * Listen to the User deleting event.
     *
     * @param  User  $user
     * @return void
     */
    public function deleted(Push $push)
    {
        $this->actualizaDashboard();
    }


    private function actualizaDashboard()
    {
        $extra=[];
        $extra['total_users'] = User::count();
        $extra['total_dispositivos'] = Dispositivo::count();
        $extra['total_android'] = Push::where('device','android')->count();
        $extra['total_apple'] = Push::where('device','ios')->count();

        Util::enviaPusher($extra);
        
        Log::info('Esta informacion se empujara via Pusher');
        Log::info($extra);
    }
}
