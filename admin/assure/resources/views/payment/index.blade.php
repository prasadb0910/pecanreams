@extends('adminlte::layouts.app')

@section('main-content')
<div class="row">
    <div class="col-lg-12">
        @if(Session::has('success_msg'))
        <div class="alert alert-success">{{Session::get('success_msg')}}</div>
        @endif

        @if(!empty($payments))
		<div class="box">
            <div class="box-header">
                <h4 class="pull-left"><b>Payment</b></h4>
            </div>
            <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <th>Sr No</th>
                        <th>User Name</th>
                        <th>Payment Date</th>
                        <th>Invoice No / Receipt no</th>
                        <th>Plan Name</th>
                        <th>No Of Properties Registered</th>
                        <th>Payment Method</th>
                        <th>Amount</th>
                        <th>CGST</th>
                        <th>SGST</th>
                        <th>IGST</th>
                        <th>Round Off Amount</th>
                        <th>Total Amount</th>
                        <th>Payment Due</th>
                        <th>Payment Status</th>
                        <th>Make Payment</th>
                    </thead>
                    <tbody>
                    <?php $i=1; ?>
                    @foreach($payments as $data)
                        <tr>
                            <td class="table-text">
                                <div>{{ $i++ }}</div>
                            </td>
                            <td class="table-text">
                                <div>{{$data->user_name}}</div>
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
                            <td class="table-text">
                                <div>@if(isset($data->payment_due_date)){{Carbon\Carbon::parse($data->payment_due_date)->format('d/m/Y')}}@endif</div>
                            </td>
                            <td class="table-text">
                                <div>{{$data->payment_status}}</div>
                            </td>
                            <td>
                                <!-- <a href="{{--'https://www.pecanreams.com/dataFrom.htm?user_id='.$data->user_id.'&sub_id=0&trans_id='.$data->id--}}" class="label label-success">Pay Now</a> -->
                                @if($data->payment_status!='paid')
                                <a href="{{url('index.php/user_payment_detail/pay_now/'.$data->id)}}" class="label label-warning">Pay Now</a>
                                @endif
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