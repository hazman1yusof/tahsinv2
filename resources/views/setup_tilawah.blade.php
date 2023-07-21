@extends('layouts.fomantic_main')

@section('title', 'Setup User')

@section('style')
    
@endsection

@section('header')
<script>
  var users = [
    @foreach ($users as $user)
      {id:'{{$user->id}}',username:'{{$user->username}}'},
    @endforeach
    ];
    
</script>
@endsection

@section('content')

<input id="_token" name="_token" value="{{ csrf_token() }}" type="hidden">
<div class="ui container mycontainer">
  <h4 class="mytitle">Setup Tilawah</h4>
  <div class="ui segment" style="display: flex;
    flex-direction: column;
    flex-wrap: nowrap;
    justify-content: space-between;">
    <div class="ui input labeled">
      <div class="ui label">Effective Date</div>
      <input type="date" name="effectivedate" id="effectivedate" value="{{$effdate}}">
    </div>
    <button type="button" class="ui blue button" id="set">Set</button>
  </div>
  <table id="dt_tilawah" class="ui celled table" style="width:100%">
      <thead>
          <tr>
              <th>Id.</th>
              <th>No giliran</th>
              <th>User</th>
              <th>Muka Surat Dari</th>
              <th>Muka Surat Hingga</th>
              <th>Last Update</th>
          </tr>
      </thead>
  </table>
</div>

@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('css/setup.css')}}">
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('js/setup_tilawah.js') }}"></script>
@endsection


