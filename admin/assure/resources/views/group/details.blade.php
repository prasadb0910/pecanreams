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
        <form id="form_group" action="{{url('index.php/group/save')}}" method="POST" class="form-horizontal">
			{{ csrf_field() }}
     
			 <a href="{{url('index.php/group/')}}" class="btn btn-primary btn-sm pull-right">Back</a>
                  <div class="box">
			 <div class="box-header with-border">
                <h4 class="pull-left"><b>New Group Details</b></h4>
               
            </div>
			  <div class="box-body">
		
          <!--<input type="hidden" name="_token" value="{{ csrf_token() }}">-->
            
				   
				   
				   
                <div class="form-group">
				<input type="hidden" class="form-control" name="id" value="@if(isset($data)){{$data->id}}@endif" placeholder="Enter Name...">
                <div class="col-md-12 col-sm-12 col-xs-12">
              <label class="col-md-2 col-sm-2 col-xs-12 control-label">Group Name *</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input type="text" class="form-control" name="group_name" value="@if(isset($data)){{$data->group_name}}@endif" placeholder="Enter Group Name...">
                    </div>
                    
                </div>
                </div>
                
				
				
            </div>
			 <div class="box-header with-border">
                <h4 class="pull-left"><b>Contact Person Details</b></h4>
               
            </div>
            <div class="box-body">
		
          <!--<input type="hidden" name="_token" value="{{ csrf_token() }}">-->
            
				   
				   
				   
                
				
				      <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <table class="table table-bordered" id="tbl_group_contact">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email Id</th>
                                        <th>Mobile No</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
								
								
								
								
								
								
								
                                <tbody>
                                    <?php $i=0; if(isset($group_contacts)) {
                                            for($i=0; $i<count($group_contacts); $i++) { ?>
                                        <tr id="group_contact_<?php echo $i; ?>_row" class="group_contact">
                                      
                                            <td>
                                                <input type="text" class="form-control" name="name[]" value="@if(isset($group_contacts)){{$group_contacts[$i]->name}}@endif" placeholder="Enter Name...">
                                            </td>
                                            <td>
                                               <input type="text" class="form-control" name="email[]" value="@if(isset($group_contacts)){{$group_contacts[$i]->email}}@endif" placeholder="Enter Email Id..."> 
                                            </td>
                                            <td>
											 <input type="text" class="form-control" name="mobile[]" value="@if(isset($group_contacts)){{$group_contacts[$i]->mobile}}@endif" placeholder="Enter Mobile No...">
                                            </td>
                                             <td style="text-align: center; vertical-align: middle;">
                                            <button type="button"  id="group_contact_<?php echo $i; ?>_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>
                                        </td>   
                                        </tr>
										  <?php }} else { ?>
										   <tr id="group_contact_<?php echo $i; ?>_row" class="group_contact">
                                      
                                            <td>
                                                <input type="text" class="form-control" name="name[]" value="" placeholder="Enter Name...">
                                            </td>
                                            <td>
                                               <input type="text" class="form-control" name="email[]" value="" placeholder="Enter Email Id..."> 
                                            </td>
                                            <td>
											 <input type="text" class="form-control" name="mobile[]" value="" placeholder="Enter Mobile No...">
                                            </td>
                                             <td style="text-align: center; vertical-align: middle;">
                                            <button type="button"  id="group_contact_<?php echo $i; ?>_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>
                                        </td>   
                                        </tr>
										       <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4"><input type="button" class="btn btn-success" id="repeat_group_contact" value="+"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        </div>
				
				
				
            </div>
     
            <div class="box-footer">
                <a href="{{url('index.php/group/')}}" class="btn btn-danger btn-sm">Cancel</a>
                <button class="btn btn-success btn-sm pull-right" type="submit">Save</button>
            </div>
            </div>
           
        </form>
    </div>
</div>
@endsection
@section('js')
<script>
jQuery(function(){
    var counter = $('.group_contact').length;
    $('#repeat_group_contact').click(function(event){
        event.preventDefault();
        var newRow = jQuery('<tr id="group_contact_'+counter+'_row" class="group_contact">' + 
                                 '<td>' + 
                                    '<input type="text" class="form-control" name="name[]" placeholder="Enter Name..." value="" />' + 
                                '</td>' + 
                                '<td>' + 
                                    '<input type="text" class="form-control" name="email[]" placeholder="Enter Email id..." value="" />' + 
                                '</td>' + 
                                '<td>' + 
                                    '<input type="text" class="form-control" name="mobile[]" placeholder="Enter Mobile No..." value="" />' + 
                                '</td>' + 
								 '<td style="text-align: center; vertical-align: middle;">' + 
                                    '<button type="button" id="group_contact_'+counter+'_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>' + 
                                '</td>' + 
                            '</tr>');
        $('#tbl_group_contact tbody').append(newRow);
        counter++;
    });
});

var delete_row = function(elem){
    var id = elem.id;
    id = '#'+id.substr(0,id.lastIndexOf('_'));
    if($(id).length>0){
        $(id).remove();
    }
};
</script>
@endsection