@extends('layouts.default')

@section('content')
    
	@if(View::exists('shop.'.$params['page']))
	    @include('shop.'.$params['page'])
	@else
	    @include('includes.errorcontent')
	@endif

@stop