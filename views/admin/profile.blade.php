@extends('admin::_layout.admin')

@section('main')
<h1 class="page-header">{{Lang::get('language.profile')}}</h1>
{{ Form::open(array('url' => '/admin/updateProfile', 'class'=>'form-horizontal')) }}
<form class="form-horizontal">
	<div class="control-group {{{ ($errors->first('name') ? 'has-error' : '') }}}">
		{{ Form::label('name', Lang::get('language.name') . " (*)", array('class'=>'control-label')) }}
		<div class="controls">
			{{ Form::text('name', $profile->name, array('class' => 'form-control')) }}
			{{ Form::hidden('id', $profile->id) }}
			<span class="help-block">{{$errors->first('name')}}</span>
		</div>
	</div>
	<div class="control-group {{{ ($errors->first('username') ? 'has-error' : '') }}}">
		{{ Form::label('username', Lang::get('language.username') . " (*)", array('class'=>'control-label')) }}
		<div class="controls">
			{{ Form::text('username', $profile->username, array('class' => 'form-control','readonly'=>true)) }}
			<span class="help-block">{{$errors->first('username')}}</span>
		</div>
	</div>
	<div class="control-group {{{ ($errors->first('password') ? 'has-error' : '') }}}">
		{{ Form::label('password', Lang::get('language.password') . " (*)", array('class'=>'control-label')) }}
		<div class="controls">
			{{ Form::password('password', array('class' => 'form-control')) }}
			<span class="help-block">{{$errors->first('password')}}</span>
		</div>
	</div>
	<div class="control-group {{{ ($errors->first('password_confirmation') ? 'has-error' : '') }}}">
		{{ Form::label('password_confirmation', Lang::get('language.password-confirmation') . " (*)", array('class'=>'control-label')) }}
		<div class="controls">
			{{ Form::password('password_confirmation', array('class' => 'form-control')) }}
			<span class="help-block">{{$errors->first('password_confirmation')}}</span>
		</div>
	</div>
	<div class="control-group {{{ ($errors->first('email') ? 'has-error' : '') }}}">
		{{ Form::label('email', Lang::get('language.email-address') . " (*)", array('class'=>'control-label')) }}
		<div class="controls">
			{{ Form::text('email', $profile->email, array('class' => 'form-control','readonly'=>true)) }}
			<span class="help-block">{{$errors->first('email')}}</span>
		</div>
	</div>

	<div class="form-actions">
		<p>&nbsp;</p>
		{{ Form::submit(Lang::get('language.save-change'), array('class'=>'btn btn-primary')) }}
		{{ Form::button(Lang::get('language.cancel'), array('class'=>'btn')) }}
	</div>
{{ Form::close() }}
@stop