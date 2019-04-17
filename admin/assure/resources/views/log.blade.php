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
	
</div>				
<div class="row">
	<div class="col-lg-3">
		<label>Select Module Type</label>
		<select id="search" class="form-control valid" aria-invalid="false">
			<option value="" <?=($model_type==""?"selected":'')?>>ALL</option>
			<option value="1" <?=($model_type=='1'?"selected":'')?>>Assure</option>
			<option value="2" <?=($model_type=='2'?"selected":'')?>>Idata</option>
		</select>
	</div>
	<div class="col-lg-12">

           

		<div class="box">
			<div class="box-header">
				
				<h3 class="box-title">Log List</h3>
			</div>
			<div class="box-body">
				<div class="loader"></div>
				<table id="example1" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th style="vertical-align:top;">Sr No</th>
							<th style="vertical-align:top;">Searched On</th>
							<th style="vertical-align:top;">Searched From</th>
							<th style="vertical-align:top;">Module Type</th>
							<th style="vertical-align:top;">Ip Address</th>
							<th style="vertical-align:top;">User</th>
							<th style="vertical-align:top;">Module Name</th>
							<th style="vertical-align:top;">Search Type</th>
							<th style="vertical-align:top;">Type Text</th>
							<th style="vertical-align:top;">Type Name</th>
							<th style="vertical-align:top;">Property Type</th>
							<th style="vertical-align:top;">Entity Type</th>
							<th style="vertical-align:top;">Action</th>
							<th style="vertical-align:top;">Newspaper</th>
							<th style="vertical-align:top;">Start Date</th>
							<th style="vertical-align:top;">End Date</th>
							<th style="vertical-align:top;">Match Keyword</th>

						</tr>
					</thead>
					<tbody>
						<?php ?>
						<?php $cnt = 0; if(isset($assure_track)) $cnt = count($assure_track); $srno = 1; ?>
						@for ($i = 0; $i < $cnt; $i++, $srno++)
					    
						<tr>		<td>{{ $srno}} </td>
									<td>{{ $assure_track[$i]->searched_on }}</td>
									 <td>{{ ($assure_track[$i]->searched_from!=""?$assure_track[$i]->searched_from:"NA") }}</td>
									  <td>{{ ($assure_track[$i]->model_type!=""?$assure_track[$i]->model_type:"NA") }}</td>
                                    <td>{{ ($assure_track[$i]->ip_address!=""?$assure_track[$i]->ip_address:"NA") }}</td>
                                    <td>{{ ($assure_track[$i]->username!=""?$assure_track[$i]->username:'NA') }}</td>
                                    <td>{{ $assure_track[$i]->module_name }}</td>
                                    <td>{{ ($assure_track[$i]->search_type!=""?$assure_track[$i]->search_type:"NA") }}</td>                                
                                    <td>{{ ($assure_track[$i]->type_text!=""  || $assure_track[$i]->type_text!="null"?$assure_track[$i]->type_text:"NA") }}</td> 
                                     <td>{{ ($assure_track[$i]->type_name!="" || $assure_track[$i]->type_name!="null"?$assure_track[$i]->type_name:"NA") }}</td>         
                                     <td>{{ ($assure_track[$i]->property_type!=""?$assure_track[$i]->property_type:"NA") }}</td> 
									<td>{{ ($assure_track[$i]->entity_type!=""?$assure_track[$i]->entity_type:"NA") }}</td>
									<td>{{ $assure_track[$i]->action }}</td>
									 <td>{{ ($assure_track[$i]->newspapers!=""?$assure_track[$i]->newspapers:"NA") }}</td>       
									
									<td>{{ ($assure_track[$i]->start_date!="0000-00-00"?$assure_track[$i]->start_date:"NA") }}</td>
                              		<td>{{ ($assure_track[$i]->end_date!="0000-00-00"?$assure_track[$i]->end_date:"NA") }}</td>
									<td>{{ ($assure_track[$i]->match_keyword!=""?$assure_track[$i]->match_keyword:"NA") }}</td>
									</tr>
									    @endfor
					</tbody>
				</table>
				<!-- <table id="example1" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th style="vertical-align:top;">Sr No</th>
							<th style="vertical-align:top;">Searched On</th>
							<th style="vertical-align:top;">Ip Address</th>
							<th style="vertical-align:top;">User</th>
							<th style="vertical-align:top;">Searched From</th>
							<th style="vertical-align:top;">Module Name</th>
							<th style="vertical-align:top;">Search Type</th>
							<th style="vertical-align:top;">Type Name</th>
							<th style="vertical-align:top;">Type Text</th>
							<th style="vertical-align:top;">Newspaper</th>
							<th style="vertical-align:top;">Action</th>
							<th style="vertical-align:top;">Start Date</th>
							<th style="vertical-align:top;">End Date</th>
							<th style="vertical-align:top;">Match Keyword</th>
						</tr>
					</thead>
					<tbody>
						<?php ?>
						<?php $cnt = 0; if(isset($assure_track)) $cnt = count($assure_track); $srno = 1; ?>
						@for ($i = 0; $i < $cnt; $i++, $srno++)
					    
						<tr>		<td>{{ $srno}} </td>
									<td>{{ $assure_track[$i]->searched_on }}</td>
                                    <td>{{ ($assure_track[$i]->ip_address!=""?$assure_track[$i]->ip_address:"NA") }}</td>
                                    <td>{{ ($assure_track[$i]->username!=""?$assure_track[$i]->username:'NA') }}</td>
                                    <td>{{ ($assure_track[$i]->searched_from!=""?$assure_track[$i]->searched_from:"NA") }}</td>
                                    <td>{{ $assure_track[$i]->module_name }}</td>
                                    <td>{{ ($assure_track[$i]->search_type!=""?$assure_track[$i]->search_type:"NA") }}</td>
                                    <td>{{ ($assure_track[$i]->type_name!=""?$assure_track[$i]->type_name:"NA") }}</td>                                   
                                    <td>{{ ($assure_track[$i]->type_text!=""?$assure_track[$i]->type_text:"NA") }}</td> 
                                     <td>{{ ($assure_track[$i]->newspapers!=""?$assure_track[$i]->newspapers:"NA") }}</td>         
                              		<td>{{ $assure_track[$i]->action }}</td>
                              		<td>{{ ($assure_track[$i]->start_date!="0000-00-00"?$assure_track[$i]->start_date:"NA") }}</td>
                              		<td>{{ ($assure_track[$i]->end_date!="0000-00-00"?$assure_track[$i]->end_date:"NA") }}</td>
									<td>{{ ($assure_track[$i]->match_keyword!=""?$assure_track[$i]->match_keyword:"NA") }}</td>
									
									</tr>
									    @endfor
					</tbody>
				</table> -->
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

	$('#search').on("change",function(){
		window.location.href='<?=url('index.php/log')?>/'+$(this).val();
	})

</script>
<script type="text/javascript">
    // 'use strict';
    // const BASE_URL = '{!! url("index.php/").'/' !!}';
</script>

<script type="text/javascript">
    // mixpanel.track("Market Level Page.");
</script>
@endsection