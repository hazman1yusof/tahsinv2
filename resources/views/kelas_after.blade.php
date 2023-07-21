<img src="./img/fancyline1.png" class="segment_line">
  <div class="ui segments @if(!empty($kd_after)){{'done_segment'}}@else{{'xdone_segment'}}@endif" style="border-color: #d6ffd2;margin-top: -10px;"><i class="exclamation circle icon"></i>
      <div class="ui secondary segment" style="text-align: center;padding: 15px 10px 5px;background-color: #f4fff3;">
          <h4 style="margin-bottom: 5px;">Kelas selepas ini</h4>
          <i class="minus square icon hide_but" id="btnhid_klsafter"></i>
      </div>
      <div class="ui segment " id="sgmnt_klsafter">

          <form class="ui form" id="form_nonpast" autocomplete="off">
              <h5 class="ui top attached negative message" id="div_error" style="display:none;">
                <i class="warning icon"></i><span id="span_error"></span>
              </h5>
              <button type="button" id="kelas_after_cp" class="ui circular copy icon button" data-content="Message Copied"><i class="clipboard icon"></i> Copy</button>
              <div class="ui segment blue user_kd">
               <p><b>Pelajar Hadir:</b>
                  <div class="ui yellow label mytlabel" style="float:right">
                    <i class="checkmark icon"></i>
                    Marked
                  </div>
               </p>
                @foreach ($user_kd as $user)
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
                @foreach ($user_kd as $user)
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

                <p><b>Pelajar Tidak Respon:</b></p>
                @foreach ($user_kd as $user)
                  @if(empty($user->status))
                    <div class="item myitem xrespon @if($user->user_id == Auth::user()->id){{'isame'}}@endif">
                      <div class="ui grid">
                        <div class="one wide column pos">{{$user->pos}}</div>
                        <div class="twelve wide column name">{{$user->name}}</div>
                        <div class="three wide column ms">{{$user->surah}}: {{$user->ms}}</div>
                      </div>
                    </div>
                    @endif
                @endforeach
              </div>
              <table>
                  <tr>
                      <th>Kelas</th>
                      <td id="kelas_after_title">{{$jadual->name}}</td>
                  <tr>
                  <tr>
                      <th>Jadual</th>
                      <td>{{$jadual->title}}</td>
                  <tr>
                  <tr>
                      <th>Hari</th>
                      <td id="kelas_after_hari">{{Carbon\Carbon::createFromFormat('Y-m-d',$date_after)->format('l')}}</td>
                  <tr>
                  <tr>
                      <th>Tarikh</th>
                      <td id="kelas_after_tarikh">{{Carbon\Carbon::createFromFormat('Y-m-d',$date_after)->format('d-m-Y')}}</td>
                  <tr>
                  <tr>
                      <th>Masa</th>
                      <td id="kelas_after_masa">{{Carbon\Carbon::createFromFormat('H:i:s',$jadual->time)->format('g:i A')}}</td>
                  <tr>
              </table>
              <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
              <input type="hidden" name="idno" value="@if(!empty($kd_after)){{$kd_after->idno}}@endif">
              <input type="hidden" name="action" value="confirm_kelas">
              <input type="hidden" name="kelas_id" value="{{$user_detail->kelas}}">
              <input type="hidden" name="user_id" value="{{$user_detail->id}}">
              <input type="hidden" name="jadual_id" value="{{$jadual->idno}}">
              <input type="hidden" name="type" value="{{$jadual->type}}">
              <input type="hidden" name="date" value="{{$date_after}}">
              <input type="hidden" name="time" value="{{$jadual->time}}">
              <input type="hidden" name="status" value="@if(!empty($kd_after)){{$kd_after->status}}@endif">
              <div class="ui grid div_past_marked" style="">
                <div class="four wide column" style="padding: 15px 1px 15px 15px;">
                    <label>Giliran</label>
                    <select id="pos" name="pos" required>
                      <option value="">Giliran</option>
                    </select>
                </div>
                <div class="six wide column" style="padding: 15px 1px;">
                    <label>Muka Surat</label>
                    <div class="ui fluid input">
                      <input type="number" placeholder="Muka Surat" name="surah" id="surah" value="@if(!empty($kd_after)){{$kd_after->surah}}@endif" required>
                    </div>
                </div>
                <div class="six wide column" style="padding: 15px 15px 15px 1px;">
                    <label>No. Ayat</label>
                    <div class="ui fluid input">
                      <input type="number" placeholder="No. Ayat" name="ms" id="ms" value="@if(!empty($kd_after)){{$kd_after->ms}}@endif" required>
                    </div>
                </div>
              </div>
              <div class="ui two buttons div_past_marked" style="">
                  <div class="ui negative button" id="tak_confirm">Tidak Hadir Kelas</div>
                  <div class="ui positive button" id="confirm">Hadir Kelas</div>
              </div>
          </form>

          <form class="ui form" autocomplete="off"  id="div_marked" style="display: none;">
              <div class="ui yellow segment" style="margin-top:10px">
                  <div class="field">
                    <label>Nota Dari Ustaz</label>
                    <textarea name="remark" id="remark_after" readonly rows="1">@if(!empty($kd_after)){{$kd_after->remark}}@endif</textarea>
                  </div>

                  <div class="field">
                    <label>Rating Pengajian</label>
                    <div id="rating_after" class="ui olive rating" data-icon="quran" data-rating="@if(!empty($kd_after)){{$kd_after->rating}}@endif" data-max-rating="5"></div>
                  </div>
              </div>
              <div class="ui segment tertiary inverted green msgreen">
                    <a class="ui green ribbon label">Muka Surat Selepas Sesi Pengajian</a>
                    <div class="ui two column grid">
                      <div class="left attached column field" style="padding-right:2px;padding-bottom: 2px;">
                            <label style="text-align: center">Muka Surat</label>
                          <div class="ui fluid input">
                            <input class="inp_trans" type="number" placeholder="Muka Surat" name="surah2" id="surah2" value="@if(!empty($kd_after)){{$kd_after->surah2}}@endif" readonly>
                          </div>
                      </div>
                      <div class="right attached column field" style="padding-left:2px;padding-bottom: 2px;">
                            <label style="text-align: center">No. Ayat</label>
                          <div class="ui fluid input">
                            <input class="inp_trans" type="number" placeholder="No. Ayat" name="ms2" id="ms2" value="@if(!empty($kd_after)){{$kd_after->ms2}}@endif" readonly>
                          </div>
                      </div>
                    </div>
              </div>
          </form>
      </div>
  </div>