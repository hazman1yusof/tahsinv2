@extends('layouts.fomantic_main')

@section('title', 'Kelas')

@section('stylesheet')
@endsection

@section('header')
    <script>
        var all_data ={
            ispast:'{{$ispast}}'
        }
        var count_kelas = {{$count_kelas}}
        var user_kd = [
            @foreach ($user_kd as $user)
                @if($user->user_id != Auth::user()->id)
                {{$user->pos}},
                @endif
            @endforeach
        ];
        var my_pos = @if(!empty($kelas_detail)){{$kelas_detail->pos}}@else{{'null'}}@endif;

        var my_marked = @if(!empty($kelas_detail)){{$kelas_detail->marked}}@else{{'0'}}@endif;
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

        <form class="ui form" id="form_nonpast" autocomplete="off">

            <h5 class="ui top attached negative message" id="div_error" style="display:none;">
              <i class="warning icon"></i><span id="span_error"></span>
            </h5>

            <div class="ui segment blue user_kd">
             <p><b>Pelajar Hadir:</b>
                <div class="ui yellow label mytlabel" style="float:right">
                  <i class="checkmark icon"></i>
                  Marked
                </div>
             </p>
              @foreach ($user_kd as $user)
                @if($user->status == 'Hadir')
                  <div class="item myitem hadir">
                    @if($user->marked == '1')
                    <div class="floating ui yellow label myflabel"><i class="checkmark icon myficon"></i></div>
                    @endif
                    <div class="ui grid">
                      <div class="one wide column pos">{{$user->pos}}</div>
                      <div class="twelve wide column name">{{$user->name}}</div>
                      <div class="three wide column ms">{{$user->surah}}:{{$user->ms}}</div>
                    </div>
                  </div>
                  @endif
              @endforeach

              <p><b>Pelajar Tidak Hadir:</b></p>
              @foreach ($user_kd as $user)
                @if($user->status == 'Tidak Hadir')
                  <div class="item myitem xhadir">
                    <div class="ui grid">
                      <div class="one wide column pos">{{$user->pos}}</div>
                      <div class="twelve wide column name">{{$user->name}}</div>
                      <div class="three wide column ms">{{$user->surah}}:{{$user->ms}}</div>
                    </div>
                  </div>
                  @endif
              @endforeach
            </div>

            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="idno" value="@if(!empty($kelas_detail)){{$kelas_detail->idno}}@endif">
            <input type="hidden" name="action" value="confirm_kelas">
            <input type="hidden" name="kelas_id" value="{{request()->get('kelas_id')}}">
            <input type="hidden" name="user_id" value="{{request()->get('user_id')}}">
            <input type="hidden" name="jadual_id" value="{{request()->get('jadual_id')}}">
            <input type="hidden" name="type" value="{{request()->get('type')}}">
            <input type="hidden" name="date" value="{{request()->get('date')}}">
            <input type="hidden" name="time" value="{{request()->get('time')}}">
            <input type="hidden" name="status" value="@if(!empty($kelas_detail)){{$kelas_detail->status}}@endif">
            <div class="ui attached green segment">
                <table >
                    <tr>
                        <th>Kelas</th>
                        <td>{{$jadual->name}}</td>
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
                <div class="ui grid div_past_marked">
                  <div class="four wide column" style="padding: 15px 1px 15px 15px;">
                      <label>Giliran</label>
                      <select id="pos" name="pos" required>
                      </select>
                  </div>
                  <div class="six wide column" style="padding: 15px 1px;">
                      <label>Muka Surat</label>
                      <div class="ui fluid input">
                        <input type="number" placeholder="Muka Surat" name="surah" id="surah" value="@if(!empty($kelas_detail)){{$kelas_detail->surah}}@endif" required>
                      </div>
                  </div>
                  <div class="six wide column" style="padding: 15px 15px 15px 1px;">
                      <label>No. Ayat</label>
                      <div class="ui fluid input">
                        <input type="number" placeholder="No. Ayat" name="ms" id="ms" value="@if(!empty($kelas_detail)){{$kelas_detail->ms}}@endif" required>
                      </div>
                  </div>
                </div>
            </div>
            <div class="ui two bottom attached buttons div_past_marked">
                <div class="ui negative button" id="tak_confirm">Tidak Hadir Kelas</div>
                <div class="ui positive button" id="confirm">Hadir Kelas</div>
            </div>
        </form>

        <form class="ui form" autocomplete="off">
            <div class="ui yellow segment" id="div_past_marked_show" style="margin-top:10px">
                <div class="field">
                  <label>Nota Dari Ustaz</label>
                  <textarea name="remark" id="remark" readonly>{{$kelas_detail->remark}}</textarea>
                </div>

                <div class="field">
                  <label>Rating Pengajian</label>
                  <div id="rating" class="ui olive rating" data-icon="quran" data-rating="{{$kelas_detail->rating}}" data-max-rating="5"></div>
                </div>
            </div>
            <div class="ui segment tertiary inverted green msgreen">
                  <a class="ui green ribbon label">Muka Surat Selepas Sesi Pengajian</a>
                  <div class="ui two column grid">
                    <div class="left attached column field" style="padding-right:2px;padding-bottom: 2px;">
                          <label style="text-align: center">Muka Surat</label>
                        <div class="ui fluid input">
                          <input class="inp_trans" type="number" placeholder="Muka Surat" name="surah2" id="surah2" value="{{$kelas_detail->surah2}}" readonly>
                        </div>
                    </div>
                    <div class="right attached column field" style="padding-left:2px;padding-bottom: 2px;">
                          <label style="text-align: center">No. Ayat</label>
                        <div class="ui fluid input">
                          <input class="inp_trans" type="number" placeholder="No. Ayat" name="ms2" id="ms2" value="{{$kelas_detail->ms2}}" readonly>
                        </div>
                    </div>
                  </div>
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


