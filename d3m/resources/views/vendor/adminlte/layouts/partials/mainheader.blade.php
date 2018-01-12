<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
        @if (session('module')=='public_notice')
        <a href="{{ url('/index.php/home') }}" class="logo" style="background-color: #fff!important; color:#28377a;">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>Assure</b></span>
            <!-- logo for regular state and mobile devices -->
            <!-- <span class="logo-lg"><b style="font-size: 28px; font-family: 'seguibl' !important;">Assure</b></span> -->
            <span class="logo-lg"><img src="{{asset('/img/assure.png')}}" alt="Assure" /></span>
        </a>
        @else
        <a href="{{ url('/index.php/home') }}" class="logo" style="background-color: #fff!important; color:#28377a;">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>iDATA</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b style="font-size: 34px; font-family: 'seguibl' !important;">iDATA</b></span>
        </a>
        @endif
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">{{ trans('adminlte_lang::message.togglenav') }}</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown edit-group"><span  class="text" style="">{{ Auth::user()->name }}</span><p class="user_login" style="">{{ Auth::user()->gu_email }}</p></li>
                <li class="dropdown" id="toggleMenu1">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">  <i class="fa fa-cog"></i></a>
                    <ul class="dropdown-menu " >
                        <li><a href="{{ url('/index.php/home') }}">Dashboard</a></li>
                        <li><a href="{{ url('/index.php/get_user_profile') }}">User Profile</a></li>
                        <li><a href="{{ url('/index.php/get_user') }}">User</a></li>
                        <li><a href="{{ url('/index.php/get_user_roles') }}">User Roles</a></li>
                        <li><a href="#">Help</a></li>
                        <li><a href="#">Support</a></li>
                        <li><a href="" data-toggle="modal" data-target="#change_psw">Change Password</a></li>
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
<!-- Modal -->



<div class="modal fade" id="sign-out" role="dialog">
    <div class="row">
    <div class="col-lg-12">
        <div class="modal-dialog modal-sm">
            <!-- <form id="form_log_out" name="form_log_out" method="post" novalidate> -->
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