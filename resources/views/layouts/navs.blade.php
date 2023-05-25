<div class="ui fixed top menu sidemenu" id="sidemenu_topmenu" style="z-index: 5000;">
    <a class="item" id="showSidebar" style="padding: 20px 25px 15px 25px !important;"><i class="sidebar inverted icon"></i></a>
    <div class="right menu">
    </div>
</div>

<div class="ui sidebar inverted vertical menu sidemenu">
    <a class="item @if(Request::is('rph') || Request::is('rph/*')) {{'active'}} @endif" href="{{ url('/rph')}}"><i style="float: left" class="big chalkboard teacher icon"></i>RPH</a>
    <a class="item @if(Request::is('setup_jadual') || Request::is('setup_jadual/*')) {{'active'}} @endif" href="{{ url('/setup_jadual')}}"><i style="float: left" class="big calendar alternate outline icon"></i>Setup Jadual</a>
</div>