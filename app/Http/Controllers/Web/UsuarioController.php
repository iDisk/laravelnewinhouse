<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Perfil;
use Yajra\DataTables\Facades\DataTables;
use App\Support\Util;
use Validator;
use Storage;
use File;
use Image;
use App\Mail\BienvenidoMail;
use Mail;

class UsuarioController extends Controller
{


    /*
    * Constructor de la clase que instancia el middleware auth
    */

    public function __construct()
    {
        $this->middleware('seguridad')->only('index');
    }

    //Funcion para DataTable
    public function datausers()
    {
        $usuarios = User::select('users.*')->where('perfil_id','!=',2)->with('perfiles');

        return DataTables::of($usuarios)
            ->addColumn('action', function ($usuarios) {

                if($usuarios->id == 1)
                {
                    return '';
                }
                $botones = '<a href="'.url('usuarios/'.$usuarios->id.'/edit').'" class="btn btn-xs btn-info waves-effect waves-light"><i class="fa fa-edit"></i> '.__('sistema.users_edit').'</a> ';
                return $botones;

                
            })
            ->editColumn('created_at', function ($usuarios) {
                return $usuarios->created_at->format('d/m/Y H:i');                
            })            
            ->editColumn('status', function ($usuarios) {
                return $usuarios->status ? 'Activo' : 'Inactivo';
            })                          
            ->editColumn('photo',function($usuarios){
                return $usuarios->photo ? $usuarios->photo : url('assets/images/users/generic-user.jpg');
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
        //Hack para enviar el menu que corresponde al profile del usuario autentificado
        $lstMenus = Util::generateMenu(auth()->user()->perfil_id);

        return view('catalogos.usuarios.index')->with('elmenu',['elmenu'=>$lstMenus]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Hack para enviar el menu que corresponde al profile del usuario autentificado
        $lstMenus = Util::generateMenu(auth()->user()->perfil_id);

        return view('catalogos.usuarios.new')
                        ->with('elmenu',['elmenu'=>$lstMenus])
                        ->with('perfiles',Perfil::where('id','!=',2)->orderBy('perfil')->get());
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
            'email' => 'required|email|unique:users,email',
        );
        $messages = array(
            'email.required' =>  __('sistema.controller_user.email_required'),
            'email.email' =>  __('sistema.controller_user.email_valid'),
            'email.unique' => __('sistema.controller_user.email_unique'),
        );

        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails())
        {
            
            return redirect('usuarios/create')->withInput()->withErrors($validator);
            
        }else{
            //crear registro
            $usuario = new User;
            $usuario->fill($campos);
            $usuario->password = bcrypt($campos['password']);            
            $usuario->save();

            //Procesar Fotos
            if($request->hasFile('photo'))
            {

                $rutaS3='/users/photos';
                Storage::disk()->makeDirectory($rutaS3);

                $id_user = auth()->user()->id;
                $checksum=md5($usuario->email);
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
               $usuario->photo = url($rutaS3.'/'.$filenameMovil);
               $usuario->save();

            } 

            //Enviar un correo notificando al usuario que fue registrado solo si esta habilitado el queue
            if(config('starter.queue_mail'))
            {
              Mail::to($usuario->email)->queue(new BienvenidoMail($usuario->name,$usuario->email,$campos['password']));  
            }
           

            return redirect('usuarios')->with('msg',__('sistema.controller_user.user_create',['name'=>$usuario->name]))->with('type','success');
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

        if($id == 1)
        {
            return redirect('usuarios');
        }
        return view('catalogos.usuarios.edit')
                ->with('elmenu',['elmenu'=>$lstMenus])
                ->with('usuario',User::find($id))
                ->with('perfiles',Perfil::where('id','!=',2)->orderBy('perfil')->get());
                
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
        //
        

        $input = $request->all();
        $edituser=User::find($id);
            $edituser->name = $input['name'];
                       
            
            $edituser->perfil_id = $input['perfil_id'];
            
            
        if($input['password']=='')
        {
            //No modificar el campo
        }else{
            $edituser->password = bcrypt($input['password']);
        }

        if(isset($input['status']))
        {
            $edituser->status = false;
        }else{
            $edituser->status = true;
        }

        $edituser->save();

        //Por si cambia la foto de perfil
        if($request->hasFile('photo'))
            {

                $rutaS3='/users/photos';
                Storage::disk()->makeDirectory($rutaS3);

                $id_user = auth()->user()->id;
                $checksum=md5($edituser->email);
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
               $edituser->photo = url($rutaS3.'/'.$filenameMovil);
               $edituser->save();

            } 

        return redirect('usuarios')->with('msg',__('sistema.controller_user.user_update',['name'=>$input['name']]))->with('type','success');;
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
