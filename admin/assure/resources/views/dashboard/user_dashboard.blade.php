@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection


@section('main-content')
<div class="row">
<div class="col-lg-12 col-xs-12">
<div class="row">
	<div class="col-lg-3 col-xs-6">
	</div>
	<div class="col-lg-3 col-xs-6">
		<div class="small-box bg-aqua">
			<div class="inner">
				<h3>{{ count($property) }}</h3>
				<p>No of Properties</p>
			</div>
			<div class="icon">
				<i class="ion ion-bag"></i>
			</div>
		</div>
	</div>
	<div class="col-lg-3 col-xs-6">
		<div class="small-box bg-yellow">
			<div class="inner">
				<h3>{{ count($notice) }}</h3>
				<p>No of Alerts</p>
			</div>
			<div class="icon">
				<i class="ion ion-stats-bars"></i>
			</div>
		</div>
	</div>
	<div class="col-lg-3 col-xs-6">
	</div>
</div>

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
					<th style="vertical-align:top;">Notice Title</th>
					<th style="vertical-align:top;">Address</th>
					<th style="vertical-align:top;">Paper Name</th>
					<th style="vertical-align:top;">Detailed View</th>
				</tr>
			</thead>
			<tbody>
				<?php $i=1; ?>
				@foreach($notice as $data)
				<tr>
					<td>{{ $i++ }}</td>
					<td>{{$data->property_name}}</td>
					<td>{{$data->notice_title}}</td>
					<td>{{$data->address}}</td>
					<td>{{$data->paper_name}}</td>
					<td>
                        <a href="@if(isset($data)){{url('/') . '/uploads/notices/' . $data->notice_file}}@endif" class="label label-success" target="_new">View</a>
                    </td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
</div>

<div class="col-lg-3 col-xs-3" style="display: none;">
<div class="box box-primary">
            <div class="box-header with-border">
              <i class="fa fa-comments-o"></i>

              <h3 class="box-title">Blogs</h3>

           
            </div>
            <div class="box-body chat" id="chat-box">
              <!-- chat item -->
              <div class="item">
             <img src="http://www.gravatar.com/avatar/88b87698be0bc461f3cacf1f080929d5.jpg?s=80&d=mm&r=g" alt="user image" class="offline">

                <p class="message">
                  <a href="#" class="name">
                    <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> 2:15</small>
                    Mike Doe
                  </a>
                  I would like to meet you to discuss the latest news about
                  the arrival of the new theme. They say it is going to be one the
                  best themes on the market
                </p>
              
                <!-- /.attachment -->
              </div>
              <!-- /.item -->
              <!-- chat item -->
              <div class="item">
              <img src="http://www.gravatar.com/avatar/88b87698be0bc461f3cacf1f080929d5.jpg?s=80&d=mm&r=g" alt="user image" class="offline">
                <p class="message">
                  <a href="#" class="name">
                    <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> 5:15</small>
                    Alexander Pierce
                  </a>
                  I would like to meet you to discuss the latest news about
                  the arrival of the new theme. They say it is going to be one the
                  best themes on the market
                </p>
              </div>
              <!-- /.item -->
              <!-- chat item -->
              <div class="item">
                <img src="http://www.gravatar.com/avatar/88b87698be0bc461f3cacf1f080929d5.jpg?s=80&d=mm&r=g" alt="user image" class="offline">

                <p class="message">
                  <a href="#" class="name">
                    <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> 5:30</small>
                    Susan Doe
                  </a>
                  I would like to meet you to discuss the latest news about
                  the arrival of the new theme. They say it is going to be one the
                  best themes on the market
                </p>
              </div>
              <!-- /.item -->
            </div>
            <!-- /.chat -->
           
          </div>

</div>
</div>


   
@endsection

