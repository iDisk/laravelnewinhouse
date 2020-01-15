<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SecurityImage;
use Yajra\DataTables\Facades\DataTables;
use App\Support\Util;
use Validator;
use Storage;
use File;
use Image;

class SecurityImageController extends Controller
{
    /*
    * Constructor de la clase que instancia el middleware auth
    */
    public function __construct()
    {
        $this->middleware('seguridad')->only('index');
    }

    //Funcion para DataTable
    public function datasecurityimages()
    {
        $security_images = SecurityImage::select('security_images.*');

        return DataTables::of($security_images)
            ->addColumn('action', function ($security_images) {
                $botones = '<a href="'.url('security_images/'.$security_images->id.'/edit').'" class="btn btn-xs btn-info waves-effect waves-light"><i class="fa fa-edit"></i> '.__('sistema.btn_edit').'</a> ';
                return $botones;
            })
            ->editColumn('image',function($security_images){
                return $security_images->image ? $security_images->image : url('assets/images/users/generic-user.jpg');
            })
            ->editColumn('created_at', function ($security_images) {
                return $security_images->created_at->format('d/m/Y H:i');
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
        return view('catalogos.security_images.index')->with('elmenu',['elmenu'=>$lstMenus]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lstMenus = Util::generateMenu(auth()->user()->perfil_id);

        return view('catalogos.security_images.new')
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
            'order' => 'required',
            'photo' => 'required',
        );
        $messages = array(
            'order.required' =>  __('sistema.controller_user.email_required'),
            'photo.required' =>  __('sistema.controller_user.email_required'),
        );

        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails())
        {
            return redirect('security_images/create')->withInput()->withErrors($validator);
            
        }else{
            
            $security_image = new SecurityImage;
            $security_image->fill($campos);
            $security_image->image = '';
            $security_image->save();

            //Procesar Fotos
            if($request->hasFile('photo'))
            {

                $rutaS3='/security_img';
                Storage::disk()->makeDirectory($rutaS3);

                $id_user = auth()->user()->id;
                $checksum=md5($security_image->id);
                $filename      = 'original_'.date('dmY_His').'_'.$checksum.'.jpg';
                $filenameMovil = 'thumb_'.date('dmY_His').'_'.$checksum.'.jpg';

                $procesa = Image::make($request->photo)->encode('jpg', 95);
                $procesa->save(public_path().$rutaS3.'/'.$filename);                
                $procesa->resize(128, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                
                $procesa->save(public_path().$rutaS3.'/'.$filenameMovil);

                //Storage::disk('s3')->put($rutaS3.'/'.$filename,fopen(storage_path().'/'.$filename,'r+'),'public');
                //Storage::disk('s3')->put($rutaS3.'/'.$filenameMovil,fopen(storage_path().'/'.$filenameMovil,'r+'),'public');        
                //File::delete(storage_path().'/'.$filename);
                //File::delete(storage_path().'/'.$filenameMovil);  
               //$usuario->photo = Storage::disk('s3')->url($rutaS3.'/'.$filenameMovil);
               $security_image->image = url($rutaS3.'/'.$filenameMovil);
               $security_image->save();

            }

            return redirect('security_images')->with('msg',__('sistema.save_success_msg'))->with('type','success');
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
        //Hack para enviar el menu que corresponde al profile del usuario autentificado
        $lstMenus = Util::generateMenu(auth()->user()->perfil_id);
        $security_image = SecurityImage::find($id);

        return view('catalogos.security_images.edit')
                ->with('elmenu',['elmenu'=>$lstMenus])
                ->with('security_image',$security_image);
                
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
        $security_image = SecurityImage::find($id);
        $security_image->fill($campos);
        $security_image->save();

        if($request->hasFile('photo'))
        {
            
            $rutaS3='/security_img';
            Storage::disk()->makeDirectory($rutaS3);

            $checksum=md5($security_image->id);
            $filename      = 'original_'.date('dmY_His').'_'.$checksum.'.jpg';
            $filenameMovil = 'thumb_'.date('dmY_His').'_'.$checksum.'.jpg';

            $procesa = Image::make($request->photo)->encode('jpg', 95);
            $procesa->save(public_path().$rutaS3.'/'.$filename);                
            $procesa->resize(128, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            
            $procesa->save(public_path().$rutaS3.'/'.$filenameMovil);

            //Storage::disk('s3')->put($rutaS3.'/'.$filename,fopen(storage_path().'/'.$filename,'r+'),'public');
            //Storage::disk('s3')->put($rutaS3.'/'.$filenameMovil,fopen(storage_path().'/'.$filenameMovil,'r+'),'public');
            //File::delete(storage_path().'/'.$filename);
            //File::delete(storage_path().'/'.$filenameMovil);  
            //$edituser->photo = Storage::disk('s3')->url($rutaS3.'/'.$filenameMovil);
            $security_image->image = url($rutaS3.'/'.$filenameMovil);
            $security_image->save();
        } 

        return redirect('security_images')->with('msg',__('sistema.update_success_msg'))->with('type','success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
