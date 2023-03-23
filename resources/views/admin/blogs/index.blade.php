@extends('admin.layouts.app2')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
  <div class="card">
   <div class="card-body">
  <div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
           <h4 class="card-title">Blogs Management</h4>
        </div>
        @can('blog-edit')
        <div class="pull-right">
        <a class="btn btn-success" href="{{ route('blogs.create') }}"> Create New Blog</a> 
        </div>
        @endcan
    </div>
</div>
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

   <table class="table color-table dark-table">
    <thead>
      <tr>
        <th>Blog ID</th>
        <th>Sites ID</th>
        <th>Blog Title</th>
        <th>Edits</th>
      </tr>
    </thead>
    <tbody>
      @for($i=0 ; $i<count($site_blogs) ; $i++)
      <tr>
        <td>{{ $site_blogs[$i]['blog_id'] }}</td>
        <td>{{ $site_blogs[$i]['site_id'] }}</td>
        <td>{{ $site_blogs[$i]['title'] }}</td>
        <td>
        @can('blog-edit')
         <a class="btn btn-primary" href="{{ route('blogs.edit',$site_blogs[$i]['blog_id']) }}">Edit</a>
         @endcan
         @can('blog-delete')
          {!! Form::open(['method' => 'DELETE','route' => ['blogs.destroy', $site_blogs[$i]['blog_id']],'style'=>'display:inline']) !!}
              {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
          {!! Form::close() !!}
          @endcan
        </td>
      </tr>
      @endfor
    </tbody>
  </table>
  {{ $site_blogs->links() }}
          </div>
        </div>
      </div>
@endsection

