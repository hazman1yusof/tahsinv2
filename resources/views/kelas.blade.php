@extends('layouts.fomantic_main')

@section('title', 'Kelas')

@section('style')
    
@endsection

@section('header')
<script>
    var weekly={
                  title:'{{$jadual->title}}',
                  hari:'{{$jadual->hari}}',
                  startTime:'{{$jadual->time}}',
                  url:'./kelas_detail?kelas_id={{$jadual->kelas_id}}&user_id={{Auth::user()->id}}&jadual_id={{$jadual->idno}}&type={{$jadual->type}}&time={{$jadual->time}}'
            }
    
</script>
@endsection

@section('content')
    <div class="ui container mycontainer">
        <h4 class="mytitle">Kelas</h4>
        <div id='calendar'></div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('css/kelas.css')}}">
@endsection

@section('js')
<script src='https://cdn.jsdelivr.net/npm/moment@2.27.0/min/moment.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/kelas.js') }}"></script>
@endsection


