@extends('admin.layouts.app2')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    <div class="card">
      <div class="card-body">
       <h4 class="card-title">Site Banner</h4>
          <div class="box-header with-border">
               @if(session()->has('message'))
                <div class="alert alert-success">
                  {{ session()->get('message') }}
                </div>
                @endif
                @if(session()->has('error'))
                <div class="alert alert-danger">
                  {{ session()->get('error') }}
                </div>
               @endif
          </div>
          <!-- general form elements -->
          <div class="box box-primary">
            @if(!empty($banners))
            @php
            $action=route("banners.update",$banners['ban_id']);
            @endphp
            @else
            @php
            $action=route("banners.store");
            @endphp
            @endif
            <form method="post" action="{{ $action }}"  enctype="multipart/form-data">
            @if(!empty($banners)) <input name="_method" type="hidden" value="PATCH"> @endif
                @csrf
              <div class="box-body">
              <div class="col-md-6">
              <div class="form-group">
                  <label>Select Site</label>
                    <select name="site_id" class="form-control" id="banner_site_select">
                    <option value="0"></option>
                     @foreach($sites as $site)
                     <option value="{{ $site['site_id'] }}" @if(@$banners['site_id']==$site['site_id']) selected @endif>{{ $site['name'] }}</option>
                     @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label>Name of Banner</label>
                  <input name="name" placeholder="Banner Name" value="{{ @$banners['name'] }}" type="text" class="form-control" >
                </div>
           <?php $unique_class = "kc_image_banner";
            $unique_name = "thumbnail";
            $folder='blog'; ?>
                <div class="form-group">
                <label>Banner Thumbnail AWS</label>
                <div class="{{ $unique_class }} kc_img_div" data-name="{{ $unique_name }}">
                <span class="no_img ">No Images Selected.</span>
                {!! @$thumb_imgs !!}
               </div>
                <button type="button" value=""  onclick="awsfunction('{{ $unique_class }}')" class="margin-5 btn btn-primary btn-sm">Select Images</button>
                </div>
              <input type="hidden" id="{{ $unique_class }}" value="">
          <?php $unique_class = "kc_image_banner_full";
            $unique_name = "full_images";
            $folder='banner'; ?>
                <div class="form-group">
                <label>Banner Full images AWS</label>
                <div class="{{ $unique_class }} kc_img_div" data-name="{{ $unique_name }}">
                <span class="no_img ">No Images Selected.</span>
                {!! @$full_imgs !!}
               </div>
                <button type="button" value=""  onclick="awsfunction('{{ $unique_class }}')" class="margin-5 btn btn-primary btn-sm">Select Images</button>
                </div>
                <input type="hidden" id="{{ $unique_class }}" value="">
              <div class="form-group">
                <div class="checkbox checkbox-success">
                  <input name="publish" id="checkbox_banner" value="1" type="checkbox" class="minimal" @if(@$banners['publish']==1) checked @endif>
                  <label for="checkbox_banner">
                  Public
                </label>
              </div>
              </div>
            <input  value="SAVE" type="submit" class="btn btn-success btn-grad submit_btn">
              </div>
            </form>
          </div>
          <!-- /.box -->
      </div>
    </div>
  </div>
@endsection

