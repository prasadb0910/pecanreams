@extends('adminlte::layouts.app')

@section('styles')
<style>
input:read-only { 
    background-color: white!important;
    border: none;
}
</style>
@endsection

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
        <form id="form_payment_details" action="{{--url('index.php/user_payment_detail/get_plan')--}}" method="get" class="form-horizontal">
            <div class="box">
            <div class="box-header">
                <h4 class="pull-left"><b>Plan Details</b></h4>
                <!-- <a href="{{--url('index.php/user_payment_detail')--}}" class="btn btn-primary btn-sm pull-right">Back</a> -->
            </div>
            <div class="box-body">
                {{csrf_field()}}
                <div class="form-group">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Plan Name</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input type="text" class="form-control" name="plan_name" value="@if(isset($final_data['plan_name'])){{$final_data['plan_name']}}@endif" readonly>
                    </div>
                    <label class="col-md-3 col-sm-3 col-xs-12 control-label" style="padding-right: 0px;">Total No Of Properties Regietered</label>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <input type="text" class="form-control" name="payment_ref" value="@if(isset($final_data['no_of_properties_registered'])){{$final_data['no_of_properties_registered']}}@endif" readonly>
                    </div>
                </div>
                </div>
                <div class="form-group" style="@if(isset($final_data['plan_name'])) @if(stripos($final_data['plan_name'],'monthly')!==false) {{'display: none;'}} @endif @endif">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">No Of Properties</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input type="text" class="form-control" name="no_of_properties" value="@if(isset($final_data['no_of_properties'])){{$final_data['no_of_properties']}}@endif" readonly>
                    </div>
                    <label class="col-md-3 col-sm-3 col-xs-12 control-label">Plan Expires On</label>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <input type="text" class="form-control" name="plan_expires_on" value="@if(isset($final_data['plan_expires_on'])){{Carbon\Carbon::parse($final_data['plan_expires_on'])->format('d/m/Y')}}@endif" readonly>
                    </div>
                </div>
                </div>
            </div>
            @if(!Route::is('user_payment_detail.details'))
            <div class="box-footer" style="text-align: center;">
                <a href="{{url('index.php/user_payment_detail/get_plan')}}" class="btn btn-success btn-lg">Subscribe</a>
                <!-- <button class="btn btn-success btn-sm pull-right" type="submit">Save</button> -->
            </div>
            </div>
            @endif
        </form>
    </div>
</div>
@endsection