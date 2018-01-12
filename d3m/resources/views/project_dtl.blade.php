@extends('adminlte::layouts.app')

@section('styles')
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
	<!-- <link href="{{-- asset('/dist/css/AdminLTE.min.css') --}}" rel="stylesheet" type="text/css" /> -->
<style>
#example1
{
	overflow-x:scroll;
}
input[type="text"] {
    width: 100%;
}
</style>

@endsection

@section('main-content')

        @if(Session::has('success_msg'))
        <div class="alert alert-success">{{Session::get('success_msg')}}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <p>{{$error}}</p>
            @endforeach()
            </div>
        @endif
	
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
	      <form id="form_notice_type" action="{{url('index.php/project/details/save')}}" method="POST" class="form-horizontal">
	 {{csrf_field()}}
		<div class="form-group">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<label class="col-md-2 col-sm-2 col-xs-12 control-label">Master Project Name:</label>
				<span class="col-md-4 col-sm-4 col-xs-12 values">
				 <input type="hidden" class="form-control" name="id" value="@if(isset($project_details)){{$project_details[0]->project_sr_no}}@endif">
				<input type="text" class="form-control" name="master_project_name" placeholder="Enter Master Project Name" value="@if(isset($project_details)){{$project_details[0]->master_project_name}}@endif"></span>
				<label class="col-md-2 col-sm-2 col-xs-12 control-label">Project Name:</label>
				<span class="col-md-4 col-sm-4 col-xs-12 values">{{ $project_details[0]->project_name }}</span>
			</div>
					<div>
		&nbsp
				</div>
			
			
					<div class="col-md-12 col-sm-12 col-xs-12">
						<label class="col-md-2 col-sm-2 col-xs-12 control-label">Developer 1:</label>
						<span class="col-md-4 col-sm-4 col-xs-12 values"> <input type="text" class="form-control" name="developer_1" placeholder="Enter Developer 1" value="@if(isset($project_details)){{$project_details[0]->developer_1}}@endif"></span>
						<label class="col-md-2 col-sm-2 col-xs-12 control-label">Developer 2:</label>
						<span class="col-md-4 col-sm-4 col-xs-12 values"> <input type="text" class="form-control" name="developer_2" placeholder="Enter Developer 2" value="@if(isset($project_details)){{$project_details[0]->developer_2}}@endif"></span>
					</div>
		
				<div>
		&nbsp
				</div>
			
					<div class="col-md-12 col-sm-12 col-xs-12">
						<label class="col-md-2 col-sm-2 col-xs-12 control-label">Developer 3:</label>
						<span class="col-md-4 col-sm-4 col-xs-12 values"> <input type="text" class="form-control" name="developer_3" placeholder="Enter Developer 3" value="@if(isset($project_details)){{$project_details[0]->developer_3}}@endif"></span>
						<label class="col-md-2 col-sm-2 col-xs-12 control-label">Developer 4:</label>
						<span class="col-md-4 col-sm-4 col-xs-12 values"> <input type="text" class="form-control" name="developer_4" placeholder="Enter Developer 4" value="@if(isset($project_details)){{$project_details[0]->developer_4}}@endif"></span>
					</div>
			
					<div>
		&nbsp
				</div>
					<div class="col-md-12 col-sm-12 col-xs-12">
				<label class="col-md-2 col-sm-2 col-xs-12 control-label">Project Status:</label>
				<span class="col-md-4 col-sm-4 col-xs-12 values">{{ $project_details[0]->project_status }}</span>
				<label class="col-md-2 col-sm-2 col-xs-12 control-label">Proposed Date of Completion:</label>
				<span class="col-md-4 col-sm-4 col-xs-12 values">{{ Carbon\Carbon::parse($project_details[0]->proposed_date_of_completion)->format('j F Y') }}</span>
			
		
			</div>
				
			<div class="col-md-12 col-sm-12 col-xs-12">
				<label class="col-md-2 col-sm-2 col-xs-12 control-label">Revised Proposed Date of Completion:</label>
					<span class="col-md-4 col-sm-4 col-xs-12 values">{{ Carbon\Carbon::parse($project_details[0]->revised_proposed_date_of_completion)->format('j F Y') }}</span>
				<label class="col-md-2 col-sm-2 col-xs-12 control-label">Litigations related to the project ?:</label>
				<span class="col-md-4 col-sm-4 col-xs-12 values">{{ $project_details[0]->litigations }}</span>
				
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-2 col-sm-2 col-xs-12 control-label">Project Type:</label>
				<span class="col-md-4 col-sm-4 col-xs-12 values">{{ $project_details[0]->project_type }}</span>
				<label class="col-md-2 col-sm-2 col-xs-12 control-label">Plot Bearing No / CTS no / Survey Number/Final Plot no.:</label>
				<span class="col-md-4 col-sm-4 col-xs-12 values">{{ $project_details[0]->survey_number }}</span>
			
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12">
				<label class="col-md-2 col-sm-2 col-xs-12 control-label">Boundaries East:</label>
				<span class="col-md-4 col-sm-4 col-xs-12 values">{{ $project_details[0]->boundaries_east }}</span>
				<label class="col-md-2 col-sm-2 col-xs-12 control-label">Boundaries West:</label>
				<span class="col-md-4 col-sm-4 col-xs-12 values">{{ $project_details[0]->boundaries_west }}</span>
			
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12">
				<label class="col-md-2 col-sm-2 col-xs-12 control-label">Boundaries North:</label>
				<span class="col-md-4 col-sm-4 col-xs-12 values">{{ $project_details[0]->boundaries_north }}</span>
				<label class="col-md-2 col-sm-2 col-xs-12 control-label">Boundaries South:</label>
				<span class="col-md-4 col-sm-4 col-xs-12 values">{{ $project_details[0]->boundaries_south }}</span>
			
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12">
				<label class="col-md-2 col-sm-2 col-xs-12 control-label">State:</label>
				<span class="col-md-4 col-sm-4 col-xs-12 values">{{ $project_details[0]->state }}</span>
				<label class="col-md-2 col-sm-2 col-xs-12 control-label">Division:</label>
				<span class="col-md-4 col-sm-4 col-xs-12 values">{{ $project_details[0]->division }}</span>
				
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12">
			<label class="col-md-2 col-sm-2 col-xs-12 control-label">District:</label>
				<span class="col-md-4 col-sm-4 col-xs-12 values">{{ $project_details[0]->district }}</span>
				<label class="col-md-2 col-sm-2 col-xs-12 control-label">Taluka:</label>
				<span class="col-md-4 col-sm-4 col-xs-12 values">{{ $project_details[0]->taluka }}</span>
			
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12">
				<label class="col-md-2 col-sm-2 col-xs-12 control-label">Village:</label>
				<span class="col-md-4 col-sm-4 col-xs-12 values">{{ $project_details[0]->village }}</span>
				<label class="col-md-2 col-sm-2 col-xs-12 control-label">Pin Code:</label>
				<span class="col-md-4 col-sm-4 col-xs-12 values">{{ $project_details[0]->pin_code }}</span>
			
			</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
				<label class="col-md-2 col-sm-2 col-xs-12 control-label">Area(In Sqft):</label>
				<span class="col-md-4 col-sm-4 col-xs-12 values">{{ $service->moneyFormatIndia(round($project_details[0]->area_in_sqft),2) }}</span>
				
				<label class="col-md-2 col-sm-2 col-xs-12 control-label">Entity Type:</label>
			<span class="col-md-4 col-sm-4 col-xs-12 values">  
									<select class="form-control" name="entity_type">
										<option>Gov</option>
										<option>Pvt</option>
										
									</select>
								</span>
					</div>
					<div>
		&nbsp
				</div>
			
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
	<div>
		&nbsp
				</div>
				<input type="submit"  class="btn btn-primary pull-right" name="save" value="save">
	</form>
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
					
						{{ $project_details[0]->parking_proposed }}
				
				</span>
				<label class="col-md-2 col-sm-2 col-xs-12 control-label">Booked Covered Parking:</label>
				<span class="col-md-4 col-sm-4 col-xs-12 values">
					
						{{ $project_details[0]->parking_booked }}
					
				</span>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12">
				<label class="col-md-2 col-sm-2 col-xs-12 control-label">WorkDone(In %) Covered Parking:</label>
				<span class="col-md-4 col-sm-4 col-xs-12 values">
		
						{{ $project_details[0]->parking_workdone_in_per }}
					
				</span>
			</div>
		</div>
	</div>
