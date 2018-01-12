@extends('adminlte::layouts.app')

@section('main-content')
<div class="row">
    <div class="col-lg-12">
        @if(Session::has('success_msg'))
        <div class="alert alert-success">{{Session::get('success_msg')}}</div>
        @endif

        @if(!empty($notice))
		<div class="box box-default">
			<div class="box-header with-border">
				<h3 class="box-title">List of Alerts</h3>
			</div>
			<div class="box-body">
				<div class="loader"></div>
				<table id="example1" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th style="vertical-align:top;">Sr No</th>
							<th style="vertical-align:top;">Property Name</th>
							<th style="vertical-align:top;">Public Notice on</th>
							<th style="vertical-align:top;">Notice type</th>
							<th style="vertical-align:top;">Notice Issued by</th>
							<th style="vertical-align:top;">View Notice</th>
							<!-- <th style="vertical-align:top;">Send Notice</th> -->
						</tr>
					</thead>
					<tbody>
						<?php $i=1; ?>
						@foreach($notice as $data)
						<tr>
							<td>{{ $i++ }}</td>
							<td><a href="@if(isset($data)){{url('index.php/property/details/'.$data->fk_property_id)}}@endif" target="_blank">{{$data->property_name}}</td>
							<td>{{Carbon\Carbon::parse($data->date_of_notice)->format('d/m/Y')}}</td>
							<td>{{$data->notice_type}}</td>
							<td>{{$data->issued_by}}</td>
							<td><a href="@if(isset($data)){{url('/') . '/uploads/notices/' . $data->notice_file}}@endif" class="label label-success" target="_blank">View</a></td>
							<!-- <td><a href="@if(isset($data)){{--url('/') . '/user_notice/send/' . $data->id--}}@endif" class="label label-success">Send</a></td> -->
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
        @endif
    </div>
</div>
@endsection
