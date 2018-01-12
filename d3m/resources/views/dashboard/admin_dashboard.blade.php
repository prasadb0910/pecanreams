@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection


@section('main-content')
<div class="box box-default">
	<div class="box-header with-border">
		<h3 class="box-title">Notice Count</h3>
	</div>
	<div class="box-body">
		<div class="loader"></div>
		<table id="example3" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th style="vertical-align:middle;" rowspan="2">Date</th>
					<th style="vertical-align:middle;" rowspan="2">Particulars</th>
					<th style="vertical-align:top;" colspan="3">No of News Papers</th>
					<th style="vertical-align:middle;" rowspan="2">No Of Notices</th>
				</tr>
				<tr>
					<th style="vertical-align:top;">Total</th>
					<th style="vertical-align:top;">Checked</th>
					<th style="vertical-align:top;">Unchecked</th>
				</tr>
			</thead>
			<tbody>
				@if(!empty($notice_cnt))
				@foreach($notice_cnt as $data)
				<tr>
					<td>@if(isset($data['date'])){{Carbon\Carbon::parse($data['date'])->format('d/m/Y')}}@endif</td>
					<td>{{$data['news_type']}}</td>
					<td>{{$data['no_of_newspapers']}}</td>
					<td>{{$data['no_of_newspapers_with_notice']}}</td>
					<td>{{$data['no_of_newspapers_without_notice']}}</td>
					<td>{{$data['no_of_notices']}}</td>
				</tr>
				@endforeach
				@endif
			</tbody>
		</table>
	</div>
</div>

<div class="box box-default">
	<div class="box-header with-border">
		<h3 class="box-title">Public Notice </h3>
	</div>
	<div class="box-body">
		<div class="loader"></div>
		<table id="example2" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th style="vertical-align:top;">Sr No</th>
					<th style="vertical-align:top;">Notice Title</th>
					<th style="vertical-align:top;">Newspaper</th>
					<th style="vertical-align:top;">Notice Type</th>
					<th style="vertical-align:top;">Date of Notice</th>
					<th style="vertical-align:top;">Owner Name</th>
					<th style="vertical-align:top;">Address</th>
					<th style="vertical-align:top;">Details</th>
				</tr>
			</thead>
			<tbody>
				@if(!empty($notice))
				<?php $i=1; ?>
				@foreach($notice as $data)
				<tr>
					<td>{{ $i++ }}</td>
					<td>@if(isset($data->notice_title)){{$data->notice_title}}@endif</td>
					<!-- <td>@if(isset($data->pn_newspaper->paper_name)){{$data->pn_newspaper->paper_name}}@endif</td>
					<td>@if(isset($data->pn_notice_type->notice_type)){{$data->pn_notice_type->notice_type}}@endif</td> -->
					<td>@if(isset($data->paper_name)){{$data->paper_name}}@endif</td>
					<td>@if(isset($data->notice_type)){{$data->notice_type}}@endif</td>
					<td>@if(isset($data->date_of_notice)){{Carbon\Carbon::parse($data->date_of_notice)->format('d/m/Y')}}@endif</td>
					<td>@if(isset($data->legal_owner_name)){{$data->legal_owner_name}}@endif</td>
					<td>@if(isset($data->address)){{$data->address}}@endif</td>
					<td>
                        <a href="{{url('index.php/notice/details/'.$data->id)}}" class="label label-success">View</a>
                    </td>
				</tr>
				@endforeach
				@endif
			</tbody>
		</table>
	</div>
</div>

<div class="box box-default">
	<div class="box-header with-border">
		<h3 class="box-title">Newspaper</h3>
	</div>
	<div class="box-body">
		<div class="loader"></div>
		<table id="example1" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th style="vertical-align:top;">Sr.No.</th>
					<th style="vertical-align:top;">Newspaper</th>
					<th style="vertical-align:top;">Epaper </th>
					<th style="vertical-align:top;">Language</th>
					<th style="vertical-align:top;">No of Notices</th>
					<th style="vertical-align:top;">Area</th>
					<th style="vertical-align:top;">Details</th>
				</tr>
			</thead>
			<tbody>
				@if(!empty($newspapers))
				<?php $i=1; ?>
				@foreach($newspapers as $data)
				<tr>
					<td>{{ $i++ }}</td>
					<td>{{$data->paper_name}}</td>
					<td>{{$data->e_paper}}</td>
					<td>{{$data->language}}</td>
					<td>{{$data->no_of_notices}}</td>
					<td>{{$data->area}}</td>
					<td>
                        <a href="{{url('index.php/newspapers/details/'.$data->id)}}" class="label label-success">View</a>
                    </td>
				</tr>
				@endforeach
				@endif
			</tbody>
		</table>
	</div>
</div>
@endsection

