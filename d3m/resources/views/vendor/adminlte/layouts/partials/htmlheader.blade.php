<head>
    <meta charset="UTF-8">
    <!-- @if (session('module')=='public_notice')
        <title> @yield('htmlheader_title', 'Public Notices') </title>
    @else
        <title> @yield('htmlheader_title', 'D3M') </title>
    @endif -->
    <title>Pecan Reams – iData Dashboard Log In  </title>
    
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="Description" content="Get access to your iData real estate analytics tool dashboard.">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('/css/all.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/validation/screen.css') }}" rel="stylesheet" type="text/css" />
    <link type="text/css" media="screen" rel="stylesheet" href="{{ asset('/css/jquery.cropbox.css') }}">
    <link href="{{ asset('/plugins/datepicker/datepicker3.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/dataTable.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/logo.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/export.css') }}" rel="stylesheet" type="text/css" />

	
    @yield('styles')

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script>
        //See https://laracasts.com/discuss/channels/vue/use-trans-in-vuejs
        window.trans = @php
            // copy all translations from /resources/lang/CURRENT_LOCALE/* to global JS variable
            $lang_files = File::files(resource_path() . '/lang/' . App::getLocale());
            $trans = [];
            foreach ($lang_files as $f) {
                $filename = pathinfo($f)['filename'];
                $trans[$filename] = trans($filename);
            }
            $trans['adminlte_lang_message'] = trans('adminlte_lang::message');
            echo json_encode($trans);
        @endphp
    </script>
</head>
