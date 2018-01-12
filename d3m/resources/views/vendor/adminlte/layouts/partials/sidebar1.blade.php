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
            <li class="list1">  <a href="{{ url('/index.php/reams') }}"><i class='fa fa-dashboard'></i> <span>REAMS</span></a></li>
            <li class="list1"> <a href="{{ url('/index.php/idata') }}"><i class="fa fa-dashboard"></i> <span>iDATA</span></a></li>
            <li>  <a href="{{ url('/index.php/assure') }}"><i class='fa fa-dashboard'></i> <span>Assure</span></a></li>
        </ul>
        <!-- /.sidebar-menu -->
    </section>

   
    <!-- <span style="position:fixed; bottom:10px; left:20px;color:#fff;">Powered by 
        <a href="https://www.pecanreams.com/" target="_blank"><img src="{{--asset('/img/main-logo.png')--}}" alt="PECAN REAMS" /></a>
    </span> -->
    <!-- /.sidebar -->
</aside>
