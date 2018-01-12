@extends('adminlte::layouts.app')

@section('main-content')
<div class="row">
    <div class="col-lg-12">
        @if($errors->any())
            <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <p>{{$error}}</p>
            @endforeach()
            </div>
        @endif
        <form id="form_notice_type" action="{{url('index.php/notice_type/save')}}" method="POST" class="form-horizontal">
            <div class="box">
            <div class="box-header">
                <h4 class="pull-left"><b>Notce Type Details</b></h4>
                <a href="{{url('index.php/notice_type')}}" class="btn btn-primary btn-sm pull-right">Back</a>
            </div>
            <div class="box-body">
                {{csrf_field()}}
                <div class="form-group">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Notce Type</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <input type="hidden" class="form-control" name="id" value="@if(isset($data)){{$data->id}}@endif">
                        <input type="text" class="form-control" name="notice_type" value="@if(isset($data)){{$data->notice_type}}@endif" placeholder="Enter Notce Type...">
                    </div>
                </div>
                </div>
            </div>
            @if(!Route::is('notice_type.details'))
            <div class="box-footer">
                <a href="{{url('index.php/notice_type')}}" class="btn btn-danger btn-sm">Cancel</a>
                <button class="btn btn-success btn-sm pull-right" type="submit">Save</button>
            </div>
            </div>
            @endif
        </form>
    </div>
</div>
@endsection