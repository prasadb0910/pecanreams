@extends('adminlte::layouts.app')

@section('styles')
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
	<link href="{{ asset('/dist/css/AdminLTE.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('main-content')
<div class="box box-default">
	<div class="box-header with-border">
		<h3 class="box-title">Orgnization Details</h3>
	</div>
	<div class="box-body">
		<div class="form-group">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<label class="col-md-2 col-sm-2 col-xs-12 control-label">Orgnization Name:</label>
				<span class="col-md-4 col-sm-4 col-xs-12 values">{{ $project_details[0]->owner_name }}</span>
				<label class="col-md-2 col-sm-2 col-xs-12 control-label">Orgnization Type:</label>
				<span class="col-md-4 col-sm-4 col-xs-12 values">{{ $project_details[0]->owner_type }}</span>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12">
				<label class="col-md-2 col-sm-2 col-xs-12 control-label">Web Url:</label>
				<span class="col-md-4 col-sm-4 col-xs-12 values">{{ $project_details[0]->website_url }}</span>
			</div>
		</div>
	</div>
</div>
@inject('service', 'App\Http\Controllers\SearchController')
<div class="box box-default">
	<div class="box-header with-border">
		<h3 class="box-title">Project Details</h3>
	</div>
	<div class="box-body">
		<div class="form-group">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<label class="col-md-2 col-sm-2 col-xs-12 control-label">Project Name:</label>
				<span class="col-md-4 col-sm-4 col-xs-12 values">{{ $project_details[0]->master_project_name }}</span>
				<label class="col-md-2 col-sm-2 col-xs-12 control-label">Project Status:</label>
				<span class="col-md-4 col-sm-4 col-xs-12 values">{{ $project_details[0]->project_status }}</span>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12">
				<label class="col-md-2 col-sm-2 col-xs-12 control-label">Proposed Date of Completion:</label>
				<span class="col-md-4 col-sm-4 col-xs-12 values">{{ Carbon\Carbon::parse($project_details[0]->proposed_date_of_completion)->format('j F Y') }}</span>
				<label class="col-md-2 col-sm-2 col-xs-12 control-label">Revised Proposed Date of Completion:</label>
				<span class="col-md-4 col-sm-4 col-xs-12 values">{{ Carbon\Carbon::parse($project_details[0]->revised_proposed_date_of_completion)->format('j F Y') }}</span>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12">
				<label class="col-md-2 col-sm-2 col-xs-12 control-label">Litigations related to the project ?:</label>
				<span class="col-md-4 col-sm-4 col-xs-12 values">{{ $project_details[0]->litigations }}</span>
				<label class="col-md-2 col-sm-2 col-xs-12 control-label">Project Type:</label>
				<span class="col-md-4 col-sm-4 col-xs-12 values">{{ $project_details[0]->project_type }}</span>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12">
				<label class="col-md-2 col-sm-2 col-xs-12 control-label">Plot Bearing No / CTS no / Survey Number/Final Plot no.:</label>
				<span class="col-md-4 col-sm-4 col-xs-12 values">{{ $project_details[0]->survey_number }}</span>
				<label class="col-md-2 col-sm-2 col-xs-12 control-label">Boundaries East:</label>
				<span class="col-md-4 col-sm-4 col-xs-12 values">{{ $project_details[0]->boundaries_east }}</span>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12">
				<label class="col-md-2 col-sm-2 col-xs-12 control-label">Boundaries West:</label>
				<span class="col-md-4 col-sm-4 col-xs-12 values">{{ $project_details[0]->boundaries_west }}</span>
				<label class="col-md-2 col-sm-2 col-xs-12 control-label">Boundaries North:</label>
				<span class="col-md-4 col-sm-4 col-xs-12 values">{{ $project_details[0]->boundaries_north }}</span>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12">
				<label class="col-md-2 col-sm-2 col-xs-12 control-label">Boundaries South:</label>
				<span class="col-md-4 col-sm-4 col-xs-12 values">{{ $project_details[0]->boundaries_south }}</span>
				<label class="col-md-2 col-sm-2 col-xs-12 control-label">State:</label>
				<span class="col-md-4 col-sm-4 col-xs-12 values">{{ $project_details[0]->state }}</span>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12">
				<label class="col-md-2 col-sm-2 col-xs-12 control-label">Division:</label>
				<span class="col-md-4 col-sm-4 col-xs-12 values">{{ $project_details[0]->division }}</span>
				<label class="col-md-2 col-sm-2 col-xs-12 control-label">District:</label>
				<span class="col-md-4 col-sm-4 col-xs-12 values">{{ $project_details[0]->district }}</span>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12">
				<label class="col-md-2 col-sm-2 col-xs-12 control-label">Taluka:</label>
				<span class="col-md-4 col-sm-4 col-xs-12 values">{{ $project_details[0]->taluka }}</span>
				<label class="col-md-2 col-sm-2 col-xs-12 control-label">Village:</label>
				<span class="col-md-4 col-sm-4 col-xs-12 values">{{ $project_details[0]->village }}</span>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12">
				<label class="col-md-2 col-sm-2 col-xs-12 control-label">Pin Code:</label>
				<span class="col-md-4 col-sm-4 col-xs-12 values">{{ $project_details[0]->pin_code }}</span>
				<label class="col-md-2 col-sm-2 col-xs-12 control-label">Area(In Sqft):</label>
				<span class="col-md-4 col-sm-4 col-xs-12 values">{{ $service->moneyFormatIndia(round($project_details[0]->area_in_sqft),2) }}</span>
			</div>
		</div>
	</div>
</div>

