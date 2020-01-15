<style>
    .user_details-content{
        width: 230px;
        z-index: 10;
        bottom: 0;
        margin-top: 0;
        padding-bottom: 30px;
        position: fixed;
        top: 70px;
    }
    .user_details_body{
        background: #8cd4dc66;  
        padding: 10px; 
        position:relative;
        overflow:hidden; 
        border-bottom:1px solid #ddd; 
    }
    .user_details_body:before {
        content: ""; 
        position:absolute; 
        z-index: 1; 
        width:96%;  
        bottom: -10px; 
        height: 10px; 
        left: 2%; 
        border-radius: 100px / 5px; 
        box-shadow:0 0 18px rgba(0,0,0,0.6); 
    }
    .user_logout_button{
        color: gray;
        font-size: 12px;
        text-decoration: underline;
        color: #AAAAAA;
        cursor: pointer;
    }
    @media (min-width: 768px) and (max-width: 991px) {
        .user_details-content{
            top: 0px;
        }
    }
    @media (min-width: 991px) and (max-width: 1240px) {
        .user_details-content{
            top: 180px;
        }
    }
    
</style>
<header  id="topnav">
    <div class="navbar-custom widget-two-black">
        <div class="container-fluid">
            <div id="navigation">
                <div style="float: left;    margin-top: 14px;    margin-right: 20px;">
                    
                    <ul class="nav navbar-right list-inline" >
                        <li class="list-inline-item">
                            <a href="javascript:void(0);" class="openNotificationModal right-menu-item" data-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-bell-o" style="color:white;font-size: 20px;"></i>
                                <span class="badge badge-pill badge-blue" style="position: absolute;top: 6px;right: 3px;color:white;">{{ \App\Util\HelperUtil::unread_notification_count() }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- Navigation Menu-->
                {!! $elmenu['elmenu'] !!}
            </div>  
        </div>  
    </div>  
</header>
<div class="user_details-content">
    <div class="user_details_body">
        <div class="font-700 font-14 m-t-10 font_primary_color">
            @php
                $client_name = isset(auth()->user()->client) ? auth()->user()->client->full_name : auth()->user()->name;
                
                if(auth()->user()->last_login_at){
                    $last_login_date = \Carbon\Carbon::parse(auth()->user()->last_login_at);
                }
            @endphp
            {{ $client_name }}
        </div>
        @if(auth()->user()->last_login_at)
            <div class="menu_user_log">@lang('frontsistema.last_admission'): @lang('frontsistema.days.'.$last_login_date->dayOfWeek) {{ $last_login_date->format('d') }} @lang('frontsistema.months.'.$last_login_date->format('m')) {{ $last_login_date->format('Y') }}.<br>{{ $last_login_date->format('H:i:s') }} hrs.</div>
        @else
            <div class="menu_user_log">&nbsp;</div>
        @endif
        <div class="menu_logout text-right m-b-10 m-t-10">
            <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="waves-effect user_logout_button">
                <span>@lang('frontsistema.sign_out')</span>
            </a>
        </div>
    </div>
</div>
 <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>