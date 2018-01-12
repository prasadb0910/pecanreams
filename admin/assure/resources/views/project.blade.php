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
		<link href="{{ asset('/js/plugins/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
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
<div class="row">
	<div class="col-lg-12">

           

		<div class="box">
			<div class="box-header">
				<h3 class="box-title">Projects List</h3>
			</div>
			<div class="box-body">
				<div class="loader"></div>
				<table id="example1" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th style="vertical-align:top;">Sr No</th>
							<th style="vertical-align:top;">Master Project Name</th>
							<th style="vertical-align:top;">Name</th>
							<th style="vertical-align:top;">Total FSI (in sf)</th>
							<th style="vertical-align:top;">Approved FSI (in sf)</th>
							<th style="vertical-align:top;">Proposed FSI (in sf)</th>
							
							<th style="vertical-align:top;">Location</th>
							<th style="vertical-align:top;">Pin Code</th>
							<th style="vertical-align:top;">Sub Location</th>
						</tr>
					</thead>
					<tbody>
						<?php $cnt = 0; if(isset($projects)) $cnt = count($projects); ?>
						@for ($i = 0; $i < $cnt; $i++)
					      <?php// setlocale(LC_MONETARY, 'en_IN');
           // $encrypted = Crypt::encryptString({{ $projects[$i]->project_sr_no }});

		   ?> 
					
					<tr>
				
					
                                    <td>{{ $projects[$i]->project_sr_no }} </td>
                                    <td><a href="{{ url('index.php/project/details') }}/{{ $projects[$i]->project_sr_no }}" target="_blank">{{ $projects[$i]->master_project_name }}</td>
                                    <td>{{ $projects[$i]->project_name }}</td>
                                    <td>{{ $projects[$i]->total_fsi }}</td>
                                    <td>{{ $projects[$i]->builtup_area_in_approved_fsi }}</td>
                                    <td>{{ $projects[$i]->builtup_area_in_proposed_fsi }}</td>
                              
                                    <td>{{ $projects[$i]->location }}</td>
                                    <td>{{ $projects[$i]->pin_code }}</td>
                                    <td>{{ $projects[$i]->sub_location }}</td>
                              
									</tr>
									    @endfor
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection

@section('js')

<script src="{{asset('/js/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/js/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
<script>
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
</script>
<script type="text/javascript">
    // 'use strict';
    // const BASE_URL = '{!! url("index.php/").'/' !!}';
</script>

<script type="text/javascript">
    // mixpanel.track("Market Level Page.");
</script>
@endsection