
                <div class="sidebar-inner slimscrollleft">

                    <div class="user-details">
                        <div class="text-center">
                            <!-- Aqui debe de ir la imagen del usuario -->
                            <!--<img src="{{ url('assets/images/users/generic-user.png') }}" alt="" class="img-circle">-->

                            @if(auth()->user()->photo!=null)
                                <img src="{{ auth()->user()->photo }}" alt="{{ auth()->user()->name }}" class="img-circle">
                            @else
                                <img src="{{ url('assets/images/users/generic-user.png') }}" alt="{{ auth()->user()->name }}" class="img-circle">
                            @endif
                            <br><br><small style="color:white;">{{ auth()->user()->name}}</small>
                            
                        </div>
                        
                    </div>
                    <!--- Divider -->


                    <div id="sidebar-menu">

                    {!! $elmenu !!}
                        
                    </div>
                    <div class="clearfix"></div>
                </div> <!-- end sidebarinner -->
            