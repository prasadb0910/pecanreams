@extends('adminlte::layouts.app')

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
        <form id="form_newspaper" action="{{url('index.php/newspapers/save')}}" method="POST" class="form-horizontal">
            <div class="box">
            <div class="box-header">
                <h4 class="pull-left"><b>Newspaper Details</b></h4>
                <a href="{{url('index.php/newspapers')}}" class="btn btn-primary btn-sm pull-right">Back</a>
            </div>
            <div class="box-body">
                {{csrf_field()}}
                <div class="form-group">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Newspaper Name</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input type="hidden" class="form-control" name="id" value="@if(isset($data)){{$data->id}}@endif">
                        <input type="text" class="form-control" name="paper_name" value="@if(isset($data)){{$data->paper_name}}@endif" placeholder="Enter Newspaper Name...">
                    </div>
                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Language</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <!-- <input type="text" class="form-control" name="language" value="@if(isset($data)){{--$data->language--}}@endif" placeholder="Enter Language..."> -->
                        <select class="form-control" id="language" name="language" >
                            <option value="English" @if(isset($data)) @if($data->language=="English"){{"Selected"}}@endif @endif>English</option>
                            <option value="Hindi" @if(isset($data)) @if($data->language=="Hindi"){{"Selected"}}@endif @endif>Hindi</option>
                            <option value="Marathi" @if(isset($data)) @if($data->language=="Marathi"){{"Selected"}}@endif @endif>Marathi</option>
                            <option value="Telugu" @if(isset($data)) @if($data->language=="Telugu"){{"Selected"}}@endif @endif>Telugu</option>
                            <option value="Bengali" @if(isset($data)) @if($data->language=="Bengali"){{"Selected"}}@endif @endif>Bengali</option>
                            <option value="Tamil" @if(isset($data)) @if($data->language=="Tamil"){{"Selected"}}@endif @endif>Tamil</option>
                            <option value="Urdu" @if(isset($data)) @if($data->language=="Urdu"){{"Selected"}}@endif @endif>Urdu</option>
                            <option value="Kannada" @if(isset($data)) @if($data->language=="Kannada"){{"Selected"}}@endif @endif>Kannada</option>
                            <option value="Gujarati" @if(isset($data)) @if($data->language=="Gujarati"){{"Selected"}}@endif @endif>Gujarati</option>
                            <option value="Odia" @if(isset($data)) @if($data->language=="Odia"){{"Selected"}}@endif @endif>Odia</option>
                            <option value="Malayalam" @if(isset($data)) @if($data->language=="Malayalam"){{"Selected"}}@endif @endif>Malayalam</option>
                            <option value="Sanskrit" @if(isset($data)) @if($data->language=="Sanskrit"){{"Selected"}}@endif @endif>Sanskrit</option>
                            <option value="Kashmiri" @if(isset($data)) @if($data->language=="Kashmiri"){{"Selected"}}@endif @endif>Kashmiri</option>
                            <option value="Punjabi" @if(isset($data)) @if($data->language=="Punjabi"){{"Selected"}}@endif @endif>Punjabi</option>
                            <option value="Sindhi" @if(isset($data)) @if($data->language=="Sindhi"){{"Selected"}}@endif @endif>Sindhi</option>
                            <option value="Manipuri" @if(isset($data)) @if($data->language=="Manipuri"){{"Selected"}}@endif @endif>Manipuri</option>
                            <option value="Rajasthani" @if(isset($data)) @if($data->language=="Rajasthani"){{"Selected"}}@endif @endif>Rajasthani</option>
                            <option value="Bhojpuri" @if(isset($data)) @if($data->language=="Bhojpuri"){{"Selected"}}@endif @endif>Bhojpuri</option>
                        </select>
                    </div>
                </div>
                </div>
                <div class="form-group">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">E Paper</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <!-- <input type="text" class="form-control" name="e_paper" value="@if(isset($data)){{--$data->e_paper--}}@endif" placeholder="EnterE Paper..."> -->
                        <select class="form-control" id="e_paper" name="e_paper" >
                            <option value="Yes" @if(isset($data)) @if($data->e_paper=="Yes"){{"Selected"}}@endif @endif>Yes</option>
                            <option value="No" @if(isset($data)) @if($data->e_paper=="No"){{"Selected"}}@endif @endif>No</option>
                        </select>
                    </div>
                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Frequency</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input type="text" class="form-control" name="frequency" value="@if(isset($data)){{$data->frequency}}@endif" placeholder="Enter Frequency...">
                    </div>
                </div>
                </div>
                <div class="form-group">
                <div class="col-md-12 col-sm-12 col-xs-12">
				
				<label class="col-md-2 col-sm-2 col-xs-12 control-label">Newspaper Type</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <!-- <input type="text" class="form-control" name="e_paper" value="@if(isset($data)){{--$data->e_paper--}}@endif" placeholder="EnterE Paper..."> -->
                        <select class="form-control" id="news_type" name="news_type" >
                            <option value="primary" @if(isset($data)) @if($data->e_paper=="primary"){{"Selected"}}@endif @endif>Primary</option>
                            <option value="secondary" @if(isset($data)) @if($data->e_paper=="secondary"){{"Selected"}}@endif @endif>Secondary</option>
                        </select>
                    </div>
				
				
                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Area</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input type="text" class="form-control" name="area" value="@if(isset($data)){{$data->area}}@endif" placeholder="Enter Area...">
                    </div>
                    
                </div>			
                </div>
				    <div class="form-group">
                <div class="col-md-12 col-sm-12 col-xs-12">
				<label class="col-md-2 col-sm-2 col-xs-12 control-label">Price</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input type="text" class="form-control" name="price" value="@if(isset($data)){{$data->price}}@endif" placeholder="Enter Price...">
                    </div>
                    </div>
                    </div>
				
            </div>
            @if(!Route::is('newspapers.details'))
            <div class="box-footer">
                <a href="{{url('index.php/newspapers')}}" class="btn btn-danger btn-sm">Cancel</a>
                <button class="btn btn-success btn-sm pull-right" type="submit">Save</button>
            </div>
            </div>
            @endif
        </form>
    </div>
</div>
@endsection