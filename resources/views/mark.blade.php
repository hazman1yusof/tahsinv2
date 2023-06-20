@extends('layouts.fomantic_main')

@section('title', 'Mark')

@section('stylesheet')
@endsection

@section('header')
    <script>
        var user_kd={
          idno : '{{$user_kd->idno}}',
          kelas_id : '{{$user_kd->kelas_id}}',
          user_id : '{{$user_kd->user_id}}',
          jadual_id : '{{$user_kd->jadual_id}}',
          type : '{{$user_kd->type}}',
          date : '{{$user_kd->date}}',
          time : '{{$user_kd->time}}',
          status : '{{$user_kd->status}}',
          pos : '{{$user_kd->pos}}',
          adddate : '{{$user_kd->adddate}}',
          adduser : '{{$user_kd->adduser}}',
          upddate : '{{$user_kd->upddate}}',
          upduser : '{{$user_kd->upduser}}',
          surah : '{{$user_kd->surah}}',
          ms : '{{$user_kd->ms}}',
          remark : '{{$user_kd->remark}}',
          name : '{{$user_kd->name}}',
        }
    </script>
@endsection

@section('content')
    <div class="ui container mycontainer">
        <h4 class="mytitle" style="position: relative;">
            <button class="circular ui icon button myback" onclick="history.back()">
                <i class="arrow left icon"></i>
            </button> 
            <span class="mytitle_name">{{$user_kd->name}}</span>
        </h4>

          <form class="ui form" id="form_kelas_detail" autocomplete="off">
            <input id="_token" name="_token" value="{{ csrf_token() }}" type="hidden">
            <input type="hidden" name="idno" value="{{$user_kd->idno}}">

              <div class="ui segment tertiary inverted blue msblue">
                  <a class="ui blue ribbon label">Muka Surat Sebelum</a>
                  <div class="ui two column grid">
                    <div class="left attached column field" style="padding-right:2px;padding-bottom: 2px;">
                        <label style="text-align: center">Muka Surat</label>
                        <div class="ui fluid input">
                          <input class="inp_trans" type="number" placeholder="Muka Surat" name="surah" value="{{$user_kd->surah}}" id="surah" readonly>
                        </div>
                    </div>
                    <div class="right attached column field" style="padding-left:2px;padding-bottom: 2px;">
                        <label style="text-align: center">No. Ayat</label>
                        <div class="ui fluid input">
                          <input class="inp_trans" type="number" placeholder="No. Ayat" name="ms" value="{{$user_kd->ms}}" id="ms" readonly>
                        </div>
                    </div>
                  </div>
              </div>

              <div class="ui top attached segment timer pos_time" id="timer_div">
                Timer : 
                <span id="neg_timer"></span><span id="timer">07:00</span>
              </div>
              <div class="ui attached bottom segment remark">
                <div class="field">
                  <label>Nota Dari Ustaz</label>
                  <textarea name="remark" id="remark">{{$user_kd->remark}}</textarea>
                </div>

                <div class="field">
                  <label>Rating Pengajian</label>
                  <div id="rating" class="ui olive rating" data-icon="quran" data-rating="{{$user_kd->rating}}" data-max-rating="5"></div>
                </div>
              </div>

              <div class="ui segment tertiary inverted green msgreen">
                  <a class="ui green ribbon label">Muka Surat Selepas Sesi Pengajian</a>
                  <div class="ui two column grid">
                    <div class="left attached column field" style="padding-right:2px;padding-bottom: 2px;">
                          <label style="text-align: center">Muka Surat</label>
                        <div class="ui fluid input">
                          <input type="number" placeholder="Muka Surat" name="surah2" id="surah2" value="{{$user_kd->surah2}}">
                        </div>
                    </div>
                    <div class="right attached column field" style="padding-left:2px;padding-bottom: 2px;">
                          <label style="text-align: center">No. Ayat</label>
                        <div class="ui fluid input">
                          <input type="number" placeholder="No. Ayat" name="ms2" id="ms2" value="{{$user_kd->ms2}}">
                        </div>
                    </div>
                  </div>
              </div>

              <div class="ui two bottom attached buttons">
                  <div class="ui positive button" id="confirm">Submit</div>
              </div>
          </form>

    </div>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('css/kelas.css')}}">
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('js/mark.js') }}"></script>
@endsection


