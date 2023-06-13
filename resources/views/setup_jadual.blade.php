@extends('layouts.fomantic_main')

@section('title', 'Setup Kelas')

@section('style')
    
@endsection

@section('header')
<script>

    
</script>
@endsection

@section('content')

<div class="ui container mycontainer">
  <h4 class="mytitle">Setup Jadual</h4>

  <form class="ui form" autocomplete="off" style="margin-bottom: 10px;">
    <select class="ui dropdown" name="kelas">
      <option value="">Pilih Kelas</option>
      @foreach ($kelas as $kelas_obj)
        <option value="{{$kelas_obj->idno}}">{{ $kelas_obj->name }}</option>
      @endforeach
    </select>
  </form>

  <table id="dt_jadual" class="ui celled table" style="width:100%">
    <thead>
      <tr>
      <th>idno</th>
      <th>Kelas id</th>
      <th>Description</th>
      <th>type</th>
      <th>hari</th>
      <th>date</th>
      <th>time</th>
      </tr>
    </thead>
  </table>

<div class="ui modal" id="mdl_add_jadual">
  <div class="header">
    Tambah Jadual
  </div>
  <div class="content">
    <form class="ui form" id="form_jadual" autocomplete="off">
      <input id="_token" name="_token" value="{{ csrf_token() }}" type="hidden">
      <input type="hidden" name="idno">
      <div class="field">
        <label>Kelas ID</label>
        <input type="text" name="kelas_id" class="uppercase" readonly>
      </div>
      <div class="field">
        <label>Jadual Description</label>
        <input type="text" name="title" class="uppercase" required>
      </div>
      <div class="field">
          <label>Jadual Type</label>
          <select class="ui dropdown" name="type">
            <option value="">Pilih Type</option>
            <option value="weekly">Weekly</option>
            <option value="date">Specific Date</option>
          </select>
      </div>
      <div class="inline field" id="divjad_weekly">
        <label style="margin-right:8px">Hari</label>
        <select class="ui dropdown" name="hari">
          <option value="">Pilih Hari</option>
          <option value="isnin">isnin</option>
          <option value="selasa">selasa</option>
          <option value="rabu">rabu</option>
          <option value="khamis">khamis</option>
          <option value="jumaat">jumaat</option>
          <option value="sabtu">sabtu</option>
          <option value="ahad">ahad</option>
        </select>

          <label style="margin-right:8px; margin-left: 8px;">Time</label>
          <input style="margin-right:8px" type="time" name="time" id="time_w">
      </div>
      <div class="inline field" id="divjad_datespec">
          <label style="margin-right:5px">Date</label>
          <input style="margin-right:8px" type="date" name="date">
          <label style="margin-right:8px">Time</label>
          <input style="margin-right:8px" type="time" name="time"  id="time_d">
      </div>
    </form>
  </div>
  <div class="actions">
    <button class="ui deny button" id="cancel_jadual">
      Cancel
    </button>
    <button class="ui positive right labeled icon button" id="save_jadual">
      Save
      <i class="checkmark icon"></i>
    </button>
  </div>
</div>

@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('css/setup.css')}}">
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('js/setup_jadual.js') }}"></script>
@endsection


