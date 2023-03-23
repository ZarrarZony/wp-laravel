@extends('web.templates.layouts.app')
@section('newcontent')
<div class="innerContainer">
    <div class="contentWrpr">
    	@if(isset($page_data->page_modules) && !empty($page_data->page_modules))
    	@if(in_array('module1', $page_data->page_modules)) @include('web/templates/Modules/Contact/template1/module1'); @endif
    	@endif
    </div>
</div>
@endsection
