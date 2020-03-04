@extends('adminlte::layouts.app')

@section('styles')
    <style>
        input[type="checkbox"], input[type="submit"] {display: block;}
        #matchingdata {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #matchingdata td, #matchingdata th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #matchingdata tr:nth-child(even){background-color: #f2f2f2;}

        #matchingdata tr:hover {background-color: #ddd;}

        #matchingdata th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #4CAF50;
            color: white;
        }
    </style>
@endsection

@section('main-content')
<div class="row">
    <div class="col-lg-12">
        @if(Session::has('success_msg'))
        <div class="alert alert-success">{{Session::get('success_msg')}}</div>
        @endif

        <div class="box">
            <div class="box-header">
                <h4 class="pull-left"><b>Property Notice List</b></h4>
                <input type="hidden" name="file_id" id="file_id" value="<?php if(isset($file_id)) echo $file_id; ?>" />
                <!--  <a href="{{--url('index.php/property_notice/add')--}}" class="btn btn-success btn-sm pull-right">Add New</a> -->
            </div>

            <div class = "tabinator">
                <!-- <input type = "radio" id = "tab1" name = "tabs" checked>
                <label for = "tab1">All ({{--count($all)--}})</label> -->
                <input type = "radio" id = "tab2" name = "tabs">
                <label for = "tab2"  class="tabs" id="approved" data-attr="approved">Approved ({{count($approved)}})</label>
                <input type = "radio" id = "tab3" name = "tabs" checked>
                <label for = "tab3" class="tabs" id="pending" data-attr="pending">Pending For Approval ({{count($pending_for_approval)}})</label>
                <!-- <input type = "radio" id = "tab4" name = "tabs">
                <label for = "tab4" class="tabs" id="pending_to_send" data-attr="pending to send">Pending To Send ({{--count($pending_to_send)--}})</label> -->
                <input type = "radio" id = "tab5" name = "tabs">
                <label for = "tab5" class="tabs" id="rejected" data-attr="rejected">Rejected ({{count($rejected)}})</label>

                <!-- <div id = "content1">
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <th>Sr No</th>
                                <th>Notice Id</th>
                                <th>Notice Title</th>
                                
                                
                                <th>Property Name</th>
                                <th>Property Address</th>
                                <th>Notice Status</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                            <?php //$i = 1; ?>
                            @if(!empty($all))
                            @foreach($all as $data)
                                <tr>
                                    <td class="table-text">
                                        <div>{{--$i++--}}</div>
                                    </td>
                                    <td class="table-text">
                                        <div><a href="{{--url('index.php/property_notice/details/'.$data->id)--}}">{{--$data->fk_notice_id--}}</a></div>
                                    </td>
                                    <td class="table-text">
                                        <div>{{--$data->notice_title--}}</div>
                                    </td>
                                    <td class="table-text">
                                        <div><a href="{{--url('index.php/notice/details/'.$data->fk_notice_id)--}}" target="_new">View</a></div>
                                    </td>
                                    <td class="table-text">
                                        <div><a href="{{--url('index.php/property/details/'.$data->fk_property_id)--}}" target="_new">View</a></div>
                                    </td>
                                    <td class="table-text">
                                        <div>{{--$data->property_name--}}</div>
                                    </td>
                                    <td class="table-text">
                                        <div>{{--$data->address--}}</div>
                                    </td>
                                    <td>
                                        <div>{{--$data->status--}}</div>
                                    </td>
                                    <td>
                                        @if($data->status=='pending')
                                        <button type="button" id="property_notice_{{$data->id}}" class="label label-danger" onClick="show_modal(this)">Reject</button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div> -->

                <div id = "content2">
                    <div class="box-body">
                        <table id="example2" class="table table-bordered table-striped">
                            <thead>
                                <th>Sr No</th>
                                <th>Notice Id</th>
                                <th>Notice Title</th>
                                <th>Owner Name</th>
                                <th>Property Address</th>
                                <th>Matching Criteria</th>
                                <th>Uploaded By</th>
                                <th>Created On </th>
                            </thead>
                            <tbody>
                            
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id = "content3">
                    <div class="box-body">
                        <form id="form_reject_notice" action="{{url('index.php/property_notice/reject')}}" method="POST" class="form-horizontal">
                        {{csrf_field()}}
                        <table id="example3" class="table table-bordered table-striped">
                            <thead>
                                <th>Sr No</th>
                                <th>Owner Name</th>
                                <th>Property Address</th>
                                <th>Notice Count</th>
                                <th>Notice Matching</th>
                            </thead>
                            <tbody>
                            
                            </tbody>
                        </table>
                        <!-- <input type="submit" class="btn btn-success btn-sm pull-right" name="send" value="Reject" style="margin:10px" /> -->
                        </form>
                    </div>
                </div>

                <div id = "content4">
                    <div class="box-body">
                        <form id="form_send_property_notice" action="{{url('index.php/property_notice/send')}}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <table id="example4" class="table table-bordered table-striped">
                            <thead>
                                <th>Sr No</th>
                                <th>Notice Id</th>
                                <th>Notice Title</th>
                                <th>Owner Name</th>
                                <th>Property Address</th>
                                <th>Matching Criteria</th>
                                <th>Uploaded By</th>
                                <th>Created On </th>
                                <th>Send Mail</th>
                            </thead>
                            <tbody>
                            
                            </tbody>
                        </table>

                        <input type="submit" class="btn btn-success btn-sm pull-right" name="send" value="Send" style="margin:10px" />
                        </form>
                    </div>
                </div>

                <div id = "content5">
                    <div class="box-body">
                        <table id="example5" class="table table-bordered table-striped">
                            <thead>
                                <th>Sr No</th>
                                <th>Notice Id</th>
                                <th>Notice Title</th>
                                <th>Owner Name</th>
                                <th>Property Address</th>
                                <th>Matching Criteria</th>
                                <th>Uploaded By</th>
                                <th>Created On </th>
                                <th>Notice Status</th>
                            </thead>
                            <tbody>
                            
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="mcriteria" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Matching Criteria</h4>
            </div>
            <div class="modal-body">
                <p class="criteria"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="matching_notice" class="modal fade" role="dialog">
    <div id="matching_notice_body" class="modal-dialog" style="width: 850px;">
        
    </div>
