@extends('layouts.fomantic_main')

@section('title', 'Setup User')

@section('style')
    
@endsection

@section('header')
<script>

    
</script>
@endsection

@section('content')

<div class="ui container mycontainer">
  <h4 class="mytitle">Setup User</h4>
  <table id="dt_user" class="ui celled table" style="width:100%">
      <thead>
          <tr>
              <th>User id</th>
              <th>Username</th>
              <th>Name</th>
              <th>Kelas</th>
              <th>Mengajar</th>
              <th>Setup</th>
              <th>User Type</th>
              <th>Add User</th>
              <th>Add Date</th>
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
      <input type="hidden" name="id" id="id">
      <div class="field">
        <label>Username</label>
        <input type="text" name="username" id="username" class="uppercase" required readonly>
      </div>
      <div class="field">
        <label>Name</label>
        <input type="text" name="name" id="name">
      </div>
      <div class="field">
          <label>Kelas</label>
          <select class="ui dropdown" name="kelas">
            <option value="">Pilih Kelas</option>
            @foreach ($kelas as $kelas_obj)
              <option value="{{$kelas_obj->idno}}">{{ $kelas_obj->name }}</option>
            @endforeach
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
    <button class="ui orange button" id="reset">
      Reset Password
    </button>
    <button class="ui ok right labeled icon button red" id="delete">
      Delete
      <i class="trash alternate outline icon"></i>
    </button>
    <button class="ui positive right labeled icon button" id="save">
      Save
      <i class="checkmark icon"></i>
    </button>
  </div>
</div>

@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('css/setup.css')}}?v=1">
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('js/setup_user.js') }}?v=1"></script>
@endsection


