@extends('admin::_layout.admin')

@section('leftnav')
@include('admin::_partial._leftnav')
@stop

@section('main')

@include('admin::_partial._addtoolbar')

<h1 class="page-header">{{Lang::get('admin::user.add-user')}}</h1>
{{ Form::open(array('url' => '/admin/'.$ctrl.'/create', 'class'=>'form-horizontal form-submitable')) }}
	<div class="control-group {{{ ($errors->first('name') ? 'has-error' : '') }}}">
		{{ Form::label('name', Lang::get('admin::user.name') . " (*)", array('class'=>'control-label')) }}
		<div class="controls">
			<div class="arrow_box name-error sending-error-message">
				Darf nicht leer
			</div>
			{{ Form::text('data[User][name]', $user->name, array('class' => 'form-control')) }}
			<span class="help-block">{{$errors->first('name')}}</span>
		</div>
	</div>
	<div class="control-group {{{ ($errors->first('username') ? 'has-error' : '') }}}">
		{{ Form::label('username', Lang::get('admin::user.username') . " (*)", array('class'=>'control-label')) }}
		<div class="controls">
			<div class="arrow_box username-error sending-error-message">
				Darf nicht leer
			</div>
			{{ Form::text('data[User][username]', $user->username, array('class' => 'form-control')) }}
			<span class="help-block">{{$errors->first('username')}}</span>
		</div>
	</div>
	<div class="control-group {{{ ($errors->first('password') ? 'has-error' : '') }}}">
		{{ Form::label('password', Lang::get('admin::user.password') . " (*)", array('class'=>'control-label')) }}
		<div class="controls">
			<div class="arrow_box password-error sending-error-message">
				Darf nicht leer
			</div>
			{{ Form::password('data[User][password]', array('class' => 'form-control')) }}
			<span class="help-block">{{$errors->first('password')}}</span>
		</div>
	</div>
	<div class="control-group {{{ ($errors->first('password_confirmation') ? 'has-error' : '') }}}">
		{{ Form::label('password_confirmation', Lang::get('admin::user.password-confirm') . " (*)", array('class'=>'control-label')) }}
		<div class="controls">
			<div class="arrow_box password_confirmation-error sending-error-message">
				Darf nicht leer
			</div>
			{{ Form::password('data[User][password_confirmation]', array('class' => 'form-control')) }}
			<span class="help-block">{{$errors->first('password_confirmation')}}</span>
		</div>
	</div>
	<div class="control-group {{{ ($errors->first('email') ? 'has-error' : '') }}}">
		{{ Form::label('email', Lang::get('admin::user.email-address') . " (*)", array('class'=>'control-label')) }}
		<div class="controls">
			<div class="arrow_box email-error sending-error-message">
				Darf nicht leer
			</div>
			{{ Form::text('data[User][email]', $user->email, array('class' => 'form-control')) }}
			<span class="help-block">{{$errors->first('email')}}</span>
		</div>
	</div>

	<div class="control-group {{{ ($errors->first('active') ? 'has-error' : '') }}}">
		{{ Form::label('status', Lang::get('admin::user.activate'), array('class'=>'control-label')) }}
		<div class="controls">
			{{ Form::checkbox('data[User][status]', 'active', false) }}
			<span class="help-block">{{$errors->first('active')}}</span>
		</div>
	</div>

	<!-- <div class="form-actions">
		<p>&nbsp;</p>
		{{ Form::submit(Lang::get('admin::user.save-change'), array('class'=>'btn btn-primary')) }}
		{{ Form::button(Lang::get('admin::user.cancel'), array('class'=>'btn','target'=>'/admin/users/')) }}
	</div> -->
{{ Form::close() }}

<hr/>
@include('admin::_partial._addtoolbar')

@stop
