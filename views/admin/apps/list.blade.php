@extends('admin::_layout.admin')

@section('leftnav')
@include('admin::_partial._leftnav')
@stop
@section('main')

@include('admin::_partial._listtoolbar')

<h1 class="page-header">{{Lang::get('admin::apps.apps-list')}}</h1>
<div class="table-responsive">
	<table class="table table-striped">
		<thead>
		<tr>
			<th width="5%">{{ Form::checkbox('checkall', 'all', false) }}</th>
			<th>{{Lang::get('admin::apps.name')}}</th>
			<th>{{Lang::get('admin::apps.folder')}}</th>
			<th>{{Lang::get('admin::apps.status')}}</th>
			<th width="10%">{{Lang::get('language.actions')}}</th>
		</tr>
		</thead>
		<tbody>
		@foreach($apps as $app)
		<tr>
			<td>{{ Form::checkbox('data[Apps][id]', $app->id, false) }}</td>
			<td>{{$app->name}}</td>
			<td>{{$app->folder}}</td>
			<td>
			@if($app->status==1)
			{{ HTML::image('images/icons/checked.png') }}
			@else
			{{ HTML::image('images/icons/unchecked.png') }}
			@endif
			</td>
			<td class="actions">
			{{ HTML::linkAction('appsedit','', array('id'=>$app->id), array('class' => 'glyphicon glyphicon-edit')) }}
			{{ HTML::linkAction('appsdel','', array('id'=>$app->id), array('class' => 'glyphicon glyphicon-trash delete','data-title'=>Lang::get('admin::common.title'),'data-message'=>Lang::get('admin::common.textMessage'),'data-ok'=>Lang::get('admin::common.ok'),'data-cancel'=>Lang::get('admin::common.cancel'))) }}
			</td>
		</tr>
		@endforeach
		</tbody>
	</table>
</div>
@stop
