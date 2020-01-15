<?php
/*
* File          Util.php
* Autor         Dante Robles
* Description   Clase con funciones de ayuda
* Fecha         01/Junio/2017
*/
namespace App\Support;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Token;
use App\Models\Menu;
use App\Models\Profile;
use App\Models\ProfileMenu;
use App\Models\Setting;
use DB;
use Auth;
use Pusher\Pusher;
use App;

class Util {


    //Enviar mensajes al canal de pusher
    public static function enviaPusher($extra=[])
    {
        
        $options = [
            'cluster' => env('PUSHER_APP_CLUSTER','us2'),
            'encrypted' => true
          ];

          $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
          );

          $data['total_users'] = $extra['total_users'];
          $data['total_dispositivos'] = $extra['total_dispositivos'];
          $data['total_android'] = $extra['total_android'];
          $data['total_apple'] = $extra['total_apple'];
          $pusher->trigger('starterkit', 'dashboard', $data);

          return ['info'=>'Enviado!!'];
    }

    /*Generador de Passwords*/
	public static function genera_password($longitud=10) {
		$str = "*abcdef1234567890ABCDEF!";
		
		$cadena = "";
		for($i=0;$i<$longitud;$i++) {
			$cadena .= substr($str,rand(0,24),1);
		}
	return $cadena;
	}

    /*Generador de Token Stateless*/
	public static function crea_token()
    {
        $inicial = time();
        $segundos = (integer)config('starter.api_time',1800);       
        $final = $inicial + $segundos;
        $token = sha1(uniqid(rand(), true));
            $rs = [];
            $rs['expire'] = $final;
            $rs['token']  = $token;
        return $rs;
    }

    /*Respuestas API RESTful*/
    public static function creaRest($httpCode=200,$data = [],$error=false,$msg="")
    {
    	$rest = [];
    	$rest['error'] 		= $error;
    	$rest['message'] 	= $msg;
    	$rest['status'] 	= $httpCode;
    	$rest['data']		= $data;   	
            $respuesta = response()->json($rest,$httpCode,[],JSON_UNESCAPED_UNICODE|JSON_NUMERIC_CHECK|JSON_PRETTY_PRINT);
            $respuesta->header('Content-Type','application/json; charset=utf-8');
    	return $respuesta;
    }

    /*Funciones para manejo de Token Stateless*/

    //Funcion para verificar si el Token es valido
    public static function verificaToken($token)
    {        
        $tiempo = time();
        $datos = Token::where('token',$token)->where('expire','>',$tiempo)->first();        
            if ($datos==null) {
                return false;
            } else {
                return true;
            }
    }

    //Funcion para devolver el id del Usuario dependiendo del token
    public static function find_id_by_token($token)
    {        
        try {           
            $eltoken = Token::where('token',$token)->first();
            $usuario_id = $eltoken->user_id;
        } catch (Exception $e) {
            $usuario_id = 0;
        }
        return $usuario_id;
    }

    public static function generateMenu($profile_id)
    {

        
        $active = request()->path();

        $locale = App::getLocale();

    $renderMenu='<ul class="metismenu list-unstyled" id="side-menu">';
    $items=DB::table('perfil_menus')
                    ->join('menus','perfil_menus.menu_id','=','menus.id')
                    ->select('perfil_menus.menu_id','menus.menu','menus.es','menus.en','menus.parent','menus.active','menus.icon','menus.url','menus.id')
                    ->where('perfil_menus.perfil_id','=',$profile_id)
                    ->where('menus.parent','=',0)
                    ->where('menus.active','=',1)
                    ->orderBy('menus.order')
                    ->get();
          
         
          //$renderMenu.=' <li><a href="'.url('/home').'"><i class="fi-air-play"></i><span> '.__('sistema.menu_start').' </span></a></li>';      
            
          //$renderMenu.=' <li><a href="'.url('/').'" class="waves-effect"><i class="ti-home"></i><span> Inicio </span></a></li>';

    foreach ($items as $value) {
        
        $subitem=DB::table('perfil_menus')
                    ->join('menus','perfil_menus.menu_id','=','menus.id')
                    ->select('perfil_menus.menu_id','menus.menu','menus.es','menus.en','menus.parent','menus.active','menus.icon','menus.url','menus.id')
                    ->where('perfil_menus.perfil_id','=',$profile_id)
                    ->where('menus.parent','=',$value->id)
                    ->where('menus.active','=',1)
                    ->orderBy('menus.order')
                    ->get();

                    if(count($subitem)==0){

                            /*if(trim($active)==trim($value->url))
                            {
                                $claseActive="has_sub nav-active";
                            }else{
                                $claseActive="has_sub";
                            }*/

                            if($locale=='en')
                            {
                                $idiomaMenu = $value->en;
                            }

                            if($locale=='es')
                            {
                                $idiomaMenu = $value->es;
                            }
                            
                        $renderMenu.='<li>
                                        <a href="'.url($value->url).'">
                                          <i class="'.$value->icon.'"></i>                                          
                                          <span>'.$idiomaMenu.'</span>
                                        </a>
                                      </li>';
                        
                    }else{

                        if($locale=='en')
                        {
                            $idiomaMenu = $value->en;
                        }

                        if($locale=='es')
                        {
                            $idiomaMenu = $value->es;
                        }

                        $renderMenu.='<li>
                                        <a href="'.url($value->url).'">
                                          <i class="'.$value->icon.'"></i>                                           
                                          <span>'.$idiomaMenu.'</span> <span class="menu-arrow"></span>
                                        </a>
                                        <ul class="nav-second-level nav" aria-expanded="false">';
                       
                        foreach($subitem as $valor){        

                            /*if($active==$valor->url)
                            {
                                $claseActive="has_sub nav-active";
                            }else{
                                $claseActive="";
                            }*/

                            if($locale=='en')
                            {
                                $idiomaMenu = $valor->en;
                            }

                            if($locale=='es')
                            {
                                $idiomaMenu = $valor->es;
                            }

                            $renderMenu.='<li>
                                            <a href="'.url($valor->url).'">
                                              <i class="'.$valor->icon.'"></i>                                           
                                              <span>'.$idiomaMenu.'</span>
                                            </a>
                                          </li> ';
                        }

                        $renderMenu.='</ul>';

                        
            
                    }

    }

    //$renderMenu.='<li><a href="'.route('logout').'" onclick="event.preventDefault();document.getElementById(\'logout-form\').submit();" class="waves-effect"><i class="mdi mdi-logout "></i><span> '.__('sistema.menu_logout').' </span></a><form id="logout-form" action="'.route('logout').'" method="POST" style="display: none;">'.csrf_field().'</form></li>';
    $renderMenu.='<li><a href="'.route('logout').'" onclick="event.preventDefault();document.getElementById(\'logout-form\').submit();" class="waves-effect"><i class="mdi mdi-logout "></i><span> '.__('sistema.menu_logout').' </span></a></li>';
                        $renderMenu.='</li>';

    $renderMenu.='</ul>';

    return $renderMenu;
    }


    public static function generateFrontMenu($broker_id)
    {
        $active = request()->path();
        $locale = App::getLocale();
        
        $items=DB::table('broker_client_menus')
        ->join('client_menus','broker_client_menus.client_menu_id','=','client_menus.id')
        ->select('broker_client_menus.client_menu_id','broker_client_menus.parent','client_menus.menu','client_menus.es','client_menus.en','client_menus.active','client_menus.url','client_menus.id')
        ->where('broker_client_menus.broker_id',$broker_id)
        ->where('broker_client_menus.parent',0)
        ->where('client_menus.active',1)
        ->orderBy('broker_client_menus.order')
        ->get();

        $broker_settings = Setting::where('broker_id', $broker_id)->first();   

        if($broker_settings->menu_orientation == 'horizontal'){
            $renderMenu='<ul class="navigation-menu" style="display:inline-block"> ';
            foreach ($items as $value) {
            
                $subitem=DB::table('broker_client_menus')
                        ->join('client_menus','broker_client_menus.client_menu_id','=','client_menus.id')
                        ->select('broker_client_menus.client_menu_id','broker_client_menus.parent','client_menus.menu','client_menus.es','client_menus.en','client_menus.active','client_menus.url','client_menus.id')
                        ->where('broker_client_menus.broker_id',$broker_id)
                        ->where('client_menus.parent',$value->id)
                        ->where('client_menus.active','=',1)
                        ->orderBy('broker_client_menus.order')
                        ->get();
    
                if(count($subitem)==0){
    
                    if($locale=='en')
                    {
                        $idiomaMenu = $value->en;
                    }
    
                    if($locale=='es')
                    {
                        $idiomaMenu = $value->es;
                    }
                        
                    $renderMenu.='<li>
                                    <a href="'.url($value->url).'">
                                      <span>'.$idiomaMenu.'</span>
                                    </a>
                                  </li>';
                    
                }else{
    
                    if($locale=='en')
                    {
                        $idiomaMenu = $value->en;
                    }
    
                    if($locale=='es')
                    {
                        $idiomaMenu = $value->es;
                    }
    
                    $renderMenu.='<li class="has-submenu">
                                    <a href="'.url($value->url).'">
                                      <span>'.$idiomaMenu.'</span> <i class="fa fa-angle-down m-l-10" style="position: absolute; color: white;"></i>
                                    </a>
                                    <ul class="submenu">';
                   
                    foreach($subitem as $valor){        
    
                        if($locale=='en')
                        {
                            $idiomaMenu = $valor->en;
                        }
    
                        if($locale=='es')
                        {
                            $idiomaMenu = $valor->es;
                        }
    
                        if($valor->client_menu_id == 31){
                            $renderMenu.='<li>
                                        <a href="javascript:void(0);" class="open_contact_us_form">
                                          <span>'.$idiomaMenu.'</span>
                                        </a>
                                      </li> ';
                        }else{
    
                            $renderMenu.='<li>
                                        <a href="'.url($valor->url).'">
                                          <span>'.$idiomaMenu.'</span>
                                        </a>
                                      </li> ';
                        }
    
                        
                    }
    
                    $renderMenu.='</ul>';
                }
    
            }
        }
        else{
            $renderMenu='<ul class="metismenu list-unstyled" id="side-menu">';
            foreach ($items as $value) {
            
                $subitem=DB::table('broker_client_menus')
                        ->join('client_menus','broker_client_menus.client_menu_id','=','client_menus.id')
                        ->select('broker_client_menus.client_menu_id','broker_client_menus.parent','client_menus.menu','client_menus.es','client_menus.en','client_menus.active','client_menus.url','client_menus.id')
                        ->where('broker_client_menus.broker_id',$broker_id)
                        ->where('client_menus.parent',$value->id)
                        ->where('client_menus.active','=',1)
                        ->orderBy('broker_client_menus.order')
                        ->get();
    
                if(count($subitem)==0){
    
                    if($locale=='en')
                    {
                        $idiomaMenu = $value->en;
                    }
    
                    if($locale=='es')
                    {
                        $idiomaMenu = $value->es;
                    }
                        
                    $renderMenu.='<li>
                                    <a href="'.url($value->url).'">
                                      <span>'.$idiomaMenu.'</span>
                                    </a>
                                  </li>';
                    
                }else{
    
                    if($locale=='en')
                    {
                        $idiomaMenu = $value->en;
                    }
    
                    if($locale=='es')
                    {
                        $idiomaMenu = $value->es;
                    }
    
                    $renderMenu.='<li>
                                    <a href="'.url($value->url).'">
                                      <span>'.$idiomaMenu.'</span> <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level nav" aria-expanded="false">';
                   
                    foreach($subitem as $valor){        
    
                        if($locale=='en')
                        {
                            $idiomaMenu = $valor->en;
                        }
    
                        if($locale=='es')
                        {
                            $idiomaMenu = $valor->es;
                        }
    
                        if($valor->client_menu_id == 31){
                            $renderMenu.='<li>
                                        <a href="javascript:void(0);" class="open_contact_us_form">
                                          <span>'.$idiomaMenu.'</span>
                                        </a>
                                      </li> ';
                        }else{
    
                            $renderMenu.='<li>
                                        <a href="'.url($valor->url).'">
                                          <span>'.$idiomaMenu.'</span>
                                        </a>
                                      </li> ';
                        }
    
                        
                    }
    
                    $renderMenu.='</ul>';
                }
    
            }
        }
        $renderMenu.='</ul>';
        return $renderMenu;
    }

    public static function evaluaMenu($menu)
    {
        $profile_id = Auth::user()->perfil_id;



        //Obtener todos los menus del usuario en base al perfil
        $listaMenu=DB::table('perfil_menus')
                    ->join('menus','perfil_menus.menu_id','=','menus.id')
                    ->select('perfil_menus.menu_id','menus.menu','menus.parent','menus.active','menus.icon','menus.url','menus.id')
                    ->where('perfil_menus.perfil_id','=',$profile_id)                    
                    ->where('menus.active','=',1)
                    ->orderBy('menus.order')
                    ->get();

                   


        foreach ($listaMenu as $menuPerfil) {
            
            if($menuPerfil->url==$menu)
            {
                $menuValido = true;
                break;
            }else{
                $menuValido = false;
            }
        }

        return $menuValido;
    }

    public static function regresaRutasValidas()
    {
        $profile_id = Auth::user()->perfil_id;

        //Obtener todos los menus del usuario en base al perfil
        $listaMenu=DB::table('perfil_menus')
                    ->join('menus','perfil_menus.menu_id','=','menus.id')
                    ->select('perfil_menus.menu_id','menus.menu','menus.parent','menus.active','menus.icon','menus.url','menus.id')
                    ->where('perfil_menus.perfil_id','=',$profile_id)                    
                    ->where('menus.active','=',1)
                    ->orderBy('menus.order')
                    ->get();

                   

        $data = collect('#');

        foreach ($listaMenu as $menuPerfil) {
            
            if($menuPerfil->url=='#')
            {

            }else{
                $data->push($menuPerfil->url);    
            }
            
            
        }

        return $data;
    }

    //Convertir XML a Arrays
    public static function xml2array($contents, $get_attributes=1, $priority = 'tag') 
    {
        if(!$contents) return array();

        if(!function_exists('xml_parser_create')) {
            //print "'xml_parser_create()' function not found!";
            return array();
        }

        //Get the XML parser of PHP - PHP must have this module for the parser to work
        $parser = xml_parser_create('');
        xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8"); # http://minutillo.com/steve/weblog/2004/6/17/php-xml-and-character-encodings-a-tale-of-sadness-rage-and-data-loss
        xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
        xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
        xml_parse_into_struct($parser, trim($contents), $xml_values);
        xml_parser_free($parser);

        if(!$xml_values) return;//Hmm...

        //Initializations
        $xml_array = array();
        $parents = array();
        $opened_tags = array();
        $arr = array();

        $current = &$xml_array; //Refference

        //Go through the tags.
        $repeated_tag_index = array();//Multiple tags with same name will be turned into an array
        foreach($xml_values as $data) {
            unset($attributes,$value);//Remove existing values, or there will be trouble

            //This command will extract these variables into the foreach scope
            // tag(string), type(string), level(int), attributes(array).
            extract($data);//We could use the array by itself, but this cooler.

            $result = array();
            $attributes_data = array();
            
            if(isset($value)) {
                if($priority == 'tag') $result = $value;
                else $result['value'] = $value; //Put the value in a assoc array if we are in the 'Attribute' mode
            }

            //Set the attributes too.
            if(isset($attributes) and $get_attributes) {
                foreach($attributes as $attr => $val) {
                    if($priority == 'tag') $attributes_data[$attr] = $val;
                    else $result['attr'][$attr] = $val; //Set all the attributes in a array called 'attr'
                }
            }

            //See tag status and do the needed.
            if($type == "open") {//The starting of the tag '<tag>'
                $parent[$level-1] = &$current;
                if(!is_array($current) or (!in_array($tag, array_keys($current)))) { //Insert New tag
                    $current[$tag] = $result;
                    if($attributes_data) $current[$tag. '_attr'] = $attributes_data;
                    $repeated_tag_index[$tag.'_'.$level] = 1;

                    $current = &$current[$tag];

                } else { //There was another element with the same tag name

                    if(isset($current[$tag][0])) {//If there is a 0th element it is already an array
                        $current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result;
                        $repeated_tag_index[$tag.'_'.$level]++;
                    } else {//This section will make the value an array if multiple tags with the same name appear together
                        $current[$tag] = array($current[$tag],$result);//This will combine the existing item and the new item together to make an array
                        $repeated_tag_index[$tag.'_'.$level] = 2;
                        
                        if(isset($current[$tag.'_attr'])) { //The attribute of the last(0th) tag must be moved as well
                            $current[$tag]['0_attr'] = $current[$tag.'_attr'];
                            unset($current[$tag.'_attr']);
                        }

                    }
                    $last_item_index = $repeated_tag_index[$tag.'_'.$level]-1;
                    $current = &$current[$tag][$last_item_index];
                }

            } elseif($type == "complete") { //Tags that ends in 1 line '<tag />'
                //See if the key is already taken.
                if(!isset($current[$tag])) { //New Key
                    $current[$tag] = $result;
                    $repeated_tag_index[$tag.'_'.$level] = 1;
                    if($priority == 'tag' and $attributes_data) $current[$tag. '_attr'] = $attributes_data;

                } else { //If taken, put all things inside a list(array)
                    if(isset($current[$tag][0]) and is_array($current[$tag])) {//If it is already an array...

                        // ...push the new element into that array.
                        $current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result;
                        
                        if($priority == 'tag' and $get_attributes and $attributes_data) {
                            $current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data;
                        }
                        $repeated_tag_index[$tag.'_'.$level]++;

                    } else { //If it is not an array...
                        $current[$tag] = array($current[$tag],$result); //...Make it an array using using the existing value and the new value
                        $repeated_tag_index[$tag.'_'.$level] = 1;
                        if($priority == 'tag' and $get_attributes) {
                            if(isset($current[$tag.'_attr'])) { //The attribute of the last(0th) tag must be moved as well
                                
                                $current[$tag]['0_attr'] = $current[$tag.'_attr'];
                                unset($current[$tag.'_attr']);
                            }
                            
                            if($attributes_data) {
                                $current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data;
                            }
                        }
                        $repeated_tag_index[$tag.'_'.$level]++; //0 and 1 index is already taken
                    }
                }

            } elseif($type == 'close') { //End of tag '</tag>'
                $current = &$parent[$level-1];
            }
        }
        
        return($xml_array);
    }

    public static function nextAvailableTicketNumber($current_ticket)
    {
        $next_number = sprintf("%08d", $current_ticket + 1);

        $check = App\Models\AccountTransaction::select('id')->where('ticket', $next_number)->first();

        if($check)
        {
            return self::nextAvailableTicketNumber($next_number);
        }
        return $next_number;
    }
    public static function nextAvailableTicketNumberTradeInvestment($current_ticket)
    {
        $next_number = sprintf("%08d", $current_ticket + 1);

        $check = App\Models\TradeInvestment::select('id')->where('ticket', $next_number)->first();

        if($check)
        {
            return self::nextAvailableTicketNumberTradeInvestment($next_number);
        }
        return $next_number;
    }
    public static function nextAvailableTicketNumberMovements($current_ticket)
    {
        $next_number = sprintf("%08d", $current_ticket + 1);

        $check = App\Models\MovimientosTransaction::select('id')->where('ticket', $next_number)->first();

        if($check)
        {
            return self::nextAvailableTicketNumberMovements($next_number);
        }
        return $next_number;
    }

    //Fetch next ticket number 14-Nov-2019

    public static function nextTicketNumber($current_ticket,$custom=null)
    {

        if($custom == 1){
            $next_number = sprintf("%08d", $current_ticket + 1);
        }else{
            $next_number = sprintf("%08d", $current_ticket);
        }

        $check_trade = App\Models\AccountTransaction::select('id')->where('ticket', $next_number)->first();
        $check_movement = App\Models\MovimientosTransaction::select('id')->where('ticket', $next_number)->first();
        $check_trade_investment = App\Models\TradeInvestment::select('id')->where('ticket', $next_number)->first();

        if($check_trade || $check_movement || $check_trade_investment)
        {
            $query = \App\Models\TicketCounter::where('id',1)->where('counter',$next_number - 17)->update(['counter' => DB::raw('counter + 17')]);

            //dd($next_number,$query);

            if($query != 0){
                return self::nextTicketNumber($next_number,0);
            }else{
                return self::nextTicketNumber($next_number,1);
            }
            
            
        }
        return $next_number;
    }

    //Fetch next ticket number 14-Nov-2019
    public static function checkTicketNumber($current_ticket,$id,$tbl)
    {
        if($tbl = 'AccountTransaction')
        {
            $check_trade = App\Models\AccountTransaction::select('id')
                ->where('ticket', $current_ticket)
                ->where('id','!=', $id)
                ->first();
        }else{
            $check_trade = App\Models\AccountTransaction::select('id')->where('ticket', $current_ticket)->first();    
        }

        if($tbl = 'MovimientosTransaction')
        {
            $check_movement = App\Models\MovimientosTransaction::select('id')
                ->where('ticket', $current_ticket)
                ->where('id','!=', $id)
                ->first();
        }else{
            $check_movement = App\Models\MovimientosTransaction::select('id')->where('ticket', $current_ticket)->first();
        }

        if($tbl = 'TradeInvestment')
        {
            $check_trade_investment = App\Models\TradeInvestment::select('id')
                ->where('ticket', $current_ticket)
                ->where('id','!=', $id)
                ->first();
        }else{
            $check_trade_investment = App\Models\TradeInvestment::select('id')->where('ticket', $current_ticket)->first();
        }

        if($check_trade || $check_movement || $check_trade_investment)
        {
            //return self::nextTicketNumber($current_ticket);
            return  1;
        }
        return 0;
    }

}
