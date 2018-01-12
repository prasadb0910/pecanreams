@extends('adminlte::layouts.app')

@section('styles')
	<link href="{{ asset('/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
	<link href="{{ asset('/dist/css/AdminLTE.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('/dist/css/skins/_all-skins.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('/js/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('/js/plugins/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('/js/plugins/datepicker/datepicker3.css') }}" rel="stylesheet" type="text/css" />
	<style>
		.graphBartype_of_apt_area {height: 230px;}
		.graphBartype_of_completion_area {height: 240px;}
		.graphBartype_of_subregion_area {height: 240px;}
		.graphLabeltype_of_apt_area, .graphLabeltype_of_apt_units {height: 70px;}
		.graphLabeltype_of_completion_area, .graphLabeltype_of_completion_units {height: 50px;}
		.graphLabeltype_of_subregion_area, .graphLabeltype_of_subregion_units {height: 50px;}
		.select2-container--default .select2-selection--multiple .select2-selection__choice{color:#333}
		#map_JSChart_type_of_apt_area + div {display:none !important;}
		#map_JSChart_type_of_apt_units + div {display:none !important;}
		#map_JSChart_type_of_completion_area + div {display:none !important;}
		#map_JSChart_type_of_completion_units + div {display:none !important;}
		#map_JSChart_type_of_subregion_area + div {display:none !important;}
		#map_JSChart_type_of_subregion_units + div {display:none !important;}
		.highcharts-credits { display: none; }
		.highcharts-legend { position: absolute; margin-top: -100px; }
	</style>
@endsection

@section('main-content')
<div class="row">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-md-4">
				<strong> Date Updated Till: {{ Carbon\Carbon::parse($max_updation_date)->format('d/m/Y') }} </strong>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<select class="form-control select2" id="location" multiple="multiple" data-placeholder="Select a Area" style="width: 100%;">
						<?php $prv_loc = ''; $loc = ''; $cnt = 0; if(isset($location)) $cnt = count($location); ?>
						@for ($i = 0; $i < $cnt; $i++)
							@php $loc = $location[$i]->location; @endphp
							@if($prv_loc!=$loc)
								@if($prv_loc!='')
									</optgroup>
								@endif
								<optgroup label="{{ $location[$i]->location }}">
								@php $prv_loc = $location[$i]->location; @endphp
							@endif
					        <option value="{{ $location[$i]->sub_location }}">{{ $location[$i]->sub_location }}</option>
							@if($i == ($cnt - 1))
								</optgroup>
							@endif
					    @endfor
					</select><i class='fa fa-caret-down' style="position:absolute;left:341px; top:10px;"></i>
				</div>

				<div class="form-group">
					<select class="form-control select2" id="project_type" multiple="multiple" data-placeholder="Select Property Type" style="width: 100%;" >
						<?php $cnt = 0; if(isset($project_type)) $cnt = count($project_type); ?>
						<option value="">Select Project Type</option>
						@for ($i = 0; $i < $cnt; $i++)
					        <option value="{{ $project_type[$i]->project_type }}">{{ $project_type[$i]->project_type }}</option>
					    @endfor
					</select><i class='fa fa-caret-down' style="position:absolute;left:341px; margin-top:9px;"></i>
				</div>

				<div class="form-group">
					<select class="form-control" id="entity_type" style="width: 100%;" >
						<option>Include Government Housing</option>
						<option>Do Not Include Government Housing</option>
						<option>Show Only Government Housing</option>
					</select>
				</div>

				<div class="form-group">
					<button class="btn btn-success btn-md center-block" type="button" id="btn_get_details">Get Details</button>
				</div>
			</div>
			<div class="col-md-4">
				<div class="small-box bg-aqua">
					<div class="inner">
						<h3 id="master_proj_cnt">&nbsp;</h3>
						<p>Total No Of Properties</p>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="small-box bg-yellow">
					<div class="inner">
						<h3 id="no_of_prop">&nbsp;</h3>
						<p>Total No Of Sub Properties</p>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-4">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Total <span class="total_sf"></span> lacs sf Carpet Area </h3>
					</div>
					<div class="box-body">
						<div class="loader"></div>
						<div class="chart_div" id="total_sf_chart" style="height: 250px;"></div>
					</div>
				</div>
				
			</div>
			<div class="col-lg-4">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Total <span class="total_units"></span> units</h3>
					</div>
					<div class="box-body">
						<div class="loader"></div>
						<div class="chart_div" id="total_units_chart" style="height: 250px;"></div>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Total FSI <span id="total_fsi"></span> lacs sf </h3>
					</div>
					<div class="box-body">
						<div class="loader"></div>
						<div class="chart_div" id="total_fsi_chart" style="height: 250px;"></div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<h3>By Type Of Apartments</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Total <span class="total_sf"></span> lacs sf Carpet Area</h3>
					</div>
					<div class="box-body" style="height:auto;">
						<div class="loader"></div>
						<div class="chart_div" id="type_of_apt_area"></div>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Total <span class="total_units"></span> units</h3>
					</div>
					<div class="box-body" style="height:auto;">
						<div class="loader"></div>
						<div class="chart_div" id="type_of_apt_units"></div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<h3>By Type Of Completion</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Total <span class="total_sf"></span> lacs sf Carpet Area</h3>
					</div>
					<div class="box-body">
						<div class="loader"></div>
						<div class="chart_div" id="type_of_completion_area" ></div>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Total <span class="total_units"></span> units</h3>
					</div>
					<div class="box-body">
						<div class="loader"></div>
						<div class="chart_div" id="type_of_completion_units" ></div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<h3>By Type Of Subregions</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Total <span class="total_sf"></span> lacs sf Carpet Area</h3>
					</div>
					<div class="box-body">
						<div class="loader"></div>
						<div class="chart_div" id="type_of_subregion_area" ></div>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Total <span class="total_units"></span> units</h3>
					</div>
					<div class="box-body">
						<div class="loader"></div>
						<div class="chart_div" id="type_of_subregion_units" ></div>
					</div>
				</div>
			</div>
		</div>

		<div class="box">
			<div class="box-header">
				<h3 class="box-title">Top 25 Projects</h3>
			</div>
			<div class="box-body">
				<div class="loader"></div>
				<table id="tbl_project_details" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th style="vertical-align:top;">Sr No</th>
							<th style="vertical-align:top;">Master Project Name</th>
							<th style="vertical-align:top;">Name</th>
							<th style="vertical-align:top;">Total FSI (in sf)</th>
							<th style="vertical-align:top;">Approved FSI (in sf)</th>
							<th style="vertical-align:top;">Proposed FSI (in sf)</th>
							<th style="vertical-align:top;">Total Carpet Area (in sf)</th>
							<th style="vertical-align:top;">Sold Carpet Area (in sf)</th>
							<th style="vertical-align:top;">Sold Carpet Area %</th>
							<th style="vertical-align:top;">Total Units</th>
							<th style="vertical-align:top;">Sold Units</th>
							<th style="vertical-align:top;">Sold Units %</th>
							<th style="vertical-align:top;">Region</th>
							<th style="vertical-align:top;">Pin Code</th>
							<th style="vertical-align:top;">Location</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="box box-default">
			<ul style="font-size:14px;margin-left: 10px;"><strong>Note 1: Units Classification:</strong> 
				<li style="font-size:12px;font-family:arial;margin-left: 20px;">1 BHK includes units having areas less than 1 BHK and also 1.5 BHK</li>
				<li style="font-size:12px;font-family:arial; margin-left: 20px;">2 BHK includes 2.5BHK</li>
				<li style="font-size:12px;font-family:arial; margin-left: 20px;">3 BHK includes 3.5 BHK</li>
				<li style="font-size:12px;font-family:arial; margin-left: 20px;">4+ BHK represents units have 4 BHK or more.</li>
			</ul>
		</div>
	</div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    // 'use strict';
    // const BASE_URL = '{!! url("index.php/").'/' !!}';
</script>

<script src="{{asset('/js/plugins/chartjs/Chart.min.js')}}"></script>
<script src="{{asset('/js/plugins/sparkline/jquery.sparkline.min.js')}}"></script>
<script src="{{asset('/js/plugins/chartjs/Chart.min.js')}}"></script>
<script src="{{asset('/js/plugins/fastclick/fastclick.js')}}"></script>
<script src="{{asset('/dist/js/demo.js')}}"></script>
<script src="{{asset('/js/plugins/knob/jquery.knob.js')}}"></script>
<script src="{{asset('/js/plugins/sparkline/jquery.sparkline.min.js')}}"></script>
<script src="{{asset('/js/plugins/select2/select2.full.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="{{asset('/js/plugins/morris/morris.min.js')}}"></script>
<script src="{{asset('/js/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('/js/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/js/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('/js/plugins/flot/jquery.flot.min.js')}}"></script>
<script src="{{asset('/js/plugins/flot/jquery.flot.resize.min.js')}}"></script>
<script src="{{asset('/js/plugins/flot/jquery.flot.pie.min.js')}}"></script>
<script src="{{asset('/js/plugins/flot/jquery.flot.categories.min.js')}}"></script>
<script src="{{asset('/js/jqBarGraph.1.1.js')}}"></script>
<script src="{{asset('/js/jscharts.js')}}"></script>

<script src="{{asset('/js/dashboard.js')}}"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>

<script type="text/javascript">
    mixpanel.track("Market Level Page.");
</script>
@endsection