</div>

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form_reject_notice1" action="{{url('index.php/property_notice/reject')}}" method="POST" class="form-horizontal">
            {{csrf_field()}}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Reject Notice</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <label class="col-md-4 col-sm-4 col-xs-12">&nbsp;</label>
                    <label class="col-md-8 col-sm-8 col-xs-12">Do you want to Reject Notice?</label>
                    <input type="hidden" id="property_notice_id" name="property_notice_id" value="" />
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
    var show_modal = function(elem){
        var id = elem.id;
        var property_notice_id = id.substring(id.lastIndexOf('_')+1);
        $('#property_notice_id').val(property_notice_id);
        // $('#notice_date').val($('#date_of_notice').val());
        $('#myModal').modal('toggle');
    };

    $('#btn_no').click(function(){
        $('#myModal').modal('toggle');
    });

    $(document).ready(function(){
        data_get($('#approved').attr('data-attr'), $('#approved'));
        data_get($('#pending').attr('data-attr'), $('#pending'));
        // data_get($('#pending_to_send').attr('data-attr'), $('#pending_to_send'));
        data_get($('#rejected').attr('data-attr'), $('#rejected'));
    });

    $('body').on('click', '.mcriteria', function() {
        var id = $(this).attr('data-attrid');
        // console.log(id);
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        $.ajax({
            method:"POST",
            url:BASE_URL +'file_noticecriteria',
            data:{id: id,_token:csrfToken},
            dataType:"html",
            success:function(data){
                 $('.criteria').html(data);
                  $('#mcriteria').modal('toggle');
            }
        });
       
        /*console.log('mcriteria'+$(this).find('div').html());
        $('.criteria').html($(this).find('div').html());
        console.log($(this).find('div').html());
        $('#mcriteria').modal('toggle');*/
    });

    $('body').on('click', '.matching_notice', function() {
        var id = $(this).attr('data-attrid');
        get_matching_notices(id);
        $('#matching_notice').modal('toggle');
    });

    var get_matching_notices = function(id) {
        // console.log(id);
        $('#matching_notice_body').html('');
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        $.ajax({
            method:"POST",
            url:BASE_URL +'file_matching_notice',
            data:{id: id, _token:csrfToken},
            dataType:"html",
            success:function(data){
                $('#matching_notice_body').html(data);
            }
        });
    }

    $('body').on('click', '.btn_approve', function() {
        var id = $(this).attr('data-attrid');
        var property_id = $('#property_id').val();
        // console.log(id);
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        $.ajax({
            method:"POST",
            url:BASE_URL +'file_approve_record',
            data:{id: id, _token:csrfToken},
            dataType:"html",
            success:function(data){
                // console.log(data);
                get_matching_notices(property_id);
                data_get($('#pending').attr('data-attr'), $('#pending'));
                // $('#matching_notice').modal('show');
            }
        });
    });

    $('body').on('click', '.btn_reject', function() {
        var id = $(this).attr('data-attrid');
        var property_id = $('#property_id').val();
        // console.log(id);
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        $.ajax({
            method:"POST",
            url:BASE_URL +'file_reject_record',
            data:{id: id, _token:csrfToken},
            dataType:"html",
            success:function(data){
                // console.log(data);
                get_matching_notices(property_id);
                data_get($('#pending').attr('data-attr'), $('#pending'));
                // $('#matching_notice').modal('show');
            }
        });
    });

    $(document).ready(function(){
        var csrfToken = $('meta[name="csrf-token"]').attr("content");    
        $('#pending').click();
        /* $('#example3').DataTable().destroy();
        $('#example3').DataTable({
            "bProcessing": true,
            "serverSide": true,
            "ajax":{
                        url : BASE_URL + "file_notices_data", // json datasource
                        type: "post",  // type of method  ,GET/POST/DELETE
                        data: function(data) 
                        {       data.param = 'pending';
                                data._token = csrfToken;
                        },
                        error: function(){
                            $("#example_processing").css("display","none");
                        }
                    }
                });*/
    });

    $(".tabs").click(function(){
        /*  alert($(this).attr('data-attr'));*/
        /*var param ='';*/
        data_get($(this).attr('data-attr'), $(this));
    });

    function data_get(param,val){
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        var file_id = $('#file_id').val();
        var table = '';
        var text='';
        var serverSide = '';
        if(param=='approved') {
            table = '#example2' ;  
            text = 'Approved';
        } else if(param=='pending') {
           table = '#example3' ;   
           text = 'Pending For Approval';  
        } else if(param=='pending to send') {
            table = '#example4' ; 
            text = 'Pending To Send';      
        } else {
            table = '#example5' ; 
            text = 'Rejected'; 
        }

        $(table).DataTable().destroy();
        $(table).DataTable({
            "bProcessing": true,
            "searchDelay": 3000,
            "serverSide": true,
            "ajax":{
                    url : BASE_URL + "file_notices_data", // json datasource
                    type: "post",  // type of method  ,GET/POST/DELETE
                    data: function(data) {       
                        data.param = param;
                        data._token = csrfToken;
                        data.file_id = file_id;
                    },
                    "dataSrc": function ( json ) {
                        val.html(text+"(" +json.recordsTotal+")" );
                        return json.data;
                    },
                    error: function() {
                        $("#example_processing").css("display","none");
                    }
                }
        });
    } 
</script>
@endsection