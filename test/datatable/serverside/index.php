<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Datatable with mysql</title>
<!-- <link rel="stylesheet" id="font-awesome-style-css" href="http://phpflow.com/code/css/bootstrap3.min.css" type="text/css" media="all"> -->
<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.11.1.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css"/>
	 
<script type="text/javascript" src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>

	
	<div class="container">
      <div class="">
        <h1>Data Table</h1>
        <div class="">
		<table id="employee_grid" class="display" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Image</th>
                <th>Title</th>
            </tr>
        </thead>
    </table>
    </div>
      </div>

    </div>

<script type="text/javascript">
$( document ).ready(function() {
$('#employee_grid').DataTable({
				 "bProcessing": true,
         "serverSide": true,
         "ajax":{
            url :"response.php", // json datasource
            type: "post",  // type of method  ,GET/POST/DELETE
            data: function(data) {
                                  data.notice_type_id = 1;
                                  data.newspaper = '6';
                                  data.from_date = '';
                                  data.to_date = '';
                                  data.keyword = '';
                                  data.match_word = '';

                                  // data.notice_type_id = $('#notice_type_id').val();
                                  // data.newspaper = $('#newspaper').val();
                                  // data.from_date = $('#from_date').val();
                                  // data.to_date = $('#to_date').val();
                                  // data.keyword = $('#keyword').val();
                                  // data.match_word = $('#match_word').val();
                                },
            error: function(){
              $("#employee_grid_processing").css("display","none");
            }
          }
        });   
});
</script>
