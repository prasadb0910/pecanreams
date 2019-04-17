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
    .font-bold {
        font-weight: bold;
    }
</style>
@endsection

@section('main-content')
<div class="row">
    <div class="col-lg-12">
        @if(Session::has('success_msg'))
        <div class="alert alert-success">{{Session::get('success_msg')}}</div>
        @endif

        <form id="form_notice_count_list" action="{{url('index.php/notice_count/save')}}" method="POST" class="form-horizontal">
        <div class="box">
            <div class="box-header">
                <h4 class="pull-left"><b>Notice Count</b></h4>
                <!-- <a href="{{--url('index.php/notice/scan')--}}" class="btn btn-success btn-sm pull-right">Scan</a>
                <a href="{{--url('index.php/notice/add')--}}" class="btn btn-success btn-sm pull-right" style="margin-right: 10px;">Add New</a> -->
            </div>
            <div class="box-body">
                {{csrf_field()}}
                <div class="form-group">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-4 col-sm-4 col-xs-12"></div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">Select Date</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" class="form-control" name="date_of_notice" id="date_of_notice" value="{{date('d/m/Y')}}">
                                <input type="hidden" name="newspaper_id" id="newspaper_id" value="">
                                <input type="hidden" name="form_action" id="form_action" value="">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12"></div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-2 col-sm-2 col-xs-6">
                            <label class="control-label">Newspapers: <span id="newspaper_count"></span></label>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-6">
                            <label class="control-label">Notices: <span id="total_notice_count"></span></label>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-6">
                            <label class="control-label">Entered: <span id="notice_count"></span></label>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-6">
                            <label class="control-label">Relevant: <span id="relevant_notice_count"></span></label>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-6">
                            <label class="control-label">Non Relevant: <span id="non_relevant_notice_count"></span></label>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-6">
                            <label class="control-label">Difference: <span id="diff_notice_count"></span></label>
                        </div>
                    </div>
                </div>
                <br/>

                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <th>Sr No</th>
                        <th>Newspaper Name</th>
                        <th>Total Notice Count</th>
                        <th>Entered Notice Count</th>
                        <th>Relevant Notice Count</th>
                        <th>Non Relevant Notice Count</th>
                        <th>Difference Notice Count</th>
                    </thead>
                    <tbody></tbody>
                    <tfoot></tfoot>
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
    $('#date_of_notice').change(function(){
        get_data();
    });
    var set_datatable = function () {
        tbl_datatable = $("#example1").DataTable({
            dom: 'Bfrtip',
            buttons: [{extend: 'excel', footer: true}],
            destroy: true,
            paging: false,
            fixedHeader: {
                header: true,
                footer: true
            }
        });
    };
    var get_data = function(){
        $.ajax({
            url:'{{url("index.php/notice_count/get_data")}}',
            type:'post',
            data:$('#form_notice_count_list').serialize(),
            datatype:'html',
            success: function(request){
                var data = JSON.parse(request);
                tbl_datatable.destroy();
                $('#example1 tbody').html(data.rows);
                $('#example1 tfoot').html(data.tfoot);
                // $('#example1').append(data.rows);
                $('#newspaper_count').html(data.newspaper_count);
                $('#total_notice_count').html(data.total_notice_count);
                $('#relevant_notice_count').html(data.relevant_notice_count);
                $('#non_relevant_notice_count').html(data.non_relevant_notice_count);
                $('#diff_notice_count').html(data.diff_notice_count);
                $('#notice_count').html(data.notice_count);
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
    var get_newspaper_id = function(elem){
        var id = elem.id;
        var index = id.substring(id.lastIndexOf('_')+1);
        $('#newspaper_id').val(index);
        $('#form_action').val('add_notice');
    }
    var set_notice = function(elem){
        var id = elem.id;
        var index = id.substring(id.lastIndexOf('_')+1);
        $('#newspaper_id').val(index);
        $('#form_action').val('set_notice');
    }
    $('#date_of_notice').datepicker({
         maxDate: 0,
        autoclose: true,
        onSelect: function(dateText) {
            get_data();
        }
    });
</script>
@endsection