jQuery(function(){
    var counter = $('.legal_owner_name').length;
    $('#repeat_legal_owner_name').click(function(event){
        event.preventDefault();
        var newRow = jQuery('<tr id="legal_owner_name_'+counter+'_row">' + 
                                '<td>' + 
                                    '<input type="text" class="form-control legal_owner_name" name="legal_owner_name[]" id="legal_owner_name_'+counter+'" placeholder="Enter Legal Owner Name..." value="" />' + 
                                '</td>' + 
                               '<td style="text-align: center; vertical-align: middle;">' + 
                                    '<button type="button" id="legal_owner_name_'+counter+'_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>' + 
                                '</td>' + 
                            '</tr>');
        $('#tbl_legal_owner_name tbody').append(newRow);
        counter++;
    });
});

jQuery(function(){
    var counter = $('.purchased_from').length;
    $('#repeat_purchased_from').click(function(event){
        event.preventDefault();
        var newRow = jQuery('<tr id="purchased_from_'+counter+'_row">' + 
                                '<td>' + 
                                    '<input type="text" class="form-control purchased_from" name="purchased_from[]" id="purchased_from_'+counter+'" placeholder="Enter Purchased From..." value="" />' + 
                                '</td>' + 
                               '<td style="text-align: center; vertical-align: middle;">' + 
                                    '<button type="button" id="purchased_from_'+counter+'_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>' + 
                                '</td>' + 
                            '</tr>');
        $('#tbl_purchased_from tbody').append(newRow);
        counter++;
    });
});

jQuery(function(){
    var counter = $('.company_name').length;
    $('#repeat_company_name').click(function(event){
        event.preventDefault();
        var newRow = jQuery('<tr id="company_name_'+counter+'_row">' + 
                                '<td>' + 
                                    '<input type="text" class="form-control company_name" name="company_name[]" id="company_name_'+counter+'" placeholder="Enter Company Name..." value="" />' + 
                                '</td>' + 
                               '<td style="text-align: center; vertical-align: middle;">' + 
                                    '<button type="button" id="company_name_'+counter+'_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>' + 
                                '</td>' + 
                            '</tr>');
        $('#tbl_company_name tbody').append(newRow);
        counter++;
    });
});

jQuery(function(){
    var counter = $('.guarantor').length;
    $('#repeat_guarantor').click(function(event){
        event.preventDefault();
        var newRow = jQuery('<tr id="guarantor_'+counter+'_row">' + 
                                '<td>' + 
                                    '<input type="text" class="form-control guarantor" name="guarantor[]" id="guarantor_'+counter+'" placeholder="Enter Guarantor..." value="" />' + 
                                '</td>' + 
                               '<td style="text-align: center; vertical-align: middle;">' + 
                                    '<button type="button" id="guarantor_'+counter+'_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>' + 
                                '</td>' + 
                            '</tr>');
        $('#tbl_guarantor tbody').append(newRow);
        counter++;
    });
});

jQuery(function(){
    var counter = $('.othername').length;
    $('#repeat_othername').click(function(event){
        event.preventDefault();
        var newRow = jQuery('<tr id="othername_'+counter+'_row">' + 
                                '<td>' + 
                                    '<input type="text" class="form-control othername" name="othername[]" id="othername_'+counter+'" placeholder="Enter Other Name..." value="" />' + 
                                '</td>' + 
                               '<td style="text-align: center; vertical-align: middle;">' + 
                                    '<button type="button" id="othername_'+counter+'_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>' + 
                                '</td>' + 
                            '</tr>');
        $('#tbl_othername tbody').append(newRow);
        counter++;
    });
});

