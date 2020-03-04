var clear_content = function(){
	$('#newspaper').val('');
	$('#from_date').val('');
	$('#to_date').val('');
	$('#keyword').val('');
	$('#match_word_any').attr('checked', false);
	$('#match_word_exact').attr('checked', false);
}

$(document).ready(function() {
	$('.datepicker').datepicker({
		autoclose: true
	});

	if($('#newspaper').val()!='' || $('#from_date').val()!='' || $('#to_date').val()!='' || $('#keyword').val()!='')
    {
    	$('#example').DataTable({
			"bProcessing": true,
			"serverSide": true,
			"ajax":{
						url : base_url + "/notice_data.php", // json datasource
						type: "post",  // type of method  ,GET/POST/DELETE
						data: function(data) {
												// data.notice_type_id = 1;
												// data.newspaper = '6';
												// data.from_date = '';
												// data.to_date = '';
												// data.keyword = '';
												// data.match_word = '';

												data.notice_type_id = $('#notice_type_id').val();
												data.newspaper = $('#newspaper').val();
												data.from_date = $('#from_date').val();
												data.to_date = $('#to_date').val();
												data.keyword = $('#keyword').val();
												data.match_word = $('#match_word').val();
						                    },
	                    "dataSrc": function ( json ) {
	                        return json.data;
	                    },
						error: function(){
						  	$("#example_processing").css("display","none");
						}
					}
		});
    }
});

$('#form_search').submit(function(){
	var result = 0;
	$.ajax({
        url: base_url+'/check_captcha.php',
        data: 'g-recaptcha-response='+$("#g-recaptcha-response").val(),
        type: "POST",
        dataType: 'html',
        global: false,
        async: false,
        success: function (data) {
            result = parseInt(data);
        },
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
		}
    });

    // console.log(result);

    if(result) {
        return true;
    } else {
    	$('#g_recaptcha_response').html('Captcha Validation Required!');
        return false;
    }
});