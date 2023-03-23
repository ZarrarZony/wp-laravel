@extends('web.templates.layouts.app')
@section('newcontent')
    	@if(isset($page_data->page_modules) && !empty($page_data->page_modules))
    	@if(in_array('module1', $page_data->page_modules)) @include('web/templates/Modules/Contact/template3/module1'); @endif
    	@endif
@endsection
