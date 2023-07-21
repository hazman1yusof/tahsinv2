@extends('layouts.fomantic_main')

@section('title', 'Register')

@section('stylesheet')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lobster&family=Satisfy&display=swap" rel="stylesheet">
@endsection

@section('content')
<!-- Content area -->
<div class="ui container content login">
    <div class="ui centered grid">
        <div class="column" style="max-width: 350px;">
            <form class="ui form" method="POST" autocomplete="off">
                {{ csrf_field() }}
                <div class="ui raised segment" style="background: rgb(121 205 255 / 50%); padding: 20px 20px;">
                    <div class="ui medium rounded image" style="display: flex;justify-content: center;">
                      <img src="{{ asset('img/quran_img.png') }}" style="width: 100px;">
                    </div>
                    <div class="topmenu_title">Keluarga AL-Quran</div>
                    <h4>Registration Form</h4>
                    <div class="field">
                        <input placeholder="Username" pattern=".{3,}" type="text" name="username" autocomplete="off" required>
                    </div>
                    <div class="field">
                        <div class="ui icon input">
                          <input placeholder="Password" type="password" name="password" id="inputPassword" autocomplete="off" pattern=".{3,}" required>
                          <i id="showpwd" class="eye link icon"></i>
                        </div>
                        <span class="meta">password are case-sensitive</span>
                    </div>
                    <div class="field">
                        <input placeholder="Name" type="text" name="name" autocomplete="off" pattern=".{3,}" required>
                    </div>
                    <div class="field">
                      <select name="kelas" required>
                        <option value="">Pilih Kelas</option>
                        @foreach ($kelas as $kelas_obj)
                          <option value="{{$kelas_obj->idno}}">{{ $kelas_obj->name }}</option>
                        @endforeach
                      </select>
                    </div>
                <button class="ui fluid basic button" type="submit" style="margin-top: 10px; background: rgb(255 255 255);"><b>Register</b></button>
                </div>

                
            </form>
        </div>
        
    </div>
    @if($errors->any())
    <div class="ui centered grid">
        <div class="ui error message">
            <div class="header">{{$errors->first()}}</div>
        </div>
    </div>
    @endif
</div>
@endsection

@section('js')
    <script src="{{ asset('js/login.js') }}"></script>
@endsection

@section('css')
<style type="text/css">
    body {
      background-color: #DADADA;
      background-image:url( {{ asset('img/mosque.png') }} ) !important;
      background-repeat: no-repeat !important;
      background-size: cover !important;
      background-position: center !important;
      height: 100% !important;
      width: 100% !important;
    }
    body > .grid {
      height: 100%;
    }
    div.topmenu_title{
        font-family: 'Satisfy', cursive;
        color: white;
        text-align: center;
        letter-spacing: 1px;
        line-height: 32px;
        font-size: 28px;
        padding: 20px 5px;
        text-shadow: 1px 1px 10px #e9bd1e;
        margin-bottom: 20px;
        text-decoration-color: white;
        text-decoration-style: double;
        text-decoration-line: underline;
        text-decoration-thickness: from-font;
    }
    h4{
        margin: 0px 0px 10px 0px;
        text-align: center;
        background: #e0f1ff7d;
        border-radius: 3px;
        padding: 5px;
    }
    span.meta{
        background: #ff0000c2;
        text-align: center;
        display: block;
        color: white;
        border-bottom-right-radius: 5px;
        border-bottom-left-radius: 5px;
        margin-top: -1px;
    }
</style>
@endsection