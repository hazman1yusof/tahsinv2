<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1" charset="utf-8">
        <link rel="icon" href="/favicon.ico" type="image/x-icon">

        <title>@yield('title')</title>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fomantic-ui@2.9.2/dist/semantic.min.css">
        <link href="https://cdn.datatables.net/v/se/dt-1.13.4/r-2.4.1/datatables.min.css" rel="stylesheet"/>
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/3.2.1/css/font-awesome.css">
        <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

        <link rel="preconnect" href="https://fonts.gstatic.com">
        <style>@import url('https://fonts.googleapis.com/css2?family=Lobster&display=swap');</style>
        <link href="https://fonts.googleapis.com/css2?family=Inknut+Antiqua:wght@300;500&family=Open+Sans:wght@300;700&family=Syncopate&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">
        @yield('stylesheet')

        <style type="text/css">
            
        </style>

        @yield('css')
        @yield('header')

    </head>
    <body>
        <div class="preloader">
            <div class="cssload-speeding-wheel"></div>
        </div>

        @if(!Request::is('login') && !Request::is('register'))
            @include('layouts.navs')
        @endif
        <div class="pusher container_sem overflowing" id="content">
            @yield('content')
        </div>
    </body>


    
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/fomantic-ui@2.9.2/dist/semantic.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
    <script src="https://cdn.datatables.net/v/se/dt-1.13.4/r-2.4.1/datatables.min.js"></script>
    <script type="text/ecmascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

    <script src="{{ asset('js/utility.js') }}?v=1"></script>
    <script src="{{ asset('js/main.js') }}?v=1"></script>

    <script type="text/javascript">
        $( document ).ready(function() {
            $(".preloader").fadeOut();
        });
    </script>  
    
    @yield('js')
</html>