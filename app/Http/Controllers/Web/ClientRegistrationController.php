<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SecurityQuestion;
use App\Models\SecurityImage;
use App\Models\Client;
use App\Models\User;
use App\Models\UserSecurity;
use App\Models\UserOtp;
use Yajra\DataTables\Facades\DataTables;
use App\Support\Util;
use App\Util\HelperUtil;
use Validator;
use Carbon\Carbon;
use Mail;
use App\Mail\NotificationMail;

class ClientRegistrationController extends Controller
{

    public function registration($id)
    {
        if(auth()->user())
        {
            return redirect('/');
        }
        //dd(base64_encode('12'));
        $user_id = HelperUtil::decode($id);

        $user = User::find($user_id);

        if ($user)
        {
            if ($user->status)
            {
                return redirect()->route('client_login');
            }

            $security_images = SecurityImage::where('active', '1')->orderBy('order')->get();

            $current_lang = HelperUtil::get_currentlang();

            $security_questions1 = SecurityQuestion::where('active', '1')->where('question_type', '1')->orderBy('order')->pluck('question_' . $current_lang, 'id')->toArray();

            $security_questions2 = SecurityQuestion::where('active', '1')->where('question_type', '2')->orderBy('order')->pluck('question_' . $current_lang, 'id')->toArray();
            $security_questions3 = SecurityQuestion::where('active', '1')->where('question_type', '3')->orderBy('order')->pluck('question_' . $current_lang, 'id')->toArray();

            return view('catalogos.client_registration.registration')
                            ->with('security_images', $security_images)
                            ->with('security_questions1', $security_questions1)
                            ->with('security_questions2', $security_questions2)
                            ->with('security_questions3', $security_questions3)
                            ->with('user_id', $id)
                            ->with('user', $user);
        }
        else
        {
            return redirect()->route('client_login');
        }
    }

    public function ajax_checkvaliduser(Request $request, $id)
    {

        $id     = HelperUtil::decode($id);
        $campos = $request->all();
        $data   = [
            "result"  => null,
            "error"   => true,
            "code"    => 500,
            "message" => __('sistema.client_register.client_login_err')
        ];
        $user   = User::where('user_login', $campos['user_name'])
                        ->where('perfil_id', 2)
                        ->where('id', $id)
                        ->where('status', 0)->first();

        if ($user)
        {

            if (\Hash::check($campos['password'], $user->password))
            {

                $data = [
                    "result"  => null,
                    "error"   => false,
                    "code"    => 200,
                    "message" => __('sistema.update_success_msg')
                ];

                //send code in sms
                $client = Client::where('user_id', $user->id)->first();

                if ($client)
                {
                    $six_digit_random = HelperUtil::send_sms($client->telephone1);
                }
                //$six_digit_random = mt_rand(100000, 999999);

                UserOtp::where('user_id', $user->id)->where('type', 'registration')->delete();
                $registered_device = UserOtp::create([
                            'user_id' => $user->id,
                            'code'    => $six_digit_random,
                            'status'  => 1,
                            'type'    => 'registration',
                ]);

                return response()->json($data, 200);
            }
        }
        return response()->json($data, 200);
    }

    public function ajax_check_otp(Request $request, $id)
    {

        $id       = HelperUtil::decode($id);
        $campos   = $request->all();
        $user_otp = UserOtp::where('user_id', $id)
                        ->where('code', $campos['code'])
                        ->where('type', 'registration')->first();

        if ($user_otp)
        {

            $data = [
                "result"  => null,
                "error"   => false,
                "code"    => 200,
                "message" => __('sistema.update_success_msg')
            ];
            UserOtp::where('user_id', $id)
                    ->where('type', 'registration')->delete();
        }
        else
        {
            $data = [
                "result"  => null,
                "error"   => true,
                "code"    => 500,
                "message" => 'Error!'
            ];
        }

        return response()->json($data, 200);
    }

    public function ajax_check_user(Request $request, $id)
    {

        $id     = HelperUtil::decode($id);
        $campos = $request->all();
        $user   = User::where('user_login', $campos['user_name'])
                        ->where('id', '!=', $id)
                        ->where('perfil_id', 2)->first();

        if ($user)
        {

            $data = [
                "result"  => null,
                "error"   => true,
                "code"    => 500,
                "message" => __('sistema.client_register.check_user_err')
            ];
        }
        else
        {

            $data = [
                "result"  => null,
                "error"   => false,
                "code"    => 200,
                "message" => __('sistema.update_success_msg')
            ];
        }

        return response()->json($data, 200);
    }

    public function ajax_save_user_security(Request $request, $id)
    {
        try
        {
            $id     = HelperUtil::decode($id);
            $campos = $request->all();

            $user                   = User::find($id);
            $user->user_login       = $campos['user_name'];
            $user->password         = bcrypt($campos['password']);
            $user->status           = 1;
            $user->password_changed = 1;
            $user->save();

            $user_security                        = new UserSecurity;
            $user_security->user_id               = $id;
            $user_security->security_image_id     = $campos['image'];
            $user_security->image_phrase          = $campos['image_phrase'];
            $user_security->security_question1_id = $campos['qusetion1'];
            $user_security->answer1               = $campos['answer1'];
            $user_security->security_question2_id = $campos['qusetion2'];
            $user_security->answer2               = $campos['answer2'];
            $user_security->security_question3_id = $campos['qusetion3'];
            $user_security->answer3               = $campos['answer3'];
            $user_security->save();

            $data = [
                "result"  => null,
                "error"   => false,
                "code"    => 200,
                "message" => __('sistema.update_success_msg')
            ];

            //Account activation
            $client = $user->client;
            if ($client)
            {
                $broker = $client->broker;

                $parameters_json = [
                    'NOMBRE_DEL_BROKER' => $broker->broker,
                ];

                \App\Models\Notification::create([
                    'user_id'       => $user->id,
                    'short_message' => 'activate_account',
                    'parameters'    => json_encode($parameters_json),
                    'template_name' => 'activate_account',
                    'is_read'       => 0,
                ]);

                $email_to     = $client->email1;
                $current_lang = HelperUtil::get_currentlang();
                $subject      = __('sistema.notifications.short_message.activate_account');
                Mail::to($email_to)->send(new NotificationMail('notifications.' . $current_lang . '.activate_account', $subject, $parameters_json));
            }
            return response()->json($data, 200);
        }
        catch (\Exception $ex)
        {
            return response()->json($ex->getMessage(), 500);
        }
    }

}
