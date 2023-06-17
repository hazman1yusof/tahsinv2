@extends('layouts.fomantic_main')

@section('title', 'Kelas')

@section('stylesheet')
@endsection

@section('header')
    <script>
        var all_data ={
            ispast:'{{$ispast}}'
        }

        var kelas_detail={
            kelas_id:'{{$jadual->idno}}',
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
            <button class="circular ui icon button myback" onclick="window.location.replace('./pengajar');">
                <i class="arrow left icon"></i>
            </button> 
            <span class="mytitle_name">{{$jadual->name}}</span>
        </h4>

        <div class="ui segment blue">
         <p><b>Pelajar Hadir:</b>
            <div class="ui yellow label mytlabel" style="float:right">
              <i class="checkmark icon"></i>
              Marked
            </div>
         </p>
          @foreach ($user_kd as $user)
            @if($user->status == 'Hadir')
              <div class="item myitem hadir" data-url="./mark?id={{$user->idno}}">
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

    </div>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('css/kelas.css')}}">
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('js/pengajar_detail.js') }}"></script>
@endsection


