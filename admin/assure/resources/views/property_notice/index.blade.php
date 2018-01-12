@extends('adminlte::layouts.app')

@section('styles')
    <style>
        input[type="checkbox"], input[type="submit"] {display: block;}
    </style>
@endsection

@section('main-content')
<div class="row">
    <div class="col-lg-12">
        @if(Session::has('success_msg'))
        <div class="alert alert-success">{{Session::get('success_msg')}}</div>
        @endif

        <div class="box">
            <div class="box-header">
                <h4 class="pull-left"><b>Property Notice List</b></h4>
                <a href="{{url('index.php/property_notice/add')}}" class="btn btn-success btn-sm pull-right">Add New</a>
            </div>

            <div class = "tabinator">
                <input type = "radio" id = "tab1" name = "tabs" checked>
                <label for = "tab1">All ({{count($all)}})</label>
                <input type = "radio" id = "tab2" name = "tabs">
                <label for = "tab2">Approved ({{count($approved)}})</label>
                <input type = "radio" id = "tab3" name = "tabs">
                <label for = "tab3">Pending For Approval ({{count($pending_for_approval)}})</label>
                <input type = "radio" id = "tab4" name = "tabs">
                <label for = "tab4">Pending To Send ({{count($pending_to_send)}})</label>
                <input type = "radio" id = "tab5" name = "tabs">
                <label for = "tab5">Rejected ({{count($rejected)}})</label>

                <div id = "content1">
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <th>Sr No</th>
                                <th>Notice Id</th>
                                <th>Notice Title</th>
                                <th>View Notice</th>
                                <th>View Property</th>
                                <th>Property Name</th>
                                <th>Property Address</th>
                                <th>Notice Status</th>
                            </thead>
                            <tbody>
                            <?php $i = 1; ?>
                            @if(!empty($all))
                            @foreach($all as $data)
                                <tr>
                                    <td class="table-text">
                                        <div>{{$i++}}</div>
                                    </td>
                                    <td class="table-text">
                                        <div><a href="{{url('index.php/property_notice/details/'.$data->id)}}">{{$data->fk_notice_id}}</a></div>
                                    </td>
                                    <td class="table-text">
                                        <div>{{$data->notice_title}}</div>
                                    </td>
                                    <td class="table-text">
                                        <div><a href="{{url('index.php/notice/details/'.$data->fk_notice_id)}}" target="_new">View</a></div>
                                    </td>
                                    <td class="table-text">
                                        <div><a href="{{url('index.php/property/details/'.$data->fk_property_id)}}" target="_new">View</a></div>
                                    </td>
                                    <td class="table-text">
                                        <div>{{$data->property_name}}</div>
                                    </td>
                                    <td class="table-text">
                                        <div>{{$data->address}}</div>
                                    </td>
                                    <td>
                                        <div>{{$data->status}}</div>
                                    </td>
                                </tr>
                            @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id = "content2">
                    <div class="box-body">
                        <table id="example2" class="table table-bordered table-striped">
                            <thead>
                                <th>Sr No</th>
                                <th>Notice Id</th>
                                <th>Notice Title</th>
                                <th>View Notice</th>
                                <th>View Property</th>
                                <th>Property Name</th>
                                <th>Property Address</th>
                            </thead>
                            <tbody>
                            <?php $i = 1; ?>
                            @if(!empty($approved))
                            @foreach($approved as $data)
                                <tr>
                                    <td class="table-text">
                                        <div>{{$i++}}</div>
                                    </td>
                                    <td class="table-text">
                                        <div><a href="{{url('index.php/property_notice/details/'.$data->id)}}">{{$data->fk_notice_id}}</a></div>
                                    </td>
                                    <td class="table-text">
                                        <div>{{$data->notice_title}}</div>
                                    </td>
                                    <td class="table-text">
                                        <div><a href="{{url('index.php/notice/details/'.$data->fk_notice_id)}}" target="_new">View</a></div>
                                    </td>
                                    <td class="table-text">
                                        <div><a href="{{url('index.php/property/details/'.$data->fk_property_id)}}" target="_new">View</a></div>
                                    </td>
                                    <td class="table-text">
                                        <div>{{$data->property_name}}</div>
                                    </td>
                                    <td class="table-text">
                                        <div>{{$data->address}}</div>
                                    </td>
                                </tr>
                            @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id = "content3">
                    <div class="box-body">
                        <table id="example3" class="table table-bordered table-striped">
                            <thead>
                                <th>Sr No</th>
                                <th>Notice Id</th>
                                <th>Notice Title</th>
                                <th>View Notice</th>
                                <th>View Property</th>
                                <th>Property Name</th>
                                <th>Property Address</th>
                            </thead>
                            <tbody>
                            <?php $i = 1; ?>
                            @if(!empty($pending_for_approval))
                            @foreach($pending_for_approval as $data)
                                <tr>
                                    <td class="table-text">
                                        <div>{{$i++}}</div>
                                    </td>
                                    <td class="table-text">
                                        <div><a href="{{url('index.php/property_notice/details/'.$data->id)}}">{{$data->fk_notice_id}}</a></div>
                                    </td>
                                    <td class="table-text">
                                        <div>{{$data->notice_title}}</div>
                                    </td>
                                    <td class="table-text">
                                        <div><a href="{{url('index.php/notice/details/'.$data->fk_notice_id)}}" target="_new">View</a></div>
                                    </td>
                                    <td class="table-text">
                                        <div><a href="{{url('index.php/property/details/'.$data->fk_property_id)}}" target="_new">View</a></div>
                                    </td>
                                    <td class="table-text">
                                        <div>{{$data->property_name}}</div>
                                    </td>
                                    <td class="table-text">
                                        <div>{{$data->address}}</div>
                                    </td>
                                </tr>
                            @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id = "content4">
                    <div class="box-body">
                        <form id="form_send_property_notice" action="{{url('index.php/property_notice/send')}}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <table id="example4" class="table table-bordered table-striped">
                            <thead>
                                <th>Sr No</th>
                                <th>Notice Id</th>
                                <th>Notice Title</th>
                                <th>View Notice</th>
                                <th>View Property</th>
                                <th>Property Name</th>
                                <th>Property Address</th>
                                <th>Send Mail</th>
                            </thead>
                            <tbody>
                            <?php $i = 1; ?>
                            @if(!empty($pending_to_send))
                            @foreach($pending_to_send as $data)
                                <tr>
                                    <td class="table-text">
                                        <div>{{$i++}}</div>
                                    </td>
                                    <td class="table-text">
                                        <div><a href="{{url('index.php/property_notice/details/'.$data->id)}}">{{$data->fk_notice_id}}</a></div>
                                    </td>
                                    <td class="table-text">
                                        <div>{{$data->notice_title}}</div>
                                    </td>
                                    <td class="table-text">
                                        <div><a href="{{url('index.php/notice/details/'.$data->fk_notice_id)}}" target="_new">View</a></div>
                                    </td>
                                    <td class="table-text">
                                        <div><a href="{{url('index.php/property/details/'.$data->fk_property_id)}}" target="_new">View</a></div>
                                    </td>
                                    <td class="table-text">
                                        <div>{{$data->property_name}}</div>
                                    </td>
                                    <td class="table-text">
                                        <div>{{$data->address}}</div>
                                    </td>
                                    <td>
                                        <div><input type="checkbox" name="id[]" value="{{$data->id}}" /></div>
                                    </td>
                                </tr>
                            @endforeach
                            @endif
                            </tbody>
                        </table>

                        <input type="submit" class="btn btn-success btn-sm pull-right" name="send" value="Send" style="margin:10px" />
                        </form>
                    </div>
                </div>

                <div id = "content5">
                    <div class="box-body">
                        <table id="example5" class="table table-bordered table-striped">
                            <thead>
                                <th>Sr No</th>
                                <th>Notice Id</th>
                                <th>Notice Title</th>
                                <th>View Notice</th>
                                <th>View Property</th>
                                <th>Property Name</th>
                                <th>Property Address</th>
                                <th>Notice Status</th>
                            </thead>
                            <tbody>
                            <?php $i = 1; ?>
                            @if(!empty($rejected))
                            @foreach($rejected as $data)
                                <tr>
                                    <td class="table-text">
                                        <div>{{$i++}}</div>
                                    </td>
                                    <td class="table-text">
                                        <div><a href="{{url('index.php/property_notice/details/'.$data->id)}}">{{$data->fk_notice_id}}</a></div>
                                    </td>
                                    <td class="table-text">
                                        <div>{{$data->notice_title}}</div>
                                    </td>
                                    <td class="table-text">
                                        <div><a href="{{url('index.php/notice/details/'.$data->fk_notice_id)}}" target="_new">View</a></div>
                                    </td>
                                    <td class="table-text">
                                        <div><a href="{{url('index.php/property/details/'.$data->fk_property_id)}}" target="_new">View</a></div>
                                    </td>
                                    <td class="table-text">
                                        <div>{{$data->property_name}}</div>
                                    </td>
                                    <td class="table-text">
                                        <div>{{$data->address}}</div>
                                    </td>
                                    <td>
                                        <div>{{$data->status}}</div>
                                    </td>
                                </tr>
                            @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

