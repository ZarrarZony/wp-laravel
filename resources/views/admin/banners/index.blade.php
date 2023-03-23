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
            <h4 class="card-title">Banner Management</h4>
        </div>
        @can('banner-create')
        <div class="pull-right">
        <a class="btn btn-success" href="{{ route('banners.create') }}"> Create New Banner</a> 
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
                  <th>Banner ID</th>
                  <th>Banner Name</th>
                  <th>Edits</th>
                </tr>
              </thead>
              <tbody>
                @for($i=0 ; $i<count($banners) ; $i++)
                <tr>
                  <td>{{ $banners[$i]['ban_id'] }}</td>
                  <td>{{ $banners[$i]['name'] }}</td>
                  <td>
                 <a class="btn btn-info" href="{{ route('banners.show',$banners[$i]['ban_id']) }}">Show</a>
                 @can('banner-edit')
                 <a class="btn btn-primary" href="{{ route('banners.edit',$banners[$i]['ban_id']) }}">Edit</a>
                 @endcan
                 @can('banner-delete')
                  {!! Form::open(['method' => 'DELETE','route' => ['banners.destroy', $banners[$i]['ban_id']],'style'=>'display:inline']) !!}
                      {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                  {!! Form::close() !!}
                  @endcan
                </td>
                </tr>
                @endfor
              </tbody>
            </table>
            {{ $banners->links() }}
          </div>
        </div>
      </div>
@endsection

