@extends('admin::_layout.admin')

@section('leftnav')
@include('admin::_partial._leftnav')
@stop
@section('main')

@include('admin::_partial._listtoolbar')

<h1 class="page-header">{{Lang::get('admin::category.category-list')}}</h1>
<div class="table-responsive">
	<table class="table table-striped">
		<thead>
		<tr>
			<th width="5%">{{ Form::checkbox('checkall', 'all', false) }}</th>
			<th>{{Lang::get('admin::category.title')}}</th>
			<th>{{Lang::get('admin::apps.label')}}</th>
			<th>{{Lang::get('admin::category.status')}}</th>
			<th width="10%">{{Lang::get('language.actions')}}</th>
		</tr>
		</thead>
		<tbody>
		@foreach($categories as $category)
		<tr>
			<td>{{ Form::checkbox('data[Category][id]', $category->id, false) }}</td>
			<td>{{$category->title}}</td>
			<td>{{$category->apps->name}}</td>
			<td>
			@if($category->status==1)
			{{ HTML::image('images/icons/checked.png') }}
			@else
			{{ HTML::image('images/icons/unchecked.png') }}
			@endif
			</td>
			<td class="actions">
			{{ HTML::linkAction('categoryedit','', array('id'=>$category->id), array('class' => 'glyphicon glyphicon-edit')) }}
			{{ HTML::linkAction('categorydel','', array('id'=>$category->id), array('class' => 'glyphicon glyphicon-trash delete','data-title'=>Lang::get('admin::common.title'),'data-message'=>Lang::get('admin::common.textMessage'),'data-ok'=>Lang::get('admin::common.ok'),'data-cancel'=>Lang::get('admin::common.cancel'))) }}
			</td>
		</tr>
		@endforeach
		</tbody>
	</table>
</div>
@stop