jQuery(function(){
    var counter = $('.property_no_detail').length;
    $('#repeat_property_no_detail').click(function(event){
        event.preventDefault();
        var newRow = jQuery('<tr id="property_no_detail_'+counter+'_row" class="property_no_detail">' + 
                                '<td>' + 
                                    '<select class="form-control" name="fk_property_no_type_id[]">' + 
                                        '<option value="">Select Property No Type</option>' + 
                                        property_no_type_list + 
                                    '</select>' + 
                                '</td>' + 
                                '<td>' + 
                                    '<input type="text" class="form-control" name="property_no[]" placeholder="Enter Property No..." value="" />' + 
                                '</td>' + 
                                '<td style="text-align: center; vertical-align: middle;">' + 
                                    '<button type="button" id="property_no_detail_'+counter+'_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>' + 
                                '</td>' + 
                            '</tr>');
        $('#tbl_property_no_detail tbody').append(newRow);
        counter++;
    });
});

jQuery(function(){
    var counter = $('.location_detail').length;
    $('#repeat_location_detail').click(function(event){
        event.preventDefault();
        var newRow = jQuery('<tr id="location_detail_'+counter+'_row" class="location_detail">' + 
                                '<td>' + 
                                    '<select class="form-control" name="fk_location_type_id[]">' + 
                                        '<option value="">Select Location Type</option>' + 
                                        location_type_list + 
                                    '</select>' + 
                                '</td>' + 
                                '<td>' + 
                                    '<input type="text" class="form-control" name="location[]" placeholder="Enter Location..." value="" />' + 
                                '</td>' + 
                                '<td style="text-align: center; vertical-align: middle;">' + 
                                    '<button type="button" id="location_detail_'+counter+'_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>' + 
                                '</td>' + 
                            '</tr>');
        $('#tbl_location_detail tbody').append(newRow);
        counter++;
    });
});

jQuery(function(){
    var counter = $('.certificate_no_detail').length;
    $('#repeat_certificate_no_detail').click(function(event){
        event.preventDefault();
        var newRow = jQuery('<tr id="certificate_no_detail_'+counter+'_row" class="certificate_no_detail">' + 
                                '<td>' + 
                                    '<select class="form-control" name="fk_certificate_no_type_id[]">' + 
                                        '<option value="">Select Certificate No Type</option>' + 
                                        certificate_no_type_list + 
                                    '</select>' + 
                                '</td>' + 
                                '<td>' + 
                                    '<input type="text" class="form-control" name="certificate_no[]" placeholder="Enter Certificate No..." value="" />' + 
                                '</td>' + 
                                '<td style="text-align: center; vertical-align: middle;">' + 
                                    '<button type="button" id="certificate_no_detail_'+counter+'_row_delete" class="delete_row" onClick="delete_row(this);"><span class="fa trash fa-trash-o"></span></button>' + 
                                '</td>' + 
                            '</tr>');
        $('#tbl_certificate_no_detail tbody').append(newRow);
        counter++;
    });
});

function recognize_image(){
    document.getElementById('transcription').innerText = "(Recognizing...)"

    OCRAD(document.getElementById("pic"), {
        numeric: true
    }, function(text){
        
    })
}

var load_file = function () {
    document.getElementById('nose').innerHTML = '';
    // if(document.getElementById('nose').hasChildNodes()){
    //     document.getElementById('nose').removeChild(img);
    // }
    document.getElementById('transcription').innerText = "";
    document.getElementById('details').value = "";

    var reader = new FileReader();
    reader.onload = function(){
        var img = new Image();
        img.src = reader.result;
        img.onload = function(){
            document.getElementById('nose').innerHTML = '';
            document.getElementById('nose').appendChild(img);
            OCRAD(img, function(text){
                document.getElementById('transcription').className = "done";
                document.getElementById('transcription').innerText = text;
                document.getElementById('details').value = text;
            })
        }

        var result = '';
        img.cropbox({width: 250, height: 500, showControls: 'auto'}).on('cropbox', function(event, result, image){});
    }
    // console.log(document.getElementById('picker').files[0]);
    reader.readAsDataURL(document.getElementById('picker').files[0]);
}

var delete_row = function(elem){
    var id = elem.id;
    id = '#'+id.substr(0,id.lastIndexOf('_'));
    if($(id).length>0){
        $(id).remove();
    }
};

