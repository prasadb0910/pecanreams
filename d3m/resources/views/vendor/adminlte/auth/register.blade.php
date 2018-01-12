@extends('adminlte::layouts.auth')

@section('htmlheader_title')
    Register
@endsection

@section('content')

<body class="hold-transition register-page">
    <div id="app" v-cloak>
        <div class="register-box">
            <div class="register-logo">
                <a href="{{ url('/index.php/home') }}"><b>Public Notices</b></a>
            </div>

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

            <div class="register-box-body">
                <p class="login-box-msg">{{ trans('adminlte_lang::message.registermember') }}</p>

                <!-- <register-form></register-form> -->

                <!-- <form action="{{ url('/register') }}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" placeholder="{{ trans('adminlte_lang::message.fullname') }}" name="name" value="{{ old('name') }}" autofocus/>
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    @if (config('auth.providers.users.field','email') === 'username')
                        <div class="form-group has-feedback">
                            <input type="text" class="form-control" placeholder="{{ trans('adminlte_lang::message.username') }}" name="username" autofocus/>
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        </div>
                    @endif

                    <div class="form-group has-feedback">
                        <input type="email" class="form-control" placeholder="{{ trans('adminlte_lang::message.email') }}" name="email" value="{{ old('email') }}"/>
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" placeholder="{{ trans('adminlte_lang::message.password') }}" name="password"/>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" placeholder="{{ trans('adminlte_lang::message.retrypepassword') }}" name="password_confirmation"/>
                        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-1">
                            <label>
                                <div class="checkbox_register icheck">
                                    <label>
                                        <input type="checkbox" name="terms">
                                    </label>
                                </div>
                            </label>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <button type="button" class="btn btn-block btn-flat" data-toggle="modal" data-target="#termsModal">{{ trans('adminlte_lang::message.terms') }}</button>
                            </div>
                        </div>
                        <div class="col-xs-4 col-xs-push-1">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">{{ trans('adminlte_lang::message.register') }}</button>
                        </div>
                    </div>
                </form> -->

                <form method="post">
                    {{ csrf_field() }}
                    <div id="result" class="alert alert-success text-center" style="display: none;"> 
                        User Registered! 
                        <i class="fa fa-refresh fa-spin"></i> Entering...
                    </div> 
                    <div class="form-group has-feedback ">
                        <input type="text" placeholder="Full Name" name="name" value="{{ old('name') }}" autofocus="autofocus" class="form-control"> 
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div> 
                    <div class="form-group has-feedback">
                        <input type="email" placeholder="Email" name="gu_email" value="{{ old('gu_email') }}" class="form-control"> 
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="text" placeholder="Mobile No" name="gu_mobile" value="{{ old('gu_mobile') }}" class="form-control">
                        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" placeholder="Password" name="gu_password" class="form-control"> 
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div> 
                    <div class="form-group has-feedback">
                        <input type="password" placeholder="Retype password" name="gu_password_confirmation" class="form-control">
                    </div> 
                    <div class="row">
                        <div class="col-xs-7">
                            <label>
                                <div class="checkbox_register icheck">
                                    <label data-toggle="modal" data-target="#termsModal">
                                        <div class="icheckbox_square-blue" style="position: relative;">
                                            <input type="checkbox" name="terms" class="has-error" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;">
                                            <ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                        </div> 
                                        <a href="#" class="">Terms and conditions</a>
                                    </label>
                                </div>
                            </label>
                        </div> 
                        <div class="col-xs-4 col-xs-push-1">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
                        </div>
                    </div>
                </form>

                {{-- @include('adminlte::auth.partials.social_login') --}}

                <a href="{{ url('/index.php/login') }}" class="text-center">{{ trans('adminlte_lang::message.membreship') }}</a>
            </div><!-- /.form-box -->
        </div><!-- /.register-box -->
    </div>

    @include('adminlte::layouts.partials.scripts_auth')

    @include('adminlte::auth.terms')

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
