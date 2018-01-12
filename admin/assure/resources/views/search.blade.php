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
		.select2-container--default .select2-selection--multiple .select2-selection__choice{color:#333}
	</style>
@endsection

@section('main-content')
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<select class="form-control select2" id="criteria" multiple="multiple" data-placeholder="Select">
				<option>Project Name</option>
				<option>Orgnization</option>
				<option>Developer</option>    
				<option>Location</option>
			</select><i class='fa fa-caret-down' style="position:absolute;left:520px; top:10px;"></i>
		</div>
	</div>
	<div class="col-md-6">
		<!-- <form action="#" method="get"> -->
			<div class="input-group">
				<input type="text" name="search" id="search" class="form-control" placeholder="Search...">
				<span class="input-group-btn">
					<button type="submit" id="search_btn" class="btn btn-flat">
						<i class="fa fa-search"></i>
					</button>
				</span>
			</div>
		<!-- </form> -->
	</div>  
</div>
<div class="box">
	<div class="box-header">
		<h3 class="box-title">Top 25 Project Details</h3>
	</div>
	<div class="box-body">
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
					<th style="vertical-align:top;">Sold Carpet Area</th>
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
@endsection

@section('js')
<script type="text/javascript">
    // 'use strict';
    // const BASE_URL = '{!! url("index.php/").'/' !!}';
</script>

<script src="{{asset('/js/plugins/select2/select2.full.min.js')}}"></script>
<script src="{{asset('/js/plugins/datatables/jquery.dataTables2.min.js')}}"></script>
<script src="{{asset('/js/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>

<script src="{{asset('/js/search.js')}}"></script>
<script type="text/javascript">
$(document).bind("keydown", function(event){
  if(event.which=="13")
   {
      $("#search_btn").click();
    }
});
</script>

<script type="text/javascript">
    mixpanel.track("Search Page.");
</script>
@endsection