function recognize_image(){
    document.getElementById('transcription').innerText = "(Recognizing...)"

    OCRAD(document.getElementById("pic"), {
        numeric: true
    }, function(text){
        
    })
}

var load_file = function () {
    document.getElementById('nose').innerHTML = '';
    // if(document.getElementById('nose').hasChildNodes()){
    //     document.getElementById('nose').removeChild(img);
    // }
    document.getElementById('transcription').innerText = "";
    document.getElementById('details').value = "";

    var reader = new FileReader();
    reader.onload = function(){
        var img = new Image();
        img.className = 'cropimage';
        img.src = reader.result;
        img.onload = function(){
            document.getElementById('nose').innerHTML = '';
            document.getElementById('nose').appendChild(img);
            OCRAD(img, function(text){
                document.getElementById('transcription').className = "done";
                document.getElementById('transcription').innerText = text;
                document.getElementById('details').value = text;
            })
        }

        window.setTimeout(function(){
            var result = '';
            $('.cropimage').each(function(){
                var image = $(this);
                image.cropbox({width: 250, height: 500, showControls: 'auto'}).on('cropbox', function(event, result, image1){});
            });
        }, 1000);
    }
    // console.log(document.getElementById('picker').files[0]);
    reader.readAsDataURL(document.getElementById('picker').files[0]);
}


//
// Please read scanner.js developer's guide at: http://asprise.com/document-scan-upload-image-browser/ie-chrome-firefox-scanner-docs.html
//

/** Scan and upload in one go */
function scanAndUploadDirectly() {
    scanner.scan(displayServerResponse,
        {
            "output_settings": [
                {
                    "type": "upload",
                    "format": "jpg",
                    "upload_target": {
                        // "url": "http://ec2-52-77-255-84.ap-southeast-1.compute.amazonaws.com/public_notices/public/uploads/upload.php?action=dump",
                        "url": ASSET_PATH + "uploads/upload.php?action=dump",
                        "post_fields": {
                            "sample-field": "Test scan"
                        },
                        "cookies": document.cookie,
                        "headers": [
                            "Referer: " + window.location.href,
                            "User-Agent: " + navigator.userAgent
                        ]
                    }
                }
            ]
        }
    );
}

function displayServerResponse(successful, mesg, response) {
    if(!successful) { // On error
        // document.getElementById('server_response').innerHTML = 'Failed: ' + mesg;
        document.getElementById('server_response').value = 'Failed: ' + mesg;
        return;
    }

    if(successful && mesg != null && mesg.toLowerCase().indexOf('user cancel') >= 0) { // User cancelled.
        // document.getElementById('server_response').innerHTML = 'User cancelled';
        document.getElementById('server_response').value = 'User cancelled';
        return;
    }

    // document.getElementById('server_response').innerHTML = scanner.getUploadResponse(response);

    var scan_response = scanner.getUploadResponse(response);
    document.getElementById('notice_file').value = scan_response;

    var img = new Image();
    img.className = 'cropimage';
    img.src = ASSET_PATH + 'uploads/notices/' + scan_response;
    document.getElementById('nose').innerHTML = '';
    document.getElementById('nose').appendChild(img);

    window.setTimeout(function(){
        OCRAD(img, function(text){
            document.getElementById('transcription').className = "done"
            document.getElementById('transcription').innerText = text;
            document.getElementById('details').value = text;
        })

        var result = '';
        $('.cropimage').each(function(){
            var image = $(this);
            image.cropbox({width: 250, height: 500, showControls: 'auto'}).on('cropbox', function(event, result, image1){});
        });
    }, 1000);
}

