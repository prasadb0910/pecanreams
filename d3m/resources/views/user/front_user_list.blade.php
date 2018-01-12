@extends('adminlte::layouts.app')

@section('main-content')
<div class="row">
    <div class="col-lg-12">
     @if(Session::has('success_msg'))
     <div class="alert alert-success">{{Session::get('success_msg')}}</div>
     @endif

     <div class="box">
        <div class="box-header">
            <h4 class="pull-left"><b>User List</b></h4>
            <a href="{{url('index.php/user/add_user')}}"  class="btn btn-success btn-sm pull-right"><span class="fa fa-plus"></span> Add User</a>
        </div>

        <div class = "tabinator">
            <input type = "radio" id = "tab1" name = "tabs" checked>
            <label for = "tab1">All</label>
            <input type = "radio" id = "tab2" name = "tabs">
            <label for = "tab2">Blocked</label>
            <input type = "radio" id = "tab3" name = "tabs">
            <label for = "tab3">Active</label>
            <input type = "radio" id = "tab4" name = "tabs">
            <label for = "tab4">InActive</label>
            <div id = "content1">
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <th>Sr. No</th>
                            <th>Name</th>
                            <th>Email Id</th>
                            <th>Mobile No</th>
                            <th>No of properties regsitered</th>
                            <th>Plan Name</th>
                            <th>Status</th>
                            <th>Edit</th>
                        </thead>
                        <tbody>
                           <?php $cnt = 0; if(isset($Users)) $cnt = count($Users); ?>
                           @for ($i = 0; $i < $cnt; $i++)
                            <tr>
                            <td class="table-text">
                             {{ $i+1 }}
                         </td>
                         <td class="table-text">
                             {{ $Users[$i]->name }}  
                         </td>
                         <td class="table-text">
                             {{ $Users[$i]->gu_email }}  
                         </td>
                         <td class="table-text">
                             {{ $Users[$i]->gu_mobile }}  
                         </td>
                         <td class="table-text">
                          {{ $Users[$i]->prop_cnt }}  
                      </td>
                      <td class="table-text">

                      </td>
                      <td class="table-text">
                       {{ $Users[$i]->status }}  
                   </td>
                   <td class="table-text">
                      <a href="{{url('index.php/user/edit/'.$Users[$i]->gu_id)}}" class="label label-warning">Edit</a>
                  </td>
              </tr>
              @endfor
          </tbody>
      </table>
  </div>
</div>

<div id = "content2">
  <div class="box-body">
    <table id="example2" class="table table-bordered table-striped">
        <thead>
          <th>Sr. No</th>
          <th>Name</th>
          <th>Email Id</th>
          <th>Mobile No</th>
          <th>No of properties regsitered</th>
          <th>Plan Name</th>
          <th>Status</th>
          <th>Edit</th>
      </thead>
      <tbody>
       <?php $cnt = 0; if(isset($block)) $cnt = count($block); ?>
       @for ($i = 0; $i < $cnt; $i++)
       <tr>
        <td class="table-text">
            {{ $i+1 }}
        </td>
        <td class="table-text">
         {{ $block[$i]->name }}  
     </td>
     <td class="table-text">
         {{ $block[$i]->gu_email }}  
     </td>
     <td class="table-text">
         {{ $block[$i]->gu_mobile }}  
     </td>
     <td class="table-text">
      {{ $block[$i]->prop_cnt }}  
  </td>
  <td class="table-text">

  </td>
  <td class="table-text">
   {{ $block[$i]->status }}  
</td>
<td class="table-text">
  <a href="{{url('index.php/user/edit/'.$block[$i]->gu_id)}}" class="label label-warning">Edit</a>
</td>
</tr>
@endfor
</tbody>
</table>
</div>
</div>

<div id = "content3">
  <div class="box-body">
    <table id="example3" class="table table-bordered table-striped">
        <thead>
           <th>Sr. No</th>
           <th>Name</th>
           <th>Email Id</th>
           <th>Mobile No</th>
           <th>No of properties regsitered</th>
           <th>Plan Name</th>
           <th>Status</th>
           <th>Edit</th>
       </thead>
       <tbody>
           <?php $cnt = 0; if(isset($active)) $cnt = count($active); ?>
           @for ($i = 0; $i < $cnt; $i++)
           <tr>
            <td class="table-text">
             {{ $i+1 }}
         </td>
         <td class="table-text">
             {{ $active[$i]->name }}  
         </td>
         <td class="table-text">
             {{ $active[$i]->gu_email }}  
         </td>
         <td class="table-text">
             {{ $active[$i]->gu_mobile }}  
         </td>
         <td class="table-text">
          {{ $active[$i]->prop_cnt }}  
      </td>
      <td class="table-text">

      </td>
      <td class="table-text">
       {{ $active[$i]->status }}  
   </td>
   <td class="table-text">
      <a href="{{url('index.php/user/edit/'.$active[$i]->gu_id)}}" class="label label-warning">Edit</a>
  </td>
</tr>
@endfor
</tbody>
</table>
</div>
</div>


<div id = "content4">
  <div class="box-body">
    <table id="example4" class="table table-bordered table-striped">
        <thead>
            <th>Sr. No</th>
            <th>Name</th>
            <th>Email Id</th>
            <th>Mobile No</th>
            <th>No of properties regsitered</th>
            <th>Plan Name</th>
            <th>Status</th>
            <th>Edit</th>
        </thead>
        <tbody>
           <?php $cnt = 0; if(isset($inactive)) $cnt = count($inactive); ?>
           @for ($i = 0; $i < $cnt; $i++)
           <tr>
            <td class="table-text">
              {{ $i+1 }}
          </td>
          <td class="table-text">
             {{ $inactive[$i]->name }}  
         </td>
         <td class="table-text">
             {{ $inactive[$i]->gu_email }}  
         </td>
         <td class="table-text">
             {{ $inactive[$i]->gu_mobile }}  
         </td>
         <td class="table-text">
          {{ $inactive[$i]->prop_cnt }}  
      </td>
      <td class="table-text">

      </td>
      <td class="table-text">
       {{ $inactive[$i]->status }}  
   </td>
   <td class="table-text">
      <a href="{{url('index.php/user/edit/'.$inactive[$i]->gu_id)}}" class="label label-warning">Edit</a>
  </td>
</tr>
@endfor
</tbody>
</table>
</div>
</div>

</div>
</div>


</div>
</div>





@endsection
