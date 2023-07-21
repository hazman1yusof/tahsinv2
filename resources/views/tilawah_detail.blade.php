@extends('layouts.fomantic_main')

@section('title', 'Tilawah')

@section('stylesheet')
@endsection

@section('header')
    <script>
        var ispast = '{{$ispast}}';
        var my_dtl_got = '{{$my_dtl->got}}';
    </script>
@endsection

@section('content')
    <div class="ui container mycontainer">
        <h4 class="mytitle" style="position: relative;">
            <button class="circular ui icon button myback" onclick="window.location.replace('./tilawah');">
                <i class="arrow left icon"></i>
            </button> 
            Kelas
        </h4>

        <form class="ui form" id="form_nonpast" autocomplete="off">

            <h5 class="ui top attached negative message" id="div_error" style="display:none;">
              <i class="warning icon"></i><span id="span_error"></span>
            </h5>

            <div class="ui segment blue user_kd">
              @foreach ($tilawah_dtl as $user)
              <div class="item myitem hadir @if($user->user_id == Auth::user()->id){{'isame'}}@endif">
                @if($user->done == 'true')
                <div class="floating ui yellow label myflabel"><i class="checkmark icon myficon"></i></div>
                @endif
                <div class="ui grid">
                  <div class="one wide column pos">{{intval($user->giliran) + 1}}</div>
                  <div class="twelve wide column name">{{$user->name}}</div>
                  <div class="three wide column ms">ms{{$user->ms1}} - ms{{$user->ms2}}</div>
                </div>
              </div>
              @endforeach
            </div>

            <div class="ui attached green segment div_past" style="display:none">
              <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
              <input type="hidden" name="action" value="tilawah_dtl_save">
              <input type="hidden" name="oper" id="oper">
              <input type="hidden" name="giliran" id="giliran" value="@if($my_dtl->got){{$my_dtl->giliran}}@endif">
              <input type="hidden" name="user_id" id="user_id" value="@if($my_dtl->got){{$my_dtl->user_id}}@endif">
              <input type="hidden" name="ms1" id="ms1" value="@if($my_dtl->got){{$my_dtl->ms1}}@endif">
              <input type="hidden" name="ms2" id="ms2" value="@if($my_dtl->got){{$my_dtl->ms2}}@endif">
              <input type="hidden" name="date" id="date" value="@if($my_dtl->got){{$my_dtl->date}}@endif">
              <table>
                <tr>
                    <th style="text-align:left;">Giliran</th>
                    <td>No. {{$my_dtl->giliran + 1}}</td>
                <tr>
                <tr>
                    <th style="text-align:left;">Nama</th>
                    <td>{{Auth::user()->name}}</td>
                <tr>
                <tr>
                    <th style="text-align:left;">Muka Surat Dari</th>
                    <td>M/S : {{$my_dtl->ms1}}</td>
                <tr>
                <tr>
                    <th style="text-align:left;">Muka Surat Hingga</th>
                    <td>M/S : {{$my_dtl->ms2}}</td>
                <tr>
                <tr>
                    <th style="text-align:left;">Tarikh</th>
                    <td>{{Carbon\Carbon::createFromFormat('Y-m-d',$my_dtl->date)->format('d-m-Y')}}</td>
                <tr>
              </table>
            </div>

            <div class="ui two bottom attached buttons div_past" style="display:none">
                <div class="ui negative button" id="tak_confirm">Not yet</div>
                <div class="ui positive button" id="confirm">Done</div>
            </div>
        </form>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('css/kelas.css')}}">
@endsection

@section('js')
<script src='https://cdn.jsdelivr.net/npm/moment@2.27.0/min/moment.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script type="text/javascript" src="{{ asset('js/tilawah_detail.js') }}"></script>
@endsection