/** Scan and upload in one go */
function scanAndUploadDirectly2() {
    scanner.scan(displayServerResponse2,
        {
            "output_settings": [
                {
                    "type": "upload",
                    "format": "jpg",
                    "upload_target": {
                        // "url": "http://ec2-52-77-255-84.ap-southeast-1.compute.amazonaws.com/public_notices/public/uploads/upload.php?action=dump",
                        "url": ASSET_PATH + "uploads/upload2.php?action=dump",
                        "post_fields": {
                            "sample-field": "Test scan"
                        },
                        "cookies": document.cookie,
                        "headers": [
                            "Referer: " + window.location.href,
                            "User-Agent: " + navigator.userAgent
                        ]
                    }
                }
            ]
        }
    );
}

function displayServerResponse2(successful, mesg, response) {
    if(!successful) { // On error
        // document.getElementById('server_response').innerHTML = 'Failed: ' + mesg;
        document.getElementById('server_response').value = 'Failed: ' + mesg;
        return;
    }

    if(successful && mesg != null && mesg.toLowerCase().indexOf('user cancel') >= 0) { // User cancelled.
        // document.getElementById('server_response').innerHTML = 'User cancelled';
        document.getElementById('server_response').value = 'User cancelled';
        return;
    }

    // document.getElementById('server_response').innerHTML = scanner.getUploadResponse(response);

    var scan_response = scanner.getUploadResponse(response);
    document.getElementById('notice_file').value = scan_response;

    var img = new Image();
    img.className = 'cropimage';
    img.src = ASSET_PATH + 'uploads/scans/' + scan_response;
    document.getElementById('nose').innerHTML = '';
    document.getElementById('nose').appendChild(img);

    window.setTimeout(function(){
        OCRAD(img, function(text){
            document.getElementById('transcription').className = "done"
            document.getElementById('transcription').innerText = text;
            document.getElementById('details').value = text;
        })

        var result = '';
        $('.cropimage').each(function(){
            var image = $(this);
            image.cropbox({width: 250, height: 500, showControls: 'auto'}).on('cropbox', function(event, result, image1){});
        });
    }, 1000);
}

function load_file2() {
    // document.getElementById('nose').innerHTML = '';
    // // if(document.getElementById('nose').hasChildNodes()){
    // //     document.getElementById('nose').removeChild(img);
    // // }
    // document.getElementById('transcription').innerText = "";
    // document.getElementById('details').value = "";

    // var reader = new FileReader();
    // reader.onload = function(){
    //     var img = new Image();
    //     // img.src = reader.result;
    //     img.src = document.getElementById('server_response').value;
    //     img.onload = function(){
    //         document.getElementById('nose').innerHTML = '';
    //         document.getElementById('nose').appendChild(img);
    //         OCRAD(img, function(text){
    //             document.getElementById('transcription').className = "done";
    //             document.getElementById('transcription').innerText = text;
    //             document.getElementById('details').value = text;
    //         })
    //     }
    // }
    // reader.readAsDataURL(document.getElementById('picker').files[0]);

    document.getElementById('pic').src=ASSET_PATH + 'uploads/notices/Notice_65.jpg';
    var img = new Image();
    img.src = ASSET_PATH + 'uploads/notices/Notice_65.jpg';

    window.setTimeout(function(){
        OCRAD(img, function(text){
            document.getElementById('transcription').className = "done"
            document.getElementById('transcription').innerText = text;
        })
    }, 1000);
}

$(function(){
    $('.cropimage').each(function(){
        var image = $(this),
        cropwidth = image.attr('cropwidth'),
        cropheight = image.attr('cropheight'),

        results = '';

        // results = image.next('.results' ),
        // x = $('.cropX', results),
        // y = $('.cropY', results),
        // w = $('.cropW', results),
        // h = $('.cropH', results),
        // download = results.next('.download').find('a');

        image.cropbox({width: cropwidth, height: cropheight, showControls: 'auto'}).on('cropbox', function(event, results, img){});

        // image.cropbox({width: cropwidth, height: cropheight, showControls: 'auto'}).on('cropbox', function( event, results, img){
        //     x.text( results.cropX );
        //     y.text( results.cropY );
        //     w.text( results.cropW );
        //     h.text( results.cropH );
        //     download.attr('href', img.getDataURL());
        // });
    });
});

