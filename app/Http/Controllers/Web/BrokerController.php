<?php

namespace App\Http\Controllers\Web;

use DB;
use Storage;
use Validator;
use App\Support\Util;
use App\Models\Broker;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class BrokerController extends Controller
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
        return view('catalogos.broker.index')
                        ->with('elmenu', ['elmenu' => $lstMenus]);
    }

    public function databrands()
    {
        $brands = Broker::select(['id', 'broker', 'description', 'broker_url', 'color', 'code', 'active']);

        return DataTables::of($brands)
                        ->addColumn('action', function ($brands)
                        {
                            $botones = '<a href="' . url('brands/' . $brands->id . '/edit') . '" class="btn btn-xs btn-info waves-effect waves-light"><i class="fa fa-edit"></i> ' . __('sistema.btn_edit') . '</a> ';

                            $botones .= '<form action="' . url('brands/' . $brands->id) . '" id="borra_Frm' . $brands->id . '" method="POST" class="deleteFrm">' . csrf_field() . ' ' . method_field('DELETE') . '<button type="button" onclick="confirmaDel(' . $brands->id . ',\'' . $brands->broker . '\');" class="btn btn-xs btn-danger"><span class="fa fa-trash"></span> </button></form>&nbsp;';

                            //$botones .= '<a class="btn btn-xs waves-effect waves-light bgBlue">Notificationes</a>&nbsp;';
                            //$botones .= '<a class="btn btn-xs waves-effect waves-light bgLightGreen">Cargos</a>&nbsp;';
                            $botones .= '<a class="btn btn-xs waves-effect waves-light bgPink" href="' . url('brands/' . $brands->id . '/promotion') . '">Promociones</a>&nbsp;';
                            //$botones .= '<a class="btn btn-xs waves-effect waves-light bgPurple">Documentos</a>&nbsp;';

                            return $botones;
                        })
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
        return view('catalogos.broker.new')->with('elmenu', ['elmenu' => $lstMenus]);
    }

    public static function generate_unique_url($string_name, $rand_no = 200)
    {
        while (true)
        {
            $username_parts = array_filter(explode(" ", strtolower($string_name)));
            $username_parts = array_slice($username_parts, 0, 2);

            $part1 = (!empty($username_parts[0])) ? substr($username_parts[0], 0, 8) : "";
            $part2 = (!empty($username_parts[1])) ? substr($username_parts[1], 0, 5) : "";
            $part3 = ($rand_no) ? rand(0, $rand_no) : "";

            $broker_url = $part1 . str_shuffle($part2) . $part3;

            $url_exist_in_db = Broker::select('id')->where('broker_url', $broker_url)->first();
            if (!$url_exist_in_db)
            {
                return $broker_url;
            }
        }
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

            $rules = Broker::rules();

            $messages = Broker::messages();

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails())
            {
                return redirect()->back()->withInput()->withErrors($validator);
            }
            else
            {
                DB::beginTransaction();
                $brand              = new Broker;
                $brand->broker      = $campos['broker'];
                $brand->color       = $campos['color'];
                $brand->code        = $campos['code'];
                $brand->description = $campos['description'];
                $brand->broker_url  = $campos['broker_url'];

                if ($brand->save())
                {
                    $setting = Setting::where('broker_id', $brand->id)->first();
                    if (!$setting)
                    {
                        $setting            = new Setting;
                        $setting->broker_id = $brand->id;
                    }

                    $campos['transfer_commission_amount'] = str_replace(',', '', $campos['transfer_commission_amount']);
                    $campos['processing_fees_amount']     = str_replace(',', '', $campos['processing_fees_amount']);

                    $setting->fill($campos);

                    if ($request->hasFile('company_statement_logo'))
                    {
                        $rutaS3                          = '/assets/images/';
                        Storage::disk()->makeDirectory($rutaS3);
                        $filename                        = 'site_logo_' . time() . '.' . $request->company_statement_logo->getClientOriginalExtension();
                        $request->company_statement_logo->move(public_path($rutaS3), $filename);
                        $setting->company_statement_logo = $rutaS3 . $filename;
                    }

                    if ($setting->save())
                    {
                        DB::commit();
                        return redirect('brands')->with('msg', __('sistema.save_success_msg'))->with('type', 'success');
                    }
                    else
                    {
                        DB::rollBack();
                        return redirect()->back()->withInput()->with('error', __('sistema.save_fail_msg'))->with('type', 'error');
                    }
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brand = Broker::where('id', $id)->with('setting')->first();

        if (!$brand)
        {
            abort(404);
        }

        $lstMenus = Util::generateMenu(auth()->user()->perfil_id);

        return view('catalogos.broker.edit')
                        ->with('elmenu', ['elmenu' => $lstMenus])
                        ->with('brand', $brand);
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
            $campos = $request->all();

            $rules = Broker::rules($id);

            $messages = Broker::messages();

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails())
            {
                return redirect()->back()->withInput()->withErrors($validator);
            }
            else
            {
                DB::beginTransaction();
                $brand = Broker::find($id);
                if (!$brand)
                {
                    $brand = new Broker;
                }
                $brand->broker      = $campos['broker'];
                $brand->color       = $campos['color'];
                $brand->code        = $campos['code'];
                $brand->description = $campos['description'];
                $brand->broker_url  = $campos['broker_url'];
                if ($brand->save())
                {
                    $setting = Setting::where('broker_id', $brand->id)->first();
                    if (!$setting)
                    {
                        $setting            = new Setting;
                        $setting->broker_id = $brand->id;
                    }                    
                    $campos['transfer_commission_amount'] = str_replace(',', '', $campos['transfer_commission_amount']);
                    $campos['processing_fees_amount']     = str_replace(',', '', $campos['processing_fees_amount']);
                    
                    $setting->fill($campos);

                    if ($request->hasFile('company_statement_logo'))
                    {
                        $rutaS3                          = '/assets/images/';
                        Storage::disk()->makeDirectory($rutaS3);
                        $filename                        = 'site_logo_' . time() . '.' . $request->company_statement_logo->getClientOriginalExtension();
                        $request->company_statement_logo->move(public_path($rutaS3), $filename);
                        $setting->company_statement_logo = $rutaS3 . $filename;
                    }

                    if ($setting->save())
                    {
                        DB::commit();
                        return redirect('brands')->with('msg', __('sistema.update_success_msg'))->with('type', 'success');
                    }
                    else
                    {
                        DB::rollBack();
                        return redirect()->back()->withInput()->with('error', __('sistema.update_fail_msg'))->with('type', 'error');
                    }
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
            $brand = Broker::find($id);
            if (!$brand)
            {
                abort(404);
            }

            $association = \App\Models\Account::where('broker_id', $brand->id)->first();
            if ($association)
            {
                return redirect()->back()->withInput()->with('msg', __('sistema.broker.association_delete'))->with('type', 'error');
            }
            DB::beginTransaction();
            $setting = Setting::where('broker_id', $brand->id)->first();
            if ($setting)
            {
                if ($setting->delete())
                {
                    if ($brand->delete())
                    {
                        DB::commit();
                        return redirect('brands')->with('msg', __('sistema.remove_success_msg'))->with('type', 'success');
                    }
                    else
                    {
                        DB::rollBack();
                        return redirect()->back()->withInput()->with('msg', __('sistema.remove_fail_msg'))->with('type', 'error');
                    }
                }
                else
                {
                    DB::rollBack();
                    return redirect()->back()->withInput()->with('msg', __('sistema.remove_fail_msg'))->with('type', 'error');
                }
            }
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $ex->getMessage())->with('type', 'error');
        }
    }

}
