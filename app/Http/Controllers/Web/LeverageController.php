<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Leverage;
use Yajra\DataTables\Facades\DataTables;
use App\Support\Util;
use Validator;

class LeverageController extends Controller
{
    /*
    * Constructor de la clase que instancia el middleware auth
    */
    public function __construct()
    {
        $this->middleware('seguridad')->only('index');
    }

    //Funcion para DataTable
    public function dataleverages()
    {
        $leverages = Leverage::select('leverages.*');

        return DataTables::of($leverages)
        ->addColumn('action', function ($leverages) {
            $botones = '<a href="'.url('leverages/'.$leverages->id.'/edit').'" class="btn btn-xs btn-info waves-effect waves-light pull-left m-r-5"><i class="fa fa-edit"></i> '.__('sistema.btn_edit').'</a>';

            $botones .= '<form action="'.url('leverages/' . $leverages->id).'" id="borra_Frm'.$leverages->id.'" method="POST" class="pull-left">'.csrf_field()  .' '.method_field('DELETE') .'<button type="button" onclick="confirmaDel('.$leverages->id.',\''.$leverages->label.'\');" class="btn btn-xs btn-danger"><span class="fa fa-trash"></span> </button></form>';
            return $botones;
        })
        ->editColumn('created_at', function ($leverages) {
            return $leverages->created_at->format('d/m/Y H:i');
        })
        ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lstMenus = Util::generateMenu(auth()->user()->perfil_id);
        return view('catalogos.leverages.index')->with('elmenu',['elmenu'=>$lstMenus]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lstMenus = Util::generateMenu(auth()->user()->perfil_id);

        return view('catalogos.leverages.new')
                ->with('elmenu',['elmenu'=>$lstMenus]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $campos = $request->all();

        $rules = array(
            'label' => 'required',
            'calc_value' => 'required|numeric|between:0,1.9999',
        );
        $messages = array(
            'label.required' =>  __('sistema.leverage.req_label'),
            'calc_value.required' =>  __('sistema.leverage.req_calc_value'),
            'calc_value.numeric' => __('sistema.leverage.req_num_calc_value'),
            'calc_value.between' => __('sistema.leverage.req_bet_calc_value'),
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails())
        {
            return redirect('leverages/create')->withInput()->withErrors($validator);
            
        }else{
            // Save leverage
            $leverage = new Leverage;
            $leverage->fill($campos);
            $leverage->save();

            return redirect('leverages')->with('msg',__('sistema.save_success_msg'))->with('type','success');
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
        $lstMenus = Util::generateMenu(auth()->user()->perfil_id);
        $leverage = Leverage::find($id);

        return view('catalogos.leverages.edit')
            ->with('elmenu',['elmenu'=>$lstMenus])
            ->with('leverage',$leverage);
                
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
        $campos = $request->all();

        $rules = array(
            'label' => 'required',
            'calc_value' => 'required|numeric|between:0,1.9999',
        );
        $messages = array(
            'label.required' =>  __('sistema.leverage.req_label'),
            'calc_value.required' =>  __('sistema.leverage.req_calc_value'),
            'calc_value.numeric' => __('sistema.leverage.req_num_calc_value'),
            'calc_value.between' => __('sistema.leverage.req_bet_calc_value'),
        );

        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails())
        {
            return redirect('leverages/'.$id.'/edit')->withInput()->withErrors($validator);
            
        }else{
            $leverage = Leverage::find($id);
            $leverage->fill($campos);
            $leverage->save();
        }

        return redirect('leverages')->with('msg',__('sistema.update_success_msg'))->with('type','success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Leverage::find($id)->delete();
        return redirect('leverages')->with('msg',__('sistema.remove_success_msg'))->with('type','success');
    }

    public function ajax_getleverages($id){
        $leverage = Leverage::find($id);
        return ['status'=>1,'data'=>$leverage->calc_value];
    }
}
