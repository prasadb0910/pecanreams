// ----------------- COMMON FUNCTIONS -------------------------------------
$.validator.addMethod("lettersonly", function(value, element) {
    return this.optional(element) || /^[a-z]+$/i.test(value);
}, "Letters only please.");

$.validator.addMethod("numbersonly", function(value, element) {
    return this.optional(element) || /^[0-9]+$/i.test(value);
}, "Numbers only please.");

$.validator.addMethod("numbersandcommaonly", function(value, element) {
    return this.optional(element) || /^[0-9]|^,+$/i.test(value);
}, "Numbers only please.");

$.validator.addMethod("checkemail", function(value, element) {
    return this.optional(element) || (/^[a-z0-9]+([-._][a-z0-9]+)*@([a-z0-9]+(-[a-z0-9]+)*\.)+[a-z]{2,4}$/i.test(value) && /^(?=.{1,64}@.{4,64}$)(?=.{6,100}$).*/i.test(value));
}, "Please enter valid email address.");

// function addMultiInputNamingRules(form, field, rules, type){
//     // alert(field);
//     $(form).find(field).each(function(index){
//         if (type=="Document") {
//             var id = $(this).attr('id');
//             var index = id.substr(id.lastIndexOf('_')+1);
//             if($('#d_m_status_'+index).val()=="Yes"){
//                 $(this).attr('alt', $(this).attr('name'));
//                 $(this).attr('name', $(this).attr('name')+'-'+index);
//                 $(this).rules('add', rules);
//             }
//         } else {
//             $(this).attr('alt', $(this).attr('name'));
//             $(this).attr('name', $(this).attr('name')+'-'+index);
//             $(this).rules('add', rules);
//         }
//     });
// }

// function removeMultiInputNamingRules(form, field){    
//     $(form).find(field).each(function(index){
//         $(this).attr('name', $(this).attr('alt'));
//         $(this).removeAttr('alt');
//     });
// }

// $('.save-form').click(function(){ 
//     $("#submitVal").val('1');
// });
// $('.submit-form').click(function(){ 
//     $("#submitVal").val('0');
// });




// ----------------- Newspaper Form Validation -------------------------------------
$("#form_newspaper").validate({
    rules: {
        paper_name: {
            required: true
        },
        language: {
            required: true,
            // lettersonly: true
        },
        e_paper: {
            required: true
        },
        frequency: {
            required: true
        },
        area: {
            required: true
        },
        price: {
            required: true,
            number: true
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});


// ----------------- Notice Form Validation -------------------------------------
$("#form_notice").validate({
    rules: {
        notice_file_file: {
            required: function(){if($('#notice_file').val()=='' && $('#temp_notice_file').val()=='') return true;}
        },
        notice_title: {
            required: true
        },
        date_of_notice: {
            required: true
        },
        fk_newspaper_id: {
            required: true
        },
        days_for_respond: {
            required: true
        },
        issued_by: {
            required: true
        },
        reason_for_notice: {
            required: true
        },
        fk_notice_type_id: {
            required: true
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});



// ----------------- Notice Form Validation -------------------------------------
$("#form_scan").validate({
    rules: {
        notice_file_file: {
            required: function(){if($('#notice_file').val()=='') return true;}
        },
        date_of_notice: {
            required: true
        },
        fk_newspaper_id: {
            required: true
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});


// ----------------- Notice Type Form Validation -------------------------------------
$("#form_notice_type").validate({
    rules: {
        notice_type: {
            required: true
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});


// ----------------- Property Form Validation -------------------------------------
$("#form_property").validate({
    rules: {
        property_type: {
            required: true
        },
        property_name: {
            required: true
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});


// ----------------- Payment Details Form Validation -------------------------------------
$("#form_payment_details").validate({
    rules: {
        payment_method: {
            required: true
        },
        payment_date: {
            required: true
        },
        payment_ref: {
            required: function(){if($('#payment_method').val()=='Cheque') return true;}
        },
        bank_name: {
            required: function(){if($('#payment_method').val()=='Cheque') return true;}
        },
        branch: {
            required: function(){if($('#payment_method').val()=='Cheque') return true;}
        },
        cheque_date: {
            required: function(){if($('#payment_method').val()=='Cheque') return true;}
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});


// ----------------- Change Password Form Validation -------------------------------------
$("#form_change_password").validate({
    rules: {
        old_password: {
            required: true,
            minlength: 6,
            maxlength: 10,
            check_old_password: true
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

$.validator.addMethod("check_old_password", function (value, element) {
    var result = 1;

    $.ajax({
        url:BASE_URL+'update_password/check_old_password',
        type:'post',
        data:$('#form_change_password').serialize(),
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
        return true;
    } else {
        return false;
    }
}, 'Old Password does not match.');

$('#form_change_password').submit(function() {
    console.log("submit");
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
        var result = 0;

        $.ajax({
            url: BASE_URL+'update_password/change_password',
            data:$('#form_change_password').serialize(),
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
            alert("Password changed successfully.");
            // $(this).parents(".message-box").removeClass("open");
            $('#change_psw').modal('toggle');
            return true;
        } else {
            return false;
        }
    }
});


$("#form_non_relevant").validate({
    rules: {
        total_notice: {
            required: true
        },
        total_relevant: {
            required: true
        },
        total_non_relevant: {
            required: true,
            checkNonRelevantCount: true
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$.validator.addMethod("checkNonRelevantCount", function (value, element) {
    var result = 1;

    if (parseInt($('#total_notice').val())<parseInt($('#total_non_relevant').val())) {
        return false;
    } else {
        return true;
    }
}, 'Non Relevant Notice count can not be greater than Total Notice Count.');

$('#form_non_relevant').submit(function() {
    if (!$("#form_non_relevant").valid()) {
        return false;
    } else {
        return true;
    }
});