<div class="box box-default">
	<div class="box-header with-border">
		<h3 class="box-title">FSI Details</h3>
	</div>
	<div class="box-body">
		<div class="form-group">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<label class="col-md-2 col-sm-2 col-xs-12 control-label">Built-up-Area as per Proposed FSI (In Sqft) :</label>
				<span class="col-md-4 col-sm-4 col-xs-12 values">
					@if ($project_details[0]->builtup_area_in_proposed_fsi!=0)
						{{ $service->moneyFormatIndia(round($project_details[0]->builtup_area_in_proposed_fsi),2) }}
					@endif
				</span>
				<label class="col-md-2 col-sm-2 col-xs-12 control-label">Built-up-Area as per Approved FSI (In Sqft):</label>
				<span class="col-md-4 col-sm-4 col-xs-12 values">
					
					@if ($project_details[0]->builtup_area_in_approved_fsi!=0)
						{{ $service->moneyFormatIndia(round($project_details[0]->builtup_area_in_approved_fsi),2) }}
					@endif
				</span>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12">
				<label class="col-md-2 col-sm-2 col-xs-12 control-label">TotalFSI:</label>
				<span class="col-md-4 col-sm-4 col-xs-12 values">{{ $service->moneyFormatIndia(round($project_details[0]->total_fsi),2) }}</span>
			</div>
		</div>
	</div>
</div>

<div class="box box-default">
	<div class="box-header with-border">
		<h3 class="box-title">Covered Parking</h3>
	</div>
	<div class="box-body">
		<div class="form-group">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<label class="col-md-2 col-sm-2 col-xs-12 control-label">Proposed Covered Parking  :</label>
				<span class="col-md-4 col-sm-4 col-xs-12 values">
					@if ($project_details[0]->parking_proposed!=0)
						{{ $project_details[0]->parking_proposed }}
					@endif
				</span>
				<label class="col-md-2 col-sm-2 col-xs-12 control-label">Booked Covered Parking:</label>
				<span class="col-md-4 col-sm-4 col-xs-12 values">
					@if ($project_details[0]->parking_booked!=0)
						{{ $project_details[0]->parking_booked }}
					@endif
				</span>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12">
				<label class="col-md-2 col-sm-2 col-xs-12 control-label">WorkDone(In %) Covered Parking:</label>
				<span class="col-md-4 col-sm-4 col-xs-12 values">
					@if ($project_details[0]->parking_workdone_in_per!=0)
						{{ $project_details[0]->parking_workdone_in_per }}
					@endif
				</span>
			</div>
		</div>
	</div>
</div>

<div class="box">
	<div class="box-header">
		<h3 class="box-title">Building Details</h3>
	</div>
	<div class="box-body">
		<table id="" class="table table-bordered">
			<thead>
				<tr>
					<th>Sr.No.</th>
					<th>Project Name</th>
					<th>Name</th>
					<th>Number of Basement's</th>
					<th>Number of Plinth</th>
					<th>Number of Podium's</th>
					<th>Number of Slab of Super Structure</th>
					<th>Number of Stilts</th>
					<th>Number of Open Parking</th>
					<th>Parking	Number of Closed Parking</th>
				</tr>
			</thead>
			<tbody>
				<?php $cnt_prop_details = count($prop_details); ?>
				@for($i=0; $i<$cnt_prop_details; $i++)
				<tr>
					<td>{{ $i+1 }}</td>
					<td>{{ $prop_details[$i]->project_name }}</td>
					<td>{{ $prop_details[$i]->property_name }}</td>
					<td>{{ $prop_details[$i]->number_of_basement }}</td>
					<td>{{ $prop_details[$i]->number_of_plinth }}</td>
					<td>{{ $prop_details[$i]->number_of_podium }}</td>
					<td>{{ $prop_details[$i]->number_of_slab_of_super_structure }}</td>
					<td>{{ $prop_details[$i]->number_of_stilts }}</td>
					<td>{{ $prop_details[$i]->number_of_open_parking }}</td>
					<td>{{ $prop_details[$i]->number_of_closed_parking }}</td>
				</tr>
				<tr>
					<td></td>
					<td colspan="9">
						<table id="" class="table table-bordered">
							<thead>
								<tr>
									<th>Sr.No.</th>
									<th>Apartment Type</th>
									<th>Carpet Area (in Sqft)</th>
									<th>Number of Apartment</th>
									<th>Number of Booked Apartment</th>
								</tr>
							</thead>
							<tbody>
								<?php $cnt_apt_details = count($apt_details[$i]); ?>
								@for($j=0; $j<$cnt_apt_details; $j++)
								<tr>
									<td>{{ $j+1 }}</td>
									<td>{{ $apt_details[$i][$j]->apartment_type_updated }}</td>
									<td>{{ round($apt_details[$i][$j]->carpet_area_sqft,2) }}</td>
									<td>{{ $apt_details[$i][$j]->number_of_apartment }}</td>
									<td>{{ $apt_details[$i][$j]->no_of_booked_apartment }}</td>
								</tr>
								@endfor
							</tbody>
						</table>
					</td>
				</tr>  
				<tr>
					<td></td>
					<td colspan="9">
						<table id="" class="table table-bordered">
							<thead>
								<tr>
									<th>Sr.No.</th>
									<th>Tasks / Activity</th>
									<th>Percentage of Work</th>
								</tr>
							</thead>
							<tbody>
								<?php $cnt_task_details = count($task_details[$i]); ?>
								@for($j=0; $j<$cnt_task_details; $j++)
								<tr>
									<td>{{ $j+1 }}</td>
									<td>{{ $task_details[$i][$j]->task }}</td>
									<td>{{ $task_details[$i][$j]->percentage_of_work }}</td>
								</tr>
								@endfor
							</tbody>
						</table>
					</td>
				</tr>
				@endfor
			</tbody>
		</table>
	</div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    mixpanel.track("Details Page.");
</script>
@endsection