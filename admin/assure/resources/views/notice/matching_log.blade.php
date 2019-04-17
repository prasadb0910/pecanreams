@extends('adminlte::layouts.app')

@section('styles')
<link href="{{ asset('/plugins/datepicker/datepicker3.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('/css/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css" />

<style>
    #example1_wrapper{
        overflow-x:scroll;
    }
    #example1{
        font-size: small;
        margin-bottom: 2px;
    }
    #example1_filter{
        float: right;
    }
    .form-group{
        margin-bottom: 0px;
    }
    .pagination{
        margin: 2px;
    }
</style>
@endsection

@section('main-content')
<div class="row">
    <div class="col-lg-12">
        @if(Session::has('success_msg'))
        <div class="alert alert-success">{{Session::get('success_msg')}}</div>
        @endif

        <form id="form_matching_log" action="{{--url('index.php/notice/save')--}}" method="POST" class="form-horizontal">
        <div class="box">
            <div class="box-header">
                <h4 class="pull-left"><b>Log</b></h4>
                <!-- <a href="{{--url('index.php/notice/scan')--}}" class="btn btn-success btn-sm pull-right">Scan</a>
                <a href="{{--url('index.php/notice/add')--}}" class="btn btn-success btn-sm pull-right" style="margin-right: 10px;">Add New</a> -->
            </div>
            <div class="box-body">
                {{csrf_field()}}
                <div class="form-group">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">From Date</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" class="form-control" name="from_date" id="from_date" value="{{date('d/m/Y')}}">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">To Date</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" class="form-control" name="to_date" id="to_date" value="{{date('d/m/Y')}}">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <button class="btn btn-success btn-sm" type="button" onclick="get_data();">Search</button>
                        </div>
                    </div>
                </div>
                <br/>

                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <th>Sr No</th>
                        <th>Date</th>
                        <th>Notice Id</th>
                        <th>Notice</th>
                        <th>Property</th>
                        <th>Parameter</th>
                        <th>Parameter Criteria</th>
                    </thead>
                    <tbody>
                    
                    </tbody>
                </table>
            </div>
            <div class="box-footer">
                <a href="{{url('index.php/notice_count')}}" class="btn btn-danger btn-sm pull-right">Cancel</a>
                <button class="btn btn-success btn-sm pull-right" type="submit" style="margin-right:20px">Save</button>
            </div>
        </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script src="{{asset('/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('/js/jszip.min.js')}}"></script>
<script>
    var tbl_datatable;
    $(document).ready(function(){
        get_data();
        set_datatable();
    });
    // $('#from_date').change(function(){
    //     get_data();
    // });
    $('#from_date').datepicker({
        maxDate: 0,
        autoclose: true,
        // onSelect: function(dateText) {
        //     get_data();
        // }
    });
    $('#to_date').datepicker({
        maxDate: 0,
        autoclose: true,
        // onSelect: function(dateText) {
        //     get_data();
        // }
    });
    var set_datatable = function () {
        tbl_datatable = $("#example1").DataTable({
            dom: 'Bfrtip',
            buttons: ['excel'],
            destroy: true,
            paging: false
        });
    };
    var get_data = function(){
        $.ajax({
            url:'{{url("index.php/notice/get_log")}}',
            type:'post',
            data:$('#form_matching_log').serialize(),
            datatype:'html',
            success: function(request){
                var data = JSON.parse(request);
                tbl_datatable.destroy();
                $('#example1 tbody').html(data.rows);
                set_datatable();
            },
            error: function(response){
                var r = jQuery.parseJSON(response.responseText);
                console.log("Message: " + r.Message);
                console.log("StackTrace: " + r.StackTrace);
                console.log("ExceptionType: " + r.ExceptionType);
            }
        });
    };
</script>
@endsection