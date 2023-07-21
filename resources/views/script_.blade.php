var count_kelas = {{$count_kelas}};
var my_pos = @if(!empty($kd_after) && !empty($kd_after->pos)){{$kd_after->pos}}@else{{'null'}}@endif;
var user_pos = [
    @foreach ($user_kd as $user)
        @if($user->user_id != Auth::user()->id)
        {{$user->pos}},
        @endif
    @endforeach
];

var user_kd_hadir = [
    @foreach ($user_kd as $user)
        @if($user->status == 'Hadir')
        '{{$user->pos}}) {{$user->name}} (ms {{$user->surah}}:{{$user->ms}})',
        @endif
    @endforeach 
];

var user_kd_xhadir = [
   @foreach ($user_kd as $user)
        @if($user->status == 'Tidak Hadir')
        '{{$user->name}} (ms {{$user->surah}}:{{$user->ms}}) - {{$user->alasan}}',
        @endif
    @endforeach 
];

var my_marked = @if(!empty($kd_after)){{$kd_after->marked}}@else{{'0'}}@endif;