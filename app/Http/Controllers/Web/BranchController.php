<?php

namespace App\Http\Controllers\Web;

use DB;
use Validator;
use App\Support\Util;
use App\Models\Branch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class BranchController extends Controller
{
    /*
     * Constructor de la clase que instancia el middleware auth
     */

    public function __construct()
    {
        $this->middleware('seguridad')->only('index');
    }

    //Funcion para DataTable
    public function databranches()
    {
        $branches = Branch::select('branches.*', DB::raw('countries.name as country_name'))
                ->leftJoin('countries', 'countries.id', '=', 'branches.country_id');

        return DataTables::of($branches)
                        ->addColumn('action', function ($branches)
                        {
                            $botones = '<a href="' . url('branches/' . $branches->id . '/edit') . '" class="btn btn-xs btn-info waves-effect waves-light pull-left m-r-5"><i class="fa fa-edit"></i> ' . __('sistema.btn_edit') . '</a> ';

                            $botones .= '<form action="' . url('branches/' . $branches->id) . '" id="borra_Frm' . $branches->id . '" method="POST" class="pull-left">' . csrf_field() . ' ' . method_field('DELETE') . '<button type="button" onclick="confirmaDel(' . $branches->id . ',\'' . (session('language') == 'es' ? $branches->branch_es : $branches->branch_en ) . '\');" class="btn btn-xs btn-danger"><span class="fa fa-trash"></span> </button></form>&nbsp;';
                            return $botones;
                        })
                        ->editColumn('created_at', function ($items)
                        {
                            return $items->created_at ? $items->created_at->format('d/m/Y H:i') : '-';
                        })
                        ->filterColumn('country_name', function($query, $keyword)
                        {
                            $query->where('countries.name', 'like', '%' . $keyword . '%');
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
        return view('catalogos.branches.index')->with('elmenu', ['elmenu' => $lstMenus]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lstMenus  = Util::generateMenu(auth()->user()->perfil_id);
        $countries = \App\Models\Country::pluck('name', 'id')->toArray();
        return view('catalogos.branches.new', compact('countries'))
                        ->with('elmenu', ['elmenu' => $lstMenus]);
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

            $rules = array(
                'branch_en'  => 'required',
                'branch_es'  => 'required',
                'country_id' => 'required'
            );

            $messages = array(
                'branch_en.required'  => __('sistema.branches.req_branch_en'),
                'branch_es.required'  => __('sistema.branches.req_branch_es'),
                'country_id.required' => __('sistema.branches.req_country'),
            );

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails())
            {
                return redirect()->back()->withInput()->withErrors($validator);
            }
            else
            {
                $branch         = new Branch;
                $branch->fill($campos);
                $branch->active = 1;
                if ($branch->save())
                {
                    return redirect('branches')->with('msg', __('sistema.save_success_msg'))->with('type', 'success');
                }
                else
                {
                    return redirect()->back()->withInput()->with('msg', __('sistema.save_fail_msg'))->with('type', 'error');
                }
            }
        }
        catch (\Exception $ex)
        {
            return redirect()->back()->withInput()->with('msg', $ex->getMessage())->with('type', 'error');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function show(Branch $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function edit(Branch $branch)
    {
        $lstMenus  = Util::generateMenu(auth()->user()->perfil_id);
        $countries = \App\Models\Country::pluck('name', 'id')->toArray();
        return view('catalogos.branches.edit')
                        ->with('elmenu', ['elmenu' => $lstMenus])
                        ->with('branch', $branch)
                        ->with('countries', $countries);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Branch $branch)
    {
        try
        {
            $campos = $request->all();

            $rules = array(
                'branch_en'  => 'required',
                'branch_es'  => 'required',
                'country_id' => 'required'
            );

            $messages = array(
                'branch_en.required'  => __('sistema.branches.req_branch_en'),
                'branch_es.required'  => __('sistema.branches.req_branch_es'),
                'country_id.required' => __('sistema.branches.req_country'),
            );

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails())
            {
                return redirect()->back()->withInput()->withErrors($validator);
            }
            else
            {
                $branch->branch_en  = $campos['branch_en'];
                $branch->branch_es  = $campos['branch_es'];
                $branch->country_id = $campos['country_id'];
                if ($branch->save())
                {
                    return redirect('branches')->with('msg', __('sistema.update_success_msg'))->with('type', 'success');
                }
                else
                {
                    return redirect()->back()->withInput()->with('msg', __('sistema.update_fail_msg'))->with('type', 'error');
                }
            }
        }
        catch (\Exception $ex)
        {
            return redirect()->back()->withInput()->with('msg', $ex->getMessage())->with('type', 'error');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Branch $branch)
    {
        try
        {
            $association = \App\Models\Account::where('branch_id', $branch->id)->first();
            if ($association)
            {
                return redirect()->back()->withInput()->with('msg', __('sistema.branches.association_delete'))->with('type', 'error');
            }
            if ($branch->delete())
            {
                return redirect('branches')->with('msg', __('sistema.remove_success_msg'))->with('type', 'success');
            }
            else
            {
                return redirect()->back()->withInput()->with('msg', __('sistema.remove_fail_msg'))->with('type', 'error');
            }
        }
        catch (\Exception $ex)
        {
            return redirect()->back()->withInput()->with('msg', $ex->getMessage())->with('type', 'error');
        }
    }

}
