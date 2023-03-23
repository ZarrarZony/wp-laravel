@extends('admin.layouts.app2')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    <div class="card">
      <div class="card-body">
          <div class="box-header with-border">
               <h4 class="card-title">Site Blogs</h4>
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
            @if(!empty($site_blog))
            @php
            $action=route("blogs.update",$site_blog['blog_id']);
            @endphp
            @else
            @php
            $action=route("blogs.store");
            @endphp
            @endif
            <!-- form start -->
            <form method="post" action=" {{ $action }} " enctype="multipart/form-data">
              @if(!empty($site_blog)) <input name="_method" type="hidden" value="PATCH"> @endif
                @csrf
              <div class="box-body">
                <div class="col-md-6">
                  *Current site is wp_laravel
             <div class="form-group">
                  <label>Select Site</label>
                    <select name="site_id" class="form-control" id="blog_site_select">
                    <option value="0"></option>
                     @foreach($sites as $site)
                     <option value="{{ $site['site_id'] }}" @if(@$site_blog['site_id']==$site['site_id']) selected @endif>{{ $site['name'] }}</option>
                     @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label>Blog Title</label>
                  <input name="title" id="blog_title_id" placeholder="Title" value="{{ @$site_blog['title'] }}" type="text" class="form-control" >
                </div>
                <div class="form-group">
                  <label>Blog Slug</label>
                  <input name="slug" id="blog_slug_id" placeholder="Slug" value="{{ @$site_blog['slug'] }}" type="text" class="form-control" >
                </div>

                 <div class="form-group">
                  <label>Blog Content</label><br> 
                  <textarea name="content" rows="15" cols="60" value="" placeholder="Your content here.." id="editor">{{ @$site_blog['content'] }}</textarea>
                </div>
              <div class="form-group">
                <div class="checkbox checkbox-success">
                  <input name="publish" value="1" type="checkbox" id="checkbox_blogs" class="minimal" @if(@$site_blog['publish']==1) checked @endif>
                <label for="checkbox_blogs"> Public </label>
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

