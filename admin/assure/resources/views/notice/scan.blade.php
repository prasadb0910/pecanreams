@extends('adminlte::layouts.app')

@section('styles')
<style>
    #transcription, #nose {
        background: white;
        display: inline-block;
        border: 1px solid #ddd;
        margin: 10px;
        min-height: 300px;
        flex-grow: 1;
    }
    #nose {
        text-align: center;
        font-size: 50px;
        padding: 10px;
        width: 60%;
    }
    #nose img {
        width: 100%;
    }
    #transcription {
        overflow: scroll;
        font-size: 15px;
        padding: 30px;
        color: gray;
        width: 40%;
    }
    #transcription.done {
        color: black;
        overflow: scroll;
        display: block;
        max-height: 100%;
    }
    #main {
        display: flex;
        position: fixed;
        z-index: 99999;
        width: 40%;
        overflow: scroll;
        height: 70%;
        padding-right: 0px;
        padding-left: 0px;
    }
    .container {
        height: 300px;
    }
    .container .img-responsive {
        overflow: scroll;
        display: block;
        width: auto;
        max-height: 100%;
    }
    .form-group {
        margin-bottom: 5px;
    }
    tbody input {
        width: 100%;
    }
    #com_asprise_scan_app_ok {
        display: none!important;
    }
    .cropControls {
        top: 0;
    }
    .prompt-dialog {
        z-index: 999999;
    }
    .overlay-for-prompt {
        z-index: 99999;
    }
    .box-body {
        height: 550px;
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
        <form id="form_scan" action="{{url('index.php/notice/save_scan')}}" method="POST" class="form-horizontal" enctype="multipart/form-data">
            <div class="box">
            <div class="box-header">
                <h4 class="pull-left"><b>Notice Details</b></h4>
                <a href="{{url('index.php/notice')}}" class="btn btn-primary btn-sm pull-right">Back</a>
            </div>
            <div class="box-body">
                {{csrf_field()}}
                <div class="form-group">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <button type="button" class="btn btn-success btn-sm pull-left" onclick="scanAndUploadDirectly2();" style="width: 100px;">Scan</button>
                    </div>
                    <div class="col-md-1 col-sm-1 col-xs-12">&nbsp;&nbsp;Or&nbsp;&nbsp;</div>
                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Select File</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input type="file" onchange="load_file()" name="notice_file_file" id="picker" class="form-control">
                        <input type="hidden" name="notice_file" id="notice_file" value="@if(isset($data)){{$data->notice_file}}@endif">
                    </div>
                </div>
                </div>
                <div class="form-group">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="col-md-6 col-sm-6 col-xs-12" style="margin: 0px;">
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 container" id="main" style="margin: 0px;">
                            <div id="nose" class="col-md-6 col-sm-6 col-xs-12 img-responsive" style="margin-right: 0px; padding: 0px;">
                                @if(isset($data))
                                    <img class="cropimage" src="@if(isset($data)){{url('/') . '/uploads/notices/' . $data->notice_file}}@endif" cropwidth="275" cropheight="500">
                                @else
                                    <!-- <img class="cropimage" src="{{--url('/') . '/uploads/notices/Notice_1.jpg'--}}" cropwidth="200" cropheight="450"> -->

                                    <!-- <div class="results"> 
                                        <b>X</b>: <span class="cropX"></span> 
                                        <b>Y</b>: <span class="cropY"></span> 
                                        <b>W</b>: <span class="cropW"></span> 
                                        <b>H</b>: <span class="cropH"></span> 
                                    </div>

                                    <div class="download"> <a href="#" download="crop.png">Download</a> </div> -->

                                    <p>No file loaded</p>
                                    <p style="font-size: 25px"> Open a file first </p>
                                    <p style="font-size: 15px">it's okay. I'll wait. </p>
                                    <p style="font-size: 10px">no seriously, I can't move</p>
                                    <p style="font-size: 8px">still waiting...</p>
                                @endif
                            </div>
                            <div id="transcription" class="col-md-6 col-sm-6 col-xs-12" style="padding: 0px; display: none;">
                                @if(isset($data)){{$data->details}}@endif
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 0px; padding: 0px;">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">Date of Notice</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="hidden" class="form-control" name="id" value="@if(!Route::is('notice.map')) @if(isset($data)){{$data->id}}@endif @endif">
                                <input type="hidden" class="form-control" name="details" id="details" value="@if(isset($data)){{$data->details}}@endif">
                                <input type="text" class="form-control " name="date_of_notice" id="date_of_notice" value="@if(isset($data)){{Carbon\Carbon::parse($data->date_of_notice)->format('d/m/Y')}}@elseif(isset($data2['date_of_notice'])){{$data2['date_of_notice']}}@else{{date('d/m/Y')}}@endif" data-date-end-date="0d" placeholder="Enter Date of Notice...">
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 0px; padding: 0px;">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">Paper Name</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <select class="form-control" name="fk_newspaper_id">
                                    <option value="">Select Newspaper</option>
                                    @foreach($newspaper_list as $newspaper)
                                    <option value="{{$newspaper->id}}" @if(isset($data)) @if($newspaper->id==$data->fk_newspaper_id){{'selected'}} @endif @elseif(isset($data2['fk_newspaper_id'])) @if($newspaper->id==$data2['fk_newspaper_id']){{'selected'}} @endif @endif>{{$newspaper->paper_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 0px; padding: 0px;">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">Paper Page No.</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" class="form-control" name="page_number" value="@if(isset($data)){{$data->page_number}}@endif" placeholder="Enter Page Number...">
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 0px; padding: 0px;">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">Paper section</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" class="form-control" name="section" value="@if(isset($data)){{$data->section}}@endif" placeholder="Enter Paper section...">
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <a href="{{url('index.php/notice')}}" class="btn btn-danger btn-sm pull-right">Cancel</a>
                            <button class="btn btn-success btn-sm pull-right" type="submit" style="margin-right:20px">Save</button>
                        </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            @if(!Route::is('notice.details'))
            <!-- <div class="box-footer">
                <a href="{{--url('index.php/notice')--}}" class="btn btn-danger btn-sm pull-right">Cancel</a>
                <button class="btn btn-success btn-sm pull-right" type="submit" style="margin-right:20px">Save</button>
            </div> -->
            @endif
        </form>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    'use strict';
    // const BASE_URL = '{!! url("index.php/").'/' !!}';
    const ASSET_PATH = '{!! url("/").'/' !!}';
    
    $( document ).ready(function() {
        $("#date_of_notice").datepicker({ maxDate: 0,changeMonth: true,yearRange:'-100:+0',changeYear: true });
    });
</script>
<script src="{{asset('/js/ocrad/ocrad.js')}}"></script>
<script src="{{asset('/js/scannerjs/scanner.js')}}"></script>
<!-- <script src="https://asprise.azureedge.net/scannerjs/scanner.js" type="text/javascript"></script> -->
<script src="{{asset('/js/notice.js')}}"></script>
@endsection