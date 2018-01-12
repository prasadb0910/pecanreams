var tbl_project_details;

$(function () {
	$(".select2").select2({
		closeOnSelect: false
	});
	set_datatable();
});

var set_datatable = function () {
	tbl_project_details = $("#tbl_project_details").DataTable({
		"scrollX": true,
        "ordering": false,
		"autoWidth": false
    });
};

$('#search_btn').click(function(){
	var criteria = $('#criteria').val();
	var search = $('#search').val();
	if (criteria!=null && search!=null){
		get_data(criteria, search);
	}
});

var get_data = function(criteria, search){
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url:BASE_URL+'search/get_data',
        type:'post',
        data: {_token: CSRF_TOKEN, criteria: criteria, search: search},
        datatype:'json',
        success: function(response){
            data = JSON.parse(response);

            var project_details = data.project_details;

            tbl_project_details.destroy();
            $("#tbl_project_details tbody").html(project_details);
            set_datatable();

            // console.log(project_details);
        },
        error: function(response){
            var r = jQuery.parseJSON(response.responseText);
            console.log("Message: " + r.Message);
            console.log("StackTrace: " + r.StackTrace);
            console.log("ExceptionType: " + r.ExceptionType);
        }
    });
};