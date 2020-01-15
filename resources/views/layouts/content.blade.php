
                <!-- Start content -->
                <div class="content">

                    <div class="">
                        <div class="page-header-title">
                            <h4 class="page-title">Dashboard </h4>
                        </div>
                    </div>

                    <div class="page-content-wrapper ">

                        <div class="container">
                            <div class="jumbotron" align="center">
                              <img src="{{asset('assets/images/logo_espacios.png')}}" height="300" />
                            </div>

                            @if(auth()->user()->perfil_id==1)
                            @if(config('starter.dashboard_active'))
                            <div class="row">
                                <div class="col-sm-6 col-lg-3">
                                    <div class="panel">
                                        <div class="panel-body p-t-10">
                                            <div class="widget-box-one">
                                                <i class="ti-user widget-box-icon"></i>
                                                <h4 class="panel-title m-b-15 text-muted font-light">@lang('sistema.dashboard_total_user')</h4>
                                                <h2 class="m-t-0 text-primary m-b-15" id="total_users">{{$extra['total_users']}}</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-sm-6 col-lg-3">
                                    <div class="panel">
                                        <div class="panel-body p-t-10">
                                            <div class="widget-box-one">
                                                <i class="ti-android widget-box-icon"></i>
                                                <h4 class="panel-title text-muted m-b-15 font-light">@lang('sistema.dashboard_total_android')</h4>
                                                <h2 class="m-t-0 text-primary m-b-15" id="total_android">{{$extra['total_android']}}</h2>                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-lg-3">
                                    <div class="panel">
                                        <div class="panel-body p-t-10">
                                            <div class="widget-box-one">
                                                <i class="ti-apple widget-box-icon"></i>
                                                <h4 class="panel-title text-muted m-b-15 font-light">@lang('sistema.dashboard_total_ios')</h4>
                                                <h2 class="m-t-0 text-primary m-b-15" id="total_apple">{{$extra['total_apple']}}</h2>                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                
                            </div>

                            @endif
                            @endif
                            


                            <div class="row">
                                <!--<div class="col-md-12">
                                    <div class="panel">
                                        <div class="panel-body">
                                            <h4 class="m-b-30 m-t-0">Listado de Staff</h4>
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div class="table-responsive">
                                                        <table class="table table-hover m-b-0">
                                                            <thead>
                                                            <tr>
                                                                <th>Nombre</th>
                                                                <th>Departamento</th>                      
                                                            </tr>

                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                                <td>Tiger Nixon</td>
                                                                <td>System Architect</td>                     
                                                            </tr>
                                                            <tr>
                                                                <td>Garrett Winters</td>
                                                                <td>Accountant</td>                      
                                                            </tr>
                                                            

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>-->
                                <!-- end col -->
                            </div>
                            <!-- end row -->


                        </div><!-- container -->


                    </div> <!-- Page content Wrapper -->

                </div> <!-- content -->

                <footer class="footer">
                     © {{ date('Y') }} @lang('sistema.pie')
                </footer>

            