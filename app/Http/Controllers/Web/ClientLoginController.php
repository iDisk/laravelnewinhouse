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


class ClientLoginController extends Controller
{
    public function index(){
        $security_images =  SecurityImage::where('active','1')->orderBy('order')->get();

        $current_lang = HelperUtil::get_currentlang();

        $security_questions1 =  SecurityQuestion::where('active','1')->where('question_type','1')->orderBy('order')->pluck('question_'.$current_lang,'id')->toArray();

        $security_questions2 =  SecurityQuestion::where('active','1')->where('question_type','2')->orderBy('order')->pluck('question_'.$current_lang,'id')->toArray();
        $security_questions3 =  SecurityQuestion::where('active','1')->where('question_type','3')->orderBy('order')->pluck('question_'.$current_lang,'id')->toArray();
        
        return view('catalogos.client_login.client_login')
                ->with('security_images',$security_images)
                ->with('security_questions1',$security_questions1)
                ->with('security_questions2',$security_questions2)
                ->with('security_questions3',$security_questions3)
                ->with('user_id',2);
    }
}
