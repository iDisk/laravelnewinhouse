<?php

namespace App\Http\Controllers\UserWeb;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;

use App\Support\Util;
use App\Models\User;
use App\Models\UserSecurity;
use App\Models\SecurityQuestion;

use Mail;
use App\Mail\GeneralMail;
use App\Util\HelperUtil;

use Auth;
use DB;

class ClientController extends Controller
{
    public function client_login(Request $request)
    {
        /**/
        //$dd = HelperUtil::broker_setting_using_domain($request);

        //dd($dd);

        ////
        $user = auth()->user();
        if(!$user)
        {
            return view('auth.client_login');
        }
        else
        {
            return redirect('/');
        }
    }

    public function auth_client(Request $request)
    {
    	//dd($request);
    	if (Auth::attempt(array('user_login' => $request->user_login, 'password' => $request->password,'perfil_id' => 2))){
            $usuario = Auth::user();

            if(!$usuario)
            {
                return redirect()->back()->withErrors(__('frontsistema.frm_user_login.correct_user_pwd_msg'))->withInput();
            }else{

                if(!$usuario->status)
                {
                    Auth::logout();
                    $request->session()->flush();
                    $request->session()->regenerate();
                    return redirect()->back()->withErrors(__('frontsistema.frm_user_login.inactive_user_msg'))->withInput();
                }

                $usuario->update([
                    'current_login_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'last_login_at' => $usuario->current_login_at
                ]);
            }
            
        }else{
            return redirect()->back()->withErrors(__('frontsistema.frm_user_login.correct_user_pwd_msg'))->withInput();
        }

        return redirect('user/inicio');
    }

    // Function to get the client security image and phrase
    public function get_client_security_data(Request $request)
    {
        $campos   = $request->all();
        try
        {

            $user = User::where('user_login', $campos['user_login'])->first();

            if ($user)
            {
                if(!$user->status){
                    $data = [
                        "result"  => null,
                        "error"   => true,
                        "code"    => 500,
                        "message" => __('frontsistema.frm_user_login.inactive_user_msg')
                    ];
                }
                else{

                    //get user broker if both same then next
                    $broker_setting  = HelperUtil::broker_setting_using_domain($request);
                    
                    if($user->client->broker->id != $broker_setting->broker_id){
                        $data = [
                            "result"  => null,
                            "error"   => true,
                            "code"    => 500,
                            "message" => __('frontsistema.frm_user_login.correct_user_login')
                        ];
                        return response()->json($data, 200);
                    }

                    $client_security = UserSecurity::select('user_securities.image_phrase', 'security_images.image')
                        ->leftJoin('security_images', 'security_images.id', '=', 'user_securities.security_image_id')
                        ->where('user_id', $user['id'])->first();
    
                    if($client_security){
                        $data = [
                            "result"  => null,
                            "error"   => false,
                            "code"    => 200,
                            "message" => '',
                            "data"    => $client_security
                        ];
                    }
                    else{
                        $data = [
                            "result"  => null,
                            "error"   => true,
                            "code"    => 500,
                            "message" => __('frontsistema.frm_user_login.no_security_data') 
                        ];
                    }
                }
                
            }
            else
            {
                $data = [
                    "result"  => null,
                    "error"   => true,
                    "code"    => 500,
                    "message" => __('frontsistema.frm_user_login.correct_user_login')
                ];
            }
            return response()->json($data, 200);
        }
        catch (\Exception $e)
        {
            $data   = [
                "result"  => null,
                "error"   => true,
                "code"    => 500,
                "message" => __('frontsistema.went_wrong_msg')
            ];

            return response()->json($data,200);
        }
    }
    // Function that allows user to login with ajax
    public function ajax_auth_client(Request $request)
    {
    	//dd($request);
    	if (Auth::attempt(array('user_login' => $request->user_login, 'password' => $request->password,'perfil_id' => 2))){
            $usuario = Auth::user();
            if(!$usuario)
            {
                $data   = [
                    "result"  => null,
                    "error"   => true,
                    "code"    => 500,
                    "message" => __('frontsistema.frm_user_login.correct_user_pwd_msg')
                ];
                return response()->json($data,200);
                
            }else{

                if(!$usuario->status)
                {
                    Auth::logout();
                    $request->session()->flush();
                    $request->session()->regenerate();
                    $data   = [
                        "result"  => null,
                        "error"   => true,
                        "code"    => 500,
                        "message" => __('frontsistema.frm_user_login.inactive_user_msg')
                    ];
                    return response()->json($data,200);
                }

                $usuario->update([
                    'current_login_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'last_login_at' => $usuario->current_login_at
                ]);
            }
        }else{
            $data   = [
                "result"  => null,
                "error"   => true,
                "code"    => 500,
                "message" => __('frontsistema.frm_user_login.correct_user_pwd_msg')
            ];
            return response()->json($data,200);
        }
         $data   = [
                "result"  => null,
                "error"   => false,
                "code"    => 200,
                "message" => __('frontsistema.frm_user_login.correct_user_pwd_msg')
            ];
            return response()->json($data,200);
    }

