<img src="./img/fancyline1.png" class="segment_line">
  <div class="ui segments" style="border-color: #b3f2ff;margin-top: -10px;">
      <div class="ui secondary segment" style="text-align: center;padding: 15px 10px 5px;background-color: #f1fdff;">
          <h4 style="margin-bottom: 5px;">Kelas sebelum ini</h4>
          <i class="plus square icon hide_but" id="btnhid_klsb4"></i>
      </div>
      <div class="ui segment " style="display:none" id="sgmnt_klsb4">
          
          <form class="ui form" autocomplete="off">
              <div class="ui segment blue user_kd">
               <p><b>Pelajar Hadir:</b>
                  <div class="ui yellow label mytlabel" style="float:right">
                    <i class="checkmark icon"></i>
                    Marked
                  </div>
               </p>
                @foreach ($user_kdb4 as $user)
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
                @foreach ($user_kdb4 as $user)
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
                @foreach ($user_kdb4 as $user)
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
                      <td>{{Carbon\Carbon::createFromFormat('Y-m-d',$date_b4)->format('d-m-Y')}}</td>
                  <tr>
                  <tr>
                      <th>Masa</th>
                      <td>{{Carbon\Carbon::createFromFormat('H:i:s',$jadual->time)->format('g:i A')}}</td>
                  <tr>
              </table>
          </form>

          <form class="ui form" autocomplete="off">
              <div class="ui yellow segment" style="margin-top:10px">
                  <div class="field">
                    <label>Nota Dari Ustaz</label>
                    <textarea name="remark" id="remark_b4" readonly>@if(!empty($kd_b4)){{$kd_b4->remark}}@endif</textarea>
                  </div>

                  <div class="field">
                    <label>Rating Pengajian</label>
                    <div id="rating_b4" class="ui olive rating" data-icon="quran" data-rating="@if(!empty($kd_b4)){{$kd_b4->rating}}@endif" data-max-rating="5"></div>
                  </div>
              </div>
              <div class="ui segment tertiary inverted green msgreen">
                    <a class="ui green ribbon label">Muka Surat Selepas Sesi Pengajian</a>
                    <div class="ui two column grid">
                      <div class="left attached column field" style="padding-right:2px;padding-bottom: 2px;">
                            <label style="text-align: center">Muka Surat</label>
                          <div class="ui fluid input">
                            <input class="inp_trans" type="number" placeholder="Muka Surat" name="surah2" id="surah2" value="@if(!empty($kd_b4)){{$kd_b4->surah2}}@endif" readonly>
                          </div>
                      </div>
                      <div class="right attached column field" style="padding-left:2px;padding-bottom: 2px;">
                            <label style="text-align: center">No. Ayat</label>
                          <div class="ui fluid input">
                            <input class="inp_trans" type="number" placeholder="No. Ayat" name="ms2" id="ms2" value="@if(!empty($kd_b4)){{$kd_b4->ms2}}@endif" readonly>
                          </div>
                      </div>
                    </div>
              </div>
          </form>
       </div>
  </div>