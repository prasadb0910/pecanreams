@extends('adminlte::layouts.app')

@section('styles')
    <style>
        .form-group {margin-bottom: 5px;}
    </style>
    @if(Route::is('property.details'))
    <style>
        .form-group label{
            font-weight: bold;
        }
        .form-group label:after {
            content: ": ";
        }
        input {
            border: none!important;
        }
        input:read-only { 
            background-color: none!important;
        }
    </style>
    @endif
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
        @if(Session::has('warning_msg'))
        <div class="alert alert-warning">{{Session::get('warning_msg')}}</div>
        @endif
        <form id="form_property" action="{{url('index.php/property/save')}}" method="POST" class="form-horizontal">
            <div class="box">
                <div class="box-header">
                    <h4 class="pull-left"><b>Property Details</b></h4>
                    <a href="{{url('index.php/property')}}" class="btn btn-primary btn-sm pull-right">Back</a>
                </div>
                <div class="box-body">
                    {{csrf_field()}}
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="pull-left"><b>Ownership</b></h4>
                        </div>
                        <div class="box-body">
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="hidden" class="form-control" name="id" value="@if(isset($data)){{$data->id}}@endif">
                                <table class="table table-bordered" id="tbl_legal_owner_name">
                                    <thead>
                                        <tr>
                                            <th>Legal Owner Name</th>
                                            <th style="text-align:center;" class="hide_details">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=0; if(isset($legal_owner_name) && count($legal_owner_name)>0) {
                                            for($i=0; $i<count($legal_owner_name); $i++) { ?>
                                            <tr id="legal_owner_name_<?php echo $i; ?>_row">
                                                <td>
                                                    <input type="text" class="form-control legal_owner_name" name="legal_owner_name[]" id="legal_owner_name_<?php echo $i; ?>" placeholder="Enter Legal Owner Name..." value="<?php if (isset($legal_owner_name)) { echo $legal_owner_name[$i]->legal_owner_name; } ?>" />
                                                </td>
                                                <td style="text-align: center; vertical-align: middle;" class="hide_details">
                                                    <button type="button" id="legal_owner_name_<?php echo $i; ?>_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>
                                                </td>
                                            </tr>
                                            <?php }} else { ?>
                                            <tr id="legal_owner_name_<?php echo $i; ?>_row">
                                                <td>
                                                    <input type="text" class="form-control legal_owner_name" name="legal_owner_name[]" id="legal_owner_name_<?php echo $i; ?>" placeholder="Enter Legal Owner Name..." value="" />
                                                </td>
                                                <td style="text-align: center; vertical-align: middle;" class="hide_details">
                                                    <button type="button" id="legal_owner_name_<?php echo $i; ?>_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                    </tbody>
                                    <tfoot class="hide_details">
                                        <tr>
                                            <td colspan="2"><input type="button" class="btn btn-success" id="repeat_legal_owner_name" value="+"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="pull-left"><b>Property Details</b></h4>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 0px; padding: 0px;">
                                <label class="col-md-2 col-sm-2 col-xs-12 control-label">Property Type *</label>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <select class="form-control" name="property_type" id="property_type">
                                        <option value="">Select Property Type</option>
                                        <option value="Land" @if(isset($data)) @if($data->property_type=="Land"){{'selected'}} @endif @endif>Land</option>
                                        <option value="Unit" @if(isset($data)) @if($data->property_type=="Unit"){{'selected'}} @endif @endif>Unit</option>
                                        <option value="Others" @if(isset($data)) @if($data->property_type=="Others"){{'selected'}} @endif @endif>Others</option>
                                    </select>
                                </div>

                                <label class="col-md-2 col-sm-2 col-xs-12 control-label">Property Name *</label>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <input type="text" class="form-control" name="property_name" value="@if(isset($data)){{$data->property_name}}@endif" placeholder="Enter Property Name...">
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>

                    <div class="box" id="address_dtl">
                        <div class="box-header with-border">
                            <h4 class="pull-left"><b>Address Details</b></h4>
                        </div>
                        <div class="box-body">
                            <div class="form-group" id="unit_floor">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                  <!--   <label class="col-md-2 col-sm-2 col-xs-12 control-label">Unit/Apartment No</label>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <input type="text" class="form-control" name="apartment_no" value="@if(isset($data)){{$data->apartment_no}}@endif" placeholder="Enter Unit/Apartment No...">
                                    </div> -->
                                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Floor</label>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <input type="text" class="form-control" name="floor" value="@if(isset($data)){{$data->floor}}@endif" placeholder="Enter Floor...">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" id="wing_bldng">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Wing</label>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <input type="text" class="form-control" name="wing" value="@if(isset($data)){{$data->wing}}@endif" placeholder="Enter Wing...">
                                    </div>

                                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Building Name</label>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <input type="text" class="form-control" name="building_name" value="@if(isset($data)){{$data->building_name}}@endif" placeholder="Enter Building Name...">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" id="society">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label class="col-md-2 col-sm-2 col-xs-12 control-label" >Society Name</label>
                                    <div class="col-md-4 col-sm-4 col-xs-12" >
                                        <input type="text" class="form-control" name="society_name" value="@if(isset($data)){{$data->society_name}}@endif" placeholder="Enter Society Name...">
                                    </div>
                                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">  Street / locality</label>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <input type="text" class="form-control" name="address" value="@if(isset($data)){{$data->address}}@endif"  placeholder="Enter Street / locality...">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                     <table class="table table-bordered" id="tbl_property_no_detail">
                                        <thead>
                                            <tr>
                                                <th>Property No Type</th>
                                                <th>Property No</th>
                                                <th style="text-align:center;" class="hide_details">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i=0; if(isset($property_no_detail) && count($property_no_detail)>0) {
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
                                                    <td style="text-align: center; vertical-align: middle;" class="hide_details">
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
                                                    <td style="text-align: center; vertical-align: middle;" class="hide_details">
                                                        <button type="button" id="property_no_detail_<?php echo $i; ?>_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                            <tfoot class="hide_details">
                                                <tr>
                                                    <td colspan="3"><input type="button" class="btn btn-success" id="repeat_property_no_detail" value="+"></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                      <table class="table table-bordered" id="tbl_location_detail">
                                        <thead>
                                            <tr>
                                                <th>Location Type</th>
                                                <th>Location</th>
                                                <th style="text-align:center;" class="hide_details">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i=0; if(isset($location_detail) && count($location_detail)>0) {
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
                                                    <td style="text-align: center; vertical-align: middle;" class="hide_details">
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
                                                    <td style="text-align: center; vertical-align: middle;" class="hide_details">
                                                        <button type="button" id="location_detail_<?php echo $i; ?>_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                            <tfoot class="hide_details">
                                                <tr>
                                                    <td colspan="3"><input type="button" class="btn btn-success" id="repeat_location_detail" value="+"></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Pincode</label>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <input type="text" class="form-control" name="pincode" value="@if(isset($data)){{$data->pincode}}@endif" placeholder="Enter Pincode...">
                                    </div>
                                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">City</label>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <input type="text" class="form-control" name="city" value="@if(isset($data)){{$data->city}}@endif" placeholder="Enter City...">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">State</label>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <input type="text" class="form-control" name="state" value="@if(isset($data)){{$data->state}}@endif" placeholder="Enter State...">
                                    </div>
                                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Country</label>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <input type="text" class="form-control" name="country" value="@if(isset($data)){{$data->country}}@else{{'India'}}@endif" placeholder="Enter Country...">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Google Map Address</label>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <input type="text" class="form-control" name="google_map_address" value="@if(isset($data)){{$data->google_map_address}}@endif" placeholder="Enter Google Map Address...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="box" id="general_dtl">
                        <div class="box-header with-border">
                            <h4 class="pull-left"><b>Other Details</b></h4>
                        </div>
                        <div class="box-body">
                            <div class="form-group" id="parking">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Parking Count</label>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <input type="text" class="form-control" name="no_of_parking" value="@if(isset($data)){{$data->no_of_parking}}@endif" placeholder="Enter No of Parking...">
                                    </div>
                                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Parking No</label>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <input type="text" class="form-control" name="parking_no" value="@if(isset($data)){{$data->parking_no}}@endif" placeholder="Enter Parking No...">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <table class="table table-bordered" id="tbl_guarantor">
                                            <thead>
                                                <tr>
                                                    <th>Guarantor</th>
                                                    <th style="text-align:center;" class="hide_details">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i=0; if(isset($guarantor) && count($guarantor)>0) {
                                                for($i=0; $i<count($guarantor); $i++) { ?>
                                                <tr id="guarantor_<?php echo $i; ?>_row">
                                                    <td>
                                                        <input type="text" class="form-control guarantor" name="guarantor[]" id="guarantor_<?php echo $i; ?>" placeholder="Enter Guarantor..." value="<?php if (isset($guarantor)) { echo $guarantor[$i]->guarantor; } ?>" />
                                                    </td>
                                                    <td style="text-align: center; vertical-align: middle;" class="hide_details">
                                                        <button type="button" id="guarantor_<?php echo $i; ?>_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>
                                                    </td>
                                                </tr>
                                                <?php }} else { ?>
                                                <tr id="guarantor_<?php echo $i; ?>_row">
                                                    <td>
                                                        <input type="text" class="form-control guarantor" name="guarantor[]" id="guarantor_<?php echo $i; ?>" placeholder="Enter Guarantor..." value="" />
                                                    </td>
                                                    <td style="text-align: center; vertical-align: middle;" class="hide_details">
                                                        <button type="button" id="guarantor_<?php echo $i; ?>_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                            <tfoot class="hide_details">
                                                <tr>
                                                    <td colspan="2"><input type="button" class="btn btn-success" id="repeat_guarantor" value="+"></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <table class="table table-bordered" id="tbl_purchased_from">
                                            <thead>
                                                <tr>
                                                    <th>Purchased From</th>
                                                    <th style="text-align:center;" class="hide_details">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php $i=0; if(isset($purchased_from) && count($purchased_from)>0) {
                                                for($i=0; $i<count($purchased_from); $i++) { ?>
                                                <tr id="purchased_from_<?php echo $i; ?>_row">
                                                    <td>
                                                        <input type="text" class="form-control purchased_from" name="purchased_from[]" id="purchased_from_<?php echo $i; ?>" placeholder="Enter Purchased From..." value="<?php if (isset($purchased_from)) { echo $purchased_from[$i]->purchased_from; } ?>" />
                                                    </td>
                                                    <td style="text-align: center; vertical-align: middle;" class="hide_details">
                                                        <button type="button" id="purchased_from_<?php echo $i; ?>_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>
                                                    </td>
                                                </tr>
                                                <?php }} else { ?>
                                                <tr id="purchased_from_<?php echo $i; ?>_row">
                                                    <td>
                                                        <input type="text" class="form-control purchased_from" name="purchased_from[]" id="purchased_from_<?php echo $i; ?>" placeholder="Enter Purchased From..." value="" />
                                                    </td>
                                                    <td style="text-align: center; vertical-align: middle;" class="hide_details">
                                                        <button type="button" id="purchased_from_<?php echo $i; ?>_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                            <tfoot class="hide_details">
                                                <tr>
                                                    <td colspan="2"><input type="button" class="btn btn-success" id="repeat_purchased_from" value="+"></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Description</label>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <input type="text" class="form-control" name="description" value="@if(isset($data)){{$data->description}}@endif" placeholder="Enter Description...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="box" id="share_dtl">
                        <div class="box-header with-border">
                            <h4 class="pull-left"><b>Share Details</b></h4>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <table class="table table-bordered" id="tbl_company_name">
                                        <thead>
                                            <tr>
                                                <th>Company Name</th>
                                                <th style="text-align:center;" class="hide_details">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i=0; if(isset($company_name) && count($company_name)>0) {
                                            for($i=0; $i<count($company_name); $i++) { ?>
                                            <tr id="company_name_<?php echo $i; ?>_row">
                                                <td>
                                                    <input type="text" class="form-control company_name" name="company_name[]" id="company_name_<?php echo $i; ?>" placeholder="Enter Company Name..." value="<?php if (isset($company_name)) { echo $company_name[$i]->company_name; } ?>" />
                                                </td>
                                                <td style="text-align: center; vertical-align: middle;" class="hide_details">
                                                    <button type="button" id="company_name_<?php echo $i; ?>_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>
                                                </td>
                                            </tr>
                                            <?php }} else { ?>
                                            <tr id="company_name_<?php echo $i; ?>_row">
                                                <td>
                                                    <input type="text" class="form-control company_name" name="company_name[]" id="company_name_<?php echo $i; ?>" placeholder="Enter Company Name..." value="" />
                                                </td>
                                                <td style="text-align: center; vertical-align: middle;" class="hide_details">
                                                    <button type="button" id="company_name_<?php echo $i; ?>_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot class="hide_details">
                                            <tr>
                                                <td colspan="2"><input type="button" class="btn btn-success" id="repeat_company_name" value="+"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <table class="table table-bordered" id="tbl_certificate_no_detail">
                                        <thead>
                                            <tr>
                                                <th>Certificate No Type</th>
                                                <th>Certificate No</th>
                                                <th style="text-align:center;" class="hide_details">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php $i=0; if(isset($certificate_no_detail) && count($certificate_no_detail)>0) {
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
                                                <td style="text-align: center; vertical-align: middle;" class="hide_details">
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
                                                <td style="text-align: center; vertical-align: middle;" class="hide_details">
                                                    <button type="button" id="certificate_no_detail_<?php echo $i; ?>_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot class="hide_details">
                                            <tr>
                                                <td colspan="3"><input type="button" class="btn btn-success" id="repeat_certificate_no_detail" value="+"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="pull-left"><b>Group Details</b></h4>
                        </div>
                        <div class="box-body">



                            <div class="form-group">
                                <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 0px; padding: 0px;">
                                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Group Name</label>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <select class="form-control" name="fk_group_id">
                                            <option value="">Select Group</option>
                                            @foreach($group_details as $group)
                                            <option value="{{$group->id}}" @if(isset($data)) @if($group->id==$data->fk_group_id){{'selected'}} @endif @elseif(isset($data2['fk_group_id'])) @if($group->id==$data2['fk_group_id']){{'selected'}} @endif @endif>{{$group->group_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                @if(!Route::is('property.details'))
                <div class="box-footer">
                    <a href="{{url('index.php/property')}}" class="btn btn-danger btn-sm">Cancel</a>
                    <button class="btn btn-success btn-sm pull-right" type="submit">Save</button>
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
<script src="{{asset('/js/property.js')}}"></script>
@if(Route::is('property.details'))
<script type="text/javascript">
    $('input').attr('readonly', 'readonly');
    $('input').css("background-color","#FFF");
    $('.hide_details').hide();
    $('select').css("border","none");
    console.log('hiii');
</script>
@endif
<script>
$(document).ready(function(){
    change_property_type();
});
$('#property_type').change(function() {
    change_property_type();
});
var change_property_type = function(){
    if ($('#property_type').val() == 'Land') {
        $('#wing_bldng').hide();
        $('#unit_floor').hide();
        $('#parking').hide();
        $('#society').hide();

        $('#share_dtl').hide();
        $('#address_dtl').show();
        $('#general_dtl').show();
    } else  if ($('#property_type').val() == 'Unit') {
        $('#wing_bldng').show();
        $('#unit_floor').show();
        $('#parking').show();
        $('#society').show();

        $('#share_dtl').hide();
        $('#address_dtl').show();
        $('#general_dtl').show();
    } else if ($('#property_type').val() == 'Others'){
        $('#address_dtl').hide();
        $('#general_dtl').hide();
        $('#share_dtl').show();
    }
}
</script>
@endsection