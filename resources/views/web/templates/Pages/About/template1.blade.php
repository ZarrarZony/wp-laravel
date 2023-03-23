@extends('web.templates.layouts.app')
@section('newcontent')
<div class="breadcrumb">
    <ul>
        <li>
            <a href="index.php"><i class="lm_home"></i> Home</a>
        </li>
        <li>
            <a href="about_us.php">About Us</a>
        </li>
    </ul>
</div>
<div class="innerContainer">
    <div class="contentWrpr">
@if(isset($page_data->page_modules) && !empty($page_data->page_modules))
@if(in_array('module1', $page_data->page_modules)) @include('web/templates/Modules/About/template1/module1') @endif
@if(in_array('module2', $page_data->page_modules)) @include('web/templates/Modules/About/template1/module2') @endif
@if(in_array('module3', $page_data->page_modules)) @include('web/templates/Modules/About/template1/module3') @endif
@if(in_array('module4', $page_data->page_modules)) @include('web/templates/Modules/About/template1/module4') @endif
    </div>
</div>
@if(in_array('module5', $page_data->page_modules)) @include('web/templates/Modules/About/template1/module5') @endif
@endif
@endsection
