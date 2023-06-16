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
                      <th>Status</th>
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

            <div class="ui segment tertiary inverted blue">
                <a class="ui blue ribbon label">Muka Surat Sebelum</a>
                <div class="ui two column grid">
                  <div class="left attached column field" style="padding-right:2px;">
                      <label>Muka Surat</label>
                      <div class="ui fluid input">
                        <input type="number" placeholder="Muka Surat" name="surah" id="surah" readonly>
                      </div>
                  </div>
                  <div class="right attached column field" style="padding-left:2px">
                        <label>No. Ayat</label>
                      <div class="ui fluid input">
                        <input type="number" placeholder="No. Ayat" name="ms" id="ms" readonly>
                      </div>
                  </div>
                </div>
            </div>

            <div class="field">
              <label>Remarks</label>
              <textarea></textarea>
            </div>

            <div class="field">
                <div class="ui yellow rating" data-rating="3" data-max-rating="5"></div>
            </div>

            <div class="ui segment tertiary inverted green">
                <a class="ui green ribbon label">Muka Surat Selepas</a>
                <div class="ui two column grid">
                  <div class="left attached column field" style="padding-right:2px;">
                        <label>Muka Surat</label>
                      <div class="ui fluid input">
                        <input type="number" placeholder="Muka Surat" name="surah2" id="surah2">
                      </div>
                  </div>
                  <div class="right attached column field" style="padding-left:2px">
                        <label>No. Ayat</label>
                      <div class="ui fluid input">
                        <input type="number" placeholder="No. Ayat" name="ms2" id="ms2">
                      </div>
                  </div>
                </div>
            </div>
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


