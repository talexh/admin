@extends('admin::_layout.admin')
@section('leftnav')
@include('admin::_partial._leftnav')
@stop

@section('main')

<h1>Export</h1>
{{ Form::open(array('url' => '/admin/do-export', 'class'=>'form-horizontal form-submitable')) }}
	<div id="main-container" class="main-container">
		<div class="control-group">
			{{ Form::label('app_id', Lang::get('admin::apps.label') , array('class'=>'control-label')) }}
			<div class="controls">
				{{ Form::select('app_id', $apps , 0, array('class' => 'form-control')) }}
			</div>
		</div>
		<div class="control-group">
			{{ Form::label('', '' , array('class'=>'control-label')) }}
			<div class="controls">
				{{ Form::submit('Export data for app') }}
			</div>
		</div>

	</div>
{{ Form::close() }}
@stop
