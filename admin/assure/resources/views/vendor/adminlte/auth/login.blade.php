@extends('adminlte::layouts.auth')

@section('htmlheader_title')
    Log in
@endsection

@section('content')
<body class="hold-transition login-page">
    <div id="app" v-cloak>
        <div class="login-box">
            <div class="login-logo">
                <!-- <a href="{{-- url('/index.php/home') --}}"><span class="logo-lg"><b style="font-size: 34px; font-family: 'seguibl' !important;">iDATA</b></span></a> -->
                <a href="{{ url('/index.php/home') }}"><img src="{{ asset('/img/main-logo.png') }}" alt="Pecan Reams"/></a>
            </div><!-- /.login-logo -->

        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> {{ trans('adminlte_lang::message.someproblems') }}<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="login-box-body">
        <p class="login-box-msg"> {{ trans('adminlte_lang::message.siginsession') }} </p>

        <!-- <login-form name="{{-- config('auth.providers.users.field','email') --}}"
                    domain="{{-- config('auth.defaults.domain','') --}}"></login-form> -->

        <form method="POST" action="{{ url('index.php/login') }}">
            {{ csrf_field() }}
            
            <div id="result" class="alert alert-success text-center" style="display: none;"> 
                Logged in! 
                <i class="fa fa-refresh fa-spin"></i> 
                Entering...
            </div> 
            <div class="form-group has-feedback">
                <input type="email" placeholder="Email" name="gu_email" value="" autofocus="autofocus" class="form-control"> 
                <span class="glyphicon form-control-feedback glyphicon-envelope"></span> <!---->
            </div> 
            <div class="form-group has-feedback">
                <input type="password" placeholder="Password" name="gu_password" class="form-control"> 
                <span class="glyphicon glyphicon-lock form-control-feedback"></span> <!---->
            </div> 
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <div class="icheckbox_square-blue" style="position: relative;">
                                <input type="checkbox" name="remember" style="display: block; position: absolute; top: -20%; left: -20%; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;">
                                <ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                            </div> 
                            Remember Me
                        </label>
                    </div>
                </div> 
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                </div>
            </div>
        </form>

        


        {{-- @include('adminlte::auth.partials.social_login') --}}

        <a href="{{ url('/index.php/password/reset') }}">{{ trans('adminlte_lang::message.forgotpassword') }}</a><br>
        <a href="{{ url('../../../register.php') }}" class="text-center">{{ trans('adminlte_lang::message.registermember') }}</a>

    </div>

    </div>
    </div>

    @include('adminlte::layouts.partials.scripts_auth')

    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
</body>

@endsection
