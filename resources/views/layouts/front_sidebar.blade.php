<!-- ========== Left Sidebar Start ========== -->
<div class="left side-menu">
    <div class="slimscroll-menu" id="remove-scroll">
        <!--User basics-->
        <div class="user_basiscs">
            <div class="navbar-default">
                <ul class="nav navbar-right list-inline">
                    <li class="list-inline-item">
                        <div class="dropdown">
                            <a href="javascript:void(0);" class="openNotificationModal right-menu-item dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-bell-o" style="color:white"></i>
                                <span class="badge badge-pill badge-blue" style="color:white">{{ \App\Util\HelperUtil::unread_notification_count() }}</span>
                            </a>
                        </div>
                    </li>
                    <!-- <li class="dropdown user-box list-inline-item">
                        <a href="" class="dropdown-toggle waves-effect user-link" data-toggle="dropdown" aria-expanded="false">
                            <img src="{{ url('assets/images/chat_icon.png')}}" width="27px">
                        </a>
                    </li> -->
                </ul>
            </div>
            <div class="menu_user_info">
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
            <div class="menu_logout text-right"><a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="waves-effect"><span>@lang('frontsistema.sign_out')</span></a></div>
        </div>
        <!--User basics-->
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            {!! $elmenu['elmenu'] !!}
        </div>
        <!-- Sidebar -->
        <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->
</div>