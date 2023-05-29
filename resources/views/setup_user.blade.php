@extends('layouts.fomantic_main')

@section('title', 'Setup User')

@section('style')
    
@endsection

@section('header')
<script>

    
</script>
@endsection

@section('content')

<div class="ui container">
    <h4 class="mytitle">Setup User</h4>
  <table id="dt_user" class="ui celled table" style="width:100%">
      <thead>
          <tr>
              <th>User id</th>
              <th>Username</th>
              <th>Name</th>
              <th>User Type</th>
          </tr>
      </thead>
  </table>
</div>

<div class="ui modal" id="mdl_user">
  <div class="header">
    Tambah Pelajar
  </div>
  <div class="content">
    <form class="ui form" id="form_user" autocomplete="off">
      <input id="_token" name="_token" value="{{ csrf_token() }}" type="hidden">
      <input type="hidden" name="idno">
      <div class="field">
        <label>Username</label>
        <input type="text" name="username" id="username" class="uppercase" required>
      </div>
      <div class="field">
          <label>Kelas</label>
          <select class="ui dropdown" name="kelas">
            <option value="">Pilih Kelas</option>
            <option value="kelas_1">Kelas 1</option>
            <option value="kelas_2">Kelas 2</option>
            <option value="kelas_3">Kelas 3</option>
            <option value="kelas_4">Kelas 4</option>
            <option value="kelas_5">Kelas 5</option>
            <option value="k_tambahan">Kelas Tambahan</option>
          </select>
      </div>
      <div class="field">
        <label>User Type</label>
        <select class="ui dropdown" name="type">
          <option value="">Pilih Type</option>
          <option value="ustaz">Ustaz</option>
          <option value="naqib">Naqib</option>
          <option value="ketua_pelajar">Ketua Pelajar</option>
          <option value="pelajar">Pelajar</option>
        </select>
      </div>
      <div class="inline field">
        <div class="ui toggle checkbox">
          <input type="checkbox" class="hidden" name="ajar">
          <label>Boleh Mengajar</label>
        </div>
      </div>
      <div class="inline field">
        <div class="ui toggle checkbox">
          <input type="checkbox" class="hidden" name="setup">
          <label>Boleh Setup</label>
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

@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('css/setup.css')}}">
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('js/setup_user.js') }}"></script>
@endsection


