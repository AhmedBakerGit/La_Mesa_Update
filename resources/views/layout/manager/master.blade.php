<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"> <!-- Favicon-->
        <title>@yield('title') - {{ config('app.name') }}</title>
        <meta name="description" content="@yield('meta_description', config('app.name'))">
        <meta name="author" content="@yield('meta_author', config('app.name'))">
        @yield('meta')

        {{-- See https://laravel.com/docs/5.5/blade#stacks for usage --}}
        @stack('before-styles')

        <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/vendor/jvectormap/jquery-jvectormap-2.0.3.min.css') }}"/>
        <link rel="stylesheet" href="{{ asset('assets/vendor/morrisjs/morris.min.css') }}" />
 
        <!-- Custom Css -->
        <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/color_skins.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">

        <link rel="stylesheet" href="{{ asset('assets/vendor/sweetalert/sweetalert.css') }}"/>

        <link rel="stylesheet" href="{{ asset('assets/vendor/jquery-datatable/dataTables.bootstrap4.min.css') }}"/>
        <link rel="stylesheet" href="{{ asset('assets/vendor/jquery-datatable/fixedeader/dataTables.fixedcolumns.bootstrap4.min.css') }}"/>
        <link rel="stylesheet" href="{{ asset('assets/vendor/jquery-datatable/fixedeader/dataTables.fixedheader.bootstrap4.min.css') }}"/>
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap-notifications.min.css') }}">

        @stack('after-styles')

        @if (trim($__env->yieldContent('page-styles')))
            @yield('page-styles')
        @endif

    </head>
    
    <?php 
        $setting = !empty($_GET['theme']) ? $_GET['theme'] : '';
        $theme = "theme-cyan";
        $menu = "";
        if ($setting == 'p') {
            $theme = "theme-purple";
        } else if ($setting == 'b') {
            $theme = "theme-blue";
        } else if ($setting == 'g') {
            $theme = "theme-green";
        } else if ($setting == 'o') {
            $theme = "theme-orange";
        } else if ($setting == 'bl') {
            $theme = "theme-blush";
        } else {
             $theme = "theme-cyan";
        }

    ?>

    <body class="<?= $theme ?>">

        <!-- Page Loader -->
        <div class="page-loader-wrapper">
            <div class="loader">
                <div class="m-t-30"><img src="{{url('/')}}/assets/img/logo-icon.svg" width="48" height="48" alt="Lucid"></div>
                <p>Please wait...</p>        
            </div>
        </div>

        <div id="wrapper">

            @include('layout.manager.navbar')
            @include('layout.manager.sidebar')

            <div id="main-content">
                <div class="container-fluid">
                    <div class="block-header">
                        <div class="row">
                            <div class="col-lg-5 col-md-8 col-sm-12">                        
                                <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> @yield('title')</h2>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><i class="icon-home"></i></li>
                                    @if (trim($__env->yieldContent('parentPageTitle')))
                                       <li class="breadcrumb-item">@yield('parentPageTitle')</li>
                                    @endif
                                    @if (trim($__env->yieldContent('title')))
                                        <li class="breadcrumb-item active">@yield('title')</li>
                                    @endif
                                </ul>
                            </div>
                            
                            <div class="col-lg-7 col-md-4 col-sm-12 text-right">
                                @yield('content-top-right')
                            </div>
                        </div>
                    </div>
                    
                    @yield('content')

                </div>
            </div>

        </div>

        <!-- Scripts -->
        @stack('before-scripts')

        <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>    
        <script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script>
        
        <script src="{{ asset('assets/bundles/morrisscripts.bundle.js') }}"></script><!-- Morris Plugin Js -->
        <script src="{{ asset('assets/bundles/jvectormap.bundle.js') }}"></script> <!-- JVectorMap Plugin Js -->
        <script src="{{ asset('assets/bundles/knob.bundle.js') }}"></script>

        <script src="{{ asset('assets/vendor/sweetalert/sweetalert.min.js') }}"></script>

        <script src="{{ asset('assets/bundles/datatablescripts.bundle.js') }}"></script>
        <script src="{{ asset('assets/vendor/jquery-datatable/buttons/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/jquery-datatable/buttons/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/jquery-datatable/buttons/buttons.colVis.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/jquery-datatable/buttons/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/jquery-datatable/buttons/buttons.print.min.js') }}"></script>


        @if (Request::segment(2) === 'staffs' )
            <script src="{{ asset('assets/js/pages/manager/staff.js') }}"></script>
        @endif
        @if (Request::segment(2) === 'menu' )
            <script src="{{ asset('assets/js/pages/manager/menu.js') }}"></script>
        @endif

        <script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
        <script src="{{ asset('assets/js/pages/api_comm.js') }}"></script>

        {{-- Firebase FireStore Setting --}}
        <script src="https://www.gstatic.com/firebasejs/8.2.3/firebase-app.js"></script>
        <script src="https://www.gstatic.com/firebasejs/8.2.3/firebase-firestore.js"></script>

        <script>
            var firebaseConfig = {
                apiKey: "AIzaSyAeRHLeTobFbx-nAEIgcDy9jc1omskzhNE",
                authDomain: "la-mesa-4cfae.firebaseapp.com",
                databaseURL: "https://la-mesa-4cfae-default-rtdb.firebaseio.com",
                projectId: "la-mesa-4cfae",
                storageBucket: "la-mesa-4cfae.appspot.com",
                messagingSenderId: "334301508320",
                appId: "1:334301508320:web:550e32d0989a30bcbcd685",
                measurementId: "G-TYZT4KYQF3"
            };
            firebase.initializeApp(firebaseConfig);
            
        </script>

        <script src="{{ asset('assets/js/pages/manager/orderNotification.js') }}"></script>
        <script src="{{ asset('assets/js/pages/manager/requestNotification.js') }}"></script>

        @if (Request::segment(2) === 'orders' )
            <script src="{{ asset('assets/js/pages/manager/orders.js') }}"></script>
        @endif

        @if (Request::segment(2) === 'request' )
            <script src="{{ asset('assets/js/pages/manager/request.js') }}"></script>
        @endif

        @if (Request::segment(2) === 'bills' )
            <script src="{{ asset('assets/js/pages/manager/bills.js') }}"></script>
        @endif

        @stack('after-scripts')

        @if (trim($__env->yieldContent('page-script')))
            <script>
                @yield('page-script')
            </script>
        @endif

    </body>
</html>
