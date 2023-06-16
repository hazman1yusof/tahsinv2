@extends('layouts.fomantic_main')

@section('title', 'Kelas')

@section('stylesheet')
    <style type="text/css">
        button.myback{
            position: absolute !important;
            left: 10px !important;
            background: none !important;
            top: 2px !important;
        }
    </style>
@endsection

@section('header')
    <script>
        var all_data ={
            oper:'{{$oper}}',
            ispast:'{{$ispast}}'
        }
    </script>
@endsection

@section('content')
    <div class="ui container mycontainer">
        <h4 class="mytitle" style="position: relative;">
            <button class="circular ui icon button myback" onclick="history.back()">
                <i class="arrow left icon"></i>
            </button> 
            Kelas
        </h4>
        <form class="ui form" id="form_addedit_nonpast" autocomplete="off"  style="display:none">
            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="oper" value="{{$oper}}">
            <input type="hidden" name="idno" value="@if(!empty($kelas_detail)){{$kelas_detail->idno}}@endif">
            <input type="hidden" name="action" value="confirm_kelas">
            <input type="hidden" name="kelas_id" value="{{request()->get('kelas_id')}}">
            <input type="hidden" name="user_id" value="{{request()->get('user_id')}}">
            <input type="hidden" name="jadual_id" value="{{request()->get('jadual_id')}}">
            <input type="hidden" name="type" value="{{request()->get('type')}}">
            <input type="hidden" name="date" value="{{request()->get('date')}}">
            <input type="hidden" name="time" value="{{request()->get('time')}}">
            <input type="hidden" name="status" value="@if(!empty($kelas_detail)){{$kelas_detail->status}}@endif">
            <div class="ui attached segment">
                <table >
                    <tr>
                        <th>Kelas</th>
                        <td>{{$kelas->name}}</td>
                    <tr>
                    <tr>
                        <th>Jadual</th>
                        <td>{{$jadual->title}}</td>
                    <tr>
                    <tr>
                        <th>Tarikh</th>
                        <td>{{Carbon\Carbon::createFromFormat('Y-m-d',request()->date)->format('d-m-Y')}}</td>
                    <tr>
                    <tr>
                        <th>Masa</th>
                        <td>{{Carbon\Carbon::createFromFormat('H:i:s',request()->time)->format('g:i A')}}</td>
                    <tr>
                </table>
                <p id="p_confirm" style="display:none">Confirm attending this Class?</p>
                <p id="p_tak_confirm" style="display:none">Cancel attending this Class?</p>
                <div class="ui two column grid">
                  <div class="left attached column" style="padding-right:2px;">
                        <label>Muka Surat</label>
                      <div class="ui fluid input">
                        <input type="number" placeholder="Muka Surat" name="surah" id="surah" value="@if(!empty($kelas_detail)){{$kelas_detail->surah}}@endif">
                      </div>
                  </div>
                  <div class="right attached column" style="padding-left:2px">
                        <label>No. Ayat</label>
                      <div class="ui fluid input">
                        <input type="number" placeholder="No. Ayat" name="ms" id="ms" value="@if(!empty($kelas_detail)){{$kelas_detail->ms}}@endif">
                      </div>
                  </div>
                </div>
                <div class="myflex">
                    
                    
                </div>
            </div>
            <div class="ui two bottom attached buttons">
                <div class="ui positive button" id="confirm" style="display:none">Confirm Class</div>
                <div class="ui negative button" id="tak_confirm" style="display:none">Cancel Class</div>
            </div>
        </form>

        <form class="ui form" id="form_add_past" autocomplete="off" style="display:none">
            <div class="ui attached segment" >
                <p>Class already done and you not attend it, Sorry..</p>
            </div>
        </form>

        <form class="ui form" id="form_edit_past" autocomplete="off" style="display:none">
            <div class="ui attached segment" >
                <p>Class already done and you attend it, congrats..</p>
            </div>
        </form>

    </div>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('css/kelas.css')}}">
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('js/kelas_detail.js') }}"></script>
@endsection


