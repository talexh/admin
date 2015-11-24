@extends('admin::_layout.admin')

@section('leftnav')
@include('admin::_partial._leftnav')
@stop
@section('main')

@include('admin::_partial._listtoolbar')
<h1 class="page-header">{{Lang::get('admin::news.news-list')}}</h1>
<div class="table-responsive">
	<table class="table table-striped">
		<thead>
		<tr>
			<th width="5%">{{ Form::checkbox('checkall', 'all', false) }}</th>
			<th>{{Lang::get('admin::news.title')}}</th>
			<th>{{Lang::get('admin::category.label')}}
			{{ Form::select('categoryId', $categories , $categoryId , array('class' => 'form-control changable','id'=>'categoryId','data-ctrl'=>$ctrl)) }}
			</th>
			<th>{{Lang::get('admin::apps.label')}}
			{{ Form::select('appId', $apps , $appId , array('class' => 'form-control changable','id'=>'appId','data-ctrl'=>$ctrl)) }}
			</th>
			<th>{{Lang::get('admin::news.status')}}</th>
			<th width="10%">{{Lang::get('language.actions')}}</th>
		</tr>
		</thead>
		<tbody>
		@foreach($newss as $news)
		<tr>
			<td>{{ Form::checkbox('data[News][id]', $news->id, false) }}</td>
			<td>{{$news->title}}</td>
			<td>{{$news->Category->title}}</td>
			<td>{{$news->apps->name}}</td>
			<td>
			@if($news->status==1)
			{{ HTML::image('images/icons/checked.png') }}
			@else
			{{ HTML::image('images/icons/unchecked.png') }}
			@endif
			</td>
			<td class="actions">
			{{ HTML::linkAction('newsedit','', array('id'=>$news->id), array('class' => 'glyphicon glyphicon-edit')) }}
			{{ HTML::linkAction('newsdel','', array('id'=>$news->id), array('class' => 'glyphicon glyphicon-trash delete','data-title'=>Lang::get('admin::common.title'),'data-message'=>Lang::get('admin::common.textMessage'),'data-ok'=>Lang::get('admin::common.ok'),'data-cancel'=>Lang::get('admin::common.cancel'))) }}
			</td>
		</tr>
		@endforeach
		<tr>
			<td colspan="5">
				{{ $newss->links() }}
			</td>
		</tr>
		</tbody>
	</table>
</div>
@stop
