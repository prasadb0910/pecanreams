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
    /*.form-group{
        margin-bottom: 0px;
    }*/
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

        <form id="form_upload_property" action="{{url('index.php/upload_property/upload_file')}}" method="POST" class="form-horizontal" enctype="multipart/form-data">
		<div class="box">
            <div class="box-header">
                <h4 class="pull-left"><b>File List</b></h4>
                <a href="{{url('index.php/notice/scan')}}" class="btn btn-success btn-sm pull-right">Scan</a>
                <a href="{{url('index.php/notice/add')}}" class="btn btn-success btn-sm pull-right" style="margin-right: 10px;">Add New</a>
            </div>
            <div class="box-body">
                {{csrf_field()}}
                <div class="form-group">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">Select File</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="file" class="form-control" name="property_file" id="property_file" />
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <!-- <button class="btn btn-success btn-sm pull-left" type="button" onclick="upload_file();">Upload</button> -->
                            <button class="btn btn-success btn-sm pull-left" type="submit">Upload</button>
                        </div>
                    </div>
                </div>
                <!-- <div class="form-group">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <br/>
                </div>
                </div> -->
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <th>Sr No</th>
                        <th>Date Of Upload</th>
                        <th>File Name</th>
                        <th>Download File</th>
                        <th>Status</th>
                        <th>Total Count</th>
                        <th>Pending Count</th>
                        <th>Approved Count</th>
                        <th>Rejected Count</th>
                        <th>Download Output</th>
                        <th>Send</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                    
                    </tbody>
                </table>

               
            </div>
        </div>
        </form>
    </div>
</div>

<!-- Modal -->
<!-- <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form_notice_list" action="{{--url('index.php/notice/map_notice')--}}" method="POST" class="form-horizontal">
            {{--csrf_field()--}}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Map Notice</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="notice_id" name="notice_id" value="" />
                <select id="notice_newspaper_id" class="form-control" name="notice_newspaper_id">
                    <option value="">Select Newspaper</option>
                </select>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" type="submit">Add</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div> -->

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form_delete_notice" action="{{url('index.php/notice/delete')}}" method="POST" class="form-horizontal">
            {{csrf_field()}}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Delete Notice</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <label class="col-md-4 col-sm-4 col-xs-12">&nbsp;</label>
                    <label class="col-md-8 col-sm-8 col-xs-12">Do you want to delete Notice?</label>
                    <input type="hidden" id="notice_id" name="notice_id" value="" />
                </div>
                </div>
                <div class="form-group">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="col-md-5 col-sm-5 col-xs-12"></div>
                    <div class="col-md-7 col-sm-7 col-xs-12">
                        <button class="btn btn-success btn-sm" type="submit" id="btn_yes">Yes</button>
                        <button class="btn btn-default btn-sm" type="button" id="btn_no">No</button>
                    </div>
                </div>
                </div>
            </div>
            </form>
        </div>
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
    // var show_modal = function(elem){
    //     var id = elem.id;
    //     var notice_id = id.substring(id.lastIndexOf('_')+1);
    //     $('#notice_id').val(notice_id);
    //     // $('#notice_date').val($('#date_of_notice').val());
    //     $('#myModal').modal('toggle');
    // };
</script>
<script>
    var show_modal = function(elem){
        var id = elem.id;
        var notice_id = id.substring(id.lastIndexOf('_')+1);
        $('#notice_id').val(notice_id);
        // $('#notice_date').val($('#date_of_notice').val());
        $('#myModal').modal('toggle');
    };
    $('#btn_no').click(function(){
        $('#myModal').modal('toggle');
    });
    var show_modal2 = function(elem){
        var id = elem.id;
        var newspaper_id = id.substring(id.lastIndexOf('_')+1);
        $('#newspaper_id2').val(newspaper_id);
        $('#date_of_notice2').val($('#date_of_notice').val());
        $.ajax({
            url:'{{url("index.php/notice/get_notice_count")}}',
            type:'post',
            data:$('#form_non_relevant').serialize(),
            datatype:'html',
            async:false,
            success: function(request){
                var data = JSON.parse(request);
                $('#total_notice').val(data.total_notice_count);
                $('#total_relevant').val(data.relevant_notice_count);
                $('#total_non_relevant').val(data.non_relevant_notice_count);
            },
            error: function(response){
                var r = jQuery.parseJSON(response.responseText);
                console.log("Message: " + r.Message);
                console.log("StackTrace: " + r.StackTrace);
                console.log("ExceptionType: " + r.ExceptionType);
            }
        });
        $('#myModal2').modal('toggle');
    };
    $('#btn_no2').click(function(){
        $('#myModal2').modal('toggle');
    });
</script>
<script>
    var tbl_datatable;
    $(document).ready(function(){
        get_data();
        set_datatable();
    });
    var set_datatable = function () {
        tbl_datatable = $("#example1").DataTable({
            dom: 'Bfrtip',
            buttons: ['excel'],
            destroy: true
        });
    };
    var get_data = function(){
        $.ajax({
            url:'{{url("index.php/upload_property/get_data")}}',
            type:'post',
            data:$('#form_upload_property').serialize(),
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
    var upload_file = function(){
        $.ajax({
            url:'{{url("index.php/upload_property/upload_file")}}',
            type:'post',
            data:$('#form_upload_property').serialize(),
            datatype:'html',
            async:false,
            success: function(request){
                console.log(request);

                // var data = JSON.parse(request);
                // tbl_datatable.destroy();
                // $('#example1 tbody').html(data.rows);
                // set_datatable();

                window.location.href = '{{url("index.php/upload_property")}}';
            },
            error: function(response){
                var r = jQuery.parseJSON(response.responseText);
                console.log("Message: " + r.Message);
                console.log("StackTrace: " + r.StackTrace);
                console.log("ExceptionType: " + r.ExceptionType);
            }
        });
    }
</script>
@endsection