    //Master login
    public function master_login(Request $request)
    {
        try{

            Auth::logout();
            //$request->session()->flush();
            //$request->session()->regenerate();
            return view('auth.master_login');
        }
        catch(\Exception $e){
            return redirect('/');
        }
    }

    public function master_admin_authentication(Request $request)
    {
        $campos   = $request->all();

        try{

            $data   = [
                "result"  => null,
                "error"   => true,
                "code"    => 500,
                "message" => __('frontsistema.master_login.admin_login_err')
            ];

            $admin_user = User::where('email',$campos['email'])->where('status',1)->where('perfil_id','!=',2)->first();

            if($admin_user){

                if(password_verify($campos['password'], $admin_user->password))
                {

                    $brokers =  \App\Models\PerfilBroker::where('perfil_id',$admin_user->perfil_id)->pluck('broker_id');

                    $accounts =  \App\Models\Account::select('users.id','accounts.account_number',DB::raw("CONCAT_WS(' ',clients.first_name,clients.middle_name,clients.surname1,clients.surname2) as client_name"))
                                    ->join('account_clients','account_clients.account_id','=','accounts.id')
                                    ->join('clients','clients.id','=','account_clients.client_id')
                                    ->join('users','users.id','=','clients.user_id')
                                    ->whereIn('accounts.broker_id',$brokers)
                                    ->where('users.status',1)
                                    ->get();

                    $data   = [
                        "result"  => $accounts,
                        "error"   => false,
                        "code"    => 200,
                        "message" => ''
                    ];
                    return response()->json($data,200);
                }
            }

            return response()->json($data,200);

        }
        catch(\Exception $e){

            $data   = [
                "result"  => null,
                "error"   => true,
                "code"    => 500,
                "message" => __('frontsistema.went_wrong_msg')
            ];

            return response()->json($data,200);

        }
    }

    // Function that allows Master to login with ajax
    public function ajax_auth_admin_as_client(Request $request)
    {

        if (env('MASTER_PASSWORD','') != '' && \Hash::check($request->master_password,env('MASTER_PASSWORD','')))
        {
            $user = User::find($request->user_id);

            if($user)
            {
                if(Auth::loginUsingId($user->id))
                {
                    $usuario = Auth::user();

                    if($usuario){

                        $request->session()->put('MASTER_USER', 'yes');

                        $data   = [
                            "result"  => null,
                            "error"   => false,
                            "code"    => 200,
                            "message" => ''
                        ];
                        return response()->json($data,200);
                    }
                }
            }

            $data   = [
                "result"  => null,
                "error"   => true,
                "code"    => 500,
                "message" => __('frontsistema.master_login.master_login_err')
            ];
            return response()->json($data,200);
        }
        else
        {
            $data   = [
                    "result"  => null,
                    "error"   => true,
                    "code"    => 500,
                    "message" => __('frontsistema.master_login.master_login_err')
                ];
            return response()->json($data,200);
        }
    }

    public function show_forgot_password(){
    
        /*$first_questions = SecurityQuestion::select('id',DB::raw("security_questions.question_".session('language')." as question"))
            ->where('question_type',1)
            ->where('active',1)
            ->get();

        $second_questions = SecurityQuestion::select('id',DB::raw("security_questions.question_".session('language')." as question"))
            ->where('question_type',2)
            ->where('active',1)
            ->get();

        $third_questions = SecurityQuestion::select('id',DB::raw("security_questions.question_".session('language')." as question"))
            ->where('question_type',3)
            ->where('active',1)
            ->get();*/

        return view('auth.client_forgot_password');
    }