window.onscroll = function() {myFunction()};

function myFunction() {
    if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
        document.getElementById("main").style.top = "10px";
        document.getElementById("main").style.height = "90%";
    } else {
        document.getElementById("main").style.top = "180px";
        document.getElementById("main").style.height = "70%";
    }
}

var selectScanImage = function() {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url:BASE_URL+'notice/get_scan',
        type:'post',
        data: {_token: CSRF_TOKEN, date_of_notice: $('#date_of_notice').val(), fk_newspaper_id: $('#fk_newspaper_id').val(), page_number: $('#page_number').val()},
        datatype:'json',
        success: function(response){
            var data = JSON.parse(response);
            var scan_details = data.rows;
            $("#tbl_scan_details tbody").html(scan_details);
            $('#myModal').modal('toggle');
        },
        error: function(response){
            var r = jQuery.parseJSON(response.responseText);
            console.log("Message: " + r.Message);
            console.log("StackTrace: " + r.StackTrace);
            console.log("ExceptionType: " + r.ExceptionType);
        }
    });
}

var cropScanImage = function(elem) {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var elem_id = elem.id;
    var index = elem_id.substr(elem_id.lastIndexOf('_')+1);
    var elem_val = $('#scan_image_'+index+'_file').val();

    var str_path = ASSET_PATH+'uploads/scans/'+elem_val;

    // console.log(str_path);

    $('#content').html('<div class="container" style="margin: 0px;">' + 
                            '<section class="copy">' + 
                                '<div class="figure-wrapper">' + 
                                    '<figure class="image-container target" style="max-width: 110%; margin-top: 15px;">' + 
                                        '<img id="target_img" src="" alt="DomoKun">' + 
                                        '<figcaption class="image-meta">' + 
                                            '<a id="scan_img" target="_blank" href=""></a>' + 
                                        '</figcaption>' + 
                                    '</figure>' + 
                                '</div>' + 
                            '</section>' + 
                        '</div>');
    

    $('#target_img').attr('src', str_path);
    $('#scan_img').attr('href', str_path);

    $('#myModal').modal('toggle');
    $('#myModal2').modal('toggle');

    var dkrm = new Darkroom('#target_img', {
        // Size options
        minWidth: 100,
        minHeight: 100,
        maxWidth: 850,
        maxHeight: 500,
        ratio: 4/3,
        backgroundColor: '#000',

        // Plugins options
        plugins: {
            //save: false,
            save: {
                callback: function() {
                    this.darkroom.selfDestroy(); // Turn off the bar and cleanup
                    var newImage = dkrm.canvas.toDataURL();

                    // console.log('save crop');
                    $.ajax({
                        url:BASE_URL+'notice/set_scan',
                        type:'post',
                        data: {_token: CSRF_TOKEN, imagedata: newImage},
                        datatype:'json',
                        success: function(response){
                            var data = JSON.parse(response);
                            var imageName = data.imageName;
                            document.getElementById('temp_notice_file').value = imageName;
                            
                            var img = new Image();
                            img.className = 'cropimage';
                            img.src = ASSET_PATH + 'uploads/scans/temp/' + imageName;
                            document.getElementById('nose').innerHTML = '';
                            document.getElementById('nose').appendChild(img);
                            $('#myModal2').modal('toggle');
                        },
                        error: function(response){
                            var r = jQuery.parseJSON(response.responseText);
                            console.log("Message: " + r.Message);
                            console.log("StackTrace: " + r.StackTrace);
                            console.log("ExceptionType: " + r.ExceptionType);
                        }
                    });
                }
            },

            crop: {
                quickCropKey: 67, 
                //key "c",
                //minHeight: 50,
                //minWidth: 50,
                //ratio: 4/3
            }
        },

        // Post initialize script
        initialize: function() {
            var cropPlugin = this.plugins['crop'];
            // cropPlugin.selectZone(170, 25, 300, 300);
            cropPlugin.requireFocus();
        }
    });
}