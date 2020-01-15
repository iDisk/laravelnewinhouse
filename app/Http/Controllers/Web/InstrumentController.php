<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Instrument;
use Yajra\DataTables\Facades\DataTables;
use App\Support\Util;
use Validator;

class InstrumentController extends Controller
{
    /*
    * Constructor de la clase que instancia el middleware auth
    */
    public function __construct()
    {
        $this->middleware('seguridad')->only('index');
    }

    //Funcion para DataTable
    public function datainstruments()
    {
        $instruments = Instrument::select('instruments.*');

        return DataTables::of($instruments)
        ->addColumn('action', function ($instruments) {
            $botones = '<a href="'.url('instruments/'.$instruments->id.'/edit').'" class="btn btn-xs btn-info waves-effect waves-light pull-left m-r-5"><i class="fa fa-edit"></i> '.__('sistema.btn_edit').'</a> ';

            $botones .= '<form action="'.url('instruments/' . $instruments->id).'" id="borra_Frm'.$instruments->id.'" method="POST" class="pull-left">'.csrf_field()  .' '.method_field('DELETE') .'<button type="button" onclick="confirmaDel('.$instruments->id.',\''.$instruments->instrument_en.'\');" class="btn btn-xs btn-danger"><span class="fa fa-trash"></span> </button></form>&nbsp;';
            return $botones;
        })
        ->editColumn('created_at', function ($instruments) {
            return $instruments->created_at->format('d/m/Y H:i');
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
        return view('catalogos.instruments.index')->with('elmenu',['elmenu'=>$lstMenus]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lstMenus = Util::generateMenu(auth()->user()->perfil_id);

        return view('catalogos.instruments.new')
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
            'instrument_en' => 'required',
            'instrument_es' => 'required',
        );
        $messages = array(
            'instrument_en.required' =>  __('sistema.instrument.req_instrument_en'),
            'instrument_es.required' =>  __('sistema.instrument.req_instrument_es'),
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails())
        {
            return redirect('instruments/create')->withInput()->withErrors($validator);
            
        }else{
            // Save instrument
            $instrument = new Instrument;
            $instrument->fill($campos);
            $instrument->save();

            return redirect('instruments')->with('msg',__('sistema.save_success_msg'))->with('type','success');
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
        $instrument = Instrument::find($id);

        return view('catalogos.instruments.edit')
            ->with('elmenu',['elmenu'=>$lstMenus])
            ->with('instrument',$instrument);
                
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
            'instrument_en' => 'required',
            'instrument_es' => 'required',
        );
        $messages = array(
            'instrument_en.required' =>  __('sistema.instrument.req_instrument_en'),
            'instrument_es.required' =>  __('sistema.instrument.req_instrument_es'),
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails())
        {
            return redirect('instruments/'.$id.'/edit')->withInput()->withErrors($validator);
            
        }else{

            $instrument = Instrument::find($id);
            $instrument->fill($campos);
            $instrument->save();

            return redirect('instruments')->with('msg',__('sistema.update_success_msg'))->with('type','success');
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
        Instrument::find($id)->delete();
        return redirect('instruments')->with('msg',__('sistema.remove_success_msg'))->with('type','success');
    }
}
