@extends('layouts.fomantic_main')

@section('title', 'Dashboard')

@section('style')
    
@endsection

@section('header')
<script>

    var count_kelas_bersemuka = {{$count_kelas_bersemuka}};
    var my_pos_bersemuka = @if(!empty($kd_bersemuka) && !empty($kd_bersemuka->pos)){{$kd_bersemuka->pos}}@else{{'null'}}@endif;
    var user_pos_bersemuka = [
        @foreach ($user_bersemuka as $user)
            @if($user->user_id != Auth::user()->id)
            {{$user->pos}},
            @endif
        @endforeach
    ];
    var my_marked_bersemuka = @if(!empty($kd_bersemuka)){{$kd_bersemuka->marked}}@else{{'0'}}@endif;

    @if($kelas_id != 0)
        @include('script_')
    @else
        var count_kelas = 0;
        var my_pos = 0;
        var user_pos = [];
        var user_kd_hadir = [];
        var user_kd_xhadir = [];
        var my_marked = 1;
    @endif


    
</script>
@endsection

@section('content')
    <div class="ui container mycontainer">

        <img src="./img/fancyline1.png" class="segment_line">
        <div class="ui segments" style="border-color: #ffebbb;margin-top: -10px;">
            <div class="ui secondary segment" style="text-align: center;padding: 15px 10px 5px;background-color: #fff8ee;">
                <h4 style="margin-bottom: 5px;">Maklumat Pelajar</h4>
                <i class="plus square icon hide_but" id="btnhid_userdtl"></i>
            </div>
            <div class="ui segment " style="display:none" id="sgmnt_userdtl">
              <a id="upd_user" class="ui fluid tiny teal button" style="margin-bottom: 10px;
                margin-top: -14px;
                padding: 5px;
                border-top-right-radius: 0px;
                border-top-left-radius: 0px;" href="./upd_user">Update My Data</a>
              <div class="ui centered grid" >
                <div class="sixteen wide tablet eight wide computer column col_"><span class="col_titl">Username</span><span class="col_cont">{{$user_detail->username}}</span></div>
                <div class="sixteen wide tablet eight wide computer column col_"><span class="col_titl">Name</span><span class="col_cont">{{$user_detail->name}}</span></div>
                <div class="sixteen wide tablet eight wide computer column col_"><span class="col_titl">User Type</span><span class="col_cont">{{$user_detail->type}}</span></div>
                <div class="sixteen wide tablet eight wide computer column col_"><span class="col_titl">Kelas</span><span class="col_cont">{{$user_detail->kelas_name}}</span></div>
                <div class="sixteen wide tablet eight wide computer column col_"><span class="col_titl">Address</span><span class="col_cont">{!!nl2br($user_detail->address)!!}</span></div>
                <div class="sixteen wide tablet eight wide computer column col_"><span class="col_titl">Handphone</span><span class="col_cont">{{$user_detail->telhp}}</span></div>
                <div class="sixteen wide tablet eight wide computer column col_"><span class="col_titl">I/C</span><span class="col_cont">{{$user_detail->newic}}</span></div>
                <div class="sixteen wide tablet eight wide computer column col_"><span class="col_titl">DOB</span><span class="col_cont">{{$user_detail->dob}}</span></div>
                <div class="sixteen wide tablet eight wide computer column col_"><span class="col_titl">Gender</span><span class="col_cont">{{$user_detail->gender}}</span></div>
                <div class="sixteen wide tablet eight wide computer column col_"><span class="col_titl">Age</span><span class="col_cont">{{$user_detail->age}}</span></div>
             </div>
            </div>
        </div>

        <img src="./img/fancyline1.png" class="segment_line">
        <div class="ui segments" style="border-color: #ffcef9;margin-top: -10px;">
            <div class="ui secondary segment" style="text-align: center;padding: 15px 10px 5px;background-color: #fff7fa;">
                <h4 style="margin-bottom: 5px;">Tatacara dan Adab semasa hadir ke Tadarus Al-Quran</h4>
                <i class="plus square icon hide_but" id="btnhid_prtkls"></i>
            </div>
            <div class="ui segment " style="display:none" id="sgmnt_prtkls">
                <div class="ui ordered list">
                    <a class="item">Buat latihan bacaan masing2 sebelum masuk ke kelas.</a>
                    <a class="item">Pastikan update kehadiran (hadir/tidak) dengan mengemaskini nama dan mukasurat selewatnya sehari sebelum kelas.</a>
                    <a class="item">Join GM selewat²nya 5 minit sebelum kelas bermula.</a>
                    <a class="item">Berpakaian sopan dan menutup aurat.</a>
                    <a class="item">Buka kamera terutama semasa mengaji.</a>
                    <a class="item">Jangan left sebelum tamat kelas, ikuti dan semak bacaan rakan2 yang lain.</a>
                    <a class="item">Jika uzur, digalakkan hadir kelas sebagai pendengar.</a>
                    <a class="item">Untuk Program Talaqqi, mohon muka mic dan ikut bacaan bersama-sama.</a>
                </div>
             </div>
        </div>

        @if($kelas_id != 0)
            @include('kelas_b4')
            @include('kelas_after')
        @endif

        <img src="./img/fancyline1.png" class="segment_line">
        <div class="ui segments" style="border-color: #bfc39c;margin-top: -10px;">
            <div class="ui secondary segment" style="text-align: center;padding: 15px 10px 5px;background-color: #fbffda;">
                <h4 style="margin-bottom: 5px;">Kelas Bersemuka</h4>
                <i class="plus square icon hide_but" id="btnhid_bersemuka"></i>
            </div>
            <div class="ui segment " style="display:none" id="sgmnt_bersemuka">
                
                <form class="ui form" id="form_bersemuka" autocomplete="off">
                    <div class="ui segment blue user_kd">
                     <p><b>Pelajar Hadir:</b>
                        <div class="ui yellow label mytlabel" style="float:right">
                          <i class="checkmark icon"></i>
                          Marked
                        </div>
                     </p>
                      @foreach ($user_bersemuka as $user)
                        @if($user->status == 'Hadir')
                          <div class="item myitem hadir @if($user->user_id == Auth::user()->id){{'isame'}}@endif">
                            @if($user->marked == '1')
                            <div class="floating ui yellow label myflabel"><i class="checkmark icon myficon"></i></div>
                            @endif
                            <div class="ui grid">
                              <div class="one wide column pos">{{$user->pos}}</div>
                              <div class="twelve wide column name">{{$user->name}}</div>
                              <div class="three wide column ms">{{$user->surah}}: {{$user->ms}}</div>
                            </div>
                          </div>
                          @endif
                      @endforeach

                      <p><b>Pelajar Tidak Hadir:</b></p>
                      @foreach ($user_bersemuka as $user)
                        @if($user->status == 'Tidak Hadir')
                          <div class="item myitem xhadir @if($user->user_id == Auth::user()->id){{'isame'}}@endif">
                            <div class="ui grid">
                              <div class="one wide column pos">{{$user->pos}}</div>
                              <div class="twelve wide column name">{{$user->name}}<br><span class="alasan">{{$user->alasan}}<span></div>
                              <div class="three wide column ms">{{$user->surah}}: {{$user->ms}}</div>
                            </div>
                          </div>
                          @endif
                      @endforeach

                    </div>
                    <table >
                        <tr>
                            <th>Kelas</th>
                            <td>{{$bersemuka->name}}</td>
                        <tr>
                        <tr>
                            <th>Jadual</th>
                            <td>{{$bersemuka->title}}</td>
                        <tr>
                        <tr>
                            <th>Tarikh</th>
                            <td>{{Carbon\Carbon::createFromFormat('Y-m-d',$bersemuka->date)->format('d-m-Y')}}</td>
                        <tr>
                        <tr>
                            <th>Masa</th>
                            <td>{{Carbon\Carbon::createFromFormat('H:i:s',$bersemuka->time)->format('g:i A')}}</td>
                        <tr>
                    </table>
                    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="idno" value="@if(!empty($kd_bersemuka)){{$kd_bersemuka->idno}}@endif">
                    <input type="hidden" name="action" value="confirm_kelas">
                    <input type="hidden" name="kelas_id" value="{{$bersemuka->kelas_id}}">
                    <input type="hidden" name="user_id" value="{{$user_detail->id}}">
                    <input type="hidden" name="jadual_id" value="{{$bersemuka->idno}}">
                    <input type="hidden" name="type" value="{{$bersemuka->type}}">
                    <input type="hidden" name="date" value="{{$bersemuka->date}}">
                    <input type="hidden" name="time" value="{{$bersemuka->time}}">
                    <input type="hidden" name="status" value="@if(!empty($kd_bersemuka)){{$kd_bersemuka->status}}@endif">
                    <div class="ui grid div_past_marked_bersemuka" style="">
                      <div class="four wide column" style="padding: 15px 1px 15px 15px;">
                          <label>Giliran</label>
                          <select id="pos_bersemuka" name="pos" required>
                            <option value="">Giliran</option>
                          </select>
                      </div>
                      <div class="six wide column" style="padding: 15px 1px;">
                          <label>Muka Surat</label>
                          <div class="ui fluid input">
                            <input type="number" placeholder="Muka Surat" name="surah" id="surah_bersemuka" value="@if(!empty($kd_bersemuka)){{$kd_bersemuka->surah}}@endif" required>
                          </div>
                      </div>
                      <div class="six wide column" style="padding: 15px 15px 15px 1px;">
                          <label>No. Ayat</label>
                          <div class="ui fluid input">
                            <input type="number" placeholder="No. Ayat" name="ms" id="ms_bersemuka" value="@if(!empty($kd_bersemuka)){{$kd_bersemuka->ms}}@endif" required>
                          </div>
                      </div>
                    </div>
                    <div class="ui two buttons div_past_marked_bersemuka" style="">
                        <div class="ui negative button" id="tak_confirm_bersemuka">Tidak Hadir Kelas</div>
                        <div class="ui positive button" id="confirm_bersemuka">Hadir Kelas</div>
                    </div>
                </form>

                <form class="ui form" autocomplete="off"  id="div_marked_bersemuka" style="display: none;">
                    <div class="ui yellow segment" style="margin-top:10px">
                        <div class="field">
                          <label>Nota Dari Ustaz</label>
                          <textarea name="remark" id="remark_bersemuka" readonly rows="1">@if(!empty($kd_bersemuka)){{$kd_bersemuka->remark}}@endif</textarea>
                        </div>

                        <div class="field">
                          <label>Rating Pengajian</label>
                          <div id="rating_bersemuka" class="ui olive rating" data-icon="quran" data-rating="@if(!empty($kd_bersemuka)){{$kd_bersemuka->rating}}@endif" data-max-rating="5"></div>
                        </div>
                    </div>
                    <div class="ui segment tertiary inverted green msgreen">
                          <a class="ui green ribbon label">Muka Surat Selepas Sesi Pengajian</a>
                          <div class="ui two column grid">
                            <div class="left attached column field" style="padding-right:2px;padding-bottom: 2px;">
                                  <label style="text-align: center">Muka Surat</label>
                                <div class="ui fluid input">
                                  <input class="inp_trans" type="number" placeholder="Muka Surat" name="surah2" id="surah2" value="@if(!empty($kd_bersemuka)){{$kd_bersemuka->surah2}}@endif" readonly>
                                </div>
                            </div>
                            <div class="right attached column field" style="padding-left:2px;padding-bottom: 2px;">
                                  <label style="text-align: center">No. Ayat</label>
                                <div class="ui fluid input">
                                  <input class="inp_trans" type="number" placeholder="No. Ayat" name="ms2" id="ms2" value="@if(!empty($kd_bersemuka)){{$kd_bersemuka->ms2}}@endif" readonly>
                                </div>
                            </div>
                          </div>
                    </div>
                </form>
             </div>
        </div>

        <img src="./img/fancyline1.png" class="segment_line">
        <div class="ui segments" style="border-color: #ffd4e2;margin-top: -10px;">
            <div class="ui secondary segment" style="text-align: center;padding: 15px 10px 5px;background-color: #ffe8e8;">
                <h4 style="margin-bottom: 5px;">Bantuan Naqib</h4>
                <i class="plus square icon hide_but" id="btnhid_naqib"></i>
            </div>
            <div class="ui segment " style="display:none" id="sgmnt_naqib">
                <div class="ui ordered list">
                    <a class="item" href="https://wa.me/601158582485?text=boleh%20bantu%20saya%20mengaji"><i class="whatsapp green icon"></i>Nadiyah</a>
                </div>
            </div>
        </div>

        <div class="ui mini modal" id="alasan_modal">
            <div class="center aligned content">
                <form class="ui form" id="form_alasan" autocomplete="off">
                    <label>Alasan untuk tidak hadir</label>
                    <div class="ui fluid input">
                      <input type="text" placeholder="Please input your reason in here" id="alasan" name="alasan" required>
                    </div>
                </form>
            </div>
            <div class="center aligned actions">
                <div class="ui negative button">Cancel</div>
                <div class="ui positive button" id="alasan_ok">OK</div>
            </div>
        </div>

    </div>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('css/dashboard.css')}}?v=1">
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('js/dashboard.js') }}?v=1"></script>
@endsection


