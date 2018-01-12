@extends('adminlte::layouts.app')

@section('main-content')
<div class="row">
    <div class="col-lg-12">
        @if(Session::has('success_msg'))
        <div class="alert alert-success">{{Session::get('success_msg')}}</div>
        @endif

        @if(!empty($property))
		<div class="box">
            <div class="box-header">
                <h4 class="pull-left"><b>Property List</b></h4>
                <a href="{{url('index.php/property/add')}}" class="btn btn-success btn-sm pull-right">Add New</a>
            </div>
            <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <th>Sr No</th>
                        <th>Property Name</th>
                        <th>Property Type</th>
                        <th>User Name</th>
                        <th>Creation Date</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                    <?php $i=1; ?>
                    @foreach($property as $data)
                        <tr>
                            <td class="table-text">
                                <div>{{$i++}}</div>
                            </td>
                            <td class="table-text">
                                <div>{{$data->property_name}}</div>
                            </td>
                            <td class="table-text">
                                <div>{{$data->property_type}}</div>
                            </td>
                            <td class="table-text">
                                <div>{{$data->user_name}}</div>
                            </td>
                            <td class="table-text">
                                <div>@if(isset($data)){{Carbon\Carbon::parse($data->created_at)->format('d/m/Y')}}@endif</div>
                            </td>
                            <td>
                                <a href="{{url('index.php/property/details/'.$data->id)}}" class="label label-success">Details</a>
                                <a href="{{url('index.php/property/edit/'.$data->id)}}" class="label label-warning">Edit</a>
                                <!-- <a href="{{-- route('property.delete', $data->id) --}}" class="label label-danger" onclick="return confirm('Are you sure to delete?')">Delete</a> -->
                            </td>
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

