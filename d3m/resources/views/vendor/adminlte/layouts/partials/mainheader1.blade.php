<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
        <a href="{{ url('/index.php/home') }}" class="logo" style="background-color: #fff; color:#28377a; height: 55px;">
            <span class="logo-mini"><b>PECAN</b></span>
            <span class="logo-lg"><img src="{{asset('/img/main-logo.png')}}" alt="Pecan Reams" /></span>
        </a>

        @if (session('module')=='public_notice')
        <!-- <a href="{{-- url('/index.php/home') --}}" class="logo" style="background-color: #ecf0f5; color:#28377a;">
            <span class="logo-mini"><b>Assure</b></span>
            <span class="logo-lg"><img src="{{--asset('/img/assure.png')--}}" alt="Assure" /></span>
        </a> -->
        @else
        <!-- <a href="{{-- url('/index.php/home') --}}" class="logo" style="background-color: #ecf0f5; color:#28377a;">
            <span class="logo-mini"><b>iDATA</b></span>
            <span class="logo-lg"><b style="font-size: 28px; font-family: 'seguibl' !important;">iDATA</b></span>
        </a> -->
        @endif

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">{{ trans('adminlte_lang::message.togglenav') }}</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-envelope-o"></i>
                        <span class="label label-success">4</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">{{ trans('adminlte_lang::message.tabmessages') }}</li>
                        <li>
                            <ul class="menu">
                                <li>
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="{{-- Gravatar::get($user->email) --}}" class="img-circle" alt="User Image"/>
                                        </div>
                                        <h4>
                                            {{ trans('adminlte_lang::message.supteam') }}
                                            <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                        </h4>
                                        <p>{{ trans('adminlte_lang::message.awesometheme') }}</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="footer"><a href="#">c</a></li>
                    </ul>
                </li> -->

                <!-- Notifications Menu -->
                <!-- <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-warning">10</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">{{ trans('adminlte_lang::message.notifications') }}</li>
                        <li>
                            <ul class="menu">
                                <li>
                                    <a href="#">
                                        <i class="fa fa-users text-aqua"></i> {{ trans('adminlte_lang::message.newmembers') }}
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="footer"><a href="#">{{ trans('adminlte_lang::message.viewall') }}</a></li>
                    </ul>
                </li> -->

                <!-- Tasks Menu -->
                <!-- <li class="dropdown tasks-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-flag-o"></i>
                        <span class="label label-danger">9</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">{{ trans('adminlte_lang::message.tasks') }}</li>
                        <li>
                            <ul class="menu">
                                <li>
                                    <a href="#">
                                        <h3>
                                            {{ trans('adminlte_lang::message.tasks') }}
                                            <small class="pull-right">20%</small>
                                        </h3>
                                        <div class="progress xs">
                                            <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                <span class="sr-only">20% {{ trans('adminlte_lang::message.complete') }}</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="footer">
                            <a href="#">{{ trans('adminlte_lang::message.alltasks') }}</a>
                        </li>
                    </ul>
                </li> -->

                <li class="dropdown edit-group"><span  class="text" style="">{{ Auth::user()->name }}</span><p class="user_login" style="">{{ Auth::user()->gu_email }}</p></li>
                <li class="dropdown" id="toggleMenu1">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">  <i class="fa fa-cog"></i></a>
                    <ul class="dropdown-menu " >
                        <li><a href="{{ url('/index.php/home') }}">Dashboard</a></li>
                        <li><a href="{{ url('/index.php/get_user_profile') }}">User Profile</a></li>
                        <!-- <li><a href="{{-- url('/index.php/get_user') --}}">User</a></li> -->
                        <!-- <li><a href="{{-- url('/index.php/get_user_roles') --}}">User Roles</a></li> -->
                        <li><a href="#">Help</a></li>
                        <li><a href="#">Support</a></li>
                        <li><a href=""  data-toggle="modal" data-target="#change_psw" >Change Password</a></li>
                    </ul>
                </li>
                
                @if (Auth::guest())
                    <li><a href="{{ url('/index.php/register') }}">{{ trans('adminlte_lang::message.register') }}</a></li>
                    <li><a href="{{ url('/index.php/login') }}">{{ trans('adminlte_lang::message.login') }}</a></li>
                @else
                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu" id="user_menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" id="sign_out"  data-toggle="modal" data-target="#sign-out">
                            <!-- The user image in the navbar-->
                
                            <i class="fa fa-sign-out"></i>
                            
                        </a>
                      
                    </li>
                @endif

                <!-- Control Sidebar Toggle Button -->
                <!-- <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li> -->
            </ul>
        </div>
    </nav>
</header>


<div class="modal fade" id="change_psw" role="dialog">
    <div class="row">
    <div class="col-lg-12">
        <div class="modal-dialog modal-sm">
        	<form id="form_change_password" name="form_change_password" method="post">
        	    {{ csrf_field() }}
                <div class="modal-content">
                    <div class="modal-header" style="background:#f1f1f1">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-check"></i> Change Password</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label>Old Password *</label>
                            <input type="password" class="form-control" id="old_password" name="old_password" value="" placeholder="Enter Old Password...">
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
            		 	    <label>New Password *</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" value="" placeholder="Enter New Password...">
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label>Confirm Password *</label>
                            <input type="password" class="form-control" id="confirm_new_password" name="confirm_new_password" value="" placeholder="Enter Confirm Password...">
                        </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <br/>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-success pull-left" id="btn_change_password">Submit</button>
                        </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
</div>

<div class="modal fade" id="sign-out" role="dialog">
    <div class="row">
    <div class="col-lg-12">
        <div class="modal-dialog modal-sm">
            <!-- <form id="form_log_out" name="form_log_out" method="post"> -->
                {{-- csrf_field() --}}
                <div class="modal-content">
                    <div class="modal-header" style="background:#f1f1f1">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-sign-out"></i>  Log Out ?</h4>
                    </div>
                    <div class="modal-body">
                       <p>Are you sure you want to log out?</p>
                       <p>Press No if you want to continue work. Press Yes to logout current user.</p>
                    </div>
                    <div class="modal-footer">
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <br/>
                            <button type="button" style="margin-left:10px" class="btn btn-danger pull-right" data-dismiss="modal">No</button>
                          <!--<button type="button" class="btn btn-success pull-right" id="btn_change_password">Yes</button>-->
                          <a href="{{ url('/index.php/logout') }}" class="btn btn-success pull-right" id="logout"
                                       onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                       Yes
                                    </a>


                            <form id="logout-form" action="{{ url('/index.php/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                                <input type="submit" value="logout" style="display: none;">
                            </form>
                        </div>
                        </div>
                    </div>
                </div>
            <!-- </form> -->
        </div>
    </div>
    </div>
</div>
<!-- Modal