@extends('adminlte::layouts.app')

		<style>
#example1
{
	font-size: small;
	
}
	</style>
@section('main-content')

 @if(Session::has('success_msg'))
        <div class="alert alert-success">{{Session::get('success_msg')}}</div>
        @endif

<div class="box box-default">

	<div class="box-header with-border">
				<h3 class="box-title">Groups</h3>
				 <a href="{{url('index.php/group/add')}}"  class="btn btn-success btn-sm pull-right"><span class="fa fa-plus"></span> Add New</a>
			</div>
			<div class="box-body">
				<div class="loader"></div>
				<table id="example1" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th style="vertical-align:top;">Sr No</th>
							<th style="vertical-align:top;">Group Id</th>
							<th style="vertical-align:top;">Group Name</th>
							<th style="vertical-align:top;">Contact Person Name</th>
							<th style="vertical-align:top;">Edit</th>
					
						
						</tr>
					</thead>
					<tbody>
					 <?php $cnt = 0; if(isset($groups)) $cnt = count($groups); ?>
					@for ($i = 0; $i < $cnt; $i++)
					
						<tr>
					
						<td>  {{ $i+1 }} </td>
						<td> {{ $groups[$i]->id }} </td>
						<td> {{ $groups[$i]->group_name }} </td>
						<td> {{ $groups[$i]->contact }} </td>
						
						<td>
						<a href="{{url('index.php/group/edit/'.$groups[$i]->id)}}" class="label label-warning">Edit</a>
									
						</td>
										
								  
						</tr>
					@endfor	  
					</tbody>
				</table>
			</div>
	
</div>




@endsection
