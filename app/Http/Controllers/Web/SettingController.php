<?php

namespace App\Http\Controllers\Web;

use Storage;
use App\Support\Util;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
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
        $settings = Setting::first();
        return view('catalogos.configuration.index')->with('elmenu', ['elmenu' => $lstMenus])->with('settings', $settings);
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
        try
        {
            $input   = $request->all();
            $setting = Setting::first();
            $setting->fill($input);
            //Upload National Identity
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
                return redirect()->back()->with('msg', __('sistema.save_success_msg'))->with('type', 'success');
            }
            else
            {
                return redirect()->back()->withInput()->with('msg', __('sistema.save_fail_msg'))->with('type', 'error');
            }
        }
        catch (Exception $ex)
        {
            return redirect()->back()->withInput()->with('msg', $ex->getMessage())->with('type', 'error');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //
    }

}
