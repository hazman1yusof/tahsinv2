<div class="ui fixed top menu sidemenu" id="sidemenu_topmenu" style="z-index: 5000;">
    <a class="item" id="showSidebar" style="padding: 20px 15px 20px 15px !important;"><img src="{{ asset('img/quran.png')}}"></a>
    <span class="topmenu_title">Keluarga AL-Quran</span>
    <div class="right menu">
        <div class="ui simple dropdown item" style="padding: 13px 0px !important;">
        <span class="himsg">{{Auth::user()->username}}<i class="dropdown icon"></i></span>
          <div class="menu">
            <a class="item"><i class="edit icon"></i>Change Password</a>
            <a class="item" href="./logout"><i class="sign out alternate icon"></i>Log Out</a>
          </div>
        </div>
    </div>
</div>

<div class="ui sidebar inverted vertical menu sidemenu">
    <a class="item @if(Request::is('dashboard')) {{'active'}} @endif" href="{{ url('/dashboard')}}"><i style="float: left" class="big home icon"></i>Dashboard</a>
    <a class="item @if(Request::is('kelas')) {{'active'}} @endif" href="{{ url('/kelas')}}"><i style="float: left" class="big chalkboard teacher icon"></i>Jadual Saya</a>
    <div class="item">
         <div class="header">Pengajar </div>
        <a class="item @if(Request::is('pengajar')){{'active'}} @endif" href="{{ url('/pengajar')}}"><i style="float: left" class="big user graduate icon"></i>Jadual Pengajar </a>
    </div>
    <div class="item">
         <div class="header">Setup </div>
        <a class="item @if(Request::is('setup_user')){{'active'}} @endif" href="{{ url('/setup_user')}}"><i style="float: left" class="big users icon"></i>Setup Pelajar</a>
        <a class="item @if(Request::is('setup_kelas')){{'active'}} @endif" href="{{ url('/setup_kelas')}}"><i style="float: left" class="big chalkboard icon"></i>Setup Kelas</a>
        <a class="item @if(Request::is('setup_jadual')){{'active'}} @endif" href="{{ url('/setup_jadual')}}"><i style="float: left" class="big chalkboard teacher icon"></i>Setup Jadual</a>
    </div>
</div>