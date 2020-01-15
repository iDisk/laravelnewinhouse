<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Item;
use Yajra\DataTables\Facades\DataTables;
use App\Support\Util;
use App\Util\HelperUtil;
use Validator;

class ItemController extends Controller
{
    /*
    * Constructor de la clase que instancia el middleware auth
    */
    public function __construct()
    {        
        $this->middleware('seguridad')->only('index');
    }

    //Funcion para DataTable
    public function dataitems()
    {
        $items = Item::select('items.*');

        return DataTables::of($items)
        ->addColumn('action', function ($items) {
            $botones = '<a href="'.url('items/'.$items->id.'/edit').'" class="btn btn-xs btn-info waves-effect waves-light pull-left m-r-5"><i class="fa fa-edit"></i> '.__('sistema.btn_edit').'</a> ';

            $botones .= '<form action="'.url('items/' . $items->id).'" id="borra_Frm'.$items->id.'" method="POST" class="pull-left">'.csrf_field()  .' '.method_field('DELETE') .'<button type="button" onclick="confirmaDel('.$items->id.',\''.$items->item_en.'\');" class="btn btn-xs btn-danger"><span class="fa fa-trash"></span> </button></form>&nbsp;';
            return $botones;
        })
        ->editColumn('created_at', function ($items) {
            return $items->created_at->format('d/m/Y H:i');
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
        return view('catalogos.items.index')->with('elmenu',['elmenu'=>$lstMenus]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lstMenus = Util::generateMenu(auth()->user()->perfil_id);
        return view('catalogos.items.new')
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
            'item_en' => 'required',
            'item_es' => 'required',
        );
        $messages = array(
            'item_en.required' =>  __('sistema.item.req_item_en'),
            'item_es.required' =>  __('sistema.item.req_item_es'),
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails())
        {
            return redirect('items/create')->withInput()->withErrors($validator);
            
        }else{
            // Save item
            $item = new Item;
            $item->fill($campos);
            $item->save();

            return redirect('items')->with('msg',__('sistema.save_success_msg'))->with('type','success');
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
        $item = Item::find($id);

        return view('catalogos.items.edit')
            ->with('elmenu',['elmenu'=>$lstMenus])
            ->with('item',$item);
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
            'item_en' => 'required',
            'item_es' => 'required',
        );
        $messages = array(
            'item_en.required' =>  __('sistema.item.req_item_en'),
            'item_es.required' =>  __('sistema.item.req_item_es'),
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails())
        {
            return redirect('items/'.$id.'/edit')->withInput()->withErrors($validator);
            
        }else{

            $item = Item::find($id);
            $item->fill($campos);
            $item->save();
            return redirect('items')->with('msg',__('sistema.update_success_msg'))->with('type','success');
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
        Item::find($id)->delete();
        return redirect('items')->with('msg',__('sistema.remove_success_msg'))->with('type','success');
    }
}
