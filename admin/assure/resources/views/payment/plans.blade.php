@extends('adminlte::layouts.app')

@section('styles')
<style>
    .footer-bottom {
        background-color: #191818; font-size:12px;
        width: 100%; padding:5px 0;
    }
    .copyright {
        color: #ccc;    text-align: right;
    }
    .design {
        color: #fff;
        text-align: left;
    }
    .design a {
        color: #fff;
    }

    /*------------------*/
    footer .housing-line {
        padding: 13px 0 0 0;
        display: inline-block;


        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    footer .housing-line img { height:88px;}
    .footer .footer-logo-coloured {
        /*  height: 87px;
        background-image: url(assets/images/main-logo.png); 
        width: 167px;*/
        display: inline-block;
        background-size: contain;
        background-position: left;
        background-repeat: no-repeat;
        margin-bottom: 4px;
    }

    .footer .desc {
        color: #7f7f7f;
        font-size: 11px;
        line-height: 22px;
    }
    .footer .footer-header {
        color: #000;
        height: 35px;  
        font-weight: 500;
        font-size: 16px;
    }
    .footer .footer-header .footer-text {
        display: inline-block; text-transform:uppercase;
        font-weight: 600; color:#fff; 
        letter-spacing:.5px;
        font-size: 12px;
    }
    #portfolio-details h4 { font-weight:400; font-size:25px; margin:5px 0;}
    #portfolio-details h5 { font-weight:400; font-size:20px; margin:5px 0; }
    .spacing-top1 { padding-top:80px;}
    .spacing-top { padding-top:50px;}
    .spacing-bottom { padding-bottom:50px;}
    @media only screen and (max-width:380px){
        .image-slider p { padding:5px; font-size:14px;}
    }
    .login-overlay { position:fixed; top:0; left:0; bottom:0; right:0; background:rgba(0,0,0,.6);display:none;  z-index:9999;}
    .login-box { background:#fff; width:100%; max-width:480px; min-height:250px; margin:auto; display:none;}
    .width-small { display:none;}
    .width-large {     padding: 69px 0 0; text-align:center;} 
    .width-large a {  font-size:17px; }
    /*--------------form style------------->

    </style>
    <style>
    #embed-video {
    position: fixed; overflow:hidden; 
    top: 0;
    left: 0;
    right: 0;
    bottom:0;
    z-index: 999999;
    }

    .close-video {
    position: fixed;
    z-index: 999999;
    color: #000;
    right: 60px;
    }
    /*----------------*/


    .single-about-detail {
        position: relative;
        margin-bottom: 50px;
    } 
    .about-img img {
        /* height: 206px;*/
    }
    .about-img img {
        width: 100%;
    }
    .about-img img {
        width: 100% !important;

    }

    .about-details {
        background: #eee;
        border-top:0px solid #fff;
        transition: all .7s ease 0s;
        -webkit-transition: all .7s ease 0s;
        -moz-transition: all .7s ease 0s;
        -o-transition: all .7s ease 0s;
        -ms-transition: all .7s ease 0s;
    }
    .about-details {
        /*min-height:260px;*/
    }
    body#home-page #main .container #where-to-buy-callout h3 {
        font-size: 20px;
    }
    body#home-page #main .container #where-to-buy-callout h3 {
        font-size: 15px;
        padding: 30px 0 10px 0;
        color: #7d4225;
    }
    .single-about-detail h3 {
        color: #000 !important;
        font-size:20px !important; padding:0 20px;
        line-height: 30px;
        text-transform: capitalize;
        font-weight: 400;
    }

    .single-about-detail p {
        color: #000 !important;  line-height:26px;

    }
    .about-details p {

        padding: 0 28px;
        padding-bottom: 30px;
    }


    .btn-read {
    /* position: absolute;
    bottom: 10px;  
    left:30%;  */

    display: block;
    margin: auto;
    /*  width: 132px;
    margin-top: -18px;*/
    }
    .btn-width {   margin: auto;  width: 132px; display:block;     padding-bottom: 16px;}

    #share-title
    {
        text-align:center!important;
        color:#000;padding:20px 0 0 0;
        font-family:inherit;
    }
    .close{
        float:none; opacity:1;

    }
</style>


