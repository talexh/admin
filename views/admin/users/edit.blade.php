@extends('admin::_layout.admin')

@section('leftnav')
@include('admin::_partial._leftnav')
@stop


@section('main')

@include('admin::_partial._edittoolbar')

<h1 class="page-header">{{Lang::get('admin::user.edit-user')}}</h1>
{{ Form::open(array('url' => '/admin/'.$ctrl.'/update', 'class'=>'form-horizontal form-submitable')) }}
	{{ Form::hidden('data[User][id]', $user->id) }}
	<div class="control-group {{{ ($errors->first('name') ? 'has-error' : '') }}}">
		{{ Form::label('name', Lang::get('admin::user.name') . " (*)", array('class'=>'control-label')) }}
		<div class="controls">
			{{ Form::text('data[User][name]', $user->name, array('class' => 'form-control')) }}
			<span class="help-block">{{$errors->first('name')}}</span>
		</div>
	</div>
	<div class="control-group {{{ ($errors->first('username') ? 'has-error' : '') }}}">
		{{ Form::label('username', Lang::get('admin::user.username') . " (*)", array('class'=>'control-label')) }}
		<div class="controls">
			{{ Form::text('data[User][username]', $user->username, array('class' => 'form-control','readonly'=>true)) }}
			<span class="help-block">{{$errors->first('username')}}</span>
		</div>
	</div>
	<div class="control-group {{{ ($errors->first('password') ? 'has-error' : '') }}}">
		{{ Form::label('password', Lang::get('admin::user.password') . " (*)", array('class'=>'control-label')) }}
		<div class="controls">
			{{ Form::password('data[User][password]', array('class' => 'form-control')) }}
			<span class="help-block">{{$errors->first('password')}}</span>
		</div>
	</div>
	<div class="control-group {{{ ($errors->first('password_confirmation') ? 'has-error' : '') }}}">
		{{ Form::label('password_confirmation', Lang::get('admin::user.password-confirm') . " (*)", array('class'=>'control-label')) }}
		<div class="controls">
			{{ Form::password('data[User][password_confirmation]', array('class' => 'form-control')) }}
			<span class="help-block">{{$errors->first('password_confirmation')}}</span>
		</div>
	</div>
	<div class="control-group {{{ ($errors->first('email') ? 'has-error' : '') }}}">
		{{ Form::label('email', Lang::get('admin::user.email-address') . " (*)", array('class'=>'control-label')) }}
		<div class="controls">
			{{ Form::text('data[User][email]', $user->email, array('class' => 'form-control','readonly'=>true)) }}
			<span class="help-block">{{$errors->first('email')}}</span>
		</div>
	</div>

	<div class="control-group {{{ ($errors->first('status') ? 'has-error' : '') }}}">
		{{ Form::label('status', Lang::get('admin::user.activate'), array('class'=>'control-label')) }}
		<div class="controls">
			{{ Form::checkbox('data[User][status]', $user->status, $user->status ) }}
			<span class="help-block">{{$errors->first('status')}}</span>
		</div>
	</div>

	<!-- <div class="form-actions actions">
		<p>&nbsp;</p>
		{{ Form::submit(Lang::get('admin::user.save-change'), array('class'=>'btn btn-primary')) }}
		{{ Form::button(Lang::get('admin::user.cancel'), array('class'=>'btn cancel','target'=>'/admin/users/')) }}
	</div> -->
{{ Form::close() }}

@stop
