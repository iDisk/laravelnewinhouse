<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Perfil;
use App\Models\PerfilMenu;
use App\Models\Menu;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use App\Support\Util;
use App\Models\Broker;
use App\Models\PerfilBroker;

class PerfilController extends Controller
{

     /*
    * Constructor de la clase que instancia el middleware auth
    */

    public function __construct()
    {
        $this->middleware('seguridad')->only('index');
    }

    //Funcion para DataTable
    public function dataperfil()
    {
        $perfiles = Perfil::select(['id', 'perfil']);

        return DataTables::of($perfiles)
            ->addColumn('action', function ($perfiles) {

                $botones ='';                
                $botones.= '<a href="'.url('perfiles/'.$perfiles->id.'/edit').'" class="btn btn-xs btn-info waves-effect waves-light"><i class="fa fa-edit"></i> '.__('sistema.btn_edit').'</a> ';                
                $botones.= '<a href="'.url('showmenus/'.$perfiles->id.'/assign').'" class="btn btn-xs btn-default waves-effect waves-light"><i class="fa fa-edit"></i> '.__('sistema.profile.assign_menu').'</a> &nbsp;';
                if(! in_array($perfiles->id,[1,2,3,4,5,6])){                    
                    $botones .= '<form id="borraPerfilFrm'.$perfiles->id.'" action="'.url('perfiles/' . $perfiles->id).'" method="POST" style="display: inline-block;">'.csrf_field()  .' '.method_field('DELETE') .'<button type="button" class="btn btn-xs btn-danger waves-effect waves-light" onclick="confirmaDel('.$perfiles->id.',\''.$perfiles->perfil.'\');"><span class="fa fa-trash"></span></button></form>';
                }
                return $botones;

                
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

        return view('catalogos.perfiles.index')->with('elmenu',['elmenu'=>$lstMenus]);
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

        return view('catalogos.perfiles.new')->with('elmenu',['elmenu'=>$lstMenus]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
            $addprofile = new Perfil;
            $addprofile->fill($input);
            $addprofile->save();
            return redirect('perfiles')->with('msg','Perfil '.$input['perfil'].' agregado correctamente')->with('type','success');
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

        $perfil = Perfil::find($id);

        return view('catalogos.perfiles.edit')->with('elmenu',['elmenu'=>$lstMenus])->with('perfil',$perfil);
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
        $perfil = Perfil::find($id);
        $perfil->fill($input);
        $perfil->save();

        return redirect('perfiles')->with('msg','Perfil '.$input['perfil'].' actualizado correctamente')->with('type','success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         //Crear reglas de validación que impidan borrar perfiles que tienen usuarios asignados

        $users = User::where('perfil_id',$id)->get();
        if($users->count()>0)
        {
            return redirect('perfiles')->with('msg','El perfil no pudo ser eliminado porque tiene usuarios asignados')->with('type','error');
        }else{
            Perfil::find($id)->delete();
            

        return redirect('perfiles')->with('msg','El perfil fue eliminado correctamente')->with('type','success');
        }

    }

    //Metodos para asignar,mostrar permisos de menus en el perfil
    public function showRolmenu($profile_id)
    {
        //Evaluar si el Rol que se envia ya tiene menus asignados
        $items=PerfilMenu::where('perfil_id','=',$profile_id)->get();
        $NameRol=Perfil::where('id',$profile_id)->first();
        $all_brokers = Broker::pluck('broker', 'id')->toArray();        
        $my_brokers = $NameRol->brokers()->pluck('brokers.id')->toArray();        
        $lang = \App\Util\HelperUtil::get_currentlang();
        //Genera un Array Temporal para poder comparar si existe el menu_id y marcar el Checkbox
        $asignados=[];
        foreach($items as $valor)
        {
            $asignados[]=$valor->menu_id;
        }

        $lstMenus = Util::generateMenu(auth()->user()->perfil_id);

        $RootMenu=Menu::where('parent','=','0')->where('active','=',1)->orderBy('order')->get();
        $lista='<ul style="list-style-type: none">';
        foreach($RootMenu as $llave => $valor)
        {
            //Buscar Submenus
            //Buscar si tiene subitems
            $subMenu=Menu::where('parent','=',$valor->id)->where('active','=',1)->orderBy('order')->get();

                if(count($subMenu)==0){
                    if(in_array($valor->id,$asignados))
                    {
                        $lista.='<li>'.$valor->$lang.' <input type="checkbox" id="valores[]" name="valores[]" value="'.$valor->id.'" checked/></li>';
                    }else{
                        $lista.='<li>'.$valor->$lang.' <input type="checkbox" id="valores[]" name="valores[]" value="'.$valor->id.'"/></li>';
                    }

                }else{
                        if(in_array($valor->id,$asignados))
                            {
                                $lista.='<li>'.$valor->$lang.' <input type="checkbox" id="valores[]" name="valores[]" value="'.$valor->id.'" checked/></li>';
                            }else{
                                $lista.='<li>'.$valor->$lang.' <input type="checkbox" id="valores[]" name="valores[]" value="'.$valor->id.'"/></li>';
                            }
                        $lista.='<ul style="list-style-type: none">';
                        foreach($subMenu as $value){
                            if(in_array($value->id,$asignados))
                                {
                                    $lista.='<li>'.$value->$lang.' <input type="checkbox" id="valores[]" name="valores[]" value="'.$value->id.'" checked/></li>';
                                }else{
                                    $lista.='<li>'.$value->$lang.' <input type="checkbox" id="valores[]" name="valores[]" value="'.$value->id.'"/></li>';
                                }

                        }
                        $lista.='</ul>';            
                }           

        }           
        $lista.='</ul>';

        return view('catalogos.perfiles.menuperfil')
                ->with('elmenu',['elmenu'=>$lstMenus])
                ->with('Menus',$lista)
                ->with('roldata',$NameRol)
                ->with('all_brokers', $all_brokers)
                ->with('my_brokers', $my_brokers);
    }

    public function asignaMenu(Request $request)
    {
        $input = $request->all();

        $opciones  = isset($input['valores']) ? $input['valores'] : [];
        $perfil_id = $input['perfil_id'];
        $broker_ids = isset($input['broker_id']) ? $input['broker_id'] : [];
        
        
        //Verificar si contiene datos $opciones (es decir que no se asignara nada)
        //Primero borrar las asignaciones actuales
        $rs = PerfilMenu::where('perfil_id', '=', $perfil_id)->delete();

        PerfilBroker::where('perfil_id', $perfil_id)->delete();
        
        $profile = Perfil::find($perfil_id);
        
        if(count($broker_ids) > 0)
        {
            $profile->brokers()->sync($broker_ids);
        }
        
        if (count($opciones) > 0)
        {
            foreach ($opciones as $menu)
            {
                $asigna            = new PerfilMenu;
                $asigna->perfil_id = $perfil_id;
                $asigna->menu_id   = $menu;
                $asigna->save();
            }
            return redirect('perfiles')->with('msg', 'Menus asignados correctamente');
        }
        else
        {
            return redirect('perfiles');
        }
    }

}
