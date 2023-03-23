@extends('web.templates.layouts.app')
@section('newcontent')
@if(isset($page_data->page_modules) && !empty($page_data->page_modules))
@if(in_array('banner', $page_data->page_modules)) @include('web/templates/Modules/Home/template1/banner') @endif
@if(in_array('top_stores_slider', $page_data->page_modules)) @include('web/templates/Modules/Home/template1/top_stores_slider') @endif
@if(in_array('feature_coupons', $page_data->page_modules)) @include('web/templates/Modules/Home/template1/feature_coupons') @endif
@if(in_array('categories', $page_data->page_modules)) @include('web/templates/Modules/Home/template1/categories') @endif
@if(in_array('recommended_coupons', $page_data->page_modules)) @include('web/templates/Modules/Home/template1/recommended_coupons') @endif

{{-- popup checking --}}
@if(isset($total_popups) && !empty($total_popups))
@for($i=1;$i<=$total_popups;$i++)
@if(in_array('popup'.$i, $page_data->page_modules)) @include('web/templates/Modules/popups/popup'.$i) @endif
@endfor
@endif

@else
{{ die('no data for this page found') }}
@endif
@endsection
