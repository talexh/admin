@extends('admin::_layout.admin')

@section('leftnav')
@include('admin::_partial._leftnav')
@stop

@section('main')

@include('admin::_partial._addtoolbar')

<h1 class="page-header">{{Lang::get('admin::news.news-edit')}}</h1>
{{ Form::open(array('url' => '/admin/news/update/', 'class'=>'form-horizontal form-submitable','files'=> true )) }}
	{{ Form::hidden('data[News][id]', $newsObject->id) }}
	<div id="main-container" class="main-container">
		<div class="control-group {{{ ($errors->first('app_id') ? 'has-error' : '') }}}">
			{{ Form::label('app_id', Lang::get('admin::apps.label') , array('class'=>'control-label')) }}
			<div class="controls">
				<div class="arrow_box appId-error sending-error-message">
					Darf nicht leer
				</div>
				{{ Form::select('data[News][app_id]', $apps , $newsObject->app_id, array('class' => 'form-control')) }}
				<span class="help-block">{{$errors->first('app_id')}}</span>
			</div>
		</div>
		<div class="control-group {{{ ($errors->first('category_id') ? 'has-error' : '') }}}">
			{{ Form::label('category_id', Lang::get('admin::category.label') , array('class'=>'control-label')) }}
			<div class="controls">
				<div class="arrow_box categoryId-error sending-error-message">
	            	Darf nicht leer
	          	</div>
				{{ Form::select('data[News][category_id]', $categories , $newsObject->category_id, array('class' => 'form-control')) }}
				<span class="help-block">{{$errors->first('category_id')}}</span>
			</div>
		</div>
		<div class="control-group {{{ ($errors->first('title') ? 'has-error' : '') }}}">
			{{ Form::label('title', Lang::get('admin::news.title') . " (*)", array('class'=>'control-label')) }}
			<div class="controls">
				<div class="arrow_box title-error sending-error-message">
					Darf nicht leer
				</div>
				{{ Form::text('data[News][title]', $newsObject? $newsObject->title : '', array('class' => 'form-control')) }}
				<span class="help-block">{{$errors->first('title')}}</span>
			</div>
		</div>
		<div class="control-group {{{ ($errors->first('description') ? 'has-error' : '') }}}">

			{{ Form::label('description', Lang::get('admin::news.description'), array('class'=>'control-label')) }}
			<div class="controls">
				{{ Form::textarea('data[News][description]',$newsObject? $newsObject->description : '', array('class' => 'form-control')) }}
				<span class="help-block">{{$errors->first('description')}}</span>
			</div>
		</div>
		<div class="control-group {{{ ($errors->first('sorting') ? 'has-error' : '') }}}">
			&nbsp;
			{{ Form::label('sorting', Lang::get('admin::news.sorting'), array('class'=>'control-label')) }}
			<div class="controls">
				{{ Form::text('data[News][sorting]', $newsObject? $newsObject->sorting : '', array('class' => 'form-control textfield-very-shortly')) }}
				<span class="help-block">{{$errors->first('sorting')}}</span>
			</div>
		</div>
		<div class="control-group {{{ ($errors->first('status') ? 'has-error' : '') }}}">
			&nbsp;
			{{ Form::label('status', Lang::get('admin::news.status'), array('class'=>'control-label')) }}
			<div class="controls">
				{{ Form::checkbox('data[News][status]', 1, $newsObject? $newsObject->status : false) }}
				<span class="help-block">{{$errors->first('status')}}</span>
			</div>
		</div>
		<div class="control-group">
			{{ Form::label('filename', Lang::get('admin::news.image'), array('class'=>'control-label')) }}
			<div class="controls">
				@if($newsObject->image_path)
				<img src="{{$newsObject->image_path . '/' . (($newsObject->allowed_resize == 'resized') ? 'thumb_' : '') . $newsObject->image_name . '.' . $newsObject->image_ext}}" data-preview="/images/eye_preview.png" class="preview" width="100"/><br/><br/>
				@else
				<img src="/images/eye_preview.png" data-preview="/images/eye_preview.png" class="preview" title="Preview" width="100"/><br/><br/>
				@endif

				<div class="arrow_box image_ext-error sending-error-message">
					Darf nicht leer
				</div>
				<a href="javascript:;" class="btn btn-default button image browse" title="{{Lang::get('admin::language.browse')}}">Browse...</a>
				@if($newsObject->image_name)
				<span class="filename" data-old="{{ $newsObject->image_name.'.'.$newsObject->image_ext }}">{{ $newsObject->image_name.'.'.$newsObject->image_ext }}</span>
				@endif
				{{ Form::file('filename', array('class'=>'hidden','id'=>'news-icon','data-type'=>'image')) }}
			</div>
		</div>

		<div class="control-group">
			<br/>
			{{ Form::label('sound', Lang::get('admin::news.sound'), array('class'=>'control-label')) }}
			<div class="controls">
				<div class="arrow_box media_ext-error sending-error-message">
					Darf nicht leer
				</div>
				<a href="javascript:;" class="btn btn-default button file browse" title="{{Lang::get('admin::language.browse')}}">Browse...</a>
				@if($newsObject->sound)
				<span class="filename" data-old="{{ basename($newsObject->sound) }}">{{ basename($newsObject->sound) }}</span>
				@endif
				{{ Form::file('musics', array('class'=>'hidden','id'=>'news-sound-icon','data-type'=>'media')) }}
			</div>
		</div>

	</div>

{{ Form::close() }}
@stop
