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
            <h2>Category Management</h2>
        </div>
        @can('category-create')
        <div class="pull-right">
        <a class="btn btn-success" href="{{ route('categories.create') }}"> Create New Category</a> 
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
        <th>Sites ID</th>
        <th>Category Name</th>
        <th>Edits</th>
      </tr>
    </thead>
    <tbody>
      @for($i=0 ; $i<count($cat_data) ; $i++)
      <tr>
        <td>{{ $cat_data[$i]['site_id'] }}</td>
        <td>{{ $cat_data[$i]['title'] }}</td>
        <td>
         <a class="btn btn-info" href="{{ route('categories.show',$cat_data[$i]['cat_id']) }}">Show</a>
         @can('category-edit')
         <a class="btn btn-primary" href="{{ route('categories.edit',$cat_data[$i]['cat_id']) }}">Edit</a>
         @endcan
         @can('category-delete')
          {!! Form::open(['method' => 'DELETE','route' => ['categories.destroy', $cat_data[$i]['cat_id']],'style'=>'display:inline']) !!}
              {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
          {!! Form::close() !!}
          @endcan
        </td>
      </tr>
      @endfor
    </tbody>
  </table>
  {{ $cat_data->links() }}
          </div>
        </div>
      </div>
@endsection

