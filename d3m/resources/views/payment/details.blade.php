@extends('adminlte::layouts.app')

@section('styles')
<style>
input:read-only { 
    background-color: white!important;
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
        <form id="form_payment_details" action="{{url('index.php/user_payment_detail/save')}}" method="POST" class="form-horizontal">
            <div class="box">
            <div class="box-header">
                <h4 class="pull-left"><b>Payment Details</b></h4>
                <a href="{{url('index.php/user_payment_detail')}}" class="btn btn-primary btn-sm pull-right">Back</a>
            </div>
            <div class="box-body">
                {{csrf_field()}}
                <div class="form-group">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">User Name</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input type="hidden" class="form-control" name="id" value="@if(isset($data[0])){{$data[0]->id}}@endif">
                        <input type="text" class="form-control" name="user_name" value="@if(isset($data[0])){{$data[0]->user_name}}@endif" placeholder="Enter User Name..." readonly>
                    </div>
                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Plan Name</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input type="text" class="form-control" name="plan_name" value="@if(isset($data[0])){{$data[0]->plan_name}}@endif" placeholder="Enter Plan Name..." readonly>
                    </div>
                </div>
                </div>
                <div class="form-group">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Invoice No</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input type="text" class="form-control" name="invoice_no" value="@if(isset($data[0])){{$data[0]->invoice_no}}@endif" placeholder="Enter Invoice No..." readonly>
                    </div>
                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">No Of Properties</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input type="text" class="form-control" name="no_of_properties" value="@if(isset($data[0])){{$data[0]->no_of_properties}}@endif" placeholder="Enter No Of Properties..." readonly>
                    </div>
                </div>
                </div>
                <div class="form-group">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Payment Method</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <select class="form-control" id="payment_method" name="payment_method">
                            <option value="">Select Payment Method</option>
                            <option value="Cash" @if(isset($data[0])) @if($data[0]->payment_method=="Cash"){{"Selected"}}@endif @endif>Cash</option>
                            <option value="Cheque" @if(isset($data[0])) @if($data[0]->payment_method=="Cheque"){{"Selected"}}@endif @endif>Cheque</option>
                        </select>
                    </div>
                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Payment Date</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input type="text" class="form-control datepicker" name="payment_date" value="@if(isset($data[0])){{Carbon\Carbon::parse($data[0]->payment_date)->format('d/m/Y')}}@endif" placeholder="Select Payment Date..."  readonly>
                    </div>
                </div>
                </div>
                <div class="form-group">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <label class="col-md-2 col-sm-2 col-xs-12 control-label" style="padding-right: 0px;">Payment Ref / Cheque No</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input type="text" class="form-control" name="payment_ref" value="@if(isset($data[0])){{$data[0]->payment_ref}}@endif" placeholder="Enter Payment Ref...">
                    </div>
                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Transaction Amount</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input type="text" class="form-control" name="transaction_amount" value="@if(isset($data[0])){{$data[0]->transaction_amount}}@endif" placeholder="Enter Transaction Amount..."  readonly>
                    </div>
                </div>
                </div>
                <div class="form-group chq_dtl">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Bank Name</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input type="text" class="form-control" name="bank_name" value="@if(isset($data[0])){{$data[0]->bank_name}}@endif" placeholder="Enter Bank Name...">
                    </div>
                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Branch</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input type="text" class="form-control" name="branch" value="@if(isset($data[0])){{$data[0]->branch}}@endif" placeholder="Enter Branch...">
                    </div>
                </div>
                </div>
                <div class="form-group chq_dtl">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Cheque Date</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input type="text" class="form-control datepicker" name="cheque_date" value="@if(isset($data[0])){{Carbon\Carbon::parse($data[0]->cheque_date)->format('d/m/Y')}}@endif" placeholder="Select Cheque Date..."  readonly>
                    </div>
                </div>
                </div>
            </div>
            @if(!Route::is('user_payment_detail.details'))
            <div class="box-footer">
                <a href="{{url('index.php/user_payment_detail')}}" class="btn btn-danger btn-sm">Cancel</a>
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
    $(document).ready(function(){
        show_chq_dtl();
    });
    $('#payment_method').change(function(){
        show_chq_dtl();
    });
    var show_chq_dtl = function(){
        if($('#payment_method').val()=="Cheque"){
            $('.chq_dtl').show();
        } else {
            $('.chq_dtl').hide();
        }
    }
</script>
@endsection