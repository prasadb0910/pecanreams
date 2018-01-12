$(document).ready(function() {
	$('#collapse_menu').click(function() {
		//alert('hi');
		if($('.vertical_nav').hasClass('vertical_nav__minify')) {
			//alert('hi');
			$.cookie("menu","open");
			$('.mCustomScrollBox').css('overflow','hidden');
			//$('.mCustomScrollbar _mCS_1').css('overflow','hidden');
		} else {
			$.cookie("menu","close"); 
			$('.mCSB_scrollTools').hide();
			$('.mCustomScrollBox').css('overflow','visible');
			//$('.mCustomScrollbar _mCS_1').css('overflow','hidden');
		}
	}); 
});

$(document).ready(function() {
	if($.cookie("menu")==="open") {
		$('.vertical_nav').removeClass('vertical_nav__minify');
		$('.wrapper').removeClass('wrapper__minify');
		//alert('if');
	} else {
		$('.vertical_nav').addClass('vertical_nav__minify');
		$('.wrapper').addClass('wrapper__minify');
		// alert('else');
	}
});

$(document).ready(function() {
	$("form").attr("autocomplete", "Off");
	// $("input[name='submit']").prop("disabled",true);
	$(".save-form").prop("disabled",true);
});

$("form :input").change(function() {
	$(".save-form").prop("disabled",false);
});

$('.datepicker').attr('readonly','true');
$('.datepicker1').attr('readonly','true');

var table,table1;
$(document).ready(function() {
	//var oTable;
	//oTable=$("#customers2").DataTable({"bPaginate": true});
	table1 =  $('#customers3');
	var tableOptions1 = {
		'bPaginate': true,
		'iDisplayLength': 10,
		aLengthMenu: [
		[10,25, 50, 100, 200, -1],
		[10,25, 50, 100, 200, "All"]
		],
	};
	table1.DataTable(tableOptions1);

	table =  $('#customers2');
	var tableOptions = {
		'bPaginate': true,
		'iDisplayLength': 10,
		aLengthMenu: [
		[10,25, 50, 100, 200, -1],
		[10,25, 50, 100, 200, "All"]
		],
	};
	table.DataTable(tableOptions);

	$("#csv").click(function(){
		table.DataTable().destroy();
		tableOptions.bPaginate = false;
		table.DataTable(tableOptions);
		table.tableExport({type:'csv',escape:'false'});
		table.DataTable().destroy();
		tableOptions.bPaginate = true;
		table.DataTable(tableOptions);
	});
	$("#xls").click(function(){
		table.DataTable().destroy();
		tableOptions.bPaginate = false;
		table.DataTable(tableOptions);
		table.tableExport({type:'excel',escape:'false'});
		table.DataTable().destroy();
		tableOptions.bPaginate = true;
		table.DataTable(tableOptions);
	});
	$("#txt").click(function(){
		table.DataTable().destroy();
		tableOptions.bPaginate = false;
		table.DataTable(tableOptions);
		table.tableExport({type:'txt',escape:'false'});
		table.DataTable().destroy();
		tableOptions.bPaginate = true;
		table.DataTable(tableOptions);
	});
	$("#doc").click(function(){
		table.DataTable().destroy();
		tableOptions.bPaginate = false;
		table.DataTable(tableOptions);
		table.tableExport({type:'doc',escape:'false'});
		table.DataTable().destroy();
		tableOptions.bPaginate = true;
		table.DataTable(tableOptions);
	});
	$("#powerpoint").click(function(){
		table.DataTable().destroy();
		tableOptions.bPaginate = false;
		table.DataTable(tableOptions);
		table.tableExport({type:'powerpoint',escape:'false'});
		table.DataTable().destroy();
		tableOptions.bPaginate = true;
		table.DataTable(tableOptions);
	});
	$("#png").click(function(){
		table.DataTable().destroy();
		tableOptions.bPaginate = false;
		table.DataTable(tableOptions);
		table.tableExport({type:'png',escape:'false'});
		table.DataTable().destroy();
		tableOptions.bPaginate = true;
		table.DataTable(tableOptions);
	});
	$("#pdf").click(function(){
		table.DataTable().destroy();
		tableOptions.bPaginate = false;
		table.DataTable(tableOptions);
		table.tableExport({type:'pdf',escape:'false'});
		table.DataTable().destroy();
		tableOptions.bPaginate = true;
		table.DataTable(tableOptions);
	});

	//var oTable;
	//oTable=$("#customers3").DataTable({"bPaginate": true});
});

$(document).ready(function(){
	var pathname = window.location.pathname;
	if (pathname.toLowerCase().indexOf("dashboard") >= 0) {
		//alert('hi');
	$('.edit-show').show();
	} else {
		$('.edit-show').hide();
	}
});

