@extends('layouts.fomantic_main')

@section('title', 'Kelas')

@section('style')
    
@endsection

@section('header')
<script>
</script>
@endsection

@section('content')
    <div class="ui container mycontainer">
        <h4 class="mytitle">Kelas</h4>
        <div id='calendar'></div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('css/kelas.css')}}?v=1">
@endsection

@section('js')
<script src='https://cdn.jsdelivr.net/npm/moment@2.27.0/min/moment.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/kelas.js') }}?v=1"></script>
@endsection