</div>

<div class="box box-default">
	<div class="box-header with-border">
		<h3 class="box-title">FSI Details</h3>
	</div>
	<div class="box-body">
				<div class="col-md-6 col-sm-6 col-xs-6">
				
						<div class="box-header with-border">
		<h4 class="box-title">Old FSI</h4>
	</div><br>
	
		<div class="form-group">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<label class="col-md-5 col-sm-5 col-xs-12 control-label">Built-up-Area as per Proposed FSI (In Sqft) :</label>
				<span class="col-md-7 col-sm-7 col-xs-12 values">
					
						@if(isset($project_details)){{ $service->moneyFormatIndia(round($project_details[0]->builtup_area_in_proposed_fsi),2) }}
					@endif
				</span>
				</div>
					<div class="col-md-12 col-sm-12 col-xs-12">
				<label class="col-md-5 col-sm-5 col-xs-12 control-label">Built-up-Area as per Approved FSI (In Sqft):</label>
				<span class="col-md-7 col-sm-7 col-xs-12 values">
					
			 @if(isset($project_details))
						{{ $service->moneyFormatIndia(round($project_details[0]->builtup_area_in_approved_fsi),2) }}
					@endif
				</span>
			</div>
	
					<div class="col-md-12 col-sm-12 col-xs-12">
						<label class="col-md-5 col-sm-5 col-xs-12 control-label">Total FSI:</label>
						<span class="col-md-7 col-sm-7 col-xs-12 values"> @if(isset($project_details)){{ $service->moneyFormatIndia(round($project_details[0]->total_fsi),2) }}@endif</span>
						</div>
							<div class="col-md-12 col-sm-12 col-xs-12">
						<label class="col-md-5 col-sm-5 col-xs-12 control-label">Total Carpet Area:</label>
						<span class="col-md-7 col-sm-7 col-xs-12 values"> @if(isset($project_details)){{  $service->moneyFormatIndia(round($project_details[0]->total_carpet_area),2) }}@endif</span>
					</div>
				
			
					<div class="col-md-12 col-sm-12 col-xs-12">
						<label class="col-md-5 col-sm-5 col-xs-12 control-label">FSI To Carpet Area Ratio:</label>
						<span class="col-md-7 col-sm-7 col-xs-12 values"> @if(isset($project_details)){{ $service->moneyFormatIndia(round($project_details[0]->fsi_to_carpet_area_ratio),2)}}@endif</span>
					</div>
				
					
					
		</div>
		</div>

	
	
			<div class="col-md-6 col-sm-6 col-xs-6">
			<div class="box-header with-border">
		<h4 class="box-title">New FSI</h4>
	</div>
			<br>
			 <form  action="{{url('index.php/project/details/save1')}}" method="POST" class="form-horizontal">
	 {{csrf_field()}}
				<div class="form-group">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<label class="col-md-5 col-sm-5 col-xs-12 control-label">Built-up-Area as per Proposed FSI(In sqft):</label>
						<span class="col-md-7 col-sm-7 col-xs-12 values">  <input type="hidden" class="form-control" name="id" value="@if(isset($project_details)){{$project_details[0]->project_sr_no}}@endif"><input type="text" class="form-control" name="builtup_area_in_proposed_fsi" placeholder="Enter Built-up-Area as per Proposed FSI (In sqft):"value=
					"@if(isset($project_details)){{$project_details[0]->builtup_area_in_proposed_fsi }}@endif"></span>
						</div>
							<div class="col-md-12 col-sm-12 col-xs-12">
						<label class="col-md-5 col-sm-5 col-xs-12 control-label">Built-up-Area as per Approved FSI(In sqft):</label>
						<span class="col-md-7 col-sm-7 col-xs-12 values"> <input type="text" class="form-control" name="builtup_area_in_approved_fsi" placeholder="Enter Built-up-Area as per Approved FSI (In sqft):" value="@if(isset($project_details)){{$project_details[0]->builtup_area_in_approved_fsi}}@endif"></span>
					</div>
		
		
					<div class="col-md-12 col-sm-12 col-xs-12">
						<label class="col-md-5 col-sm-5 col-xs-12 control-label">Total FSI:</label>
						<span class="col-md-7 col-sm-7 col-xs-12 values"> <input type="text" class="form-control" name="total_fsi" placeholder="Total FSI" value="@if(isset($project_details)){{ $project_details[0]->total_fsi }}@endif"></span>
					</div>	
									<div>
		&nbsp
				</div>	
					<div class="col-md-12 col-sm-12 col-xs-12">
						<label class="col-md-5 col-sm-5 col-xs-12 control-label">Total Carpet Area:</label>
						<span class="col-md-7 col-sm-7 col-xs-12 values"> <input type="text" class="form-control" name="total_carpet_area" placeholder="Total Carpet Area" value="@if(isset($project_details)){{  $project_details[0]->total_carpet_area }}@endif"></span>
					</div>
			
					<div>
		&nbsp
				</div>
					<div class="col-md-12 col-sm-12 col-xs-12">
						<label class="col-md-5 col-sm-5 col-xs-12 control-label">FSI To Carpet Area Ratio:</label>
						<span class="col-md-7 col-sm-7 col-xs-12 values"> <input type="text" class="form-control" name="fsi_to_carpet_area_ratio" placeholder="FSI To Carpet Area Ratio" value="@if(isset($project_details)){{ $project_details[0]->fsi_to_carpet_area_ratio}}@endif"></span>
					</div>
				</div>
								<div>
		&nbsp
				</div>
				<input type="submit"  class="btn btn-primary pull-right" name="save1" value="save">
	 </form>
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
					<td colspan="1">
						<table id="" class="table table-bordered">
							<thead>
							<tr><th colspan="5">Old Appartment Details:</th></tr>
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
					
					
					<td colspan="8">
						<table id="" class="table table-bordered">
					
							<thead>
								<tr><th colspan="6">New Appartment Details:</th></tr>
								
							
								<tr>
									<th>Sr.No.</th>
									<th>Project Type</th>
									<th>Mistake Type</th>
									<th>Apartment Type</th>
									<th>Carpet Area (in Sqft)</th>
									<th>Number of Apartment</th>
									<th>Number of Booked Apartment</th>
								</tr>
							</thead>
						
							<tbody>
							 <form  action="{{url('index.php/project/details/save2')}}" method="POST" class="form-horizontal">
	 {{csrf_field()}}
								<?php $cnt_apt_details = count($apt_details[$i]); ?>
								@for($j=0; $j<$cnt_apt_details; $j++)
								<tr>
									<td>{{ $j+1 }}</td>
									<input type="hidden" name="project_sr_no[]" value="{{ $apt_details[$i][$j]->project_sr_no }}">
									<input type="hidden" name="property_sr_no[]" value="{{ $apt_details[$i][$j]->property_sr_no }}">
									<td><select class="form-control" style="width:80px" name="apartment_type">
										<option>Residential</option>
										<option>Commersial</option>
										
									</select></td>
									<td><select class="form-control" name="mistake_type[]" style="width:80px">
										<option>Total</option>
										<option>Sqft</option>
										<option>Delete</option>
										
									</select></td>
									<td><input type="text" name="apartment_type_updated[]" value="{{ $apt_details[$i][$j]->apartment_type_updated }}"></td>
									<td><input type="text" name="carpet_area_sqft[]" value="{{ round($apt_details[$i][$j]->carpet_area_sqft,2) }}"></td>
									<td><input type="text" name="number_of_apartment[]" value="{{ $apt_details[$i][$j]->number_of_apartment }}"></td>
									<td><input type="text" name="no_of_booked_apartment[]" value="{{ $apt_details[$i][$j]->no_of_booked_apartment }}"></td>
								</tr>
							
								@endfor
								
							</tbody>
								
						
						</table>
			
				<input type="submit"  class="btn btn-primary pull-right" name="save2" value="save">
 
					</form>
					</td>
					
				</tr>  
				<!--<tr>
					<td></td>
					<td colspan="9">
						<table id="example1" class="table table-bordered">
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
				</tr>-->
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
<!-- <script src="{{--asset('/js/plugins/datatables/jquery.dataTables.min.js')--}}"></script>
<script src="{{--asset('/js/plugins/datatables/dataTables.bootstrap.min.js')--}}"></script> -->
<script>
// $(document).ready(function() {
//     $('#example').dataTable({
//     	"bSort": false,
//     	ordering: false,
//         "columnDefs": [ {
//             "visible": false,
//             "targets": -1
//         } ]
//     });
// });
</script>
@endsection