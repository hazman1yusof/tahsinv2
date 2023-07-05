@extends('layouts.fomantic_main')

@section('title', 'Log in')

@section('stylesheet')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lobster&family=Satisfy&display=swap" rel="stylesheet">
@endsection

@section('content')
<!-- Content area -->
<div class="ui container content login">
	<div class="ui centered grid">
		<div class="column" style="max-width: 350px;">
			<form class="ui form" method="POST" autocomplete="off">
				{{ csrf_field() }}
				<div class="ui raised segment" style="background: rgb(121 205 255 / 50%); padding: 20px 20px;">
					<div class="ui medium rounded image" style="display: flex;justify-content: center;">
					  <img src="{{ asset('img/quran_img.png') }}" style="width: 100px;">
					</div>
					<div class="topmenu_title">Keluarga AL-Quran</div>
					<div class="field">
						<!-- <label>Username</label> -->
						<input placeholder="Username" type="text" name="username" autocomplete="off">
					</div>
					<div class="field">
						<!-- <label>Password</label> -->
						<div class="ui icon input">
						  <input placeholder="Password" type="password" name="password" id="inputPassword" autocomplete="off">
						  <i id="showpwd" class="eye link icon"></i>
						</div>
					</div>
				<button class="ui fluid basic button" type="submit" style="margin-top: 10px; background: rgb(255 255 255);"><b>Log In</b></button>
				</div>

				
			</form>
		</div>
		
	</div>
	@if($errors->any())
	<div class="ui centered grid">
		<div class="ui error message">
			<div class="header">{{$errors->first()}}</div>
		</div>
	</div>
	@endif
</div>
@endsection

@section('js')
	<script src="{{ asset('js/login.js') }}"></script>
@endsection

@section('css')
<style type="text/css">
	body {
      background-color: #DADADA;
      background-image:url( {{ asset('img/mosque.png') }} ) !important;
      background-repeat: no-repeat !important;
      background-size: cover !important;
      background-position: center !important;
      height: 100% !important;
      width: 100% !important;
    }
    body > .grid {
      height: 100%;
    }
    div.topmenu_title{
    	font-family: 'Satisfy', cursive;
	    color: white;
	    text-align: center;
	    letter-spacing: 1px;
	    line-height: 32px;
	    font-size: 28px;
	    padding: 20px 5px;
	    text-shadow: 1px 1px 10px #e9bd1e;
	    margin-bottom: 20px;
	    text-decoration-color: white;
	    text-decoration-style: double;
	    text-decoration-line: underline;
	    text-decoration-thickness: from-font;
    }
</style>
@endsection