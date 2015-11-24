@extends('admin::_layout.admin')
@section('leftnav')
@include('admin::_partial._leftnav')
@stop

@section('main')
@include('admin::_partial._listtoolbar')
<h1 class="page-header">{{Lang::get('language.user-list')}}</h1>
<div class="table-responsive">
	<table class="table table-striped">
		<thead>
		<tr>
			<th>{{ Form::checkbox('checkall', 'all', false) }}</th>
			<th>{{Lang::get('language.name')}}</th>
			<th>{{Lang::get('language.username')}}</th>
			<th>{{Lang::get('language.email')}}</th>
			<th>{{Lang::get('language.activate')}}</th>
			<th>{{Lang::get('language.actions')}}</th>
		</tr>
		</thead>
		<tbody>
		@foreach($users as $user)
		<tr>
			<td>{{ Form::checkbox('data[User][id]', $user->id, false) }}</td>
			<td>{{$user->name}}</td>
			<td>{{$user->username}}</td>
			<td>{{$user->email}}</td>
			<td>
			@if($user->status=='active')
			{{ HTML::image('images/icons/checked.png') }}
			@else
			{{ HTML::image('images/icons/unchecked.png') }}
			@endif
			</td>
			<td class="actions">
			{{ HTML::linkAction('useredit','', array('id'=>$user->id), array('class' => 'glyphicon glyphicon-edit')) }}
			{{ HTML::linkAction('userdel','', array('id'=>$user->id), array('class' => 'glyphicon glyphicon-trash delete','data-title'=>Lang::get('admin::common.title'),'data-message'=>Lang::get('admin::common.textMessage'),'data-ok'=>Lang::get('admin::common.ok'),'data-cancel'=>Lang::get('admin::common.cancel'))) }}
			</td>
		</tr>
		@endforeach
		</tbody>
	</table>
</div>
@stop
