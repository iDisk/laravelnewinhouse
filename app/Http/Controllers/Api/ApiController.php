<?php

namespace App\Http\Controllers\Api;

/**
 * @SWG\Swagger(
 *     schemes={"http","https"},
 *     host="pwm.espacios.io",
 *     basePath="/api/v1",
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="PWM API",
 *         description="Esta es la API REST para las operaciones de la aplicacion Laravel y poder ser compliant",
 *         @SWG\Contact(
 *             email="alealg@espaciosmail.com"
 *         )
 *     )
 * )
 */
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Support\Util;
use App\Models\Token;
use App\Models\Push;
use App\Models\User;
use Validator;
use Log;
use Auth;

class ApiController extends Controller
{

    /**
     * Version de API REST
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/",
     *     description="Returns API Version.",
     *     produces={"application/json"},
     *     tags={"API Methods"},
     *     @SWG\Response(
     *         response=200,
     *         description="API V1 Version Standard."
     *     )
     * )
     */
    public function versionApi()
    {
        return Util::creaRest(200, [], false, 'PWM Móvil API V1 (c) ' . date('Y'));
    }

    /**
     * @SWG\Post(
     *   path="/login",
     *     description="Authentication with username and password",
     *     summary="General Authentication",
     *     produces={"application/json"},
     *     tags={"Authentication Methods"},
     *     operationId="login",
     *   @SWG\Parameter(
     *     name="email",
     *     in="query",
     *     description="Email of user",
     *     required=true,     
     *     type="string"
     *   ),     
     *   @SWG\Parameter(
     *     name="password",
     *     in="query",
     *     description="Password for authentication",
     *     required=true,     
     *     type="string"
     *   ),               
     *   @SWG\Response(response=200, description="Authenticated"),     
     *   @SWG\Response(response=400, description="Validation failed."),          
     *   @SWG\Response(response=401, description="Invalid Credentials"),          
     *   @SWG\Response(response=403, description="User not found/Inactive User"),              
     *   @SWG\Response(response=500, description="Something went wrong"),     
     * )
     *
     */
    public function login(Request $request)
    {
        //Obtener todos los campos
        $campos   = $request->all();
        //Validar
        //Validation rules
        $rules    = array(
            'email'    => 'required|email',
            'password' => 'required'
        );
        $messages = array(
            'email.required'    => 'El correo es requerido',
            'email.email'       => 'El correo debe ser valido',
            'password.required' => 'El password es requerido'
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails())
        {
            return Util::creaRest(400, $validator->messages(), true, 'Error en datos de inicio de sesión');
        }
        else
        {
            //Procesar la logica de inicio de sesion
            $usuario = User::where('email', $campos['email'])->first();

            if ($usuario == null)
            {
                //El usuario no existe
                return Util::creaRest(400, [], true, 'La cuenta no existe');
            }
            else
            {
                //El usuario existe validar que ya este la cuenta activa
                if ($usuario->status == 0)
                {
                    //La cuenta existe pero no esta activada
                    return Util::creaRest(400, [], true, 'La cuenta esta bloqueada y no puede iniciar sesión');
                }



                //Autentificar si la cuenta ya esta activa
                if (Auth::attempt(['email' => $campos['email'], 'password' => $campos['password']]))
                {
                    //Si la validacion es correcta

                    $tiempo  = time();
                    $user_id = $usuario->id;


                    //Verificar que no exista un token activo y valido
                    $dataToken = Token::where('user_id', $user_id)->where('expire', '>', $tiempo)->first(['token', 'expire']);

                    $sendToken = [];

                    if ($dataToken == null)
                    {
                        //No hay token activo o valido
                        //Crear uno nuevo
                        $nwToken           = Util::crea_token();
                        $sendToken['auth'] = ['token' => $nwToken['token'], 'expire' => $nwToken['expire'], 'info' => 'Token nuevo enviando'];

                        //Grabar en la tabla para crear persistencia
                        $saveToken          = new Token;
                        $saveToken->token   = $nwToken['token'];
                        $saveToken->expire  = $nwToken['expire'];
                        $saveToken->user_id = $user_id;
                        $saveToken->save();
                    }
                    else
                    {
                        //Aun existe un token activo enviar                            
                        $sendToken['auth'] = ['token' => $dataToken->token, 'expire' => $dataToken->expire, 'info' => 'Token aun valido reenviando'];
                    }
                    //Ya obtenido el token enviar arreglo con respuesta
                    $sendAuth = compact('usuario', 'sendToken');
                    return Util::creaRest(200, $sendAuth, false, 'Inicio de sesion correcto');
                }
                else
                {
                    //Contraseña equivocada
                    return Util::creaRest(400, [], true, 'La contraseña esta incorrecta');
                }
            }
        }
    }

    public function changePass(Request $request)
    {
        $token = $request->header('Authorization');
        if (Util::verificaToken($token))
        {

            $data              = $request->all();
            $user_id           = $data['user_id'];
            $id                = $user_id;
            $usuario           = User::find($id);
            $data              = $request->all();
            $usuario->password = bcrypt($data['password']);
            $usuario->save();

            $respuesta = Util::creaRest(200, ['info' => 'Su Contraseña fue cambiada correctamente'], false, 'Contraseña cambiada correctamente! ');
        }
        else
        {

            //El token no es valido
            $respuesta = Util::creaRest(500, ['info' => 'Verifique su sesion'], true, 'El token proporcionado no es valido ');
        }

        return $respuesta;
    }

    //Registro de device token para notificaciones Push
    public function registerPush(Request $request)
    {
        $token = $request->header('Authorization');
        if (Util::verificaToken($token))
        {
            //Si el token es valido
            $data = $request->all();

            //Token Valido obtener id de usuario
            $user_id = Util::find_id_by_token($token);

            //Verificar el deviceToken no este duplicado
            $dt        = $data['token'];
            $verifPush = Push::where('token', $dt)->where('user_id', $user_id)->get();
            Log::info('Datos de verificacion de token = ');
            Log::info($verifPush);

            if ($verifPush->count() > 0)
            {
                //YA existe el Token con el id de usuario
                Log::info('Datos de Token ya existen =');
                Log::info($data);
            }
            else
            {
                //Agregar device type y token para notificaciones push
                Log::info('Datos de Token agregados =');
                Log::info($data);
                $push          = new Push;
                $push->user_id = $user_id;
                $push->device  = $data['device'];
                $push->token   = $data['token'];
                $push->save();
            }



            $respuesta = Util::creaRest(200, [], false, 'Registro de dispositivo para notificaciones ,realizado correctamente');
        }
        else
        {

            //El token no es valido
            $respuesta = Util::creaRest(500, ['info' => 'Verifique su sesion'], true, 'El token proporcionado no es valido ');
        }

        return $respuesta;
    }

}
