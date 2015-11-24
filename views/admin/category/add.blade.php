@extends('admin::_layout.admin')

@section('leftnav')
@include('admin::_partial._leftnav')
@stop

@section('main')

@include('admin::_partial._addtoolbar')

<h1 class="page-header">{{Lang::get('admin::category.category-add')}}</h1>
{{ Form::open(array('url' => '/admin/'.$ctrl.'/create', 'class'=>'form-horizontal form-submitable','files'=> true )) }}
	<div id="main-container" class="main-container">

		<div class="control-group {{{ ($errors->first('app_id') ? 'has-error' : '') }}}">
			{{ Form::label('app_id', Lang::get('admin::apps.label') , array('class'=>'control-label')) }}
			<div class="controls">
				<div class="arrow_box appId-error sending-error-message">
	            	Darf nicht leer
	          	</div>
				{{ Form::select('data[Category][app_id]', $apps , 0, array('class' => 'form-control')) }}
				<span class="help-block">{{$errors->first('app_id')}}</span>
			</div>
		</div>
		<div class="control-group {{{ ($errors->first('title') ? 'has-error' : '') }}}">

			{{ Form::label('title', Lang::get('admin::category.title') . " (*)", array('class'=>'control-label')) }}
			<div class="controls">
				<div class="arrow_box title-error sending-error-message">
	            	Darf nicht leer
	          	</div>
				{{ Form::text('data[Category][title]', '', array('class' => 'form-control')) }}
				<span class="help-block">{{$errors->first('title')}}</span>
			</div>
		</div>

		<div class="control-group {{{ ($errors->first('sorting') ? 'has-error' : '') }}}">
			&nbsp;
			{{ Form::label('sorting', Lang::get('admin::category.sorting'), array('class'=>'control-label')) }}
			<div class="controls">
				{{ Form::text('data[Category][sorting]', '', array('class' => 'form-control textfield-very-shortly')) }}
				<span class="help-block">{{$errors->first('sorting')}}</span>
			</div>
		</div>
		<div class="control-group">
			{{ Form::label('filename', Lang::get('admin::category.image'), array('class'=>'control-label')) }}
			<div class="controls">
				<img src="/images/eye_preview.png" data-preview="/images/eye_preview.png" class="preview" title="Preview" width="100"/><br/><br/>
				<a href="javascript:;" class="btn btn-default button image browse" title="{{Lang::get('admin::language.browse')}}">Browse...</a>
				{{ Form::file('filename', array('class'=>'hidden','id'=>'category-icon','data-type'=>'image')) }}
			</div>
		</div>
		<div class="control-group {{{ ($errors->first('status') ? 'has-error' : '') }}}">
			&nbsp;
			{{ Form::label('status', Lang::get('admin::category.status'), array('class'=>'control-label')) }}
			<div class="controls">
				{{ Form::checkbox('data[Category][status]', 1, true) }}
				<span class="help-block">{{$errors->first('status')}}</span>
			</div>
		</div>


	</div>


{{ Form::close() }}
@stop
