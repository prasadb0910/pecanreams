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
        <form id="form_newspaper" action="{{url('index.php/user/save')}}" method="POST" class="form-horizontal">
			{{ csrf_field() }}
            <div class="box">
            <div class="box-header">
                <h4 class="pull-left"><b>New User Details</b></h4>
                <a href="{{url('index.php/user/')}}" class="btn btn-primary btn-sm pull-right">Back</a>
            </div>
            <div class="box-body">
		
          <!--<input type="hidden" name="_token" value="{{ csrf_token() }}">-->
                <input type="hidden" class="form-control" name="gu_id" value="@if(isset($data)){{$data->gu_id}}@endif"placeholder="Enter Name...">
                <input type="hidden" class="form-control" name="assigned_role" value="@if(isset($data)){{$data->assigned_role}}@endif" placeholder="Enter Name...">
				   
				   
				   
                <div class="form-group">
                <div class="col-md-12 col-sm-12 col-xs-12">
              <label class="col-md-2 col-sm-2 col-xs-12 control-label">Name</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input type="text" class="form-control" name="name" value="@if(isset($data)){{$data->name}}@endif" placeholder="Enter Name...">
                    </div>
                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Email Id:</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input type="text" class="form-control" name="gu_email" value="@if(isset($data)){{$data->gu_email}}@endif" placeholder="Enter Email Id...">
                    </div>
                </div>
                </div>
                <div class="form-group">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Password</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input type="password" class="form-control" name="gu_password" value="@if(isset($data)){{$data->gu_password}}@endif" placeholder="Enter Password...">
                    </div>
                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Mobile No.</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input type="text" class="form-control" name="gu_mobile" value="@if(isset($data)){{$data->gu_mobile}}@endif" placeholder="Enter Mobile No...">
                    </div>
                </div>
                </div>
				   <div class="form-group">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Plan Name</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input type="text" class="form-control" name="plan_name" value="@if(isset($data)){{$data->gu_mobile}}@endif" placeholder="Enter Plan Name...">
                    </div>
					
					<label class="col-md-2 col-sm-2 col-xs-12 control-label">Status</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <!-- <input type="text" class="form-control" name="e_paper" value="@if(isset($data)){{--$data->e_paper--}}@endif" placeholder="EnterE Paper..."> -->
                        <select class="form-control" id="status" name="status" >
                            <option value="Active" @if(isset($data)) @if($data->status=="Active"){{"Selected"}}@endif @endif>Active</option>
                            <option value="InActive" @if(isset($data)) @if($data->status=="InActive"){{"Selected"}}@endif @endif>InActive</option>
                            <option value="Block" @if(isset($data)) @if($data->status=="Block"){{"Selected"}}@endif @endif>Block</option>
                        </select>
                    </div>
                   
                </div>
                </div>
				
            </div>
     
            <div class="box-footer">
                <a href="{{url('index.php/user/')}}" class="btn btn-danger btn-sm">Cancel</a>
                <button class="btn btn-success btn-sm pull-right" type="submit">Save</button>
            </div>
            </div>
           
        </form>
    </div>
</div>
@endsection