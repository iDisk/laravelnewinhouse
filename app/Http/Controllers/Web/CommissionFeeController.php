<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CommissionFee;
use Yajra\DataTables\Facades\DataTables;
use App\Support\Util;
use Validator;

class CommissionFeeController extends Controller
{
    /*
    * Constructor de la clase que instancia el middleware auth
    */
    public function __construct()
    {
        $this->middleware('seguridad')->only('index');
    }

    //Funcion para DataTable
    public function datacommission_fees()
    {
        $commission_fees = CommissionFee::select('commission_fees.*');

        return DataTables::of($commission_fees)
        ->addColumn('action', function ($commission_fees) {
            $botones = '<a href="'.url('commission_fees/'.$commission_fees->id.'/edit').'" class="btn btn-xs btn-info waves-effect waves-light pull-left m-r-5"><i class="fa fa-edit"></i> '.__('sistema.btn_edit').'</a> ';

            $botones .= '<form action="'.url('commission_fees/' . $commission_fees->id).'" id="borra_Frm'.$commission_fees->id.'" method="POST" class="pull-left">'.csrf_field()  .' '.method_field('DELETE') .'<button type="button" onclick="confirmaDel('.$commission_fees->id.',\''.$commission_fees->commission_fee.'\');" class="btn btn-xs btn-danger"><span class="fa fa-trash"></span> </button></form>&nbsp;';
            return $botones;
        })
        ->editColumn('created_at', function ($commission_fees) {
            return $commission_fees->created_at->format('d/m/Y H:i');
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
        return view('catalogos.commission_fees.index')->with('elmenu',['elmenu'=>$lstMenus]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lstMenus = Util::generateMenu(auth()->user()->perfil_id);
        return view('catalogos.commission_fees.new')
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
            'commission_fee' => 'required|numeric|between:0,1.9999',
        );
        $messages = array(
            'commission_fee.required' =>  __('sistema.commission_fee.req_commission_fee'),
            'commission_fee.numeric' => __('sistema.commission_fee.req_num_commission_fee'),
            'commission_fee.between' => __('sistema.commission_fee.req_bet_commission_fee'),
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails())
        {
            return redirect('commission_fees/create')->withInput()->withErrors($validator);
            
        }else{
            // Save commission fee
            $item = new CommissionFee;
            $item->fill($campos);
            $item->save();

            return redirect('commission_fees')->with('msg',__('sistema.save_success_msg'))->with('type','success');
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
        $commission_fee = CommissionFee::find($id);

        return view('catalogos.commission_fees.edit')
            ->with('elmenu',['elmenu'=>$lstMenus])
            ->with('commission_fee',$commission_fee);
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
            'commission_fee' => 'required|numeric|between:0,1.9999',
        );
        $messages = array(
            'commission_fee.required' =>  __('sistema.commission_fee.req_commission_fee'),
            'commission_fee.numeric' => __('sistema.commission_fee.req_num_commission_fee'),
            'commission_fee.between' => __('sistema.commission_fee.req_bet_commission_fee'),
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails())
        {
            return redirect('commission_fees/'.$id.'/edit')->withInput()->withErrors($validator);
            
        }else{

            $item = CommissionFee::find($id);
            $item->fill($campos);
            $item->save();
            return redirect('commission_fees')->with('msg',__('sistema.update_success_msg'))->with('type','success');
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
        CommissionFee::find($id)->delete();
        return redirect('commission_fees')->with('msg',__('sistema.remove_success_msg'))->with('type','success');
    }
}
