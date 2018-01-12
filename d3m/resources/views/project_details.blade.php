@extends('adminlte::layouts.app')

@section('styles')
	<!-- <link href="{{-- asset('/bootstrap/css/bootstrap.min.css') --}}" rel="stylesheet" type="text/css" />
	<link href="{{-- asset('/dist/css/AdminLTE.min.css') --}}" rel="stylesheet" type="text/css" />
	<link href="{{-- asset('/dist/css/skins/_all-skins.min.css') --}}" rel="stylesheet" type="text/css" /> -->
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
	<link href="{{ asset('/js/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('/js/plugins/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('/js/plugins/datepicker/datepicker3.css') }}" rel="stylesheet" type="text/css" />
	<style>
		#region {
			overflow-y: auto;
		}
		#eg1 {
			overflow-x: scroll;
		}
		.form-group {
			margin-bottom: 5px;
		}
		.control-label {
			padding-top: 0px !important;
		}
	</style>
@endsection

@section('main-content')
<form class="form-horizontal">
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Orgnization Details</h3>
			</div>
			<div class="box-body">
				<div class="form-group">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<label class="col-md-2 col-sm-2 col-xs-12 control-label">Orgnization Name:</label>
						<span class="col-md-4 col-sm-4 col-xs-12 values"> <input type="text" class="form-control" name="org_name" placeholder="Enter Orgnization Name" value="@if(isset($project)){{$project[0]->owner_name}}@endif"></span>
						<label class="col-md-2 col-sm-2 col-xs-12 control-label">Orgnization Type:</label>
						<span class="col-md-4 col-sm-4 col-xs-12 values"> <input type="text" class="form-control" name="org_type" placeholder="Enter Orgnization Type" value="@if(isset($project)){{$project[0]->owner_type}}@endif"></span>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<label class="col-md-2 col-sm-2 col-xs-12 control-label">Web Url:</label>
						<span class="col-md-4 col-sm-4 col-xs-12 values"> <input type="text" class="form-control" name="web_url" placeholder="Enter Web Url" value="@if(isset($project)){{$project[0]->website_url}}@endif"></span>
					</div>
				</div>
			</div>
		</div>

		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Project Details</h3>
			</div>
			<div class="box-body">
				<div class="form-group">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<label class="col-md-2 col-sm-2 col-xs-12 control-label">Master Project:</label>
						<span class="col-md-4 col-sm-4 col-xs-12 values"> <input type="text" class="form-control" name="master_project" placeholder="Enter Master Project" value="@if(isset($project)){{$project[0]->master_project_name}}@endif"></span>
						<label class="col-md-2 col-sm-2 col-xs-12 control-label">Project Name:</label>
						<span class="col-md-4 col-sm-4 col-xs-12 values"> <input type="text" class="form-control" name="project_name" placeholder="Enter Project Name" value="@if(isset($project)){{$project[0]->project_name}}@endif"></span>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<label class="col-md-2 col-sm-2 col-xs-12 control-label">Developer 1:</label>
						<span class="col-md-4 col-sm-4 col-xs-12 values"> <input type="text" class="form-control" name="developer_1" placeholder="Enter Developer 1" value="@if(isset($project)){{$project[0]->developer_1}}@endif"></span>
						<label class="col-md-2 col-sm-2 col-xs-12 control-label">Developer 2:</label>
						<span class="col-md-4 col-sm-4 col-xs-12 values"> <input type="text" class="form-control" name="developer_2" placeholder="Enter Developer 2" value="@if(isset($project)){{$project[0]->developer_2}}@endif"></span>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<label class="col-md-2 col-sm-2 col-xs-12 control-label">Developer 3:</label>
						<span class="col-md-4 col-sm-4 col-xs-12 values"> <input type="text" class="form-control" name="developer_3" placeholder="Enter Developer 3" value="@if(isset($project)){{$project[0]->developer_3}}@endif"></span>
						<label class="col-md-2 col-sm-2 col-xs-12 control-label">Developer 4:</label>
						<span class="col-md-4 col-sm-4 col-xs-12 values"> <input type="text" class="form-control" name="developer_4" placeholder="Enter Developer 4" value="@if(isset($project)){{$project[0]->developer_4}}@endif"></span>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<label class="col-md-2 col-sm-2 col-xs-12 control-label">Project Status:</label>
						<span class="col-md-4 col-sm-4 col-xs-12 values"> <input type="text" class="form-control" name="project_status" placeholder="Enter Project Status" value="@if(isset($project)){{$project[0]->project_status}}@endif"></span>
						<label class="col-md-2 col-sm-2 col-xs-12 control-label">Proposed Date of Completion:</label>
						<span class="col-md-4 col-sm-4 col-xs-12 values"> <input type="text" class="form-control" name="proposed_date_of_completion" placeholder="Enter Proposed Date of Completion" value="@if(isset($project)){{$project[0]->proposed_date_of_completion}}@endif"></span>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<label class="col-md-2 col-sm-2 col-xs-12 control-label">Revised Proposed Date of Completion:</label>
						<span class="col-md-4 col-sm-4 col-xs-12 values"> <input type="text" class="form-control" name="revised_proposed_date_of_completion" placeholder="Enter Revised Proposed Date of Completion" value="@if(isset($project)){{$project[0]->revised_proposed_date_of_completion}}@endif"></span>
						<label class="col-md-2 col-sm-2 col-xs-12 control-label">Litigations related to the project ?:</label>
						<span class="col-md-4 col-sm-4 col-xs-12 values"> <input type="checkbox" class="" name="litigations" value="Yes" @if(isset($project)) @if($project[0]->litigations=='Yes'){{'selected'}}@endif @endif></span>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<label class="col-md-2 col-sm-2 col-xs-12 control-label">Project Type:</label>
						<span class="col-md-4 col-sm-4 col-xs-12 values"> <input type="text" class="form-control" name="project_type" placeholder="Enter Project Type" value="@if(isset($project)){{$project[0]->project_type}}@endif"></span>
						<label class="col-md-2 col-sm-2 col-xs-12 control-label">Co Promoters:</label>
						<span class="col-md-4 col-sm-4 col-xs-12 values"> <input type="checkbox" class="" name="co_promoters" value="Yes" @if(isset($project)) @if($project[0]->litigations=='Yes'){{'selected'}}@endif @endif></span>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<label class="col-md-2 col-sm-2 col-xs-12 control-label">Plot Bearing No / CTS no / Survey Number / Final Plot no.:</label>
						<span class="col-md-4 col-sm-4 col-xs-12 values"> <input type="text" class="form-control" name="survey_number" placeholder="Enter Plot Bearing No / CTS no / Survey Number / Final Plot no." value="@if(isset($project)){{$project[0]->survey_number}}@endif"></span>
						<label class="col-md-2 col-sm-2 col-xs-12 control-label">Area(In sqft):</label>
						<span class="col-md-4 col-sm-4 col-xs-12 values"> <input type="text" class="form-control" name="area_in_sqft" placeholder="Enter Area In sqft" value="@if(isset($project)){{$project[0]->area_in_sqft}}@endif"></span>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<label class="col-md-2 col-sm-2 col-xs-12 control-label">Boundaries East:</label>
						<span class="col-md-4 col-sm-4 col-xs-12 values"> <input type="text" class="form-control" name="boundaries_east" placeholder="Enter Boundaries East" value="@if(isset($project)){{$project[0]->boundaries_east}}@endif"></span>
						<label class="col-md-2 col-sm-2 col-xs-12 control-label">Boundaries West:</label>
						<span class="col-md-4 col-sm-4 col-xs-12 values"> <input type="text" class="form-control" name="boundaries_west" placeholder="Enter Boundaries West" value="@if(isset($project)){{$project[0]->boundaries_west}}@endif"></span>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<label class="col-md-2 col-sm-2 col-xs-12 control-label">Boundaries North:</label>
						<span class="col-md-4 col-sm-4 col-xs-12 values"> <input type="text" class="form-control" name="boundaries_north" placeholder="Enter Boundaries North" value="@if(isset($project)){{$project[0]->boundaries_north}}@endif"></span>
						<label class="col-md-2 col-sm-2 col-xs-12 control-label">Boundaries South:</label>
						<span class="col-md-4 col-sm-4 col-xs-12 values"> <input type="text" class="form-control" name="boundaries_south" placeholder="Enter Boundaries South" value="@if(isset($project)){{$project[0]->boundaries_south}}@endif"></span>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<label class="col-md-2 col-sm-2 col-xs-12 control-label">State:</label>
						<span class="col-md-4 col-sm-4 col-xs-12 values"> <input type="text" class="form-control" name="state" placeholder="Enter State" value="@if(isset($project)){{$project[0]->state}}@endif"></span>
						<label class="col-md-2 col-sm-2 col-xs-12 control-label">Division:</label>
						<span class="col-md-4 col-sm-4 col-xs-12 values"> <input type="text" class="form-control" name="division" placeholder="Enter Division" value="@if(isset($project)){{$project[0]->division}}@endif"></span>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<label class="col-md-2 col-sm-2 col-xs-12 control-label">District:</label>
						<span class="col-md-4 col-sm-4 col-xs-12 values"> <input type="text" class="form-control" name="district" placeholder="Enter District" value="@if(isset($project)){{$project[0]->district}}@endif"></span>
						<label class="col-md-2 col-sm-2 col-xs-12 control-label">Taluka:</label>
						<span class="col-md-4 col-sm-4 col-xs-12 values"> <input type="text" class="form-control" name="taluka" placeholder="Enter Taluka" value="@if(isset($project)){{$project[0]->taluka}}@endif"></span>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<label class="col-md-2 col-sm-2 col-xs-12 control-label">Village:</label>
						<span class="col-md-4 col-sm-4 col-xs-12 values"> <input type="text" class="form-control" name="village" placeholder="Enter Village" value="@if(isset($project)){{$project[0]->village}}@endif"></span>
						<label class="col-md-2 col-sm-2 col-xs-12 control-label">Pin Code:</label>
						<span class="col-md-4 col-sm-4 col-xs-12 values"> <input type="text" class="form-control" name="pin_code" placeholder="Enter Pin Code" value="@if(isset($project)){{$project[0]->pin_code}}@endif"></span>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<label class="col-md-2 col-sm-2 col-xs-12 control-label">Location:</label>
						<span class="col-md-4 col-sm-4 col-xs-12 values">  
							<select class="form-control" id="location" name="location">
								<option value="">Select Location</option>
								<?php $cnt = 0; if(isset($location)) $cnt = count($location); ?>
								@for($i=0; $i<$cnt; $i++)
									<option value="{{ $location[$i]->location }}" @if(isset($project)) @if($location[$i]->location==$project[0]->location){{'selected'}} @endif @endif>{{ $location[$i]->location }}</option>
								@endfor
							</select>
						</span>
						<label class="col-md-2 col-sm-2 col-xs-12 control-label">Sub Location:</label>
						<span class="col-md-4 col-sm-4 col-xs-12 values">  
							<select class="form-control" id="sub_location" name="sub_location">
								<option value="">Select Location</option>
								<?php $cnt = 0; if(isset($sub_location)) $cnt = count($sub_location); ?>
								@for($i=0; $i<$cnt; $i++)
									<option value="{{ $sub_location[$i]->sub_location }}" @if(isset($project)) @if($sub_location[$i]->sub_location==$project[0]->sub_location){{'selected'}} @endif @endif>{{ $sub_location[$i]->sub_location }}</option>
								@endfor
							</select>
						</span>
					</div>
				</div>
			</div>
		</div>

		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">FSI Details</h3>
			</div>
			<div class="box-body">
				<div class="form-group">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<label class="col-md-2 col-sm-2 col-xs-12 control-label">Built-up-Area as per Proposed FSI(In sqft):</label>
						<span class="col-md-4 col-sm-4 col-xs-12 values"> <input type="text" class="form-control" name="builtup_area_in_proposed_fsi" placeholder="Enter Built-up-Area as per Proposed FSI (In sqft) :" value="@if(isset($project)){{$project[0]->builtup_area_in_proposed_fsi}}@endif"></span>
						<label class="col-md-2 col-sm-2 col-xs-12 control-label">Built-up-Area as per Approved FSI(In sqft):</label>
						<span class="col-md-4 col-sm-4 col-xs-12 values"> <input type="text" class="form-control" name="builtup_area_in_approved_fsi" placeholder="Enter Built-up-Area as per Approved FSI (In sqft):" value="@if(isset($project)){{$project[0]->builtup_area_in_approved_fsi}}@endif"></span><br><br>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<label class="col-md-2 col-sm-2 col-xs-12 control-label">Total FSI:</label>
						<span class="col-md-4 col-sm-4 col-xs-12 values"> <input type="text" class="form-control" name="total_fsi" placeholder="Total FSI" value="@if(isset($project)){{$project[0]->total_fsi}}@endif"></span>
						<label class="col-md-2 col-sm-2 col-xs-12 control-label">Total Carpet Area:</label>
						<span class="col-md-4 col-sm-4 col-xs-12 values"> <input type="text" class="form-control" name="total_carpet_area" placeholder="Total Carpet Area" value="@if(isset($project)){{$project[0]->total_carpet_area}}@endif"></span>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<label class="col-md-2 col-sm-2 col-xs-12 control-label">FSI To Carpet Area Ratio:</label>
						<span class="col-md-4 col-sm-4 col-xs-12 values"> <input type="text" class="form-control" name="fsi_to_carpet_area_ratio" placeholder="FSI To Carpet Area Ratio" value="@if(isset($project)){{$project[0]->fsi_to_carpet_area_ratio}}@endif"></span>
					</div>
				</div>
			</div>
		</div>

		<div class="box box-primary"  >
			<div class="box-header with-border">
				<h3 class="box-title">Building Details</h3>
			</div>
			<div id="sections">
					<?php $cnt = 0; if(isset($property)) $cnt = count($property); ?>
						@for ($i = 0; $i < $cnt; $i++)
			<div class="box-body">
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title">Project Details</h3>
					</div>
					<div class="box-body">
						<div class="form-group">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<label class="col-md-2 col-sm-2 col-xs-12 control-label">Project Name:</label>
								<span class="col-md-4 col-sm-4 col-xs-12 values"> <input type="text" class="form-control" name="Project Name" placeholder="Enter Project Name" value="@if(isset($property)){{$property[$i]->project_name}}@endif"></span>
								<label class="col-md-2 col-sm-2 col-xs-12 control-label">Name:</label>
								<span class="col-md-4 col-sm-4 col-xs-12 values"> <input type="text" class="form-control" name="Name" placeholder="Enter Name" value="@if(isset($property)){{$property[$i]->property_name}}@endif"></span>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<label class="col-md-2 col-sm-2 col-xs-12 control-label">Number of Basement's:</label>
								<span class="col-md-4 col-sm-4 col-xs-12 values"> <input type="text" class="form-control" name="Number of Basement's" placeholder="Enter Number of Basement's" value="@if(isset($property)){{$property[$i]->number_of_basement}}@endif"></span>
								<label class="col-md-2 col-sm-2 col-xs-12 control-label">Number of Plinth:</label>
								<span class="col-md-4 col-sm-4 col-xs-12 values"> <input type="text" class="form-control" name="Number of Plinth" placeholder="Enter Number of Plinth" value="@if(isset($property)){{$property[$i]->number_of_plinth}}@endif"></span>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<label class="col-md-2 col-sm-2 col-xs-12 control-label">Number of Podium's:</label>
								<span class="col-md-4 col-sm-4 col-xs-12 values"> <input type="text" class="form-control" name="Number of Podium's" placeholder="Number of Podium's" value="@if(isset($property)){{$property[$i]->number_of_podium}}@endif"></span>
								<label class="col-md-2 col-sm-2 col-xs-12 control-label">Number of Slab of Super Structure:</label>
								<span class="col-md-4 col-sm-4 col-xs-12 values"> <input type="text" class="form-control" name="Number of Slab of Super Structure" placeholder="Enter Number of Slab of Super Structure" value="@if(isset($property)){{$property[$i]->number_of_slab_of_super_structure}}@endif"></span>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<label class="col-md-2 col-sm-2 col-xs-12 control-label">Number of Stilts:</label>
								<span class="col-md-4 col-sm-4 col-xs-12 values"> <input type="text" class="form-control" name="Number of Stilts" placeholder=" Enter Number of Stilts" value="@if(isset($property)){{$property[$i]->number_of_stilts}}@endif"></span>
								<label class="col-md-2 col-sm-2 col-xs-12 control-label">Number of Open Parking:</label>
								<span class="col-md-4 col-sm-4 col-xs-12 values"> <input type="text" class="form-control" name="Number of Open Parking" placeholder="Number of Open Parking" value="@if(isset($property)){{$property[$i]->	number_of_open_parking}}@endif" ></span>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<label class="col-md-2 col-sm-2 col-xs-12 control-label">Number of Closed Parking:</label>
								<span class="col-md-4 col-sm-4 col-xs-12 values"> <input type="text" class="form-control" name="Boundaries West" placeholder="Enter Boundaries West" value="@if(isset($property)){{$property[$i]->	number_of_closed_parking}}@endif"></span>
							</div>
						</div>
					</div>
				</div>
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title">Appartment Details</h3>
					</div>
					
					<?php $cnt = 0; if(isset($apartment)) $cnt = count($apartment); ?>
						@for ($i = 0; $i < $cnt; $i++)
					
					<div class="box-body" id="apartment">
						<div class="form-group">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<label class="col-md-2 col-sm-2 col-xs-12 control-label">Apartment Type:</label>
								<span class="col-md-4 col-sm-4 col-xs-12 values">  
									<select class="form-control">
										<option>Residential</option>
										<option>Office</option>
										<option>Retail</option>
										<option>Goverment Housings</option>
										<option>Others</option>
									</select>
								</span>
								<label class="col-md-2 col-sm-2 col-xs-12 control-label">Carpet Area (in Sqmts):</label>
								<span class="col-md-4 col-sm-4 col-xs-12 values"> <input type="text" class="form-control" name="Carpet Area (in Sqmts)" placeholder="Enter Carpet Area (in Sqmts)" value="@if(isset($apartment)){{$apartment[$i]->		carpet_area_sqft}}@endif"></span><br><br>
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<label class="col-md-2 col-sm-2 col-xs-12 control-label" >Number of Apartment:</label>
								<span class="col-md-4 col-sm-4 col-xs-12 values"> <input type="text" class="form-control" name="Number of Apartment" placeholder="Number of Apartment" value="@if(isset($apartment)){{$apartment[$i]->		number_of_apartment}}@endif"></span>
								<label class="col-md-2 col-sm-2 col-xs-12 control-label">Number of Booked Apartment:</label>
								<span class="col-md-4 col-sm-4 col-xs-12 values"> <input type="text" class="form-control" name="Number of Booked Apartment" placeholder="Number of Booked Apartment" value="@if(isset($apartment)){{$apartment[$i]->	no_of_booked_apartment	}}@endif" ></span><br><br>
							</div>
						</div>
					</div><hr	>  @endfor
					
				</div>
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title">Task Details</h3>
					</div>
						<?php $cnt = 0; if(isset($task)) $cnt = count($task); ?>
						@for ($i = 0; $i < $cnt; $i++)
					<div class="box-body" id="tasks">task
						<div class="form-group">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<label class="col-md-2 col-sm-2 col-xs-12 control-label">Tasks / Activity:</label>
								<span class="col-md-4 col-sm-4 col-xs-12 values"> <input type="text" class="form-control" name="Tasks / Activity" placeholder="Enter Tasks / Activity" value="@if(isset($task)){{$task[$i]->	task	}}@endif"></span>
								<label class="col-md-2 col-sm-2 col-xs-12 control-label">Percentage of Work:</label>
								<span class="col-md-4 col-sm-4 col-xs-12 values"> <input type="text" class="form-control" name="Percentage of Work" placeholder="Enter Percentage of Work" value="@if(isset($task)){{$task[$i]->	percentage_of_work	}}@endif"></span><br><br>
							</div>
						</div>
					</div><hr	>  @endfor
	
				</div>
			</div>
			    @endfor
			</div>
			
		</div>
	</div>
</div>
</form>
@endsection

@section('js')
<script type="text/javascript">
    // 'use strict';
    // const BASE_URL = '{!! url("index.php/").'/' !!}';
</script>

<script type="text/javascript">
    // mixpanel.track("Market Level Page.");
</script>
@endsection