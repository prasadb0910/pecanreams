<!-- Left side column. contains the logo and sidebar -->

<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <!-- @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{-- Gravatar::get($user->gu_email) --}}" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p>{{-- Auth::user()->name --}}</p>
                    <i class="fa fa-circle text-success"></i> {{-- trans('adminlte_lang::message.online') --}}
                </div>
            </div>
        @endif -->

        <!-- search form (Optional) -->
        <!-- <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="{{-- trans('adminlte_lang::message.search') --}}..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
        </form> -->
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <!-- <li class="header">{{-- trans('adminlte_lang::message.header') --}}</li> -->
            <!-- Optionally, you can add icons to the links -->
            <!-- <li><a href="{{-- url('index.php/home') --}}"><i class='fa fa-home'></i> <span>{{-- trans('adminlte_lang::message.home') --}}</span></a></li> -->

            @if (session('module')=='public_notice')
                <li class= "reams1"><a href="{{ url('index.php/reams') }}"><i class='fa fa-tachometer'></i> <span>REAMS</span></a></li>
                <!-- <li class= "idata1"><a href="{{-- url('index.php/idata') --}}"><i class='fa fa-tachometer'></i> <span>iDATA</span></a></li> -->
                <li class="active treeview">
                    <a href="#">
                        <i class="fa fa-dashboard"></i> <span>Assure</span>
                        <span class="pull-right-container">
                            <i class="fa fa-caret-down pull-right"></i>
                        </span>
                    </a>
                    <!-- <ul class="treeview-menu"> -->
                        <li><a href="{{ url('index.php/dashboard') }}"><i class='fa fa-tachometer'></i> <span>Dashboard</span></a></li>        

                        @if (isset($access['UserGroups']))
                        @if ($access['UserGroups']['r_view']=='1' || $access['UserGroups']['r_insert']=='1' || $access['UserGroups']['r_edit']=='1' || $access['UserGroups']['r_delete']=='1' || $access['UserGroups']['r_approvals']=='1' || $access['UserGroups']['r_export']=='1')
                        <li><a href="{{ url('index.php/group') }}"><i class='fa fa fa-users'></i> <span>Groups</span></a></li>
                        @endif
                        @endif

                        <!-- @if (isset($access['Newspapers']))
                        @if ($access['Newspapers']['r_view']=='1' || $access['Newspapers']['r_insert']=='1' || $access['Newspapers']['r_edit']=='1' || $access['Newspapers']['r_delete']=='1' || $access['Newspapers']['r_approvals']=='1' || $access['Newspapers']['r_export']=='1')
                        <li><a href="{{-- url('index.php/newspapers') --}}"><i class='fa fa-newspaper-o'></i> <span>Newspapers</span></a></li>
                        @endif
                        @endif
                        @if (isset($access['NoticeTypes']))
                        @if ($access['NoticeTypes']['r_view']=='1' || $access['NoticeTypes']['r_insert']=='1' || $access['NoticeTypes']['r_edit']=='1' || $access['NoticeTypes']['r_delete']=='1' || $access['NoticeTypes']['r_approvals']=='1' || $access['NoticeTypes']['r_export']=='1')
                        <li><a href="{{-- url('index.php/notice_type') --}}"><i class='fa fa-list'></i> <span>Notice Types</span></a></li>
                        @endif
                        @endif
                        @if (isset($access['Notices']))
                        @if ($access['Notices']['r_view']=='1' || $access['Notices']['r_insert']=='1' || $access['Notices']['r_edit']=='1' || $access['Notices']['r_delete']=='1' || $access['Notices']['r_approvals']=='1' || $access['Notices']['r_export']=='1')
                        <li><a href="{{-- url('index.php/notice') --}}"><i class='fa fa-exclamation-triangle'></i> <span>Notices</span></a></li>
                        @endif
                        @endif
                        @if (isset($access['PropertyNotices']))
                        @if ($access['PropertyNotices']['r_view']=='1' || $access['PropertyNotices']['r_insert']=='1' || $access['PropertyNotices']['r_edit']=='1' || $access['PropertyNotices']['r_delete']=='1' || $access['PropertyNotices']['r_approvals']=='1' || $access['PropertyNotices']['r_export']=='1')
                        <li><a href="{{-- url('index.php/property_notice') --}}"><i class='fa fa-bullhorn'></i> <span>Property Notices</span></a></li>
                        @endif
                        @endif -->

                        @if (isset($access['Properties']))
                        @if ($access['Properties']['r_view']=='1' || $access['Properties']['r_insert']=='1' || $access['Properties']['r_edit']=='1' || $access['Properties']['r_delete']=='1' || $access['Properties']['r_approvals']=='1' || $access['Properties']['r_export']=='1')
                        <li><a href="{{ url('index.php/property') }}"><i class='fa fa-building-o'></i> <span>Properties</span></a></li>
                        @endif
                        @endif
                        @if (isset($access['UserNotices']))
                        @if ($access['UserNotices']['r_view']=='1' || $access['UserNotices']['r_insert']=='1' || $access['UserNotices']['r_edit']=='1' || $access['UserNotices']['r_delete']=='1' || $access['UserNotices']['r_approvals']=='1' || $access['UserNotices']['r_export']=='1')
                        <li><a href="{{ url('index.php/user_notice') }}"><i class='fa fa-exclamation-triangle'></i> <span>Alerts</span></a></li>
                        @endif
                        @endif

                        <!-- @if (isset($access['Users']))
                        @if ($access['Users']['r_view']=='1' || $access['Users']['r_insert']=='1' || $access['Users']['r_edit']=='1' || $access['Users']['r_delete']=='1' || $access['Users']['r_approvals']=='1' || $access['Users']['r_export']=='1')
                        <li><a href="{{-- url('index.php/user') --}}"><i class='fa fa-user-plus'></i> <span>Users</span></a></li>
                        @endif
                        @endif
                        @if (isset($access['AdminProperties']))
                        @if ($access['AdminProperties']['r_view']=='1' || $access['AdminProperties']['r_insert']=='1' || $access['AdminProperties']['r_edit']=='1' || $access['AdminProperties']['r_delete']=='1' || $access['AdminProperties']['r_approvals']=='1' || $access['AdminProperties']['r_export']=='1')
                        <li><a href="{{-- url('index.php/property') --}}"><i class='fa fa-building-o'></i> <span>Properties</span></a></li>
                        @endif
                        @endif
                        @if (isset($access['Payments']))
                        @if ($access['Payments']['r_view']=='1' || $access['Payments']['r_insert']=='1' || $access['Payments']['r_edit']=='1' || $access['Payments']['r_delete']=='1' || $access['Payments']['r_approvals']=='1' || $access['Payments']['r_export']=='1')
                        <li><a href="{{-- url('index.php/user_payment_detail') --}}"><i class='fa fa-credit-card '></i> <span>Payments</span></a></li>
                        @endif
                        @endif -->

                        @if (isset($access['UserPayments']))
                        @if ($access['UserPayments']['r_view']=='1' || $access['UserPayments']['r_insert']=='1' || $access['UserPayments']['r_edit']=='1' || $access['UserPayments']['r_delete']=='1' || $access['UserPayments']['r_approvals']=='1' || $access['UserPayments']['r_export']=='1')
                        <li><a href="{{ url('index.php/user_payment_detail/list1') }}"><i class='fa fa-credit-card '></i> <span>Payments</span></a></li>
                        @endif
                        @endif

                        @if (isset($access['UserPayments']))
                        @if ($access['UserPayments']['r_view']=='1' || $access['UserPayments']['r_insert']=='1' || $access['UserPayments']['r_edit']=='1' || $access['UserPayments']['r_delete']=='1' || $access['UserPayments']['r_approvals']=='1' || $access['UserPayments']['r_export']=='1')
                        <li><a href="{{ url('index.php/user_payment_detail/plan') }}"><i class='fa fa-shopping-cart '></i> <span>Plan</span></a></li>
                        @endif
                        @endif
                    <!-- </ul> -->
                </li>
            @else
                <li class= "reams1"><a href="{{ url('index.php/reams') }}"><i class='fa fa-tachometer'></i> <span>REAMS</span></a></li>
                <li class="active treeview">
                    <a href="#">
                        <i class="fa fa-dashboard"></i> <span>iDATA</span>
                        <span class="pull-right-container">
                            <i class="fa fa-caret-down pull-right"></i>
                        </span>
                    </a>
                    <!-- <ul class="treeview-menu"> -->
                        <li><a href="{{ url('index.php/dashboard') }}"><i class='fa fa-tachometer'></i> <span>Dashboard</span></a></li>
                        <li><a href="{{ url('index.php/developer') }}"><i class='fa fa-group'></i> <span>Developer Level</span></a></li>
                        <li><a href="{{ url('index.php/search') }}"><i class="fa fa-search"></i> <span>Search</span></a></li>
                        <li><a href="{{ url('index.php/compare') }}"><i class='fa fa-balance-scale'></i> <span>Compare</span></a></li>
                        <li><a href="{{ url('index.php/user_feedback') }}"><i class='fa fa-reply-all'></i> <span>User Feedback</span></a></li>
                    <!-- </ul> -->
                </li>
                <li class= "assure1"><a href="{{ url('index.php/assure') }}"><i class='fa fa-tachometer'></i> <span>Assure</span></a></li>
                <!-- <li><a href="{{ url('index.php/project') }}"><i class='fa fa-search'></i> <span>Project</span></a></li> -->
            @endif

            <!-- <li><a href="#"><i class='fa fa-link'></i> <span>{{-- trans('adminlte_lang::message.anotherlink') --}}</span></a></li> -->
            <!-- <li class="treeview">
                <a href="#"><i class='fa fa-link'></i> <span>{{-- trans('adminlte_lang::message.multilevel') --}}</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="#">{{-- trans('adminlte_lang::message.linklevel2') --}}</a></li>
                    <li><a href="#">{{-- trans('adminlte_lang::message.linklevel2') --}}</a></li>
                </ul>
            </li> -->


			
                @if (session('module')=='public_notice')
                <!-- <li class="menus">
                    <a href="{{-- url('/index.php/reams') --}}" class="logo" target="_blank" style="bottom: 135px !important;"> <i class='fa fa-reply'></i>
                        <img src="{{--asset('/img/main-logo.png')--}}" alt="Reams" />
                    </a>
                </li>
                <li class="menus">  
                    <a href="{{-- url('/index.php/idata') --}}" class="logo"> <i class='fa fa-reply'></i>
                        <span class="logo-lg"> <b style="font-family:'seguibl' !important;font-size:x-large;text-align:center;">iDATA</b></span>
                    </a>   
                </li> -->
                @else
                <!-- <li class="menus">
                    <a href="{{-- url('/index.php/reams') --}}" class="logo" target="_blank" style="bottom: 135px !important;"> <i class='fa fa-share'></i>
                        <img src="{{--asset('/img/main-logo.png')--}}" alt="Reams" />
                    </a>
                </li>
                <li class="menus">
                    <a href="{{-- url('/index.php/assure') --}}" class="logo">  <i class='fa fa-share'></i>
                        <span class="logo-lg" style=""><b style="font-family:'seguibl' !important;"><img src="{{--asset('/img/assure.png')--}}"></b></span>&nbsp
                    </a> 
                </li> -->
                @endif

        </ul><!-- /.sidebar-menu -->
    </section>

   
    <!-- <span style="position:fixed; bottom:10px; left:20px;color:#fff;">Powered by 
        <a href="https://www.pecanreams.com/" target="_blank"><img src="{{--asset('/img/main-logo.png')--}}" alt="PECAN REAMS" /></a>
    </span> -->
    <!-- /.sidebar -->
</aside>
