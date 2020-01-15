<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Broker;
use App\Models\ClientFile;
use App\Models\User;
use App\Models\NationalIdentityDoc;
use App\Models\FinancialService;
use Yajra\DataTables\Facades\DataTables;
use App\Support\Util;
use App\Util\HelperUtil;
use Validator;
use Storage;
use File;
use Image;
use Carbon\Carbon;

class AccountformController extends Controller
{
    /*
     * Constructor de la clase que instancia el middleware auth
     */

    public function __construct()
    {
        $this->middleware('seguridad')->only('index');
    }

    public function forms($account_type)
    {

        try
        {
            if ($account_type == 'individual')
            {

                $countries              = Country::orderBy('name')->get();
                $current_lang           = HelperUtil::get_currentlang();
                $ventas                 = User::where('perfil_id', 3)->where('status', 1)->orderBy('name')->get();
                $gerente                = User::where('perfil_id', 4)->where('status', 1)->orderBy('name')->get();
                $analista               = User::where('perfil_id', 5)->where('status', 1)->orderBy('name')->get();
                $atencion_a_cliente     = User::where('perfil_id', 6)->where('status', 1)->orderBy('name')->get();
                $national_identity_docs = NationalIdentityDoc::orderBy('national_identity_' . $current_lang)->pluck('national_identity_' . $current_lang, 'id')->toArray();
                $branches               = \App\Models\Branch::orderBy('branch_' . $current_lang)->pluck('branch_' . $current_lang, 'id')->toArray();
                $view                   = \View::make('catalogos.account_forms.individual_account', compact('national_identity_docs', 'ventas', 'gerente', 'analista', 'atencion_a_cliente', 'countries', 'branches'));
                $view_html              = $view->render();
            }
            elseif ($account_type == 'joint')
            {

                $countries              = Country::orderBy('name')->get();
                $current_lang           = HelperUtil::get_currentlang();
                $ventas                 = User::where('perfil_id', 3)->where('status', 1)->orderBy('name')->get();
                $gerente                = User::where('perfil_id', 4)->where('status', 1)->orderBy('name')->get();
                $analista               = User::where('perfil_id', 5)->where('status', 1)->orderBy('name')->get();
                $atencion_a_cliente     = User::where('perfil_id', 6)->where('status', 1)->orderBy('name')->get();
                $national_identity_docs = NationalIdentityDoc::orderBy('national_identity_' . $current_lang)->pluck('national_identity_' . $current_lang, 'id')->toArray();
                $branches               = \App\Models\Branch::orderBy('branch_' . $current_lang)->pluck('branch_' . $current_lang, 'id')->toArray();
                $view      = \View::make('catalogos.account_forms.joint_account', compact('national_identity_docs', 'ventas', 'gerente', 'analista', 'atencion_a_cliente', 'countries', 'branches'));
                $view_html = $view->render();
            }
            elseif ($account_type == 'business')
            {

                $countries              = Country::orderBy('name')->get();
                $current_lang           = HelperUtil::get_currentlang();
                $ventas                 = User::where('perfil_id', 3)->where('status', 1)->orderBy('name')->get();
                $gerente                = User::where('perfil_id', 4)->where('status', 1)->orderBy('name')->get();
                $analista               = User::where('perfil_id', 5)->where('status', 1)->orderBy('name')->get();
                $atencion_a_cliente     = User::where('perfil_id', 6)->where('status', 1)->orderBy('name')->get();
                $national_identity_docs = NationalIdentityDoc::orderBy('national_identity_' . $current_lang)->pluck('national_identity_' . $current_lang, 'id')->toArray();
                $branches               = \App\Models\Branch::orderBy('branch_' . $current_lang)->pluck('branch_' . $current_lang, 'id')->toArray();
                $view      = \View::make('catalogos.account_forms.buisness_account', compact('national_identity_docs', 'ventas', 'gerente', 'analista', 'atencion_a_cliente', 'countries', 'branches'));
                $view_html = $view->render();
            }
            else
            {
                $view_html = '';
            }
            $result['flag']         = 1;
            $result['data']         = $view_html;
            $result['account_type'] = $account_type;
            return response()->json($result);
        }
        catch (\Exception $ex)
        {
            $result['flag']         = 0;
            $result['data']         = '';
            $result['account_type'] = $account_type;
            $result['array']        = $ex->getMessage();
            return response()->json($result);
        }
    }

}
