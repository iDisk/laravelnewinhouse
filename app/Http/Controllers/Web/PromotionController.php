<?php

namespace App\Http\Controllers\Web;

use DB;
use File;
use Image;
use Storage;
use Validator;
use App\Support\Util;
use App\Models\Broker;
use App\Models\Promotion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class PromotionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($broker_id)
    {
        $broker = Broker::find($broker_id);

        if (!$broker)
        {
            abort(404);
        }

        $lstMenus = Util::generateMenu(auth()->user()->perfil_id);
        return view('catalogos.promotions.index')
                        ->with('elmenu', ['elmenu' => $lstMenus])
                        ->with('broker', $broker);
    }

    public function data_promotions($broker_id)
    {
        $promotions = Promotion::select(['id', 'promo_title_en', 'promo_title_es', 'estatus'])
                ->where('broker_id', $broker_id);

        return DataTables::of($promotions)
                        ->editColumn('estatus', function($promotions)
                        {
                            return $promotions->estatus ? '<span>' . __('sistema.active') . '</span>' : '<span>' . __('sistema.inactive') . '</span>';
                        })
                        ->addColumn('action', function ($promotions) use ($broker_id)
                        {
                            $botones = '<a href="' . url('brands/' . $broker_id . '/promotion/' . $promotions->id . '/edit') . '" class="btn btn-xs btn-info waves-effect waves-light"><i class="fa fa-edit"></i> ' . __('sistema.btn_edit') . '</a> ';
                            $botones .= '<form action="' . url('brands/' . $broker_id) . '/promotion/' . $promotions->id . '" id="borra_Frm' . $promotions->id . '" method="POST" class="deleteFrm">' . csrf_field() . ' ' . method_field('DELETE') . '<button type="button" onclick="confirmaDel(' . $promotions->id . ',\'' . $promotions->promo_title_en . '\');" class="btn btn-xs btn-danger"><span class="fa fa-trash"></span> </button></form>&nbsp;';
                            return $botones;
                        })
                        ->rawColumns(['estatus', 'action'])
                        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($broker_id)
    {
        $broker = Broker::find($broker_id);

        if (!$broker)
        {
            abort(404);
        }

        $lstMenus = Util::generateMenu(auth()->user()->perfil_id);
        return view('catalogos.promotions.new')
                        ->with('elmenu', ['elmenu' => $lstMenus])
                        ->with('broker', $broker);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $broker_id)
    {
        try
        {
            $campos = $request->all();

            $rules = Promotion::rules();

            $messages = Promotion::messages();

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails())
            {
                return redirect()->back()->withInput()->withErrors($validator);
            }
            else
            {
                DB::beginTransaction();
                $promotion                       = new Promotion;
                $promotion->broker_id            = $broker_id;
                $promotion->promo_title_en       = $campos['promotion_title_en'];
                $promotion->promo_title_es       = $campos['promotion_title_es'];
                $promotion->short_description_en = $campos['promotion_short_description_en'];
                $promotion->short_description_es = $campos['promotion_short_description_es'];
                $promotion->long_description_en  = $campos['promotion_long_description_en'];
                $promotion->long_description_es  = $campos['promotion_long_description_es'];
                $promotion->estatus              = $campos['estatus'];

                if ($promotion->save())
                {
                    // Procesar foto
                    if ($request->hasFile('promo_image'))
                    {
                        $rutaS3 = '/promos/photos';

                        File::makeDirectory(public_path($rutaS3), 0777, true, true);
                        $checksum = md5($promotion->promotion_title_en);

                        $img_extension = $request->promo_image->getClientOriginalExtension();

                        $filename      = 'original_' . date('dmY_His') . '_' . $checksum . '.' . $img_extension;
                        $filenameMovil = 'thumb_' . date('dmY_His') . '_' . $checksum . '.' . $img_extension;

                        $procesa = Image::make($request->promo_image->getRealPath())->encode($img_extension, 95);
                        $procesa->save(public_path() . $rutaS3 . '/' . $filename);
                        $procesa->resize(128, null, function ($constraint)
                        {
                            $constraint->aspectRatio();
                        });

                        $procesa->save(public_path() . $rutaS3 . '/' . $filenameMovil);

                        $promotion->promo_image       = $rutaS3 . '/' . $filename;
                        $promotion->promo_image_thumb = $rutaS3 . '/' . $filenameMovil;
                        $promotion->save();
                    }

                    if ($promotion->save())
                    {
                        DB::commit();
                        return redirect('brands/' . $broker_id . '/promotion')->with('msg', __('sistema.save_success_msg'))->with('type', 'success');
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
     * @param  \App\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function show(Promotion $promotion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function edit($broker_id, $promotion_id)
    {
        $promotion = Promotion::where([
                    'id'        => $promotion_id,
                    'broker_id' => $broker_id
                ])->first();

        if (!$promotion)
        {
            abort(404);
        }

        $lstMenus = Util::generateMenu(auth()->user()->perfil_id);
        return view('catalogos.promotions.edit')
                        ->with('elmenu', ['elmenu' => $lstMenus])
                        ->with('promotion', $promotion)
                        ->with('broker', $promotion->broker);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $broker_id, $promotion_id)
    {
        try
        {
            $campos = $request->all();

            $rules = Promotion::rules($promotion_id);

            $messages = Promotion::messages();

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails())
            {
                return redirect()->back()->withInput()->withErrors($validator);
            }
            else
            {
                DB::beginTransaction();
                $promotion = Promotion::where([
                            'id'        => $promotion_id,
                            'broker_id' => $broker_id
                        ])->first();
                if (!$promotion)
                {
                    abort(404);
                }

                $delete_files = false;

                $promotion->promo_title_en       = $campos['promotion_title_en'];
                $promotion->promo_title_es       = $campos['promotion_title_es'];
                $promotion->short_description_en = $campos['promotion_short_description_en'];
                $promotion->short_description_es = $campos['promotion_short_description_es'];
                $promotion->long_description_en  = $campos['promotion_long_description_en'];
                $promotion->long_description_es  = $campos['promotion_long_description_es'];
                $promotion->estatus              = $campos['estatus'];

                $delete_file_1 = base_path('/public' . $promotion->promo_image);
                $delete_file_2 = base_path('/public' . $promotion->promo_image_thumb);

                if ($promotion->save())
                {
                    // Procesar foto
                    if ($request->hasFile('promo_image'))
                    {
                        $rutaS3 = '/promos/photos';

                        File::makeDirectory(public_path($rutaS3), 0777, true, true);
                        $checksum = md5($promotion->promotion_title_en);

                        $img_extension = $request->promo_image->getClientOriginalExtension();

                        $filename      = 'original_' . date('dmY_His') . '_' . $checksum . '.' . $img_extension;
                        $filenameMovil = 'thumb_' . date('dmY_His') . '_' . $checksum . '.' . $img_extension;

                        $procesa = Image::make($request->promo_image->getRealPath())->encode($img_extension, 95);
                        $procesa->save(public_path() . $rutaS3 . '/' . $filename);
                        $procesa->resize(128, null, function ($constraint)
                        {
                            $constraint->aspectRatio();
                        });

                        $procesa->save(public_path() . $rutaS3 . '/' . $filenameMovil);

                        $promotion->promo_image       = $rutaS3 . '/' . $filename;
                        $promotion->promo_image_thumb = $rutaS3 . '/' . $filenameMovil;
                        $promotion->save();

                        $delete_files = true;
                    }

                    if ($promotion->save())
                    {
                        DB::commit();

                        if ($delete_files)
                        {
                            File::delete($delete_file_1);
                            File::delete($delete_file_2);
                        }
                        return redirect('brands/' . $broker_id . '/promotion')->with('msg', __('sistema.save_success_msg'))->with('type', 'success');
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function destroy($broker_id, $promotion_id)
    {
        try
        {
            $promotion = Promotion::where([
                        'id'        => $promotion_id,
                        'broker_id' => $broker_id
                    ])->first();

            if (!$promotion)
            {
                abort(404);
            }

            $delete_file_1 = base_path('/public' . $promotion->promo_image);
            $delete_file_2 = base_path('/public' . $promotion->promo_image_thumb);
            
            DB::beginTransaction();
            if ($promotion->delete())
            {
                DB::commit();
                File::delete($delete_file_1);
                File::delete($delete_file_2);
                return redirect('brands/' . $broker_id . '/promotion')->with('msg', __('sistema.remove_success_msg'))->with('type', 'success');
            }
            else
            {
                DB::rollBack();
                return redirect()->back()->withInput()->with('error', __('sistema.remove_fail_msg'))->with('type', 'error');
            }
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $ex->getMessage())->with('type', 'error');
        }
    }

}
