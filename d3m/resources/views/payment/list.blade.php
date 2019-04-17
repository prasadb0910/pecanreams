@extends('adminlte::layouts.app')

@section('main-content')
<div class="row">
    <div class="col-lg-12">
    @if(Session::has('success_msg'))
    <div class="alert alert-success">{{Session::get('success_msg')}}</div>
    @endif

    <div class="box box-default">
        <div class="box-header with-border">
            <h4 class="pull-left"><b>Payment List</b></h4>
            <!-- <a href="{{--url('index.php/user/add_user')--}}"  class="btn btn-success btn-sm pull-right"><span class="fa fa-plus"></span> Add User</a> -->
        </div>

        <div class = "tabinator">
            <input type = "radio" id = "tab1" name = "tabs" checked>
            <label for = "tab1">Payment Done ({{count($payments_done)}})</label>
            <input type = "radio" id = "tab2" name = "tabs">
            <label for = "tab2">Pending Payments ({{count($payments_pending)}})</label>
            <div id = "content1">
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <th>Sr. No</th>
                            <th>Payment Date</th>
                            <th>Invoice No/Receipt no</th>
                            <th>Plan Name</th>
                            <th>No Of Properties Registered</th>
                            <th>Payment Method</th>
                            <th>Amount</th>
                            <th>CGST</th>
                            <th>SGST</th>
                            <th>IGST</th>
                            <th>Round Off Amount</th>
                            <th>Total Amount</th>
                        </thead>
                        <tbody>
                        <?php $i=1; ?>
                        @foreach($payments_done as $data)
                            <tr>
                                <td class="table-text">
                                    <div>{{ $i++ }}</div>
                                </td>
                                <td class="table-text">
                                    <div>@if(isset($data->payment_date)){{Carbon\Carbon::parse($data->payment_date)->format('d/m/Y')}}@endif</div>
                                </td>
                                <td class="table-text">
                                    <div>
                                        <a href="{{url('index.php/user_payment_detail/get_invoice/'.$data->id)}}" target="_blank">{{$data->invoice_no}}</a>
                                    </div>
                                </td>
                                <td class="table-text">
                                    <div>{{$data->plan_name}}</div>
                                </td>
                                <td class="table-text">
                                    <div>{{$data->no_of_properties}}</div>
                                </td>
                                <td class="table-text">
                                    <div>{{$data->payment_method}}</div>
                                </td>
                                <td class="table-text">
                                    <div>{{$data->amount}}</div>
                                </td>
                                <td class="table-text">
                                    <div>{{$data->cgst}}</div>
                                </td>
                                <td class="table-text">
                                    <div>{{$data->sgst}}</div>
                                </td>
                                <td class="table-text">
                                    <div>{{$data->igst}}</div>
                                </td>
                                <td class="table-text">
                                    <div>{{$data->round_off_amount}}</div>
                                </td>
                                <td class="table-text">
                                    <div>{{$data->transaction_amount}}</div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div id = "content2">
              <div class="box-body">
                <table id="example2" class="table table-bordered table-striped">
                    <thead>
                        <th>Sr. No</th>
                        <th>Invoice Date</th>
                        <th>Invoice No/Receipt no</th>
                        <th>Plan Name</th>
                        <th>No Of Properties Registered</th>
                        <th>Payment Method</th>
                        <th>Amount</th>
                        <th>CGST</th>
                        <th>SGST</th>
                        <th>IGST</th>
                        <th>Round Off Amount</th>
                        <th>Total Amount</th>
                        <th>Pay Now</th>
                    </thead>
                    <tbody>
                    <?php $i=1; ?>
                    @foreach($payments_pending as $data)
                        <tr>
                            <td class="table-text">
                                <div>{{ $i++ }}</div>
                            </td>
                            <td class="table-text">
                                <div>@if(isset($data->invoice_date)){{Carbon\Carbon::parse($data->invoice_date)->format('d/m/Y')}}@endif</div>
                            </td>
                            <td class="table-text">
                                <div>
                                    <a href="{{url('index.php/user_payment_detail/get_invoice/'.$data->id)}}" target="_blank">{{$data->invoice_no}}</a>
                                </div>
                            </td>
                            <td class="table-text">
                                <div>{{$data->plan_name}}</div>
                            </td>
                            <td class="table-text">
                                <div>{{$data->no_of_properties}}</div>
                            </td>
                            <td class="table-text">
                                <div>{{$data->payment_method}}</div>
                            </td>
                            <td class="table-text">
                                <div>{{$data->amount}}</div>
                            </td>
                            <td class="table-text">
                                <div>{{$data->cgst}}</div>
                            </td>
                            <td class="table-text">
                                <div>{{$data->sgst}}</div>
                            </td>
                            <td class="table-text">
                                <div>{{$data->igst}}</div>
                            </td>
                            <td class="table-text">
                                <div>{{$data->round_off_amount}}</div>
                            </td>
                            <td class="table-text">
                                <div>{{$data->transaction_amount}}</div>
                            </td>
                            <td>
                                @if($data->payment_status!='paid')
                                <a href="{{url('../../dataFrom.php?user_id='.$data->user_id.'&sub_id=0&trans_id='.$data->id.'&module='.$data->module)}}" class="label label-success" target="_blank">Pay Now</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            </div>

        </div>
    </div>

    </div>
</div>
@endsection

