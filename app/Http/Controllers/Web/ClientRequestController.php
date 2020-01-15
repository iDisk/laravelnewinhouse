<?php

namespace App\Http\Controllers\Web;

use DB;
use Mail;
use App\Support\Util;
use Illuminate\Http\Request;
use App\Models\ClientRequest;
use App\Models\RequestStatus;
use App\Models\User;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class ClientRequestController extends Controller
{
    /*
     * Constructor de la clase que instancia el middleware auth
     */

    public function __construct()
    {
        $this->middleware('seguridad')->only('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $request_status = RequestStatus::select('id', DB::raw('(status_' . session('language') . ') as estatus'))->get();

        $lstMenus = Util::generateMenu(auth()->user()->perfil_id);
        return view('catalogos.client_requests.index')
                        ->with('elmenu', ['elmenu' => $lstMenus])
                        ->with('request_status', $request_status);
    }

    public function data_client_request(Request $request)
    {
        $estatus_id = $request->has('estatus_id') ? $request->estatus_id : '';
        $broker_id = $request->has('broker_id') ? $request->broker_id : '';
        $assigned_brokers_id = collect(auth()->user()->assigned_brokers)->pluck('id')->toArray();
        
        $client_request = ClientRequest::select(['client_requests.id', 'client_requests.file_number', 'client_requests.user_id',
                    'client_requests.request_status_id', 'client_requests.request_type_id', 'client_requests.category_id', 'client_requests.from',
                    'client_requests.created_at', DB::raw('users.name as user_name'), DB::raw('accounts.account_number as account_number'),
                    'request_status.status_en', 'request_status.status_es', 'request_status.color_code'])
                ->leftJoin('users', 'users.id', '=', 'client_requests.user_id')
                ->leftJoin('accounts', 'accounts.id', '=', 'client_requests.account_id')
                ->leftJoin('request_status', 'request_status.id', '=', 'client_requests.request_status_id')
                ->where('client_requests.status',1);

        if ($estatus_id != '')
        {
            $client_request->where('client_requests.request_status_id', $estatus_id);
        }
        
        if($broker_id == '')
        {
            $client_request->whereIn('accounts.broker_id', $assigned_brokers_id);
        }
        else
        {
            if(in_array($broker_id, $assigned_brokers_id))
            {
                $client_request->where('accounts.broker_id', $broker_id);
            }
            else 
           {
                $client_request->where('accounts.broker_id', null);
            }
        }
        
        return DataTables::of($client_request)
                        ->addColumn('action', function ($client_request)
                        {
                            return '<a href="' . url('tramites/' . $client_request->id) . '" class="btn btn-xs btn-info waves-effect waves-light"><i class="fa fa-pencil"></i> ' . __('sistema.btn_view') . '</a> ';
                        })
                        ->editColumn('request_type_id', function($client_request)
                        {
                            return config('site.client_request_type.' . $client_request->request_type_id . '.' . session('language'));
                        })
                        ->editColumn('category_id', function($client_request)
                        {
                            return config('site.contact_us_category.' . $client_request->category_id . '.' . session('language'));
                        })
                        ->editColumn('estatus', function($client_request)
                        {
                            $estatus = session('language') == 'en' ? $client_request->status_en : $client_request->status_es;
                            return '<div style="height: 5px;width: 5px;background: ' . $client_request->color_code . ';padding: 5px;display: inline-block;"></div>&nbsp;' . '<span>' . $estatus . '</span>';
                        })
                        ->editColumn('created_at', function ($client_request)
                        {
                            return $client_request->created_at ? $client_request->created_at->format('d/m/Y H:i') : '-';
                        })
                        ->filterColumn('account_number', function($query, $keyword)
                        {
                            $query->where('accounts.account_number', 'like', '%' . $keyword . '%');
                        })
                        ->filterColumn('user_name', function($query, $keyword)
                        {
                            $query->where('users.name', 'like', '%' . $keyword . '%');
                        })
                        ->filterColumn('estatus', function($query, $keyword)
                        {
                            
                        })
                        ->rawColumns(['estatus', 'action'])
                        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ClientRequest  $clientRequest
     * @return \Illuminate\Http\Response
     */
    public function show($client_request_id)
    {
        try
        {
            $client_request = ClientRequest::find($client_request_id);

            if (!$client_request)
            {
                abort(404);
            }

            $client_request->fields_arr = json_decode($client_request->text);
            // dd($client_request->request_type_id);

            $lstMenus = Util::generateMenu(auth()->user()->perfil_id);
            return view('catalogos.client_requests.view')
                            ->with('elmenu', ['elmenu' => $lstMenus])
                            ->with('client_request', $client_request);
        }
        catch (\Exception $ex)
        {
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ClientRequest  $clientRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(ClientRequest $clientRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ClientRequest  $clientRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $client_request_id)
    {
        try
        {
            $campos = $request->only('response', 'comment_chk', 'comments');

            $client_request = ClientRequest::find($client_request_id);

            if (!$client_request)
            {
                return response()->json(['flag' => 0, 'message' => __('sistema.client_request.no_data_found')], 200);
            }

            if ($campos['response'] != '' && in_array($campos['response'], ['2', '3']))
            {
                $send_comments = isset($campos['comment_chk']) ? $campos['comment_chk'] : 0;
                $comments      = isset($campos['comments']) ? $campos['comments'] : '';

                if ($send_comments == 1 && $comments == '')
                {
                    return response()->json(['flag' => 0, 'message' => __('sistema.client_request.comments_required')], 200);
                }

                $client_request->request_status_id = $campos['response'];
                $client_request->comments          = $comments;
                $client_request->save();
                $status                            = $campos['response'] == 2 ? __('sistema.client_request.past_approved') : __('sistema.client_request.past_declined');

                if ($send_comments == 1 && $comments != '')
                {
                    $client = $client_request->user;

                    if ($client && $client->email)
                    {
                        //Send Email
                        /*
                          $view = \View::make('emails.client_response', ['user_name' => $client_request->name, 'comment' => $campos['comments']]);
                          Mail::send('emails.client_response', ['user_name' => $client_request->name, 'comment' => $campos['comments']], function ($m) use($client)
                          {
                          $m->from('info@atrix.com', 'Admin atrix');
                          $m->to($client->email, $client->name);
                          $m->subject(__('sistema.client_request.response_email_subject'));
                          });
                         * 
                         */
                    }
                    else
                    {
                        //Send Notification
                    }
                }
                \App\Util\HelperUtil::event_notification($client_request);
                return response()->json(['flag' => 1, 'message' => __('sistema.client_request.success_request', ['estatus' => $status])], 200);
            }
            else
            {
                return response()->json(['flag' => 0, 'message' => __('sistema.client_request.invalid_request')], 200);
            }
        }
        catch (\Exception $ex)
        {
            // dd($ex->getMessage());
            return response()->json(['flag' => 0, 'message' => $ex->getMessage()], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ClientRequest  $clientRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClientRequest $clientRequest)
    {
        //
    }

    public static function checkFileURL($fileURL)
    {
        if ((substr($fileURL, 0, 7) == "http://") || (substr($fileURL, 0, 8) == "https://")){
            $extension = pathinfo($fileURL, PATHINFO_EXTENSION);
            if($extension != '' && $extension != null){
                $extension = strtolower($extension);
                if($extension == 'png' || $extension == 'jpg' || $extension == 'jpeg' || $extension == 'gif'){
                    return true;
                }
                else{
                    return false;
                }
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }

}
