@extends('admin::_layout.admin')
@section('leftnav')
@include('admin::_partial._leftnav')
@stop

@section('main')

<h1>{{$exportMessage}}</h1>
@stop
