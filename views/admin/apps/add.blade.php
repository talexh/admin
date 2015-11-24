@extends('admin::_layout.admin')

@section('leftnav')
@include('admin::_partial._leftnav')
@stop

@section('main')

@include('admin::_partial._addtoolbar')

<h1 class="page-header">{{Lang::get('admin::apps.apps-add')}}</h1>
{{ Form::open(array('url' => '/admin/apps/create', 'class'=>'form-horizontal form-submitable','files'=> true )) }}
	<div id="main-container" class="main-container">

		<div class="control-group {{{ ($errors->first('name') ? 'has-error' : '') }}}">

			{{ Form::label('name', Lang::get('admin::apps.name') . " (*)", array('class'=>'control-label')) }}
			<div class="controls">
				<div class="arrow_box name-error sending-error-message">
	            	Darf nicht leer
	          	</div>
				{{ Form::text('data[Apps][name]', '', array('class' => 'form-control')) }}
				<span class="help-block">{{$errors->first('name')}}</span>
			</div>
		</div>
		<div class="control-group {{{ ($errors->first('folder') ? 'has-error' : '') }}}">

			{{ Form::label('folder', Lang::get('admin::apps.folder'), array('class'=>'control-label')) }}<i>{{Lang::get('admin::apps.explaining')}}</i>
			<div class="controls">
				<div class="arrow_box folder-error sending-error-message">
	            	Darf nicht leer
	          	</div>
				{{ Form::text('data[Apps][folder]', '', array('class' => 'form-control','maxlength'=>20)) }}
				<span class="help-block">{{$errors->first('folder')}}</span>
			</div>
		</div>
		<div class="control-group {{{ ($errors->first('description') ? 'has-error' : '') }}}">

			{{ Form::label('description', Lang::get('admin::apps.description'), array('class'=>'control-label')) }}
			<div class="controls">
				{{ Form::textarea('data[Apps][description]','', array('class' => 'form-control')) }}
				<span class="help-block">{{$errors->first('description')}}</span>
			</div>
		</div>
		<div class="control-group {{{ ($errors->first('sorting') ? 'has-error' : '') }}}">
			&nbsp;
			{{ Form::label('sorting', Lang::get('admin::apps.sorting'), array('class'=>'control-label')) }}
			<div class="controls">
				<div class="arrow_box sorting-error sending-error-message">
	            	Darf nicht leer
	          	</div>
				{{ Form::text('data[Apps][sorting]', '', array('class' => 'form-control textfield-very-shortly')) }}
				<span class="help-block">{{$errors->first('sorting')}}</span>
			</div>
		</div>
		<div class="control-group {{{ ($errors->first('status') ? 'has-error' : '') }}}">
			&nbsp;
			{{ Form::label('status', Lang::get('admin::apps.status'), array('class'=>'control-label')) }}
			<div class="controls">
				{{ Form::checkbox('data[Apps][status]', 1, true) }}
				<span class="help-block">{{$errors->first('status')}}</span>
			</div>
		</div>

	</div>


{{ Form::close() }}
@stop
