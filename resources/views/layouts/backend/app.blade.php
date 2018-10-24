<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title> @yield('title') - {{ config('app.name', 'Laravel') }} </title>
    <!-- Favicon-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href=" {{asset('assets/backend')}}/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{asset('assets/backend')}}/plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="{{asset('assets/backend')}}/plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Morris Chart Css-->
    <link href="{{asset('assets/backend')}}/plugins/morrisjs/morris.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="{{asset('assets/backend')}}/css/style.css" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="{{asset('assets/backend')}}/css/themes/all-themes.css" rel="stylesheet" />

    <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">


    @stack('css')

</head>


<body class="theme-red">



<!-- Page Loader -->
@include('layouts.backend.partial.page_loader')






<!-- #END# Page Loader -->
<!-- Overlay For Sidebars -->
<div class="overlay"></div>
<!-- #END# Overlay For Sidebars -->
<!-- Search Bar -->



@include('layouts.backend.partial.search_bar')
<!-- #END# Search Bar -->






<!-- Top Bar -->
@include('layouts.backend.partial.topbar')
<!-- #Top Bar -->


{{-- bodysection--}}
<section>
    <!-- Left Sidebar -->
       @include('layouts.backend.partial.sidebar')
    <!-- #END# Right Sidebar -->
</section>


<section class="content">
      @yield('contents')
</section>









<!-- Jquery Core Js -->
<script src="{{asset('assets/backend')}}/plugins/jquery/jquery.min.js"></script>

<!-- Bootstrap Core Js -->
<script src="{{asset('assets/backend')}}/plugins/bootstrap/js/bootstrap.js"></script>

<!-- Select Plugin Js -->
<script src="{{asset('assets/backend')}}/plugins/bootstrap-select/js/bootstrap-select.js"></script>

<!-- Slimscroll Plugin Js -->
<script src="{{asset('assets/backend')}}/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

<!-- Waves Effect Plugin Js -->
<script src="{{asset('assets/backend')}}/plugins/node-waves/waves.js"></script>


<!-- Sparkline Chart Plugin Js -->
<script src="{{asset('assets/backend')}}/plugins/jquery-sparkline/jquery.sparkline.js"></script>

<!-- Custom Js -->
<script src="{{asset('assets/backend')}}/js/admin.js"></script>

<!-- Demo Js -->
<script src="{{asset('assets/backend')}}/js/demo.js"></script>


<script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>

{!! Toastr::message() !!}


@stack('js')


</body>
</html>
