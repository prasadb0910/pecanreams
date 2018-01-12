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
		.select2-container--default .select2-selection--multiple .select2-selection__choice{color:#333}
		.graphBartype_of_apt_area_1 {height: 230px;}
		.graphBartype_of_completion_area_1 {height: 240px;}
		.graphBartype_of_subregion_area_1 {height: 240px;}
		.graphLabeltype_of_apt_area_1, .graphLabeltype_of_apt_units_1 {height: 70px;}
		.graphLabeltype_of_completion_area_1, .graphLabeltype_of_completion_units_1 {height: 50px;}
		.graphLabeltype_of_subregion_area_1, .graphLabeltype_of_subregion_units_1 {height: 50px;}
		#map_JSChart_type_of_apt_area_1 + div {display:none !important;}
		#map_JSChart_type_of_apt_units_1 + div {display:none !important;}
		#map_JSChart_type_of_completion_area_1 + div {display:none !important;}
		#map_JSChart_type_of_completion_units_1 + div {display:none !important;}
		#map_JSChart_type_of_subregion_area_1 + div {display:none !important;}
		#map_JSChart_type_of_subregion_units_1 + div {display:none !important;}
		.highcharts-credits_1 { display: none; }
		.highcharts-legend_1 { position: absolute; margin-top: -100px; }
		.graphBartype_of_apt_area_2 {height: 230px;}
		.graphBartype_of_completion_area_2 {height: 240px;}
		.graphBartype_of_subregion_area_2 {height: 240px;}
		.graphLabeltype_of_apt_area_2, .graphLabeltype_of_apt_units_2 {height: 70px;}
		.graphLabeltype_of_completion_area_2, .graphLabeltype_of_completion_units_2 {height: 50px;}
		.graphLabeltype_of_subregion_area_2, .graphLabeltype_of_subregion_units_2 {height: 50px;}
		#map_JSChart_type_of_apt_area_2 + div {display:none !important;}
		#map_JSChart_type_of_apt_units_2 + div {display:none !important;}
		#map_JSChart_type_of_completion_area_2 + div {display:none !important;}
		#map_JSChart_type_of_completion_units_2 + div {display:none !important;}
		#map_JSChart_type_of_subregion_area_2 + div {display:none !important;}
		#map_JSChart_type_of_subregion_units_2 + div {display:none !important;}
		.highcharts-credits_2 { display: none; }
		.highcharts-legend_2 { position: absolute; margin-top: -100px; }
		.graphBartype_of_apt_area_3 {height: 230px;}
		.graphBartype_of_completion_area_3 {height: 240px;}
		.graphBartype_of_subregion_area_3 {height: 240px;}
		.graphLabeltype_of_apt_area_3, .graphLabeltype_of_apt_units_3 {height: 70px;}
		.graphLabeltype_of_completion_area_3, .graphLabeltype_of_completion_units_3 {height: 50px;}
		.graphLabeltype_of_subregion_area_3, .graphLabeltype_of_subregion_units_3 {height: 50px;}
		#map_JSChart_type_of_apt_area_3 + div {display:none !important;}
		#map_JSChart_type_of_apt_units_3 + div {display:none !important;}
		#map_JSChart_type_of_completion_area_3 + div {display:none !important;}
		#map_JSChart_type_of_completion_units_3 + div {display:none !important;}
		#map_JSChart_type_of_subregion_area_3 + div {display:none !important;}
		#map_JSChart_type_of_subregion_units_3 + div {display:none !important;}
		.highcharts-credits_3 { display: none; }
		.highcharts-legend_3 { position: absolute; margin-top: -100px; }
	</style>
@endsection

@section('main-content')
<div class="row">
	<div class="col-md-4">
		<strong> Date Updated Till: {{ Carbon\Carbon::parse($max_updation_date)->format('d/m/Y') }} </strong>
	</div>
</div>

<div class="row">
	<div class="col-md-4">
		<div class="form-group">
			<label></label>
			<select class="form-control" id="criteria_1" style="width: 100%;" onChange="set_criteria(this);">
				<option selected="selected">Market</option>
				<option>Developer</option>
				<option>Project</option>
			</select>
		</div>
	</div>

	<div class="col-md-4">
		<div class="form-group">
			<label></label>
			<select class="form-control" id="criteria_2" style="width: 100%;" onChange="set_criteria(this);">
				<option selected="selected">Market</option>
				<option>Developer</option>
				<option>Project</option>
			</select>
		</div>
	</div>

	<div class="col-md-4">
		<div class="form-group">
			<label></label>
			<select class="form-control" id="criteria_3" style="width: 100%;" onChange="set_criteria(this);">
				<option selected="selected">Market</option>
				<option>Developer</option>
				<option>Project</option>
			</select>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-4">
		<div class="form-group" id="location_div_1">
			<select class="form-control select2" id="location_1" multiple="multiple" data-placeholder="Select a Area" style="width: 100%;">
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

		<div class="form-group" id="developer_div_1" style="display: none;">
			<select class="form-control select2" id="developer_1" multiple="multiple" data-placeholder="Select a Developer" style="width: 100%;">
				<?php $cnt = 0; if(isset($developer)) $cnt = count($developer); ?>
				@for ($i = 0; $i < $cnt; $i++)
			        <option value="{{ $developer[$i]->developer }}">{{ $developer[$i]->developer }}</option>
			    @endfor
			</select><i class='fa fa-caret-down' style="position:absolute;left:341px; top:10px;"></i>
		</div>

		<div class="form-group" id="project_div_1" style="display: none;">
			<select class="form-control select2" multiple="multiple" id="project_name_1" data-placeholder="Select a Project" style="width: 100%;">
				<?php $cnt = 0; if(isset($master_project_name)) $cnt = count($master_project_name); ?>
				@for ($i = 0; $i < $cnt; $i++)
				<option value="{{ $master_project_name[$i]->master_project_name }}">{{ $master_project_name[$i]->master_project_name }}</option>
				@endfor
			</select><i class='fa fa-caret-down' style="position:absolute;left:341px; top:10px;"></i>
		</div>
	</div>

	<div class="col-md-4">
		<div class="form-group" id="location_div_2">
			<select class="form-control select2" id="location_2" multiple="multiple" data-placeholder="Select a Area" style="width: 100%;">
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

		<div class="form-group" id="developer_div_2" style="display: none;">
			<select class="form-control select2" id="developer_2" multiple="multiple" data-placeholder="Select a Developer" style="width: 100%;">
				<?php $cnt = 0; if(isset($developer)) $cnt = count($developer); ?>
				@for ($i = 0; $i < $cnt; $i++)
			        <option value="{{ $developer[$i]->developer }}">{{ $developer[$i]->developer }}</option>
			    @endfor
			</select><i class='fa fa-caret-down' style="position:absolute;left:341px; top:10px;"></i>
		</div>

		<div class="form-group" id="project_div_2" style="display: none;">
			<select class="form-control select2" multiple="multiple" id="project_name_2" data-placeholder="Select a Project" style="width: 100%;">
				<?php $cnt = 0; if(isset($master_project_name)) $cnt = count($master_project_name); ?>
				@for ($i = 0; $i < $cnt; $i++)
				<option value="{{ $master_project_name[$i]->master_project_name }}">{{ $master_project_name[$i]->master_project_name }}</option>
				@endfor
			</select><i class='fa fa-caret-down' style="position:absolute;left:341px; top:10px;"></i>
		</div>
	</div>

	<div class="col-md-4">
		<div class="form-group" id="location_div_3">
			<select class="form-control select2" id="location_3" multiple="multiple" data-placeholder="Select a Area" style="width: 100%;">
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

		<div class="form-group" id="developer_div_3" style="display: none;">
			<select class="form-control select2" id="developer_3" multiple="multiple" data-placeholder="Select a Developer" style="width: 100%;">
				<?php $cnt = 0; if(isset($developer)) $cnt = count($developer); ?>
				@for ($i = 0; $i < $cnt; $i++)
			        <option value="{{ $developer[$i]->developer }}">{{ $developer[$i]->developer }}</option>
			    @endfor
			</select><i class='fa fa-caret-down' style="position:absolute;left:341px; top:10px;"></i>
		</div>

		<div class="form-group" id="project_div_3" style="display: none;">
			<select class="form-control select2" multiple="multiple" id="project_name_3" data-placeholder="Select a Project" style="width: 100%;">
				<?php $cnt = 0; if(isset($master_project_name)) $cnt = count($master_project_name); ?>
				@for ($i = 0; $i < $cnt; $i++)
				<option value="{{ $master_project_name[$i]->master_project_name }}">{{ $master_project_name[$i]->master_project_name }}</option>
				@endfor
			</select><i class='fa fa-caret-down' style="position:absolute;left:341px; top:10px;"></i>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-4">
		<div class="form-group">
			<button class="btn btn-success btn-md center-block" type="button" id="btn_get_details_1" onClick="get_data(this);">Get Details</button>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<button class="btn btn-success btn-md center-block" type="button" id="btn_get_details_2" onClick="get_data(this);">Get Details</button>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<button class="btn btn-success btn-md center-block" type="button" id="btn_get_details_3" onClick="get_data(this);">Get Details</button>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-4">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Total <span class="total_sf_1"></span> lacs sf Carpet Area </h3>
			</div>
			<div class="box-body">
				<div class="loader_1"></div>
				<div class="chart_div_1" id="total_sf_chart_1" style="height: 250px;"></div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Total <span class="total_sf_2"></span> lacs sf Carpet Area </h3>
			</div>
			<div class="box-body">
				<div class="loader_2"></div>
				<div class="chart_div_2" id="total_sf_chart_2" style="height: 250px;"></div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Total <span class="total_sf_3"></span> lacs sf Carpet Area </h3>
			</div>
			<div class="box-body">
				<div class="loader_3"></div>
				<div class="chart_div_3" id="total_sf_chart_3" style="height: 250px;"></div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-4">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Total <span class="total_units_1"></span> units</h3>
			</div>
			<div class="box-body">
				<div class="loader_1"></div>
				<div class="chart_div_1" id="total_units_chart_1" style="height: 250px;"></div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Total <span class="total_units_2"></span> units</h3>
			</div>
			<div class="box-body">
				<div class="loader_2"></div>
				<div class="chart_div_2" id="total_units_chart_2" style="height: 250px;"></div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Total <span class="total_units_3"></span> units</h3>
			</div>
			<div class="box-body">
				<div class="loader_3"></div>
				<div class="chart_div_3" id="total_units_chart_3" style="height: 250px;"></div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-4">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Total FSI <span id="total_fsi_1"></span> lacs sf </h3>
			</div>
			<div class="box-body">
				<div class="loader_1"></div>
				<div class="chart_div_1" id="total_fsi_chart_1" style="height: 250px;"></div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Total FSI <span id="total_fsi_2"></span> lacs sf </h3>
			</div>
			<div class="box-body">
				<div class="loader_2"></div>
				<div class="chart_div_2" id="total_fsi_chart_2" style="height: 250px;"></div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Total FSI <span id="total_fsi_3"></span> lacs sf </h3>
			</div>
			<div class="box-body">
				<div class="loader_3"></div>
				<div class="chart_div_3" id="total_fsi_chart_3" style="height: 250px;"></div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-4">
		<h4 style="font-weight: 600px;">By Type Of Apartments:</h4>
	</div>
	<div class="col-md-4">
		<h4 style="font-weight: 600px;">By Type Of Apartments:</h4>
	</div>
	<div class="col-md-4">
		<h4 style="font-weight: 600px;">By Type Of Apartments:</h4>
	</div>
</div>
<div class="row">
	<div class="col-lg-4">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Total <span class="total_sf_1"></span> lacs sf carpet area</h3>
			</div>
			<div class="box-body" style="height:auto;">
				<div class="loader_1"></div>
				<div class="chart_div_1" id="type_of_apt_area_1"></div>
			</div>
		</div>
	</div>
	<div class="col-lg-4">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Total <span class="total_sf_2"></span> lacs sf carpet area</h3>
			</div>
			<div class="box-body" style="height:auto;">
				<div class="loader_2"></div>
				<div class="chart_div_2" id="type_of_apt_area_2"></div>
			</div>
		</div>
	</div>
	<div class="col-lg-4">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Total <span class="total_sf_3"></span> lacs sf carpet area</h3>
			</div>
			<div class="box-body" style="height:auto;">
				<div class="loader_3"></div>
				<div class="chart_div_3" id="type_of_apt_area_3"></div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-4">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Total <span class="total_units_1"></span> units</h3>
			</div>
			<div class="box-body" style="height:auto;">
				<div class="loader_1"></div>
				<div class="chart_div_1" id="type_of_apt_units_1"></div>
			</div>
		</div>
	</div>
	<div class="col-lg-4">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Total <span class="total_units_2"></span> units</h3>
			</div>
			<div class="box-body" style="height:auto;">
				<div class="loader_2"></div>
				<div class="chart_div_2" id="type_of_apt_units_2"></div>
			</div>
		</div>
	</div>
	<div class="col-lg-4">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Total <span class="total_units_3"></span> units</h3>
			</div>
			<div class="box-body" style="height:auto;">
				<div class="loader_3"></div>
				<div class="chart_div_3" id="type_of_apt_units_3"></div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-4">
		<h4 style="font-weight: 600px;">By Type Of Completion:</h4>
	</div>
	<div class="col-md-4">
		<h4 style="font-weight: 600px;">By Type Of Completion:</h4>
	</div>
	<div class="col-md-4">
		<h4 style="font-weight: 600px;">By Type Of Completion:</h4>
	</div>
</div>
<div class="row">
	<div class="col-lg-4">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Total <span class="total_sf_1"></span> lacs sf carpet area</h3>
			</div>
			<div class="box-body">
				<div class="loader_1"></div>
				<div class="chart_div_1" id="type_of_completion_area_1"></div>
			</div>
		</div>
	</div>
	<div class="col-lg-4">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Total <span class="total_sf_2"></span> lacs sf carpet area</h3>
			</div>
			<div class="box-body">
				<div class="loader_2"></div>
				<div class="chart_div_2" id="type_of_completion_area_2"></div>
			</div>
		</div>
	</div>
	<div class="col-lg-4">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Total <span class="total_sf_3"></span> lacs sf carpet area</h3>
			</div>
			<div class="box-body">
				<div class="loader_3"></div>
				<div class="chart_div_3" id="type_of_completion_area_3"></div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-4">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Total <span class="total_units_1"></span> units</h3>
			</div>
			<div class="box-body">
				<div class="loader_1"></div>
				<div class="chart_div_1" id="type_of_completion_units_1"></div>
			</div>
		</div>
	</div>
	<div class="col-lg-4">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Total <span class="total_units_2"></span> units</h3>
			</div>
			<div class="box-body">
				<div class="loader_2"></div>
				<div class="chart_div_2" id="type_of_completion_units_2"></div>
			</div>
		</div>
	</div>
	<div class="col-lg-4">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Total <span class="total_units_3"></span> units</h3>
			</div>
			<div class="box-body">
				<div class="loader_3"></div>
				<div class="chart_div_3" id="type_of_completion_units_3"></div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-4">
		<h4 style="font-weight: 600px;">By Type Of Subregions:</h4>
	</div>
	<div class="col-md-4">
		<h4 style="font-weight: 600px;">By Type Of Subregions:</h4>
	</div>
	<div class="col-md-4">
		<h4 style="font-weight: 600px;">By Type Of Subregions:</h4>
	</div>
</div>
<div class="row">
	<div class="col-lg-4">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Total <span class="total_sf_1"></span> lacs sf carpet area</h3>
			</div>
			<div class="box-body">
				<div class="loader_1"></div>
				<div class="chart_div_1" id="type_of_subregion_area_1"></div>
			</div>
		</div>
	</div>
	<div class="col-lg-4">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Total <span class="total_sf_2"></span> lacs sf carpet area</h3>
			</div>
			<div class="box-body">
				<div class="loader_2"></div>
				<div class="chart_div_2" id="type_of_subregion_area_2"></div>
			</div>
		</div>
	</div>
	<div class="col-lg-4">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Total <span class="total_sf_3"></span> lacs sf carpet area</h3>
			</div>
			<div class="box-body">
				<div class="loader_3"></div>
				<div class="chart_div_3" id="type_of_subregion_area_3"></div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-4">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Total <span class="total_units_1"></span> units</h3>
			</div>
			<div class="box-body">
				<div class="loader_1"></div>
				<div class="chart_div_1" id="type_of_subregion_units_1"></div>
			</div>
		</div>
	</div>
	<div class="col-lg-4">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Total <span class="total_units_2"></span> units</h3>
			</div>
			<div class="box-body">
				<div class="loader_2"></div>
				<div class="chart_div_2" id="type_of_subregion_units_2"></div>
			</div>
		</div>
	</div>
	<div class="col-lg-4">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Total <span class="total_units_3"></span> units</h3>
			</div>
			<div class="box-body">
				<div class="loader_3"></div>
				<div class="chart_div_3" id="type_of_subregion_units_3"></div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-4">
		<h4 style="font-weight: 600px;">Project List</h4>
	</div>
	<div class="col-md-4">
		<h4 style="font-weight: 600px;">Project List</h4>
	</div>
	<div class="col-md-4">
		<h4 style="font-weight: 600px;">Project List</h4>
	</div>
</div>
<div class="row">
	<div class="col-lg-4">
		<div class="box" style="overflow-x:scroll;" >
			<div class="box-header">
				<h3 class="box-title">Top 25 Projects</h3>
			</div>
			<div class="box-body">
				<div class="loader_1"></div>
				<table id="tbl_project_details_1" class="table table-bordered table-striped">
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
	<div class="col-lg-4">
		<div class="box" style="overflow-x:scroll;" >
			<div class="box-header">
				<h3 class="box-title">Top 25 Projects</h3>
			</div>
			<div class="box-body">
				<div class="loader_2"></div>
				<table id="tbl_project_details_2" class="table table-bordered table-striped">
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
	<div class="col-lg-4">
		<div class="box" style="overflow-x:scroll;" >
			<div class="box-header">
				<h3 class="box-title">Top 25 Projects</h3>
			</div>
			<div class="box-body">
				<div class="loader_3"></div>
				<table id="tbl_project_details_3" class="table table-bordered table-striped">
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
<script src="{{asset('/js/plugins/datatables/jquery.dataTables2.min.js')}}"></script>
<script src="{{asset('/js/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('/js/plugins/flot/jquery.flot.min.js')}}"></script>
<script src="{{asset('/js/plugins/flot/jquery.flot.resize.min.js')}}"></script>
<script src="{{asset('/js/plugins/flot/jquery.flot.pie.min.js')}}"></script>
<script src="{{asset('/js/plugins/flot/jquery.flot.categories.min.js')}}"></script>
<script src="{{asset('/js/jqBarGraph.1.1.js')}}"></script>
<script src="{{asset('/js/jscharts.js')}}"></script>

<script src="{{asset('/js/compare.js')}}"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>

<script type="text/javascript">
    mixpanel.track("Compare Page.");
</script>
@endsection