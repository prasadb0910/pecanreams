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
</style>
<link rel="stylesheet" href="{{asset('/plugins/crop/build/darkroom.css')}}">
<link rel="stylesheet" href="{{asset('/plugins/crop/demo/css/page.css')}}">
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
        <form id="form_notice" action="{{url('index.php/notice/save')}}" method="POST" class="form-horizontal" enctype="multipart/form-data">
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
                        <button type="button" class="btn btn-success btn-sm pull-left" onclick="selectScanImage();" style="width: 75px;">Select</button>
                        <button type="button" class="btn btn-success btn-sm pull-left" onclick="scanAndUploadDirectly();" style="width: 75px; margin-left: 10px;">Scan</button>
                    </div>
                    <div class="col-md-1 col-sm-1 col-xs-12">&nbsp;&nbsp;Or&nbsp;&nbsp;</div>
                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Select File</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input type="file" onchange="load_file()" name="notice_file_file" id="picker" class="form-control">
                        <input type="hidden" name="notice_file" id="notice_file" value="@if(isset($data)){{$data->notice_file}}@endif">
                        <input type="hidden" name="temp_notice_file" id="temp_notice_file" value="">
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
                            <div id="transcription" class="col-md-6 col-sm-6 col-xs-12" style="padding: 0px;">
                                @if(isset($data)){{$data->details}}@endif
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 0px; padding: 0px;">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">Notice Type</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <select class="form-control" name="fk_notice_type_id">
                                    <option value="">Select Notice Type</option>
                                    @foreach($notice_type_list as $notice_type)
                                    <option value="{{$notice_type->id}}" @if(isset($data)) @if($notice_type->id==$data->fk_notice_type_id){{'selected'}} @endif @endif>{{$notice_type->notice_type}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 0px; padding: 0px;">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">Notice Title</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="hidden" class="form-control" name="id" value="@if(!Route::is('notice.map')) @if(isset($data)){{$data->id}}@endif @endif">
                                <input type="hidden" class="form-control" name="details" id="details" value="@if(isset($data)){{$data->details}}@endif">
                                <input type="text" class="form-control" name="notice_title" value="@if(isset($data)){{$data->notice_title}}@endif" placeholder="Enter Notice Title...">
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 0px; padding: 0px;">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">Date of Notice</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" class="form-control " name="date_of_notice" id="date_of_notice" value="@if(isset($data)){{Carbon\Carbon::parse($data->date_of_notice)->format('d/m/Y')}}@elseif(isset($data2['date_of_notice'])){{$data2['date_of_notice']}}@else{{date('d/m/Y')}}@endif" data-date-end-date="0d" placeholder="Enter Date of Notice...">
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 0px; padding: 0px;">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">Paper Name</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <select class="form-control" name="fk_newspaper_id" id="fk_newspaper_id">
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
                                <input type="text" class="form-control" name="page_number" id="page_number" value="@if(isset($data)){{$data->page_number}}@endif" placeholder="Enter Page Number...">
                            </div>
                        </div>
                        </div>
                        <div class="form-group" style="display: none;">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 0px; padding: 0px;">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">Name of Property</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" class="form-control" name="name_of_property" value="@if(isset($data)){{$data->name_of_property}}@endif" placeholder="Enter Name of Property...">
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 0px; padding: 0px;">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">Property Type</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <select class="form-control" name="property_type">
                                    <option value="">Select Property Type</option>
                                    <option value="Land" @if(isset($data)) @if($data->property_type=="Land"){{'selected'}} @endif @endif>Land</option>
                                    <option value="Unit" @if(isset($data)) @if($data->property_type=="Unit"){{'selected'}} @endif @endif>Unit</option>
                                    <option value="Others" @if(isset($data)) @if($data->property_type=="Others"){{'selected'}} @endif @endif>Others</option>
                                </select>
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 0px; padding: 0px;">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">Building Name</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" class="form-control" name="building_name" value="@if(isset($data)){{$data->building_name}}@endif" placeholder="Enter Building Name...">
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 0px; padding: 0px;">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">Society Name</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" class="form-control" name="society_name" value="@if(isset($data)){{$data->society_name}}@endif" placeholder="Enter Society Name...">
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <table class="table table-bordered" id="tbl_property_no_detail">
                                <thead>
                                    <tr>
                                        <th>Property No Type</th>
                                        <th>Property No</th>
                                        <th style="text-align:center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=0; if(isset($property_no_detail)) {
                                            for($i=0; $i<count($property_no_detail); $i++) { ?>
                                        <tr id="property_no_detail_<?php echo $i; ?>_row" class="property_no_detail">
                                            <td>
                                                <select class="form-control" name="fk_property_no_type_id[]">
                                                    <option value="">Select Property No Type</option>
                                                    @foreach($property_no_type_list as $property_no_type)
                                                    <option value="{{$property_no_type->id}}" @if(isset($property_no_detail)) @if($property_no_type->id==$property_no_detail[$i]->fk_property_no_type_id){{'selected'}} @endif @endif>{{$property_no_type->property_no_type}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="property_no[]" placeholder="Enter Property No..." value="<?php if (isset($property_no_detail)) { echo $property_no_detail[$i]->property_no; } ?>" />
                                            </td>
                                            <td style="text-align: center; vertical-align: middle;">
                                                <button type="button" id="property_no_detail_<?php echo $i; ?>_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>
                                            </td>
                                        </tr>
                                    <?php }} else { ?>
                                        <tr id="property_no_detail_<?php echo $i; ?>_row" class="property_no_detail">
                                            <td>
                                                <select class="form-control" name="fk_property_no_type_id[]">
                                                    <option value="">Select Property No Type</option>
                                                    @foreach($property_no_type_list as $property_no_type)
                                                    <option value="{{$property_no_type->id}}">{{$property_no_type->property_no_type}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="property_no[]" placeholder="Enter Property No..." value="" />
                                            </td>
                                            <td style="text-align: center; vertical-align: middle;">
                                                <button type="button" id="property_no_detail_<?php echo $i; ?>_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3"><input type="button" class="btn btn-success" id="repeat_property_no_detail" value="+"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 0px; padding: 0px;">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">Floor</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" class="form-control" name="floor" value="@if(isset($data)){{$data->floor}}@endif" placeholder="Enter Floor...">
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 0px; padding: 0px;">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">Wing</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" class="form-control" name="wing" value="@if(isset($data)){{$data->wing}}@endif" placeholder="Enter Wing...">
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 0px; padding: 0px;">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">Address</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" class="form-control" name="address" value="@if(isset($data)){{$data->address}}@endif" placeholder="Enter Address...">
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <table class="table table-bordered" id="tbl_location_detail">
                                <thead>
                                    <tr>
                                        <th>Location Type</th>
                                        <th>Location</th>
                                        <th style="text-align:center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=0; if(isset($location_detail)) {
                                            for($i=0; $i<count($location_detail); $i++) { ?>
                                        <tr id="location_detail_<?php echo $i; ?>_row" class="location_detail">
                                            <td>
                                                <select class="form-control" name="fk_location_type_id[]">
                                                    <option value="">Select Location Type</option>
                                                    @foreach($location_type_list as $location_type)
                                                    <option value="{{$location_type->id}}" @if(isset($location_detail)) @if($location_type->id==$location_detail[$i]->fk_location_type_id){{'selected'}} @endif @endif>{{$location_type->location_type}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="location[]" placeholder="Enter Location..." value="<?php if (isset($location_detail)) { echo $location_detail[$i]->location; } ?>" />
                                            </td>
                                            <td style="text-align: center; vertical-align: middle;">
                                                <button type="button" id="location_detail_<?php echo $i; ?>_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>
                                            </td>
                                        </tr>
                                    <?php }} else { ?>
                                        <tr id="location_detail_<?php echo $i; ?>_row" class="location_detail">
                                            <td>
                                                <select class="form-control" name="fk_location_type_id[]">
                                                    <option value="">Select Location Type</option>
                                                    @foreach($location_type_list as $location_type)
                                                    <option value="{{$location_type->id}}">{{$location_type->location_type}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="location[]" placeholder="Enter Location..." value="" />
                                            </td>
                                            <td style="text-align: center; vertical-align: middle;">
                                                <button type="button" id="location_detail_<?php echo $i; ?>_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3"><input type="button" class="btn btn-success" id="repeat_location_detail" value="+"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 0px; padding: 0px;">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">City</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" class="form-control" name="city" value="@if(isset($data)){{$data->city}}@endif" placeholder="Enter City...">
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 0px; padding: 0px;">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">Pincode</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" class="form-control" name="pincode" value="@if(isset($data)){{$data->pincode}}@endif" placeholder="Enter Pincode...">
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 0px; padding: 0px;">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">State</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" class="form-control" name="state" value="@if(isset($data)){{$data->state}}@endif" placeholder="Enter State...">
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 0px; padding: 0px;">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">Country</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" class="form-control" name="country" value="@if(isset($data)){{$data->country}}@else{{'India'}}@endif" placeholder="Enter Country...">
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 0px; padding: 0px;">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">Parking</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" class="form-control" name="parking" value="@if(isset($data)){{$data->parking}}@endif" placeholder="Enter Parking...">
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <table class="table table-bordered" id="tbl_certificate_no_detail">
                                <thead>
                                    <tr>
                                        <th>Certificate No Type</th>
                                        <th>Certificate No</th>
                                        <th style="text-align:center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=0; if(isset($certificate_no_detail)) {
                                            for($i=0; $i<count($certificate_no_detail); $i++) { ?>
                                        <tr id="certificate_no_detail_<?php echo $i; ?>_row" class="certificate_no_detail">
                                            <td>
                                                <select class="form-control" name="fk_certificate_no_type_id[]">
                                                    <option value="">Select Certificate No Type</option>
                                                    @foreach($certificate_no_type_list as $certificate_no_type)
                                                    <option value="{{$certificate_no_type->id}}" @if(isset($certificate_no_detail)) @if($certificate_no_type->id==$certificate_no_detail[$i]->fk_certificate_no_type_id){{'selected'}} @endif @endif>{{$certificate_no_type->certificate_no_type}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="certificate_no[]" placeholder="Enter Certificate No..." value="<?php if (isset($certificate_no_detail)) { echo $certificate_no_detail[$i]->certificate_no; } ?>" />
                                            </td>
                                            <td style="text-align: center; vertical-align: middle;">
                                                <button type="button" id="certificate_no_detail_<?php echo $i; ?>_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>
                                            </td>
                                        </tr>
                                    <?php }} else { ?>
                                        <tr id="certificate_no_detail_<?php echo $i; ?>_row" class="certificate_no_detail">
                                            <td>
                                                <select class="form-control" name="fk_certificate_no_type_id[]">
                                                    <option value="">Select Certificate No Type</option>
                                                    @foreach($certificate_no_type_list as $certificate_no_type)
                                                    <option value="{{$certificate_no_type->id}}">{{$certificate_no_type->certificate_no_type}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="certificate_no[]" placeholder="Enter Certificate No..." value="" />
                                            </td>
                                            <td style="text-align: center; vertical-align: middle;">
                                                <button type="button" id="certificate_no_detail_<?php echo $i; ?>_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3"><input type="button" class="btn btn-success" id="repeat_certificate_no_detail" value="+"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 0px; padding: 0px;">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">Property Description</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" class="form-control" name="property_description" value="@if(isset($data)){{$data->property_description}}@endif" placeholder="Enter Property Description...">
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 0px; padding: 0px;">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">Issued by</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" class="form-control" name="issued_by" value="@if(isset($data)){{$data->issued_by}}@endif" placeholder="Enter Issued by...">
                            </div>
                        </div>
                        </div>

                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <table class="table table-bordered" id="tbl_legal_owner_name">
                                <thead>
                                    <tr>
                                        <th>Legal Owner Name</th>
                                        <th style="text-align:center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=0; if(isset($legal_owner_name)) {
                                    for($i=0; $i<count($legal_owner_name); $i++) { ?>
                                    <tr id="legal_owner_name_<?php echo $i; ?>_row">
                                        <td>
                                            <input type="text" class="form-control legal_owner_name" name="legal_owner_name[]" id="legal_owner_name_<?php echo $i; ?>" placeholder="Enter Legal Owner Name..." value="<?php if (isset($legal_owner_name)) { echo $legal_owner_name[$i]->legal_owner_name; } ?>" />
                                        </td>
                                        <td style="text-align: center; vertical-align: middle;">
                                            <button type="button" id="legal_owner_name_<?php echo $i; ?>_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>
                                        </td>
                                    </tr>
                                    <?php }} else { ?>
                                    <tr id="legal_owner_name_<?php echo $i; ?>_row">
                                        <td>
                                            <input type="text" class="form-control legal_owner_name" name="legal_owner_name[]" id="legal_owner_name_<?php echo $i; ?>" placeholder="Enter Legal Owner Name..." value="" />
                                        </td>
                                        <td style="text-align: center; vertical-align: middle;">
                                            <button type="button" id="legal_owner_name_<?php echo $i; ?>_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2"><input type="button" class="btn btn-success" id="repeat_legal_owner_name" value="+"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        </div>

                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <table class="table table-bordered" id="tbl_purchased_from">
                                <thead>
                                    <tr>
                                        <th>Purchased From</th>
                                        <th style="text-align:center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=0; if(isset($purchased_from)) {
                                    for($i=0; $i<count($purchased_from); $i++) { ?>
                                    <tr id="purchased_from_<?php echo $i; ?>_row">
                                        <td>
                                            <input type="text" class="form-control purchased_from" name="purchased_from[]" id="purchased_from_<?php echo $i; ?>" placeholder="Enter Purchased From..." value="<?php if (isset($purchased_from)) { echo $purchased_from[$i]->purchased_from; } ?>" />
                                        </td>
                                        <td style="text-align: center; vertical-align: middle;">
                                            <button type="button" id="purchased_from_<?php echo $i; ?>_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>
                                        </td>
                                    </tr>
                                    <?php }} else { ?>
                                    <tr id="purchased_from_<?php echo $i; ?>_row">
                                        <td>
                                            <input type="text" class="form-control purchased_from" name="purchased_from[]" id="purchased_from_<?php echo $i; ?>" placeholder="Enter Purchased From..." value="" />
                                        </td>
                                        <td style="text-align: center; vertical-align: middle;">
                                            <button type="button" id="purchased_from_<?php echo $i; ?>_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2"><input type="button" class="btn btn-success" id="repeat_purchased_from" value="+"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        </div>

                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <table class="table table-bordered" id="tbl_company_name">
                                <thead>
                                    <tr>
                                        <th>Company Name</th>
                                        <th style="text-align:center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=0; if(isset($company_name)) {
                                    for($i=0; $i<count($company_name); $i++) { ?>
                                    <tr id="company_name_<?php echo $i; ?>_row">
                                        <td>
                                            <input type="text" class="form-control company_name" name="company_name[]" id="company_name_<?php echo $i; ?>" placeholder="Enter Company Name..." value="<?php if (isset($company_name)) { echo $company_name[$i]->company_name; } ?>" />
                                        </td>
                                        <td style="text-align: center; vertical-align: middle;">
                                            <button type="button" id="company_name_<?php echo $i; ?>_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>
                                        </td>
                                    </tr>
                                    <?php }} else { ?>
                                    <tr id="company_name_<?php echo $i; ?>_row">
                                        <td>
                                            <input type="text" class="form-control company_name" name="company_name[]" id="company_name_<?php echo $i; ?>" placeholder="Enter Company Name..." value="" />
                                        </td>
                                        <td style="text-align: center; vertical-align: middle;">
                                            <button type="button" id="company_name_<?php echo $i; ?>_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2"><input type="button" class="btn btn-success" id="repeat_company_name" value="+"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        </div>

                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <table class="table table-bordered" id="tbl_guarantor">
                                <thead>
                                    <tr>
                                        <th>Guarantor</th>
                                        <th style="text-align:center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=0; if(isset($guarantor)) {
                                    for($i=0; $i<count($guarantor); $i++) { ?>
                                    <tr id="guarantor_<?php echo $i; ?>_row">
                                        <td>
                                            <input type="text" class="form-control guarantor" name="guarantor[]" id="guarantor_<?php echo $i; ?>" placeholder="Enter Guarantor..." value="<?php if (isset($guarantor)) { echo $guarantor[$i]->guarantor; } ?>" />
                                        </td>
                                        <td style="text-align: center; vertical-align: middle;">
                                            <button type="button" id="guarantor_<?php echo $i; ?>_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>
                                        </td>
                                    </tr>
                                    <?php }} else { ?>
                                    <tr id="guarantor_<?php echo $i; ?>_row">
                                        <td>
                                            <input type="text" class="form-control guarantor" name="guarantor[]" id="guarantor_<?php echo $i; ?>" placeholder="Enter Guarantor..." value="" />
                                        </td>
                                        <td style="text-align: center; vertical-align: middle;">
                                            <button type="button" id="guarantor_<?php echo $i; ?>_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2"><input type="button" class="btn btn-success" id="repeat_guarantor" value="+"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        </div>


                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <table class="table table-bordered" id="tbl_othername">
                                <thead>
                                    <tr>
                                        <th>Other Name</th>
                                        <th style="text-align:center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=0; if(isset($othername)) {
                                    for($i=0; $i<count($othername); $i++) { ?>
                                    <tr id="othername_<?php echo $i; ?>_row">
                                        <td>
                                            <input type="text" class="form-control othername" name="othername[]" id="othername_<?php echo $i; ?>" placeholder="Enter Other Name..." value="<?php if (isset($othername)) { echo $othername[$i]->othername; } ?>" />
                                        </td>
                                        <td style="text-align: center; vertical-align: middle;">
                                            <button type="button" id="othername_<?php echo $i; ?>_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>
                                        </td>
                                    </tr>
                                    <?php }} else { ?>
                                    <tr id="othername_<?php echo $i; ?>_row">
                                        <td>
                                            <input type="text" class="form-control othername" name="othername[]" id="othername_<?php echo $i; ?>" placeholder="Enter Other Name..." value="" />
                                        </td>
                                        <td style="text-align: center; vertical-align: middle;">
                                            <button type="button" id="othername_<?php echo $i; ?>_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2"><input type="button" class="btn btn-success" id="repeat_othername" value="+"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        </div>

                        <div id="myModal" class="modal fade" role="dialog" style="z-index: 100000;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Select Scans</h4>
                                    </div>
                                    <div class="modal-body">
                                        <table id="tbl_scan_details" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <td>Sr</td>
                                                    <td>Date</td>
                                                    <td>Newspaper</td>
                                                    <td>Page Number</td>
                                                    <td>Section</td>
                                                    <td>Action</td>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="myModal2" class="modal fade" role="dialog" style="z-index: 100000;">
                            <div class="modal-dialog">
                                <div class="modal-content" style="width: 755px; height: 635px;">
                                    <div class="modal-body">
                                        <div id="content">
                                            <div class="container" style="margin: 0px;">
                                                <section class="copy">
                                                    <div class="figure-wrapper">
                                                        <figure class="image-container target" style="max-width: 110%; margin-top: 15px;">
                                                            <img id="target_img" src="" alt="DomoKun">

                                                            <figcaption class="image-meta">
                                                                <a id="scan_img" target="_blank" href=""></a>
                                                            </figcaption>
                                                        </figure>
                                                    </div>
                                                </section>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div> -->
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                </div>
            </div>
            @if(!Route::is('notice.details'))
            <div class="box-footer">
                <a href="{{url('index.php/notice')}}" class="btn btn-danger btn-sm pull-right">Cancel</a>
                <button class="btn btn-success btn-sm pull-right" type="submit" style="margin-right:20px">Save</button>
            </div>
            @endif
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    var property_no_type_list = '';
    @foreach($property_no_type_list as $property_no_type)
        property_no_type_list = property_no_type_list + '<option value="{{$property_no_type->id}}">{{$property_no_type->property_no_type}}</option>';
    @endforeach

    var location_type_list = '';
    @foreach($location_type_list as $location_type)
        location_type_list = location_type_list + '<option value="{{$location_type->id}}">{{$location_type->location_type}}</option>';
    @endforeach

    var certificate_no_type_list = '';
    @foreach($certificate_no_type_list as $certificate_no_type)
        certificate_no_type_list = certificate_no_type_list + '<option value="{{$certificate_no_type->id}}">{{$certificate_no_type->certificate_no_type}}</option>';
    @endforeach
</script>

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
<script src="{{asset('/plugins/crop/demo/vendor/fabric.js')}}"></script>
<script src="{{asset('/plugins/crop/build/darkroom.js')}}"></script>
@endsection