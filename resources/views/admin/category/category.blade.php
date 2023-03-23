@extends('admin.layouts.app2')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    <div class="card">
      <div class="card-body">
          <div class="box-header with-border">
            <h4 class="card-title">Site Categories</h4>
              @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
                @endif
            </div>
          <!-- general form elements -->
          <div class="box box-primary">
            @if(!empty($cat_data))
            @php
            $action=route("categories.update",$cat_data['cat_id']);
            @endphp
            @else
            @php
            $action=route("categories.store");
            @endphp
            @endif
          </div>
            <!-- form start -->
            <form method="post" action=" {{ $action }} " enctype="multipart/form-data">
              @if(!empty($cat_data)) <input name="_method" type="hidden" value="PATCH"> @endif
                @csrf
              <div class="box-body">
                <div class="col-md-6">
                <div class="form-group">
                  <label>Select Site</label>
                    <select name="site_id" class="form-control" id="category_site_select">
                    <option value="0"></option>
                     @foreach($sites as $site)
                     <option value="{{ $site['site_id'] }}" @if(@$cat_data['site_id']==$site['site_id']) selected @endif>{{ $site['name'] }}</option>
                     @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label>Category Title</label>
                  <input name="title" placeholder="Title" id="cat_title_id" value="{{ @$cat_data['title'] }}" type="text" class="form-control" >
                </div>
                <div class="form-group">
                  <label>Category Slug</label>
                  <input name="slug" placeholder="Slug" id="cat_slug_id" value="{{ @$cat_data['slug'] }}" type="text" class="form-control" >
                </div>
              @if(isset($for_slug) && !empty($for_slug))
               <div class="form-group">
                  <label>Childeren of</label>
                    <select name="slug_parent_id" class="form-control">
                    <option value="0"></option>
                     @foreach($for_slug as $slug)
                     <option value="{{ $slug['cat_id'] }}" @if(@$slug['cat_id']==@$cat_data['slug_parent_id']) selected @endif>{{ $slug['title'] }}</option>
                     @endforeach
                  </select>
                </div>
                @endif
                <div class="form-group">
           <?php $unique_class = "kc_image_category";
            $unique_name = "icon";
            $folder='category'; ?>
                <div class="form-group">
                <label>Category Icon</label>
                <div class="{{ $unique_class }} kc_img_div" data-name="{{ $unique_name }}">
                <span class="no_img ">No Images Selected.</span>
                {!! @$cat_img !!}
               </div>
                <button type="button" value=""  onclick="awsfunction('{{ $unique_class }}')" class="margin-5 btn btn-primary btn-sm">Select Images</button>
                </div>
                <input type="hidden" id="{{ $unique_class }}" value="">
                </div>
                 <div class="form-group">
                  <label>Category Discription</label><br> 
                  <textarea name="discription" rows="15" cols="60" value="" placeholder="Category discription here.." id="editor">{{ @$cat_data['discription'] }}</textarea>
                </div>
              <div class="form-group">
                <div class="checkbox checkbox-success">
                  <input name="publish" id="checkbox_category" value="1" type="checkbox" class="minimal" @if(@$cat_data['publish']==1) checked @endif>
                  <label for="checkbox_category"> Public </label>
                </div>
              </div>
            <input value="SAVE" type="submit" class="btn btn-success btn-grad submit_btn">
              </div>
            </form>
          </div>
          <!-- /.box -->
        </div>
      </div>
    </div>

@endsection

