<?php

namespace App\Http\Controllers\Web;

use DB;
use Validator;
use App\Support\Util;
use Illuminate\Http\Request;
use App\Models\RequestStatus;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class EstatusController extends Controller
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
        $lstMenus = Util::generateMenu(auth()->user()->perfil_id);
        return view('catalogos.estatus.index')->with('elmenu', ['elmenu' => $lstMenus]);
    }

    public function data_estatus()
    {
        $estatus = RequestStatus::select('id', 'status_en', 'status_es', 'color_code', 'active', 'created_at');

        $lang = session('language');

        return DataTables::of($estatus)
                        ->addColumn('action', function ($estatus)
                        {
                            $botones = '<a href="' . url('estatus/' . $estatus->id . '/edit') . '" class="btn btn-xs btn-info waves-effect waves-light pull-left m-r-5"><i class="fa fa-edit"></i> ' . __('sistema.btn_edit') . '</a> ';
                            if(!in_array($estatus->id, [1,2,3]))
                            {
                                $botones .= '<form action="' . url('estatus/' . $estatus->id) . '" id="borra_Frm' . $estatus->id . '" method="POST" class="pull-left">' . csrf_field() . ' ' . method_field('DELETE') . '<button type="button" onclick="confirmaDel(' . $estatus->id . ',\'' . $estatus->status_en . '\');" class="btn btn-xs btn-danger"><span class="fa fa-trash"></span> </button></form>&nbsp;';
                            }
                            return $botones;
                        })
                        ->editColumn('color_code', function($estatus)
                        {
                            return '<div style="border: 1px solid black; height: 5px;width: 5px;background: ' . $estatus->color_code . ';padding: 5px;display: inline-block;"></div>&nbsp;';
                        })
                        ->editColumn('active', function($estatus)
                        {
                            if ($estatus->active)
                            {
                                return '<span>' . __('sistema.active') . '</span>';
                            }
                            return '<span>' . __('sistema.active') . '</span>';
                        })
                        ->editColumn('created_at', function ($items)
                        {
                            return $items->created_at ? $items->created_at->format('d/m/Y H:i') : 'N/A';
                        })
                        ->rawColumns(['active', 'color_code', 'action'])
                        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lstMenus = Util::generateMenu(auth()->user()->perfil_id);
        return view('catalogos.estatus.new')->with('elmenu', ['elmenu' => $lstMenus]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try
        {
            $campos = $request->all();

            $rules = RequestStatus::rules();

            $messages = RequestStatus::messages();

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails())
            {
                return redirect()->back()->withInput()->withErrors($validator);
            }
            else
            {
                DB::beginTransaction();

                $estatus = new RequestStatus;

                $estatus->status_en  = $campos['status_en'];
                $estatus->status_es  = $campos['status_es'];
                $estatus->color_code = $campos['color_code'];
                $estatus->active     = $campos['active'];

                if ($estatus->save())
                {
                    DB::commit();
                    return redirect('estatus')->with('msg', __('sistema.save_success_msg'))->with('type', 'success');
                }
                else
                {
                    DB::rollBack();
                    return redirect()->back()->withInput()->with('error', __('sistema.save_fail_msg'))->with('type', 'error');
                }
            }
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $ex->getMessage())->with('type', 'error');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try
        {
            $estatus = RequestStatus::find($id);

            if (!$estatus)
            {
                abort(404);
            }

            $lstMenus = Util::generateMenu(auth()->user()->perfil_id);
            return view('catalogos.estatus.edit')->with('elmenu', ['elmenu' => $lstMenus])
                            ->with('estatus', $estatus);
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $ex->getMessage())->with('type', 'error');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try
        {
            $estatus = RequestStatus::find($id);

            if (!$estatus)
            {
                abort(404);
            }

            $campos = $request->all();

            $rules = RequestStatus::rules($id);

            $messages = RequestStatus::messages();

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails())
            {
                return redirect()->back()->withInput()->withErrors($validator);
            }
            else
            {
                DB::beginTransaction();

                $estatus->status_en  = $campos['status_en'];
                $estatus->status_es  = $campos['status_es'];
                $estatus->color_code = $campos['color_code'];
                $estatus->active     = $campos['active'];

                if ($estatus->save())
                {
                    DB::commit();
                    return redirect('estatus')->with('msg', __('sistema.update_success_msg'))->with('type', 'success');
                }
                else
                {
                    DB::rollBack();
                    return redirect()->back()->withInput()->with('error', __('sistema.update_fail_msg'))->with('type', 'error');
                }
            }
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $ex->getMessage())->with('type', 'error');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
        {
            $estatus = RequestStatus::find($id);

            if (!$estatus)
            {
                abort(404);
            }

            if(!in_array($estatus->id, [1,2,3]))
            {
                $association = \App\Models\ClientRequest::where('request_status_id', $id)->first();

                if ($association)
                {
                    return redirect('estatus')->with('msg', __('sistema.remove_fail_msg_associated'))->with('type', 'error');
                }

                DB::beginTransaction();
                if ($estatus->delete())
                {
                    DB::commit();
                    return redirect('estatus')->with('msg', __('sistema.remove_success_msg'))->with('type', 'success');
                }
                else
                {
                    DB::rollBack();
                    return redirect()->back()->withInput()->with('error', __('sistema.remove_fail_msg'))->with('type', 'error');
                }
            }
            else
            {
                return redirect('estatus');
            }            
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $ex->getMessage())->with('type', 'error');
        }
    }

}
