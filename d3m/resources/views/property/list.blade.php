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
                        <th>Property ID</th>
                        <th>Property Name</th>
                        <th>Address</th>
                        <th>Public Notice</th>
                        <th>View Notice</th>
                    </thead>
                    <tbody>
                    <?php $i = 1; ?>
                    @foreach($property as $data)
                        <tr>
                            <td class="table-text">
                                <div>{{$i++}}</div>
                            </td>
                            <td class="table-text">
                                <div>{{$data->id}}</div>
                            </td>
                            <td class="table-text">
                                <div><a href="{{url('index.php/property/details/'.$data->id)}}" target="_new">{{$data->property_name}}</a></div>
                            </td>
                            <td class="table-text">
                                <div>{{$data->address}}</div>
                            </td>
                            <td class="table-text">
                                <div>@if(isset($data->fk_notice_id)){{'Yes'}}@else{{'No'}}@endif</div>
                            </td>
                            <td class="table-text">
                                <div>@if(isset($data->fk_notice_id))<a href="{{url('index.php/notice/details/'.$data->fk_notice_id)}}" class="label label-success" target="_new">View Notice</a>@endif</div>
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

@section('js')
<script>
$(document).ready(function(){
    $("#example1").DataTable({
        destroy: true,
        dom: 'Bfrtip',
        buttons: ['excel']
    });
});
</script>
@endsection