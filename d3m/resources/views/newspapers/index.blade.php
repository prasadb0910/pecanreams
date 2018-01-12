@extends('adminlte::layouts.app')


@section('main-content')
<div class="row">
    <div class="col-lg-12">
        @if(Session::has('success_msg'))
        <div class="alert alert-success">{{Session::get('success_msg')}}</div>
        @endif

        @if(!empty($newspapers))
		<div class="box">
            <div class="box-header">
                <h4 class="pull-left"><b>Newspaper List</b></h4>
                <a href="{{url('index.php/newspapers/add')}}" class="btn btn-success btn-sm pull-right">Add New</a>
            </div>
            <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <th>Sr No</th>
                        <th>Newspaper Name</th>
                        <th>Language</th>
                        <th>E Paper</th>
                        <th>Frequency</th>
                        <th>Area</th>
                        <th>Price</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                    <?php $i=1; ?>
                    @foreach($newspapers as $data)
                        <tr>
                            <td class="table-text">
                                <div>{{$i++}}</div>
                            </td>
                            <td class="table-text">
                                <div>{{$data->paper_name}}</div>
                            </td>
                            <td class="table-text">
                                <div>{{$data->language}}</div>
                            </td>
                            <td class="table-text">
                                <div>{{$data->e_paper}}</div>
                            </td>
                            <td class="table-text">
                                <div>{{$data->frequency}}</div>
                            </td>
                            <td class="table-text">
                                <div>{{$data->area}}</div>
                            </td>
                            <td class="table-text">
                                <div>{{$data->price}}</div>
                            </td>
                            <td>
                                <a href="{{url('index.php/newspapers/details/'.$data->id)}}" class="label label-success">Details</a>
                                <a href="{{url('index.php/newspapers/edit/'.$data->id)}}" class="label label-warning">Edit</a>
                                <button type="button" id="newspaper_{{$data->id}}" class="label label-danger" onClick="show_modal(this)">Delete</button>
                                <!-- <a href="{{-- route('newspapers.delete', $data->id) --}}" class="label label-danger" onclick="return confirm('Are you sure to delete?')">Delete</a> -->
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

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form_notice_list" action="{{url('index.php/newspapers/delete')}}" method="POST" class="form-horizontal">
            {{csrf_field()}}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Delete Newspaper</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <label class="col-md-4 col-sm-4 col-xs-12">&nbsp;</label>
                    <label class="col-md-8 col-sm-8 col-xs-12">Do you want to delete Newspaper?</label>
                    <input type="hidden" id="newspaper_id" name="newspaper_id" value="" />
                </div>
                </div>
                <div class="form-group">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="col-md-5 col-sm-5 col-xs-12"></div>
                    <div class="col-md-7 col-sm-7 col-xs-12">
                        <button class="btn btn-success btn-sm" type="submit" id="btn_yes">Yes</button>
                        <button class="btn btn-default btn-sm" type="button" id="btn_no">No</button>
                    </div>
                </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')

<script>
    var show_modal = function(elem){
        var id = elem.id;
        var newspaper_id = id.substring(id.lastIndexOf('_')+1);
        $('#newspaper_id').val(newspaper_id);
        // $('#notice_date').val($('#date_of_notice').val());
        $('#myModal').modal('toggle');
    };
    $('#btn_no').click(function(){
        $('#myModal').modal('toggle');
    });
</script>
@endsection