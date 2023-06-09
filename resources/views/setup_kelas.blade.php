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
  <h4 class="mytitle">Setup Kelas</h4>
  <table id="dt_kelas" class="ui celled table" style="width:100%">
    <thead>
      <tr>
      <th>Kelas id</th>
      <th>Nama</th>
      <th>Kelas Tambahan</th>
      <th>Kelas Terbuka</th>
      <th>Ketua Kelas</th>
      <th>Pengajar Utama</th>
      <th>Add User</th>
      <th>Add Date</th>
      </tr>
    </thead>
  </table>
</div>

<div class="ui modal" id="mdl_kelas">
  <div class="header">
    Tambah Kelas
  </div>
  <div class="content">
    <form class="ui form" id="form_kelas" autocomplete="off">
      <input id="_token" name="_token" value="{{ csrf_token() }}" type="hidden">
      <input type="hidden" name="idno" id="idno">
      <div class="field">
        <label>Class Name</label>
        <input type="text" name="name" id="name" class="uppercase" required>
      </div>
      <div class="field">
          <label>Ketua Kelas</label>
          <select class="ui dropdown" name="ketua">
            <option value="">Pilih Ketua</option>
            <option value="kelas_1">Kelas 1</option>
            <option value="kelas_2">Kelas 2</option>
            <option value="kelas_3">Kelas 3</option>
            <option value="kelas_4">Kelas 4</option>
            <option value="kelas_5">Kelas 5</option>
            <option value="k_tambahan">Kelas Tambahan</option>
          </select>
      </div>
      <div class="field">
        <label>Pengajar Utama</label>
        <select class="ui dropdown" name="pengajar">
          <option value="">Pilih Pengajar</option>
          <option value="ustaz">Ustaz</option>
          <option value="naqib">Naqib</option>
          <option value="ketua_pelajar">Ketua Pelajar</option>
          <option value="pelajar">Pelajar</option>
        </select>
      </div>
      <div class="inline field">
        <div class="ui toggle checkbox">
          <input type="checkbox" class="hidden" name="tambahan">
          <label>Kelas Tambahan</label>
        </div>
      </div>
      <div class="inline field">
        <div class="ui toggle checkbox">
          <input type="checkbox" class="hidden" name="terbuka">
          <label>Kelas Terbuka</label>
        </div>
      </div>
    </form>
  </div>
  <div class="actions">
    <button class="ui deny button" id="cancel">
      Cancel
    </button>
    <button class="ui positive right labeled icon button" id="save">
      Save
      <i class="checkmark icon"></i>
    </button>
  </div>
</div>

<div class="ui modal" id="mdl_jadual">
  <div class="header">
    Setup Jadual
  </div>
  <div class="content">
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
  </div>
  <div class="actions">
    <button class="ui deny button">
      Exit
    </button>
  </div>
</div>

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
        <input type="text" name="description" class="uppercase" required>
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
          <input style="margin-right:8px" type="time" name="time_w">
      </div>
      <div class="inline field" id="divjad_datespec">
          <label style="margin-right:5px">Date</label>
          <input style="margin-right:8px" type="date" name="date">
          <label style="margin-right:8px">Time</label>
          <input style="margin-right:8px" type="time" name="time_s">
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
    <script type="text/javascript" src="{{ asset('js/setup_kelas.js') }}"></script>
@endsection