$(function(){
	$('#popModal_ex1').click(function(){
		$('#popModal_ex1').popModal({
			html : $('#content'),
			placement : 'bottomLeft',
			showCloseBut : true,
			onDocumentClickClose : true,
			onDocumentClickClosePrevent : '',
			overflowContent : false,
			inline : true,
			asMenu : false,
			beforeLoadingContent : 'Please, wait...',
			onOkBut : function() {},
			onCancelBut : function() {},
			onLoad : function() {},
			onClose : function() {}
		});
	});

	$('#popModal_ex2').click(function(){
		$('#popModal_ex2').popModal({
			html : function(callback) {
				$.ajax({url:'ajax.html'}).done(function(content){
					callback(content);
				});
			}
		});
	});

	$('#popModal_ex3').click(function(){
		$('#popModal_ex3').popModal({
			html : $('#content3'),
			placement : 'bottomLeft',
			asMenu : true
		});
	});

	$('#notifyModal_ex1').click(function(){
		$('#content2').notifyModal({
			duration : 2500,
			placement : 'center',
			overlay : true,
			type : 'notify',
			onClose : function() {}
		});
	});

	$('#dialogModal_ex1').click(function(){
		$('.dialog_content').dialogModal({
			topOffset: 0,
			top: '10%',
			type: '',
			onOkBut: function() {},
			onCancelBut: function() {},
			onLoad: function(el, current) {},
			onClose: function() {},
			onChange: function(el, current) {
				if(current == 3){
					el.find('.dialogModal_header span').text('Page 3');
					$.ajax({url:'ajax.html'}).done(function(content){
						el.find('.dialogModal_content').html(content);
					});
				}
			}
		});
	});

	$('#confirmModal_ex1').click(function(){
		$('#confirm_content1').confirmModal({
			topOffset: 0,
			onOkBut: function() {},
			onCancelBut: function() {},
			onLoad: function() {},
			onClose: function() {}
		});
	});

	$('#confirmModal_ex').click(function(){
		$('#confirm_content1').confirmModal({
			topOffset: 0,
			onOkBut: function() {},
			onCancelBut: function() {},
			onLoad: function() {},
			onClose: function() {}
		});
	});


	(function($) {
		$.fn.tab = function(method){
			var methods = {
				init : function(params) {

					$('.tab').click(function() {
						var curPage = $(this).attr('data-tab');
						$(this).parent().find('> .tab').each(function(){
							$(this).removeClass('active');
						});
						$(this).parent().find('+ .page_container > .page').each(function(){
							$(this).removeClass('active');
						});
						$(this).addClass('active');
						$('.page[data-page="' + curPage + '"]').addClass('active');
					});

				}
			};
			if (methods[method]) {
				return methods[method].apply( this, Array.prototype.slice.call(arguments, 1));
			} else if (typeof method === 'object' || ! method) {
				return methods.init.apply(this, arguments);
			}
		};
		$('html').tab();
	})(jQuery);
});

$("#form_change_password").validate({
    rules: {
        old_password: {
            required: true,
            checkValidPassword: true
        },
        new_password: {
            required: true,
            minlength: 6,
            maxlength: 10
        },
        confirm_new_password: {
            required: true,
            minlength: 6,
            maxlength: 10,
            equalTo: "#new_password"
        }
    },

    ignore: false,
    onkeyup: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$.validator.addMethod("checkValidPassword", function (value, element) {
    var result = 1;

    $.ajax({
        url: BASE_URL+'index.php/Login/check_valid_password',
        data: 'password='+$("#old_password").val(),
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

    if (result) {
        return false;
    } else {
        return true;
    }
}, 'Old Password does not match.');

$('#form_change_password').submit(function() {
    if (!$("#form_change_password").valid()) {
        return false;
    } else {
        return true;
    }
});

$('#btn_change_password').on('click', function (e) {

    if (!$("#form_change_password").valid()) {
        return false;
    } else {

    	var result = 1;

	    $.ajax({
	        url: BASE_URL+'index.php/Login/change_password',
	        data: 'password='+$("#new_password").val(),
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

	    if(result==1) {
	    	alert("Password changed successfully.")
	    	$(this).parents(".message-box").removeClass("open");
				return true;
	    } else {
	    	return false;
	    }
    }
});

// function submit_form_change_password(){
// 	if (!$("#form_change_password").valid()) {
//         return false;
//     } else {

//     	var result = 1;

// 	    $.ajax({
// 	        url: BASE_URL+'index.php/Login/change_password',
// 	        data: 'password='+$("#new_password").val(),
// 	        type: "POST",
// 	        dataType: 'html',
// 	        global: false,
// 	        async: false,
// 	        success: function (data) {
// 	            result = parseInt(data);
// 	        },
// 	        error: function (xhr, ajaxOptions, thrownError) {
// 	            alert(xhr.status);
// 	            alert(thrownError);
// 	        }
// 	    });

// 	    if(result==1) {
// 	    	alert("Password changed successfully.")
// 	    	$(this).parents(".message-box").removeClass("open");
// 				return true;
// 	    } else {
// 	    	return false;
// 	    }
//     }
// }

// $('#submit_form_change_password').on("click", function() {
// 	console.log('sfsdf');

// 	// if (!$("#form_reset_password").valid()) {
//  //        return false;
//  //    } else {
//  //        // return true;
//  //        $('#confirm_content').toggle();
//  //    }
// });