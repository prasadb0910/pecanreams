@extends('adminlte::layouts.app1')

@section('htmlheader_title')
{{ trans('adminlte_lang::message.home') }}
@endsection
@section('styles')
<style>

.wrapper
{
	background:#ecf0f5 !important; 
}

.small-box .inner {

    text-align: center;
    background-color:#fff;
    padding: 30px;

}

.items
{
  height:120px; width:120px;
  margin:0 auto;
  padding:10px;
}
.items img
{
	width:100%
	
}
</style>
@endsection

@section('main-content')

<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-md-12">
 
        
        <div class="col-lg-4 col-xs-6">
            <div class="small-box ">
                <a href="{{ url('/index.php/reams') }}">
                <div class="inner" >
                    <img src="{{asset('/img/main-logo.png')}}" >
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                </a>
                <a href="{{ url('/index.php/reams') }}" class="small-box-footer" style="color:#000;">Get Started <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-4 col-xs-6">
            <div class="small-box ">
                <a href="{{ url('/index.php/idata') }}">
                <div class="inner">
                    <b style="font-family:'seguibl' !important;font-size:34px;text-align:center; color: rgb(40, 55, 122)!important;">iDATA</b>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                </a>
                <a href="{{ url('/index.php/idata') }}" class="small-box-footer" style="color:#000;">Get Started <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-4 col-xs-6">
            <div class="small-box ">
                <a href="{{ url('/index.php/assure') }}">
                <div class="inner" style="padding: 37px!important;">
                    <img src="{{asset('/img/assure.png')}}" style="text-align:center;">
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                </a>
                <a href="{{ url('/index.php/assure') }}" class="small-box-footer" style="color:#000;">Get Started <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

 
    </div>
    </div>


<div class="row" style="display: none;">
    <div class="col-md-12">
    <div class="col-md-8">


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

<!-- /.item -->
</div>
<!-- /.chat -->




</div>
</div>



<div class="col-md-4">
  <!-- DIRECT CHAT -->
  <div class="box box-primary direct-chat direct-chat-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Newsletter</h3>






  </div>
  <!-- /.box-header -->
  <div class="box-body">
      <!-- Conversations are loaded here -->
      <div class="items" >
        <img src="{{asset('/img/Newsletter.png')}}">
    </div>         
    <h2 style="padding:10px;text-align:center;">Sign Up</h2>
    <p style="margin-left:10px;margin-right:10px;">

        Sign up to our newsletter and get exclusive deals you wont find anywhere else straight to your inbox!</p>

        <!-- Contacts are loaded here -->

        <!-- /.box-body --></div><br>
       
<!-- /.box-footer-->
</div>
</div>

</div>
</div>




@endsection