<style>
    .pricing {
        padding-bottom: 100px ;
    }
    .pricing-table {
        border: 1px solid #f2f2f2;
        border-radius: 5px;
        background-color: #fff;
        margin-top:10px;
    }
    .pricing-table .pricing-header .pt-price {
        font-family: Roboto, sans-serif;
        color: #4c4c4c;
        font-size: 25px;
        line-height: 40px;
        font-weight: 400;
        text-align: left;
        padding: 0px 40px;
    }
    .pricing-table .pricing-header .pt-price small {
        font-size: 14px;
        color: #9a9a9a;
        font-weight: 300;
        font-family: Roboto, sans-serif;
    }
    .pricing-table .pricing-header .pt-name {
        font-family: Roboto, sans-serif;
        padding: 10px 40px;
        text-align: left;
        font-weight: 500;
        font-size: 20px;
        line-height: 40px;
        color: #4c4c4c;
        border-top: 1px solid #f2f2f2;
    }
    .pricing-table .pricing-body ul {
        margin: 0;
        padding: 0;
        list-style: none;
        text-align:left
    }
    .pricing-table .pricing-body  {
        padding: 0px 25px;
        font-family: Roboto, sans-serif;
        font-weight: 500;
        font-size:18px;
        
        margin: 0;
    }
      /*.pricing-table .pricing-body ul li:nth-child(even) {
        background-color: #fafafa;
        }*/
        .pricing-table .pricing-body ul li .fa-times {
            color: #ff6666;
        }
        .pricing-table .pricing-body ul li .fa-check {
            color: #2185c5;
        }
        .pricing-table .pricing-footer {
            text-align: left;
            padding: 15px 40px;
            /* border-top: 1px solid #f2f2f2;*/
            font-family: Roboto,sans-serif;
        }
        .pricing-table.featured .pricing-header {
            position: relative;
            overflow: hidden;
        }
        .pricing-table.featured .pricing-header .pt-price {
            color: #4ecdc4;
        }
        .pricing-table.featured .pricing-header .pt-price small {
            color: #4ecdc4;
        }
        .pricing-table.featured .pricing-header .pt-name {

            color: #4ecdc4;
        }
        .pricing-table.featured .pricing-header .featured-text {
            font-family: Roboto, sans-serif;
            font-size: 24px;
            line-height: 15px;
            letter-spacing: 1px;
            font-weight: 300;
            text-transform: uppercase;
            text-align: center;
            background-color: #4ecdc4;
            color: #fff;
            position: absolute;
            top: 22px;
            left: -28px;
            padding: 5px 0;
            width: 126px;
            -webkit-transform: rotate(-45deg);
            -ms-transform: rotate(-45deg);
            transform: rotate(-45deg);
        }
        .btn-default {
          color: #4285f4;

          border: 2px solid #4285f4;
      }
      .btn-default:hover {
        color: #fff;
        border: 2px solid #4285f4;

    }
    .pricing-plans__plan-price-bill {
      display: block;
      font-size: 16px;
      line-height: 20px;
      margin-bottom: 0;
      font-family: Roboto, sans-serif;
    }
    .pricing-plans__plan-price {
      color: #4285f4;
      display: block;
      font-size: 25px;
      font-family: Roboto, sans-serif;
      font-weight: 500;
      line-height: 1;
      margin-bottom: 0;
      margin-top: 20px;
    }
    .pricing-plans__original-price {
      color: #bdbdbd;
      font-size: 24px;
      text-decoration: line-through;
    }
    .pricing-plans__plan-intro {
      font-size: 15px;
      line-height: 22px;
      margin-bottom: 0;
      font-family: Roboto, sans-serif;
      padding: 0px 40px;
    }
    .btn {
     font-family: 'Roboto',arial,sans-serif;
     font-size: 16px;
     letter-spacing: 1px;
     border-radius: 40px;
     font-weight:400;
     padding: 8px 30px;
     margin-bottom: 5px;
     -webkit-transition: color 0.3s, background-color 0.3s, border-color 0.3s;
     transition: color 0.3s, background-color 0.3s, border-color 0.3s;
    }
    .btn-main {
        color: #fff;
        background-color: #4ecdc4;
        border-color: #4ecdc4;
    }
    .btn-main:hover,
    .btn-main:focus,
    .btn-main:active {
        background-color: #33b5ac;
        border-color: #33b5ac;
        color: #fff;
    }
</style>
@endsection

@section('main-content')
<div class="row">
    <div class="col-lg-12">
        @if($errors->any())
            <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <p>{{$error}}</p>
            @endforeach()
            </div>
        @endif
        <form id="form_payment_details" action="{{url('index.php/user_payment_detail/get_plan')}}" method="get" class="form-horizontal">
            <div class="box">
            <div class="box-header">
                <h4 class="pull-left"><b>Pricing</b></h4>
            </div>
            <div class="box-body">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    @foreach($subscription as $data)
                    <div class="col-md-4">
                        <div class="pricing-table" style="background:#fafafa;">
                            <div class="pricing-header">
                                <div class="pt-name">{{$data->package_name}}</div>
                                @if($data->num_of_prop!=null)
                                <div class="pt-price" >{{$data->num_of_prop}}<small>No.Of Properties</small></div>
                                @else
                                <div class="pt-price" >{{$data->min_prop.'-'.$data->max_prop}}<small>No.Of Properties</small></div>
                                @endif
                                <P class="pricing-plans__plan-intro">{{$data->description}}</P>
                            </div>
                            <div class="pricing-body" style="padding: 0px 40px;">
                                @if($data->monthly_package==0)
                                <div class="pricing-plans__plan-price">
                                    <span class="pricing-plans__original-price" >  </span>&#8377 {{$data->yearly_package}}
                                </div>
                                <p class="pricing-plans__plan-price-bill"> per year</p>
                                <br/><br/>
                                @else
                                <div class="pricing-plans__plan-price">
                                    &#8377 {{$data->monthly_package}}
                                </div>
                                <p class="pricing-plans__plan-price-bill"> per month</p>
                                <div class="pricing-plans__plan-price">
                                    <span class="pricing-plans__original-price" > &#8377 {{$data->monthly_package*12}} </span>
                                    &#8377 {{$data->yearly_package}}
                                </div>
                                <p class="pricing-plans__plan-price-bill"> per year</p>
                                @endif
                            </div>
                            <!-- </div>
                            <p> &nbsp </p><p> &nbsp </p> -->
                            <div class="pricing-footer">
                                <a href="{{url('../../dataFrom.php?user_id='.$user_id.'&sub_id='.$data->id.'&trans_id=0&module=Assure')}}" class="btn btn-default">Get Started</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </form>
    </div>
</div>
@endsection