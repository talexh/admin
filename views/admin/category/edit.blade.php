@extends('admin::_layout.admin')

@section('leftnav')
@include('admin::_partial._leftnav')
@stop

@section('main')

@include('admin::_partial._addtoolbar')

<h1 class="page-header">{{Lang::get('admin::category.category-edit')}}</h1>
{{ Form::open(array('url' => '/admin/category/update/', 'class'=>'form-horizontal form-submitable','files'=> true )) }}
	{{ Form::hidden('data[Category][id]', $categoryObject->id) }}
	<div id="main-container" class="main-container">
		<div class="control-group {{{ ($errors->first('app_id') ? 'has-error' : '') }}}">
			{{ Form::label('app_id', Lang::get('admin::apps.label') , array('class'=>'control-label')) }}
			<div class="controls">
				<div class="arrow_box appId-error sending-error-message">
					Darf nicht leer
				</div>
				{{ Form::select('data[Category][app_id]', $apps , $categoryObject->app_id, array('class' => 'form-control')) }}
				<span class="help-block">{{$errors->first('app_id')}}</span>
			</div>
		</div>
		<div class="control-group {{{ ($errors->first('title') ? 'has-error' : '') }}}">
			{{ Form::label('title', Lang::get('admin::category.title') . " (*)", array('class'=>'control-label')) }}
			<div class="controls">
				<div class="arrow_box title-error sending-error-message">
					Darf nicht leer
				</div>
				{{ Form::text('data[Category][title]', $categoryObject? $categoryObject->title : '', array('class' => 'form-control')) }}
				<span class="help-block">{{$errors->first('title')}}</span>
			</div>
		</div>

		<div class="control-group {{{ ($errors->first('sorting') ? 'has-error' : '') }}}">
			&nbsp;
			{{ Form::label('sorting', Lang::get('admin::category.sorting'), array('class'=>'control-label')) }}
			<div class="controls">
				{{ Form::text('data[Category][sorting]', $categoryObject? $categoryObject->sorting : '', array('class' => 'form-control textfield-very-shortly')) }}
				<span class="help-block">{{$errors->first('sorting')}}</span>
			</div>
		</div>
		<div class="control-group">
			{{ Form::label('filename', Lang::get('admin::category.image'), array('class'=>'control-label')) }}
			<div class="controls">
				@if($categoryObject->image_path)
				<img src="{{$categoryObject->image_path . '/' . (($categoryObject->allowed_resize == 'resized') ? 'thumb_' : '') . $categoryObject->image_name . '.' . $categoryObject->image_ext}}" data-preview="/images/eye_preview.png" class="preview" width="100"/><br/><br/>
				@else
				<img src="/images/eye_preview.png" data-preview="/images/eye_preview.png" class="preview" title="Preview" width="100"/><br/><br/>
				@endif

				<div class="arrow_box image_ext-error sending-error-message">
					Darf nicht leer
				</div>
				<a href="javascript:;" class="btn btn-default button image browse" title="{{Lang::get('admin::language.browse')}}">Browse...</a>
				@if($categoryObject->image_name)
				<span class="filename" data-old="{{ $categoryObject->image_name.'.'.$categoryObject->image_ext }}">{{ $categoryObject->image_name.'.'.$categoryObject->image_ext }}</span>
				@endif
				{{ Form::file('filename', array('class'=>'hidden','id'=>'category-icon','data-type'=>'image')) }}
			</div>
		</div>
		<div class="control-group {{{ ($errors->first('status') ? 'has-error' : '') }}}">
			&nbsp;
			{{ Form::label('status', Lang::get('admin::category.status'), array('class'=>'control-label')) }}
			<div class="controls">
				{{ Form::checkbox('data[Category][status]', 1, $categoryObject? $categoryObject->status : false) }}
				<span class="help-block">{{$errors->first('status')}}</span>
			</div>
		</div>

	</div>

{{ Form::close() }}
@stop
