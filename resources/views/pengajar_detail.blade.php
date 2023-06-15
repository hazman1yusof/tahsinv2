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
            ispast:'{{$ispast}}'
        }

        var kelas_detail={
            kelas_id:'{{$kelas->idno}}',
            jadual_id:'{{$jadual->idno}}',
            type:'{{$jadual->type}}',
            date:'{{request()->get("date")}}',
            time:'{{$jadual->time}}'
        }

    </script>
@endsection

@section('content')
    <div class="ui container mycontainer">
        <h4 class="mytitle" style="position: relative;">
            <button class="circular ui icon button myback" onclick="history.back()">
                <i class="arrow left icon"></i>
            </button> 
            Kelas {{$kelas->name}}
        </h4>

        <table id="dt_kelas_detail" class="ui celled table" style="width:100%">
            <thead>
                  <tr>
                      <th>Name</th>
                      <th>Surah</th>
                      <th>M/S</th>
                  </tr>
            </thead>
        </table>
    </div>

    <div class="ui modal" id="mdl_kelas_detail">
      <div class="header">
        Pelajar : <span id="span_name"></span>
      </div>
      <div class="content">
        <form class="ui form" id="form_kelas_detail" autocomplete="off">
          <input id="_token" name="_token" value="{{ csrf_token() }}" type="hidden">
          <input type="hidden" name="idno">
          <label>Remarks</label>
          <textarea></textarea>
        </form>
      </div>
      <div class="actions">
        <button class="ui deny button" id="cancel_kelas_detail">
          Cancel
        </button>
        <button class="ui positive right labeled icon button" id="save_kelas_detail">
          Save
          <i class="checkmark icon"></i>
        </button>
      </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('css/kelas.css')}}">
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('js/pengajar_detail.js') }}"></script>
@endsection


