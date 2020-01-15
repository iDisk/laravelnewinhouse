<?php

namespace App\Http\Controllers\Web;

use DB;
use App\Models\MovimientosTipoCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MovimientosTipo;
use Yajra\DataTables\Facades\DataTables;
use App\Support\Util;
use App\Util\HelperUtil;
use Validator;

class MovimientosTipoController extends Controller
{
    /*
     * Constructor de la clase que instancia el middleware auth
     */

    public function __construct()
    {
        $this->middleware('seguridad')->only('index');
    }

    //Funcion para DataTable
    public function datamovimientos_tipos()
    {
        $current_lang = HelperUtil::get_currentlang();
        
        $movimientos_tipos = MovimientosTipo::select(['movimientos_tipos.id', 'movimientos_tipos.type_en', 'movimientos_tipos.type_es', 'movimientos_tipos.created_at',
                    'movimientos_tipos.movimientos_tipo_category_id', DB::raw('(movimientos_tipo_categories.category_' . $current_lang . ') as equity')])
                ->leftJoin('movimientos_tipo_categories', 'movimientos_tipo_categories.id', '=', 'movimientos_tipos.movimientos_tipo_category_id');

        return DataTables::of($movimientos_tipos)
                        ->addColumn('action', function ($movimientos_tipos)
                        {
                            $botones = '<a href="' . url('movimientos_tipos/' . $movimientos_tipos->id . '/edit') . '" class="btn btn-xs btn-info waves-effect waves-light pull-left m-r-5"><i class="fa fa-edit"></i> ' . __('sistema.btn_edit') . '</a> ';

                            if (!in_array($movimientos_tipos->id, [1, 2, 10, 11, 12, 13]))
                            {
                                $botones .= '<form action="' . url('movimientos_tipos/' . $movimientos_tipos->id) . '" id="borra_Frm' . $movimientos_tipos->id . '" method="POST" class="pull-left">' . csrf_field() . ' ' . method_field('DELETE') . '<button type="button" onclick="confirmaDel(' . $movimientos_tipos->id . ',\'' . $movimientos_tipos->type_en . '\');" class="btn btn-xs btn-danger"><span class="fa fa-trash"></span> </button></form>&nbsp;';
                            }
                            return $botones;
                        })
                        ->filterColumn('equity', function($query, $keyword) use($current_lang){
                            return $query->where('movimientos_tipo_categories.category_' . $current_lang, 'like', '%'  .  $keyword . '%');
                        })
                        ->editColumn('created_at', function ($movimientos_tipos)
                        {
                            return $movimientos_tipos->created_at->format('d/m/Y H:i');
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
        return view('catalogos.movimientos_tipos.index')->with('elmenu', ['elmenu' => $lstMenus]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $current_lang = HelperUtil::get_currentlang();
        $lstMenus = Util::generateMenu(auth()->user()->perfil_id);
        $categories = MovimientosTipoCategory::pluck('category_' . $current_lang, 'id')->toArray();
        
        return view('catalogos.movimientos_tipos.new')
                        ->with('elmenu', ['elmenu' => $lstMenus])
                        ->with('categories', $categories);
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

        $rules     = array(
            'type_en' => 'required',
            'type_es' => 'required',
            'movimientos_tipo_category_id'        => 'required|exists:movimientos_tipo_categories,id'
        );
        $messages  = array(
            'type_en.required' => __('sistema.movimientos_tipo.req_type_en'),
            'type_es.required' => __('sistema.movimientos_tipo.req_type_es'),
            'movimientos_tipo_category_id.required' => __('sistema.movimientos_tipo.req_equity'),
            'movimientos_tipo_category_id.exists' => __('sistema.movimientos_tipo.exists_equity')
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails())
        {
            return redirect('movimientos_tipos/create')->withInput()->withErrors($validator);
        }
        else
        {
            // Save MovimientosTipo
            $movimientos_tipo = new MovimientosTipo;
            $movimientos_tipo->fill($campos);
            $movimientos_tipo->save();

            return redirect('movimientos_tipos')->with('msg', __('sistema.save_success_msg'))->with('type', 'success');
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
        $current_lang = HelperUtil::get_currentlang();
        $lstMenus = Util::generateMenu(auth()->user()->perfil_id);
        
        $categories = MovimientosTipoCategory::pluck('category_' . $current_lang, 'id')->toArray();
        $movimientos_tipo = MovimientosTipo::find($id);

        return view('catalogos.movimientos_tipos.edit')
                        ->with('elmenu', ['elmenu' => $lstMenus])
                        ->with('movimientos_tipo', $movimientos_tipo)
                        ->with('categories', $categories);
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

        $rules    = array(
            'type_en' => 'required',
            'type_es' => 'required',
            'movimientos_tipo_category_id'        => 'required|exists:movimientos_tipo_categories,id'
        );
        $messages = array(
            'type_en.required' => __('sistema.movimientos_tipo.req_type_en'),
            'type_es.required' => __('sistema.movimientos_tipo.req_type_es'),
            'movimientos_tipo_category_id.required' => __('sistema.movimientos_tipo.req_equity'),
            'movimientos_tipo_category_id.exists' => __('sistema.movimientos_tipo.exists_equity')
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails())
        {
            return redirect('movimientos_tipos/' . $id . '/edit')->withInput()->withErrors($validator);
        }
        else
        {

            $item = MovimientosTipo::find($id);
            $item->fill($campos);
            $item->save();
            return redirect('movimientos_tipos')->with('msg', __('sistema.update_success_msg'))->with('type', 'success');
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
            if (in_array($id, [1, 2, 10, 11, 12, 13]))
            {
                return redirect()->back();
            }

            $movement_type = MovimientosTipo::find($id);

            if (!$movement_type)
            {
                abort(404);
            }

            $association = \App\Models\MovimientosTransaction::where('movimientos_tipo_id', $movement_type->id)->first();

            if ($association)
            {
                return redirect()->back()->with('msg', __('sistema.remove_fail_msg_associated'))->with('type', 'error');
            }
            if ($movement_type->delete())
            {
                return redirect()->back()->with('msg', __('sistema.remove_success_msg'))->with('type', 'success');
            }
            else
            {
                return redirect()->back()->with('msg', __('sistema.remove_fail_msg'))->with('type', 'error');
            }
        }
        catch (\Exception $ex)
        {
            return redirect()->back()->with('msg', $ex->getMessage())->with('type', 'error');
        }
    }

}
