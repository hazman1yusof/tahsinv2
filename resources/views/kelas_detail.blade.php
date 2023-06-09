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
        <h4 class="mytitle" style="min-height: 46px;">
            <button class="circular ui icon button" style="float: left;" onclick="history.back()">
                <i class="arrow left icon"></i>
            </button> 
            Kelas
        </h4>
        <form class="ui form" id="form_kelas" autocomplete="off" method="post">
            <input id="_token" name="_token" value="{{ csrf_token() }}" type="hidden">
            <input type="hidden" name="idno" id="idno" value="@if(!empty($kelas_detail)){{$kelas_detail->idno}}@endif">
            <input type="hidden" name="oper" id="oper" value="{{$oper}}">
            <div class="ui attached segment">
                <table >
                    <tr>
                        <th>Kelas</th>
                        <td>{{$kelas->name}}</td>
                    <tr>
                    <tr>
                        <th>Jadual</th>
                        <td>{{$jadual->title}}</td>
                    <tr>
                    <tr>
                        <th>Tarikh</th>
                        <td>{{Carbon\Carbon::createFromFormat('Y-m-d',request()->date)->format('d-m-Y')}}</td>
                    <tr>
                    <tr>
                        <th>Masa</th>
                        <td>{{Carbon\Carbon::createFromFormat('H:i:s',request()->time)->format('g:i A')}}</td>
                    <tr>
                </table>
                <p>Confirm attending this Class?</p>
            </div>
            <div class="ui two bottom attached buttons">
                <div class="ui button" onclick="history.back()">Cancel</div>
                <div class="ui positive button" >Confirm</div>
            </div>

        </form>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('css/kelas.css')}}">
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('js/kelas_detail.js') }}"></script>
@endsection


