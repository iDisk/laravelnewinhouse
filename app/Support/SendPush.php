<?php
/*
* File          SendPush.php
* Autor         Dante Robles
* Description   Clase con funciones de ayuda para enviar notificaciones Push
* Fecha         19/Septiembre/2017
*/
namespace App\Support;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Push;
use Apple\ApnPush\Certificate\Certificate;
use Apple\ApnPush\Notification;
use Apple\ApnPush\Notification\Connection;


class SendPush {

public function sendNotificacionAll($mensaje = "Mensaje de Prueba") {
        //Obtener todos los devices por tipo de sistema operativo
        $allAndroid = Push::where('device', 'android')->get();
        $alliOS = Push::where('device', 'ios')->get();

        $total = 0;

        if ($allAndroid->count() > 0) {
            $this->sendAndroid($allAndroid, $mensaje);
            $total = $total + $allAndroid->count();
        }


        //No usar hasta que se registre en apple
        if ($alliOS->count() > 0) {
            $this->sendiOS($alliOS, $mensaje);
            $total = $total + $alliOS->count();
        }


        return 'Total de notificaciones enviadas ' . $total;
    }

    public function sendNotificacion($user_id = 1, $mensaje = "Mensaje de Prueba") {
        //Obtener todos los devices por tipo de sistema operativo
        $allAndroid = Push::where('device', 'android')->where('user_id', $user_id)->get();
        $alliOS = Push::where('device', 'ios')->where('user_id', $user_id)->get();

        $total = 0;

        if ($allAndroid->count() > 0) {
            $this->sendAndroid($allAndroid, $mensaje);
            $total = $total + $allAndroid->count();
        }


        //No usar hasta que se registre en apple
        if ($alliOS->count() > 0) {
            $this->sendiOS($alliOS, $mensaje);
            $total = $total + $alliOS->count();
        }


        //return $respuesta = Util::creaRest(200, [], false, 'Total de notificaciones enviadas ' . $total);
    }

    public function sendAndroid($devices, $mensaje) {
        //Cambiar LLaves para usar la correcta    	
        $gcmKey = config('starter.gcm_key');

        foreach ($devices as $androide) {
            $registrationIds = array($androide->token);

            // prep the bundle
            $msg = array
                (
                'message' => $mensaje,
                'title' => 'Starterkit 5.5',
                'sound' => 'default',
                'largeIcon' => 'large_icon',
                'smallIcon' => 'small_icon'
            );
            $fields = array
                (
                'registration_ids' => $registrationIds,
                'data' => $msg
            );
            $headers = array
                (
                'Authorization: key=' . $gcmKey,
                'Content-Type: application/json'
            );
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            $result = curl_exec($ch);
            curl_close($ch);
        }
        return $devices;
    }

    public function sendiOS($devices, $mensaje) {
        // Cambiar Certificado por el que corresponde
        $certificate = new Certificate(storage_path() . '/push/starterkit55.pem', 'Starterkit2017*');
        // Second argument - sandbox mode
        $connection = new Connection($certificate, false);
        $notification = new Notification($connection);
        foreach ($devices as $iphone) {
            $notification->sendMessage($iphone->token, $mensaje, null, null, 'default');
        }
        return $devices;
    }

}