@extends('layouts.fomantic_main')

@section('title', 'Update My Data')

@section('style')
    
@endsection

@section('header')
<script>
</script>
@endsection

@section('content')
    <div class="ui container mycontainer">
        <h4 class="mytitle" style="position: relative;">
            <button class="circular ui icon button myback" onclick="window.location.href = './dashboard';">
                <i class="arrow left icon"></i>
            </button> 
            Update My Data
        </h4>
        <form id="upd_user_form" autocomplete="off" method="POST">
        <input id="_token" name="_token" value="{{ csrf_token() }}" type="hidden">
        <div class="ui segment attached " id="sgmnt_userdtl">
          <a id="upd_user" class="ui fluid tiny button" style="margin-bottom: 10px;
            border: 1px solid #c3c300;border-top: none;
            margin-top: -14px;background: #ffffe2;
            padding: 5px;
            border-top-right-radius: 0px;
            border-top-left-radius: 0px;">Update yellow box only</a>
            <div class="ui centered grid" >
                <div class="sixteen wide tablet eight wide computer column col_">
                    <span class="col_titl">Username</span>
                    <span class="col_cont">{{$user_detail->name}}</span>
                </div>
                <div class="sixteen wide tablet eight wide computer column col_">
                    <span class="col_titl">Password</span>
                    <input class="col_cont" type="password" name="password" value="{{$user_detail->password}}">
                </div>
                <div class="sixteen wide tablet eight wide computer column col_">
                    <span class="col_titl">Name</span>
                    <input class="col_cont" type="text" name="name" value="{{$user_detail->name}}">
                </div>
                <div class="sixteen wide tablet eight wide computer column col_">
                    <span class="col_titl">User Type</span>
                    <span class="col_cont">{{$user_detail->type}}</span>
                </div>
                <div class="sixteen wide tablet eight wide computer column col_">
                    <span class="col_titl">Kelas</span>
                    <span class="col_cont">{{$user_detail->kelas_name}}</span>
                </div>
                <div class="sixteen wide tablet eight wide computer column col_">
                    <span class="col_titl">Address</span>
                    <textarea class="col_cont" name="address">{{$user_detail->address}}</textarea>
                </div>
                <div class="sixteen wide tablet eight wide computer column col_">
                    <span class="col_titl">Handphone</span>
                    <input class="col_cont" type="number" name="telhp" value="{{$user_detail->telhp}}">
                </div>
                <div class="sixteen wide tablet eight wide computer column col_">
                    <span class="col_titl">I/C</span>
                    <input class="col_cont" type="number" name="newic" value="{{$user_detail->newic}}" placeholder="900115108219">
                </div>
                <div class="sixteen wide tablet eight wide computer column col_">
                    <span class="col_titl">DOB</span>
                    <input class="col_cont" type="date" name="dob" value="{{$user_detail->dob}}">
                </div>
                <div class="sixteen wide tablet eight wide computer column col_">
                    <span class="col_titl">Gender</span>
                    <select class="col_cont" name="gender">
                        <option value="Lelaki" @if($user_detail->gender=='Lelaki'){{'selected'}}@endif>Lelaki</option>
                        <option value="Perempuan" @if($user_detail->gender=='Perempuan'){{'selected'}}@endif>Perempuan</option>
                    </select>
                </div>
                <div class="sixteen wide tablet eight wide computer column col_">
                    <span class="col_titl">Age</span>
                    <span class="col_cont" id="age"></span>
                </div>
            </div>
        </div>
        <div class="ui two bottom attached buttons">
            <div class="ui red button" onClick="window.location.href=window.location.href">Cancel</div>
            <button type="submit" class="ui green button">Update</button>
        </div>
        </form>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('css/setup.css')}}">
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('js/upd_user.js') }}"></script>
@endsection


