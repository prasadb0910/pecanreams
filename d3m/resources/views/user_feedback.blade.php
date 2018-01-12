@extends('adminlte::layouts.app')

@section('main-content')
<div class="row">
    <div class="col-lg-12">
        @if(Session::has('success_msg'))
        <div class="alert alert-success">{{Session::get('success_msg')}}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <p>{{$error}}</p>
            @endforeach()
            </div>
        @endif
        <form id="form_newspaper" action="{{url('index.php/user_feedback/save')}}" method="POST" class="form-horizontal">
            <div class="box">
            <div class="box-header">
                <h4 class="pull-left"><b>Feedback</b></h4>
                <a href="{{url('index.php/user_feedback')}}" class="btn btn-primary btn-sm pull-right">Back</a>
            </div>
            <div class="box-body">
                {{csrf_field()}}
                <div class="form-group">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Name</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input type="hidden" class="form-control" name="id" value="@if(isset($data)){{$data->id}}@endif">
                        <input type="text" class="form-control" name="name" value="@if(isset($data)){{$data->name}}@endif" placeholder="Enter Name...">
                    </div>
                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Email</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input type="text" class="form-control" name="email" value="@if(isset($data)){{$data->email}}@endif" placeholder="Enter Email...">
                    </div>
                </div>
                </div>
                <div class="form-group">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Mobile</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input type="text" class="form-control" name="mobile" value="@if(isset($data)){{$data->mobile}}@endif" placeholder="Enter Mobile...">
                    </div>
                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Type Of Feedback</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input type="text" class="form-control" name="type_of_feedback" value="@if(isset($data)){{$data->type_of_feedback}}@endif" placeholder="Enter Type Of Feedback...">
                    </div>
                </div>
                </div>
                <div class="form-group">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Message</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <textarea class="form-control" rows="3" name="message">@if(isset($data)){{$data->message}}@endif</textarea>
                    </div>
                </div>
                </div>
            </div>
            @if(!Route::is('user_feedback.details'))
            <div class="box-footer">
                <a href="{{url('index.php/user_feedback')}}" class="btn btn-danger btn-sm">Cancel</a>
                <button class="btn btn-success btn-sm pull-right" type="submit">Save</button>
            </div>
            </div>
            @endif
        </form>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    mixpanel.track("User Feedback Page.");
</script>
@endsection