    // Function to get the client security image and phrase
    public function get_client_security_questions(Request $request)
    {
        $campos   = $request->all();
        try
        {

            $user = User::where('user_login', $campos['user_login'])->first();

            if ($user)
            {
                if(!$user->status){
                    $data = [
                        "result"  => null,
                        "error"   => true,
                        "code"    => 500,
                        "message" => __('frontsistema.frm_user_login.inactive_user_msg')
                    ];
                }
                else{

                    //get user broker if both same then next
                    $broker_setting  = HelperUtil::broker_setting_using_domain($request);
                    if($user->client->broker->id != $broker_setting->broker_id){
                        $data = [
                            "result"  => null,
                            "error"   => true,
                            "code"    => 500,
                            "message" => __('frontsistema.frm_user_login.correct_user_login')
                        ];
                        return response()->json($data, 200);
                    }

                    $user_security = UserSecurity::where('user_id',$user->id)->first();

                    $first_questions = SecurityQuestion::select('id',DB::raw("security_questions.question_".session('language')." as question"))
                        ->where('id',$user_security->security_question1_id)
                        ->first();

                    $second_questions = SecurityQuestion::select('id',DB::raw("security_questions.question_".session('language')." as question"))
                        ->where('id',$user_security->security_question2_id)
                        ->first();

                    $third_questions = SecurityQuestion::select('id',DB::raw("security_questions.question_".session('language')." as question"))
                        ->where('id',$user_security->security_question3_id)
                        ->first();

                    $data['first_questions'] = $first_questions;
                    $data['second_questions'] = $second_questions;
                    $data['third_questions'] = $third_questions;

                    if($user_security){
                        $data = [
                            "result"  => null,
                            "error"   => false,
                            "code"    => 200,
                            "message" => '',
                            "data"    => $data
                        ];
                    }
                    else{
                        $data = [
                            "result"  => null,
                            "error"   => true,
                            "code"    => 500,
                            "message" => __('frontsistema.frm_user_login.no_security_data') 
                        ];
                    }
                }
                
            }
            else
            {
                $data = [
                    "result"  => null,
                    "error"   => true,
                    "code"    => 500,
                    "message" => __('frontsistema.frm_user_login.correct_user_login')
                ];
            }
            return response()->json($data, 200);
        }
        catch (\Exception $e)
        {
            $data   = [
                "result"  => null,
                "error"   => true,
                "code"    => 500,
                "message" => __('frontsistema.went_wrong_msg')
            ];

            return response()->json($data,200);
        }
    }

    public function ajax_check_security_question(Request $request)
    {
        $campos   = $request->all();
        try
        {

            $data   = [
                    "result"  => null,
                    "error"   => true,
                    "code"    => 500,
                    "message" => __('frontsistema.forgot_password.enter_correct_answers')
                ];

            $user = User::where('user_login', $campos['user_login'])->first();

            if($user){

                $client_security = UserSecurity::select('user_securities.id')
                        ->where('user_id', $user->id)
                        ->where('security_question1_id', $campos['question1'])
                        ->where('security_question2_id', $campos['question2'])
                        ->where('security_question3_id', $campos['question3'])
                        ->where('answer1', $campos['answer1'])
                        ->where('answer2', $campos['answer2'])
                        ->where('answer3', $campos['answer3'])
                        ->first();

                if($client_security){
                    //User selected correct question answers
                    //send email
                    $client = $user->client;
                    $subject = __('sistema.forgot_password_mail.subject');

                    $user_id = HelperUtil::encode($user->id);
                    $time = HelperUtil::encode(time());

                    $parameters['url'] = url('forgot-password-link').'/'.$user_id.'/'.$time;
                    $parameters['user'] = $client->FullName;

                    Mail::to($client->email1)->send(new GeneralMail('emails\forgot_password', $subject, $parameters));

                        $data   = [
                        "result"  => null,
                        "error"   => false,
                        "code"    => 200,
                        "message" => __('frontsistema.forgot_password.recive_email')
                    ];
                    return response()->json($data,200);
                }
            }

            return response()->json($data,200);
        }
        catch(\Exception $e){
            $data   = [
                    "result"  => null,
                    "error"   => true,
                    "code"    => 500,
                    "message" => __('frontsistema.went_wrong_msg')
                ];
            return response()->json($data,200);
        }
    }

    public function forgot_password_link($user_id, $time)
    {
        try{

            $decoded_user_id = HelperUtil::decode($user_id);
            $time = HelperUtil::decode($time);

            $current_time = time();

            $link_expire = true;

            if(($time + 43200) >= $current_time)
            {
                $link_expire = false;
            }

            $user = User::find($decoded_user_id);

            if(!$user){
                return redirect()->route('client_login');
            }

            return view('auth.client_forgot_pwd_link')
                ->with('link_expire', $link_expire)
                ->with('user_id', $user_id);

        }
        catch(\Exception $e){
            return redirect()->route('client_login');
        }
    }

    public function forgot_pwd_change(Request $request)
    {

        $campos   = $request->all();
        try
        {

            $user_id = HelperUtil::decode($campos['user']);

            $user = User::where('user_login', $campos['user_login'])->where('id',$user_id)->first();

            if($user){
                $user->password = \Hash::make($campos['new_password']);
                $user->save();

                $data   = [
                    "result"  => null,
                    "error"   => false,
                    "code"    => 200,
                    "message" => __('frontsistema.forgot_password_link.password_change_suc')
                ];

                return response()->json($data,200);

            }else
            {
                $data   = [
                    "result"  => null,
                    "error"   => true,
                    "code"    => 500,
                    "message" => __('frontsistema.forgot_password_link.user_err_msg')
                ];

                return response()->json($data,200);

            }

        }
        catch(\Exception $e){
            $data   = [
                    "result"  => null,
                    "error"   => true,
                    "code"    => 500,
                    "message" => __('frontsistema.went_wrong_msg')
                ];
            return response()->json($data,200);
        }
    }
}