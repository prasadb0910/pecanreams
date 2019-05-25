@extends('adminlte::layouts.app')

@section('styles')
    <style>
        .form-group {margin-bottom: 5px;}
        .hide {display: none;}
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
        <form id="form_property_notice" action="{{url('index.php/prop_notice/save')}}" method="POST" class="form-horizontal" enctype="multipart/form-data">
            <div class="box">
            <div class="box-header">
                <h4 class="pull-left"><b>Property Notice Details</b></h4>
                <a href="{{url('index.php/prop_notice')}}" class="btn btn-primary btn-sm pull-right">Back</a>
            </div>
            <div class="box-body">
                {{csrf_field()}}
                <div class="form-group">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 0px; padding: 0px;">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">Notice Type</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="hidden" class="form-control" name="id" value="@if(isset($data)){{$data[0]->id}}@endif">
                                <select class="form-control" name="fk_notice_type_id">
                                    <option value="">Select Notice Type</option>
                                    @foreach($notice_type_list as $notice_type)
                                    <option value="{{$notice_type->id}}" @if(isset($notice)) @if($notice_type->id==$notice->fk_notice_type_id){{'selected'}} @endif @endif>{{$notice_type->notice_type}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 0px; padding: 0px;">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">Notice Title</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="hidden" class="form-control" name="notice_id" value="@if(isset($notice)){{$notice->id}}@endif">
                                <input type="hidden" class="form-control" name="details" id="details" value="@if(isset($notice)){{$notice->details}}@endif">
                                <input type="text" class="form-control" name="notice_title" value="@if(isset($notice)){{$notice->notice_title}}@endif" placeholder="Enter Notice Title...">
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 0px; padding: 0px;">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">Date of Notice</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" class="form-control" name="date_of_notice" id="date_of_notice" value="@if(isset($notice)){{Carbon\Carbon::parse($notice->date_of_notice)->format('d/m/Y')}}@elseif(isset($notice2['date_of_notice'])){{$notice2['date_of_notice']}}@else{{date('d/m/Y')}}@endif" placeholder="Enter Date of Notice...">
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 0px; padding: 0px;">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">Paper Name</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <select class="form-control" name="fk_newspaper_id">
                                    <option value="">Select News Paper</option>
                                    @foreach($newspaper_list as $newspaper)
                                    <option value="{{$newspaper->id}}" @if(isset($notice)) @if($newspaper->id==$notice->fk_newspaper_id){{'selected'}} @endif @elseif(isset($notice2['fk_newspaper_id'])) @if($newspaper->id==$notice2['fk_newspaper_id']){{'selected'}} @endif @endif>{{$newspaper->paper_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 0px; padding: 0px;">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">Paper Page No.</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" class="form-control" name="page_number" value="@if(isset($notice)){{$notice->page_number}}@endif" placeholder="Enter Page Number...">
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 0px; padding: 0px;">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">Name of Property</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" class="form-control" name="name_of_property" value="@if(isset($notice)){{$notice->name_of_property}}@endif" placeholder="Enter Name of Property...">
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 0px; padding: 0px;">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">Property Type</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <select class="form-control" name="property_type">
                                    <option value="">Select Property Type</option>
                                    <option value="Land" @if(isset($notice)) @if($notice->property_type=="Land"){{'selected'}} @endif @endif>Land</option>
                                    <option value="Unit" @if(isset($notice)) @if($notice->property_type=="Unit"){{'selected'}} @endif @endif>Unit</option>
                                    <option value="Others" @if(isset($notice)) @if($notice->property_type=="Others"){{'selected'}} @endif @endif>Others</option>
                                </select>
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 0px; padding: 0px;">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">Building Name</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" class="form-control" name="building_name" value="@if(isset($notice)){{$notice->building_name}}@endif" placeholder="Enter Building Name...">
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 0px; padding: 0px;">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">Society Name</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" class="form-control" name="society_name" value="@if(isset($notice)){{$notice->society_name}}@endif" placeholder="Enter Society Name...">
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
                                        <th style="text-align:center;" class="hide">Action</th>
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
                                            <td style="text-align: center; vertical-align: middle;" class="hide">
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
                                            <td style="text-align: center; vertical-align: middle;" class="hide">
                                                <button type="button" id="property_no_detail_<?php echo $i; ?>_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot class="hide">
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
                                <input type="text" class="form-control" name="floor" value="@if(isset($notice)){{$notice->floor}}@endif" placeholder="Enter Floor...">
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 0px; padding: 0px;">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">Wing</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" class="form-control" name="wing" value="@if(isset($notice)){{$notice->wing}}@endif" placeholder="Enter Wing...">
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 0px; padding: 0px;">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">Address</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" class="form-control" name="address" value="@if(isset($notice)){{$notice->address}}@endif" placeholder="Enter Address...">
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
                                        <th style="text-align:center;" class="hide">Action</th>
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
                                            <td style="text-align: center; vertical-align: middle;" class="hide">
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
                                            <td style="text-align: center; vertical-align: middle;" class="hide">
                                                <button type="button" id="location_detail_<?php echo $i; ?>_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot class="hide">
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
                                <input type="text" class="form-control" name="city" value="@if(isset($notice)){{$notice->city}}@endif" placeholder="Enter City...">
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 0px; padding: 0px;">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">Pincode</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" class="form-control" name="pincode" value="@if(isset($notice)){{$notice->pincode}}@endif" placeholder="Enter Pincode...">
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 0px; padding: 0px;">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">State</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" class="form-control" name="state" value="@if(isset($notice)){{$notice->state}}@endif" placeholder="Enter State...">
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 0px; padding: 0px;">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">Country</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" class="form-control" name="country" value="@if(isset($notice)){{$notice->country}}@else{{'India'}}@endif" placeholder="Enter Country...">
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 0px; padding: 0px;">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">Parking</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" class="form-control" name="parking" value="@if(isset($notice)){{$notice->parking}}@endif" placeholder="Enter Parking...">
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
                                        <th style="text-align:center;" class="hide">Action</th>
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
                                            <td style="text-align: center; vertical-align: middle;" class="hide">
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
                                            <td style="text-align: center; vertical-align: middle;" class="hide">
                                                <button type="button" id="certificate_no_detail_<?php echo $i; ?>_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot class="hide">
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
                                <input type="text" class="form-control" name="property_description" value="@if(isset($notice)){{$notice->property_description}}@endif" placeholder="Enter Property Description...">
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 0px; padding: 0px;">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">Issued by</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" class="form-control" name="issued_by" value="@if(isset($notice)){{$notice->issued_by}}@endif" placeholder="Enter Issued by...">
                            </div>
                        </div>
                        </div>

                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <table class="table table-bordered" id="tbl_legal_owner_name">
                                <thead>
                                    <tr>
                                        <th>Legal Owner Name</th>
                                        <th style="text-align:center;" class="hide">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=0; if(isset($legal_owner_name)) {
                                    for($i=0; $i<count($legal_owner_name); $i++) { ?>
                                    <tr id="legal_owner_name_<?php echo $i; ?>_row">
                                        <td>
                                            <input type="text" class="form-control legal_owner_name" name="legal_owner_name[]" id="legal_owner_name_<?php echo $i; ?>" placeholder="Enter Legal Owner Name..." value="<?php if (isset($legal_owner_name)) { echo $legal_owner_name[$i]->legal_owner_name; } ?>" />
                                        </td>
                                        <td style="text-align: center; vertical-align: middle;" class="hide">
                                            <button type="button" id="legal_owner_name_<?php echo $i; ?>_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>
                                        </td>
                                    </tr>
                                    <?php }} else { ?>
                                    <tr id="legal_owner_name_<?php echo $i; ?>_row">
                                        <td>
                                            <input type="text" class="form-control legal_owner_name" name="legal_owner_name[]" id="legal_owner_name_<?php echo $i; ?>" placeholder="Enter Legal Owner Name..." value="" />
                                        </td>
                                        <td style="text-align: center; vertical-align: middle;" class="hide">
                                            <button type="button" id="legal_owner_name_<?php echo $i; ?>_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot class="hide">
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
                                        <th style="text-align:center;" class="hide">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=0; if(isset($purchased_from)) {
                                    for($i=0; $i<count($purchased_from); $i++) { ?>
                                    <tr id="purchased_from_<?php echo $i; ?>_row">
                                        <td>
                                            <input type="text" class="form-control purchased_from" name="purchased_from[]" id="purchased_from_<?php echo $i; ?>" placeholder="Enter Purchased From..." value="<?php if (isset($purchased_from)) { echo $purchased_from[$i]->purchased_from; } ?>" />
                                        </td>
                                        <td style="text-align: center; vertical-align: middle;" class="hide">
                                            <button type="button" id="purchased_from_<?php echo $i; ?>_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>
                                        </td>
                                    </tr>
                                    <?php }} else { ?>
                                    <tr id="purchased_from_<?php echo $i; ?>_row">
                                        <td>
                                            <input type="text" class="form-control purchased_from" name="purchased_from[]" id="purchased_from_<?php echo $i; ?>" placeholder="Enter Purchased From..." value="" />
                                        </td>
                                        <td style="text-align: center; vertical-align: middle;" class="hide">
                                            <button type="button" id="purchased_from_<?php echo $i; ?>_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot class="hide">
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
                                        <th style="text-align:center;" class="hide">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=0; if(isset($company_name)) {
                                    for($i=0; $i<count($company_name); $i++) { ?>
                                    <tr id="company_name_<?php echo $i; ?>_row">
                                        <td>
                                            <input type="text" class="form-control company_name" name="company_name[]" id="company_name_<?php echo $i; ?>" placeholder="Enter Company Name..." value="<?php if (isset($company_name)) { echo $company_name[$i]->company_name; } ?>" />
                                        </td>
                                        <td style="text-align: center; vertical-align: middle;" class="hide">
                                            <button type="button" id="company_name_<?php echo $i; ?>_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>
                                        </td>
                                    </tr>
                                    <?php }} else { ?>
                                    <tr id="company_name_<?php echo $i; ?>_row">
                                        <td>
                                            <input type="text" class="form-control company_name" name="company_name[]" id="company_name_<?php echo $i; ?>" placeholder="Enter Company Name..." value="" />
                                        </td>
                                        <td style="text-align: center; vertical-align: middle;" class="hide">
                                            <button type="button" id="company_name_<?php echo $i; ?>_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot class="hide">
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
                                        <th style="text-align:center;" class="hide">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=0; if(isset($guarantor)) {
                                    for($i=0; $i<count($guarantor); $i++) { ?>
                                    <tr id="guarantor_<?php echo $i; ?>_row">
                                        <td>
                                            <input type="text" class="form-control guarantor" name="guarantor[]" id="guarantor_<?php echo $i; ?>" placeholder="Enter Guarantor..." value="<?php if (isset($guarantor)) { echo $guarantor[$i]->guarantor; } ?>" />
                                        </td>
                                        <td style="text-align: center; vertical-align: middle;" class="hide">
                                            <button type="button" id="guarantor_<?php echo $i; ?>_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>
                                        </td>
                                    </tr>
                                    <?php }} else { ?>
                                    <tr id="guarantor_<?php echo $i; ?>_row">
                                        <td>
                                            <input type="text" class="form-control guarantor" name="guarantor[]" id="guarantor_<?php echo $i; ?>" placeholder="Enter Guarantor..." value="" />
                                        </td>
                                        <td style="text-align: center; vertical-align: middle;" class="hide">
                                            <button type="button" id="guarantor_<?php echo $i; ?>_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot class="hide">
                                    <tr>
                                        <td colspan="2"><input type="button" class="btn btn-success" id="repeat_guarantor" value="+"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-sm-6 col-xs-12" style="margin: 0px;">
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label"></label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                &nbsp
                                    <br>
                                    <br>
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label"></label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                &nbsp
                                    <br>
                                    <br>
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label"></label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                &nbsp
                                    <br>
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label"></label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                &nbsp
                                    <br>
                                    <br>
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label"></label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                &nbsp
                                    <br>
                                    <br>
                            </div>
                        </div>
                        </div>
                        
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">Property Name</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" class="form-control" name="property_name" value="@if(isset($property)){{$property->property_name}}@endif" placeholder="Enter Property Name...">
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">Property Type</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <select class="form-control" name="property_type">
                                    <option value="">Select Property Type</option>
                                    <option value="Land" @if(isset($property)) @if($property->property_type=="Land"){{'selected'}} @endif @endif>Land</option>
                                    <option value="Unit" @if(isset($property)) @if($property->property_type=="Unit"){{'selected'}} @endif @endif>Unit</option>
                                    <option value="Others" @if(isset($property)) @if($property->property_type=="Others"){{'selected'}} @endif @endif>Others</option>
                                </select>
                            </div>
                        </div>
                        </div>
                       
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">Building Name</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" class="form-control" name="building_name" value="@if(isset($property)){{$property->building_name}}@endif" placeholder="Enter Building Name...">
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">Society Name</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" class="form-control" name="society_name" value="@if(isset($property)){{$property->society_name}}@endif" placeholder="Enter Society Name...">
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
                                        <th style="text-align:center;" class="hide">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=0; if(isset($property_no_detail1)) {
                                            for($i=0; $i<count($property_no_detail1); $i++) { ?>
                                        <tr id="property_no_detail_<?php echo $i; ?>_row" class="property_no_detail">
                                            <td>
                                                <select class="form-control" name="fk_property_no_type_id[]">
                                                    <option value="">Select Property No Type</option>
                                                    @foreach($property_no_type_list as $property_no_type)
                                                    <option value="{{$property_no_type->id}}" @if(isset($property_no_detail)) @if($property_no_type->id==$property_no_detail1[$i]->fk_property_no_type_id){{'selected'}} @endif @endif>{{$property_no_type->property_no_type}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="property_no[]" placeholder="Enter Property No..." value="<?php if (isset($property_no_detail1)) { echo $property_no_detail1[$i]->property_no; } ?>" />
                                            </td>
                                            <td style="text-align: center; vertical-align: middle;" class="hide">
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
                                            <td style="text-align: center; vertical-align: middle;" class="hide">
                                                <button type="button" id="property_no_detail_<?php echo $i; ?>_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot class="add_new hide">
                                    <tr>
                                        <td colspan="3"><input type="button" class="btn btn-success" id="repeat_property_no_detail" value="+"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        </div>
                        
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">Floor</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" class="form-control" name="floor" value="@if(isset($property)){{$property->floor}}@endif" placeholder="Enter Floor...">
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">Wing</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" class="form-control" name="wing" value="@if(isset($property)){{$property->wing}}@endif" placeholder="Enter Wing...">
                            </div>
                        </div>
                        </div>
                        
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">Address</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" class="form-control" name="address" value="@if(isset($property)){{$property->address}}@endif" placeholder="Enter Address...">
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
                                        <th style="text-align:center;" class="hide">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=0; if(isset($location_detail1)) {
                                            for($i=0; $i<count($location_detail1); $i++) { ?>
                                        <tr id="location_detail_<?php echo $i; ?>_row" class="location_detail">
                                            <td>
                                                <select class="form-control" name="fk_location_type_id[]">
                                                    <option value="">Select Location Type</option>
                                                    @foreach($location_type_list as $location_type)
                                                    <option value="{{$location_type->id}}" @if(isset($location_detail1)) @if($location_type->id==$location_detail1[$i]->fk_location_type_id){{'selected'}} @endif @endif>{{$location_type->location_type}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="location[]" placeholder="Enter Location..." value="<?php if (isset($location_detail1)) { echo $location_detail1[$i]->location; } ?>" />
                                            </td>
                                            <td style="text-align: center; vertical-align: middle;" class="hide">
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
                                            <td style="text-align: center; vertical-align: middle;" class="hide">
                                                <button type="button" id="location_detail_<?php echo $i; ?>_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot class="add_new hide">
                                    <tr>
                                        <td colspan="3"><input type="button" class="btn btn-success" id="repeat_location_detail" value="+"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        </div>
                        
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">City</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" class="form-control" name="city" value="@if(isset($property)){{$property->city}}@endif" placeholder="Enter City...">
                            </div>
                        </div>
                        </div>
                        
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">Pincode</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" class="form-control" name="pincode" value="@if(isset($property)){{$property->pincode}}@endif" placeholder="Enter Pincode...">
                            </div>
                        </div>
                        </div>
                        
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">State</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" class="form-control" name="state" value="@if(isset($property)){{$property->state}}@endif" placeholder="Enter State...">
                            </div>
                        </div>
                        </div>
                     
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">Country</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" class="form-control" name="country" value="@if(isset($property)){{$property->country}}@else{{'India'}}@endif" placeholder="Enter Country...">
                            </div>
                        </div>
                        </div>
                        
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">Parking count</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" class="form-control" name="no_of_parking" value="@if(isset($property)){{$property->no_of_parking}}@endif" placeholder="Enter No of Parking...">
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
                                        <th style="text-align:center;" class="hide">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=0; if(isset($certificate_no_detail1)) {
                                            for($i=0; $i<count($certificate_no_detail1); $i++) { ?>
                                        <tr id="certificate_no_detail_<?php echo $i; ?>_row" class="certificate_no_detail">
                                            <td>
                                                <select class="form-control" name="fk_certificate_no_type_id[]">
                                                    <option value="">Select Certificate No Type</option>
                                                    @foreach($certificate_no_type_list as $certificate_no_type)
                                                    <option value="{{$certificate_no_type->id}}" @if(isset($certificate_no_detail1)) @if($certificate_no_type->id==$certificate_no_detail1[$i]->fk_certificate_no_type_id){{'selected'}} @endif @endif>{{$certificate_no_type->certificate_no_type}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="certificate_no[]" placeholder="Enter Certificate No..." value="<?php if (isset($certificate_no_detail1)) { echo $certificate_no_detail1[$i]->certificate_no; } ?>" />
                                            </td>
                                            <td style="text-align: center; vertical-align: middle;" class="hide">
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
                                            <td style="text-align: center; vertical-align: middle;" class="hide">
                                                <button type="button" id="certificate_no_detail_<?php echo $i; ?>_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot class="add_new hide">
                                    <tr>
                                        <td colspan="3"><input type="button" class="btn btn-success" id="repeat_certificate_no_detail" value="+"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        </div>
                        
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">Area</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" class="form-control" name="area" value="@if(isset($property)){{$property->area}}@endif" placeholder="Enter Area...">
                            </div>
                        </div>
                        </div>
                        
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">Google Map Address</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" class="form-control" name="google_map_address" value="@if(isset($property)){{$property->google_map_address}}@endif" placeholder="Enter Google Map Address...">
                            </div>
                        </div>
                        </div>
                        
                        <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <table class="table table-bordered" id="tbl_legal_owner_name">
                                <thead>
                                    <tr>
                                        <th>Legal Owner Name</th>
                                        <th style="text-align:center;" class="hide">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=0; if(isset($legal_owner_name1)) {
                                    for($i=0; $i<count($legal_owner_name1); $i++) { ?>
                                    <tr id="legal_owner_name_<?php echo $i; ?>_row">
                                        <td>
                                            <input type="text" class="form-control legal_owner_name" name="legal_owner_name[]" id="legal_owner_name_<?php echo $i; ?>" placeholder="Enter Legal Owner Name..." value="<?php if (isset($legal_owner_name1)) { echo $legal_owner_name1[$i]->legal_owner_name; } ?>" />
                                        </td>
                                        <td style="text-align: center; vertical-align: middle;" class="hide">
                                            <button type="button" id="legal_owner_name_<?php echo $i; ?>_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>
                                        </td>
                                    </tr>
                                    <?php }} else { ?>
                                    <tr id="legal_owner_name_<?php echo $i; ?>_row">
                                        <td>
                                            <input type="text" class="form-control legal_owner_name" name="legal_owner_name[]" id="legal_owner_name_<?php echo $i; ?>" placeholder="Enter Legal Owner Name..." value="" />
                                        </td>
                                        <td style="text-align: center; vertical-align: middle;" class="hide">
                                            <button type="button" id="legal_owner_name_<?php echo $i; ?>_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                   <tfoot class="add_new hide">
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
                                        <th style="text-align:center;" class="hide">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=0; if(isset($purchased_from1)) {
                                    for($i=0; $i<count($purchased_from1); $i++) { ?>
                                    <tr id="purchased_from_<?php echo $i; ?>_row">
                                        <td>
                                            <input type="text" class="form-control purchased_from" name="purchased_from[]" id="purchased_from_<?php echo $i; ?>" placeholder="Enter Purchased From..." value="<?php if (isset($purchased_from1)) { echo $purchased_from1[$i]->purchased_from; } ?>" />
                                        </td>
                                        <td style="text-align: center; vertical-align: middle;" class="hide">
                                            <button type="button" id="purchased_from_<?php echo $i; ?>_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>
                                        </td>
                                    </tr>
                                    <?php }} else { ?>
                                    <tr id="purchased_from_<?php echo $i; ?>_row">
                                        <td>
                                            <input type="text" class="form-control purchased_from" name="purchased_from[]" id="purchased_from_<?php echo $i; ?>" placeholder="Enter Purchased From..." value="" />
                                        </td>
                                        <td style="text-align: center; vertical-align: middle;" class="hide">
                                            <button type="button" id="purchased_from_<?php echo $i; ?>_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot class="add_new hide">
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
                                        <th style="text-align:center;" class="hide">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=0; if(isset($company_name1)) {
                                    for($i=0; $i<count($company_name1); $i++) { ?>
                                    <tr id="company_name_<?php echo $i; ?>_row">
                                        <td>
                                            <input type="text" class="form-control company_name" name="company_name[]" id="company_name_<?php echo $i; ?>" placeholder="Enter Company Name..." value="<?php if (isset($company_name1)) { echo $company_name1[$i]->company_name; } ?>" />
                                        </td>
                                        <td style="text-align: center; vertical-align: middle;" class="hide">
                                            <button type="button" id="company_name_<?php echo $i; ?>_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>
                                        </td>
                                    </tr>
                                    <?php }} else { ?>
                                    <tr id="company_name_<?php echo $i; ?>_row">
                                        <td>
                                            <input type="text" class="form-control company_name" name="company_name[]" id="company_name_<?php echo $i; ?>" placeholder="Enter Company Name..." value="" />
                                        </td>
                                        <td style="text-align: center; vertical-align: middle;" class="hide">
                                            <button type="button" id="company_name_<?php echo $i; ?>_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot class="hide">
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
                                        <th style="text-align:center;" class="hide">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=0; if(isset($guarantor1)) {
                                    for($i=0; $i<count($guarantor1); $i++) { ?>
                                    <tr id="guarantor_<?php echo $i; ?>_row">
                                        <td>
                                            <input type="text" class="form-control guarantor" name="guarantor[]" id="guarantor_<?php echo $i; ?>" placeholder="Enter Guarantor..." value="<?php if (isset($guarantor1)) { echo $guarantor1[$i]->guarantor; } ?>" />
                                        </td>
                                        <td style="text-align: center; vertical-align: middle;" class="hide">
                                            <button type="button" id="guarantor_<?php echo $i; ?>_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>
                                        </td>
                                    </tr>
                                    <?php }} else { ?>
                                    <tr id="guarantor_<?php echo $i; ?>_row">
                                        <td>
                                            <input type="text" class="form-control guarantor" name="guarantor[]" id="guarantor_<?php echo $i; ?>" placeholder="Enter Guarantor..." value="" />
                                        </td>
                                        <td style="text-align: center; vertical-align: middle;" class="hide">
                                            <button type="button" id="guarantor_<?php echo $i; ?>_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot class="add_new hide">
                                    <tr>
                                        <td colspan="2"><input type="button" class="btn btn-success" id="repeat_guarantor" value="+"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            @if(!Route::is('notice.details'))
            <div class="box-footer">
                <a href="{{url('index.php/prop_notice')}}" class="btn btn-danger btn-sm pull-right">Cancel</a>
                <!-- <button class="btn btn-success btn-sm pull-right" type="submit" style="margin-right:20px">Save</button> -->
                <input type="submit" class="btn btn-success btn-sm pull-left" name="approve" value="Approve" style="margin-right:10px" />
                <input type="submit" class="btn btn-warning btn-sm pull-left" name="reject" value="Reject  " />
            </div>
            @endif
            </div>
        </form>
    </div>
</div>
@endsection