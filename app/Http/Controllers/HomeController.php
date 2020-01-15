<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

use App\Support\Util;
use App\Models\User;
use App\Models\Push;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        if(auth()->user())
        {
            session(['menusValidos'=>Util::regresaRutasValidas()]);

            $lstMenus = Util::generateMenu(auth()->user()->perfil_id);
            
            if(auth()->user()->perfil_id == 1)
            {
                return redirect('transactions');
            }
            else
            {
                 return redirect()->route('client_home');
            }
            
            if(config('starter.dashboard_active'))
            {
                $extra['total_users'] = User::count();
                $extra['total_android'] = Push::where('device','android')->count();
                $extra['total_apple'] = Push::where('device','ios')->count();

                return view('home')->with('elmenu',['elmenu'=>$lstMenus])->with('extra',$extra); 
            }
            else
            {
                return view('home')->with('elmenu',['elmenu'=>$lstMenus]);
            }

        }else{

            //return redirect()->route('login');
            return redirect()->route('client_login');
        }
    }

    public function home()
    {
        session(['menusValidos'=>Util::regresaRutasValidas()]);

        $lstMenus = Util::generateMenu(auth()->user()->perfil_id);

        if(auth()->user()->isActive)
        {
            return redirect('transactions');
            if(config('starter.dashboard_active'))
            {
                $extra['total_users'] = User::count();            
                $extra['total_android'] = Push::where('device','android')->count();
                $extra['total_apple'] = Push::where('device','ios')->count();

                return view('home')->with('elmenu',['elmenu'=>$lstMenus])->with('extra',$extra); 
            }else{
                return view('home')->with('elmenu',['elmenu'=>$lstMenus]);
            } 


        }else{
            return redirect('error');
        }
    }

    public function noAccess()
    {
        return view('noingresar')->with('elmenu',['elmenu'=>'']);
    }

    public function idioma(Request $request,$idioma)
    {
        session(['language' => $idioma]);
        return back();
    }

    public function ajaxImageUpload(Request $request)
    {
        if ($request->isMethod('get'))
            return view('ajax_image_upload');
        else {
            $validator = Validator::make($request->all(),
                [
                    'file' => 'image',
                ],
                [
                    'file.image' => 'The file must be an image (jpeg, png, bmp, gif, or svg)'
                ]);
            if ($validator->fails())
                return array(
                    'fail' => true,
                    'errors' => $validator->errors()
                );
            $extension = $request->file('file')->getClientOriginalExtension();
            $dir = 'uploads/';
            $filename = uniqid() . '_' . time() . '.' . $extension;
            $request->file('file')->move($dir, $filename);
            return $filename;
        }
    }
    
    public function get_broker_accounts(Request $request)
    {
        $selected_broker_id = $request->has('broker_id') ? $request->broker_id : '';

        $assigned_brokers_id = collect(auth()->user()->assigned_brokers)->pluck('id')->toArray();

        if ($selected_broker_id != '')
        {
            $assigned_brokers_id = [$selected_broker_id];
        }

        $accounts = \App\Models\Account::select('id', 'account_number')
                ->whereIn('broker_id', $assigned_brokers_id)
                ->orderBy('account_number')
                ->get();

        $html_rendered = '<option value="">' . __('sistema.all') . '</option>';

        if ($accounts)
        {
            foreach ($accounts as $account)
            {
                $primary_account = $account->primary_client;
                $html_rendered   .= '<option value="' . $account->id . '">' . $account->account_number . ($account->primary_client ? ' - ' . $account->primary_client->full_name : '') . '</option>';
            }
        }

        return response()->json(['flag' => 1, 'html' => $html_rendered], 200);
    }
}
