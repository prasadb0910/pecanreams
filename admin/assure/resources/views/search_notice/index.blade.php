@extends('adminlte::layouts.app')

@section('styles')
<link href="{{ asset('/plugins/datepicker/datepicker3.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('/css/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css" />

<style>
    #tbl_notice_list_wrapper{
        overflow-x:scroll;
    }
    #tbl_notice_list{
        font-size: small;
        margin-bottom: 2px;
    }
    #tbl_notice_list_filter{
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

        <form id="form_notice_list" action="{{url('index.php/search_notice')}}" method="POST" class="form-horizontal">
		<div class="box">
            <div class="box-header">
                <h4 class="pull-left"><b>Search Notices</b></h4>
            </div>
            <div class="box-body">
                {{csrf_field()}}
                <div class="form-group">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="col-md-4 col-sm-4 col-xs-12 control-label">Paper Name</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="hidden" name="notice_type_id" id="notice_type_id" value="0" />
                            <select class="form-control" name="newspaper" id="newspaper">
                                <option value="">Select Newspaper</option>
                                @foreach($newspaper_list as $newspaper)
                                <option value="{{$newspaper->id}}">{{$newspaper->paper_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                </div>
                <div class="form-group">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="col-md-4 col-sm-4 col-xs-12 control-label">From Date</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" class="form-control" name="from_date" id="from_date" value="">
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="col-md-4 col-sm-4 col-xs-12 control-label">To Date</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" class="form-control" name="to_date" id="to_date" value="">
                        </div>
                    </div>
                </div>
                </div>
                <div class="form-group">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="col-md-4 col-sm-4 col-xs-12 control-label">Keyword</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" class="form-control" name="keyword" id="keyword" value="">
                        </div>
                    </div>
                </div>
                </div>
                <div class="form-group">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="col-md-1 col-sm-1 col-xs-12" style="padding-left:0px;">
                        &nbsp;
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input class="col-md-2 col-sm-2 col-xs-3" type="radio" name="match_word" id="match_word_any" value="any"> 
                        <label class="col-md-10 col-sm-10 col-xs-9">Matches on any word</label>
                    </div>
                    <div class="col-md-1 col-sm-1 col-xs-12" style="padding-left:0px;">
                        <div class="field">
                            OR 
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input class="col-md-2 col-sm-2 col-xs-3" type="radio" name="match_word" id="match_word_exact" value="exact"> 
                        <label class="col-md-10 col-sm-10 col-xs-9">An exact phrase match</label>
                    </div>
                </div>
                </div>
                <div class="form-group">
                <div class="col-md-10 col-sm-10 col-xs-10 text-center">
                    <input type="button" class="btn btn-primary btn-md" name="submit" id="submit" value="Search" onclick="get_data();" />
                    <input type="button" class="btn btn-warning btn-md" name="clear" id="clear" value="Clear" onclick="clear_content();" />
                </div>
                </div>
                <!-- <div class="form-group">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <br/>
                </div>
                </div> -->
                <!-- <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <th>Sr No</th>
                        <th>Newspaper Name</th>
                        <th>Language</th>
                        <th>E Paper</th>
                        <th>Frequency</th>
                        <th>Non Relevant Notice Count</th>
                        <th>Relevant Notice Count</th>
                        <th>Notice Title</th>
                        <th>Address</th>
                        <th>Added By</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                    
                    </tbody>
                </table> -->

                <table id="tbl_notice_list" class="table table-bordered table-striped" style="background-color: #fff;">
                    <thead style="display: none;">
                        <th>Image</th>
                        <th>Title, Date Of Notice & Description </th>
                    </thead>
                    <tbody id="tbl_body">
                    </tbody>
                </table>

               
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
        // set_datatable();
    });
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
    // var set_datatable = function () {
    //     tbl_datatable = $("#tbl_notice_list").DataTable({
    //         dom: 'Bfrtip',
    //         buttons: ['excel'],
    //         destroy: true
    //     });
    // };

    function get_data(){
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        var notice_type_id = $('#notice_type_id').val();
        var newspaper = $('#newspaper').val();
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();
        var keyword = $('#keyword').val();
        var match_word = $('#match_word').val();
        var table = '#tbl_notice_list';
        var serverSide = '';
        
        $(table).DataTable().destroy();
        $(table).DataTable({
            "bProcessing": true,
            "searchDelay": 3000,
            "serverSide": true,
            "ajax":{
                    url : BASE_URL + "search_notice/get_data", // json datasource
                    type: "post",  // type of method  ,GET/POST/DELETE
                    data: function(data) {       
                        // data.param = param;
                        data._token = csrfToken;
                        data.notice_type_id = notice_type_id;
                        data.newspaper = newspaper;
                        data.from_date = from_date;
                        data.to_date = to_date;
                        data.keyword = keyword;
                        data.match_word = match_word;
                    },
                    "dataSrc": function ( json ) {
                        return json.data;
                    },
                    error: function() {
                        $("#tbl_notice_list_processing").css("display","none");
                    }
                }
        });
    }

    var clear_content = function(){
        $('#newspaper').val('');
        $('#from_date').val('');
        $('#to_date').val('');
        $('#keyword').val('');
        $('#match_word_any').attr('checked', false);
        $('#match_word_exact').attr('checked', false);
    }
</script>
@endsection