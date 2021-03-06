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

        @if(!empty($notice))
        <form id="form_notice_list" action="{{url('index.php/notice/add_notice')}}" method="POST" class="form-horizontal">
		<div class="box">
            <div class="box-header">
                <h4 class="pull-left"><b>Notice List</b></h4>
                <a href="{{url('index.php/notice/add')}}" class="btn btn-success btn-sm pull-right">Add New</a>
            </div>
            <div class="box-body">
                {{csrf_field()}}
                <div class="form-group">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="col-md-4 col-sm-4 col-xs-12 control-label">Select Date</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" class="form-control" name="date_of_notice" id="date_of_notice" value="{{date('d/m/Y')}}">
                            <input type="hidden" name="newspaper_id" id="newspaper_id" value="">
                            <input type="hidden" name="form_action" id="form_action" value="">
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12"></div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="col-md-6 col-sm-6 col-xs-12 control-label">Total Notice Count:</label>
                        <label class="col-md-4 col-sm-4 col-xs-12 control-label" id="total_notice_count"></label>
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
                        <th>Newspaper Name</th>
                        <th>Language</th>
                        <th>E Paper</th>
                        <th>Frequency</th>
                        <th>Area</th>
                        <th>Notice Count</th>
                        <th>Notice Title</th>
                        <th>Address</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                    
                    </tbody>
                </table>

                <!-- <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <th>Notice Title</th>
                        <th>Date Of Notice</th>
                        <th>Paper Name</th>
                        <th>Days For Respond</th>
                        <th>Issued By</th>
                        <th>Reason For Notice</th>
                        <th>Notice Type</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                    @foreach($notice as $data)
                        <tr>
                            <td class="table-text">
                                <div>{{--$data->notice_title--}}</div>
                            </td>
                            <td class="table-text">
                                <div>{{--$data->date_of_notice--}}</div>
                            </td>
                            <td class="table-text">
                                <div>{{--$data->newspaper->paper_name--}}</div>
                            </td>
                            <td class="table-text">
                                <div>{{--$data->days_for_respond--}}</div>
                            </td>
                            <td class="table-text">
                                <div>{{--$data->issued_by--}}</div>
                            </td>
                            <td class="table-text">
                                <div>{{--$data->reason_for_notice--}}</div>
                            </td>
                            <td class="table-text">
                                <div>{{--$data->notice_type->notice_type--}}</div>
                            </td>
                            <td>
                                <a href="{{--url('index.php/notice/details'.$data->id)--}}" class="label label-success">Details</a>
                                <a href="{{--url('index.php/notice/edit'.$data->id)--}}" class="label label-warning">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table> -->
            </div>
        </div>
        </form>
        @endif
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
            <form id="form_notice_list" action="{{url('index.php/notice/delete')}}" method="POST" class="form-horizontal">
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
</script>
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
            buttons: ['excel'],
            destroy: true
        });
    };
    var get_data = function(){
        $.ajax({
            url:'{{url("index.php/notice/get_data")}}',
            type:'post',
            data:$('#form_notice_list').serialize(),
            datatype:'html',
            success: function(request){
                var data = JSON.parse(request);
                tbl_datatable.destroy();
                $('#example1 tbody').html(data.rows);
                $('#notice_newspaper_id').html(data.rows2);
                $('#total_notice_count').html(data.total_notice_count);
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
        autoclose: true,
        onSelect: function(dateText) {
            get_data();
        }
    });
</script>
@endsection