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

var delete_row = function(elem){
    var id = elem.id;
    id = '#'+id.substr(0,id.lastIndexOf('_'));
    if($(id).length>0){
        $(id).remove();
    }
};

// var template = $('#sections:first').clone();

// //define counter
// var sectionsCount = 1;

// //add new section
// $('body').on('click', '#addsection', function() {

//     //increment
//     sectionsCount++;

//     //loop through each input
//     var section = template.clone().find(':input').each(function(){

//         //set id to store the updated section number
//         var newId = this.id + sectionsCount;

//         //update for label
//         $(this).prev().attr('for', newId);

//         //update id
//         this.id = newId;

//     }).end()

//     //inject new section
//     .appendTo('#sections');
//     return false;
// });

// var template1 = $('#apartment:first').clone();

// //define counter
// var sectionsCount = 1;

// //add new section
// $('body').on('click', '#apartment', function() {

//     //increment
//     sectionsCount++;

//     //loop through each input
//     var section = template1.clone().find(':input').each(function(){

//         //set id to store the updated section number
//         var newId = this.id + sectionsCount;

//         //update for label
//         $(this).prev().attr('for', newId);

//         //update id
//         this.id = newId;

//     }).end()

//     //inject new section
//     .appendTo('#apartment');
//     return false;
// });

// var template2 = $('#tasks:first').clone();

// //define counter
// var sectionsCount = 1;

// //add new section
// $('body').on('click', '#tasks', function() {

//     //increment
//     sectionsCount++;

//     //loop through each input
//     var section = template2.clone().find(':input').each(function(){

//         //set id to store the updated section number
//         var newId = this.id + sectionsCount;

//         //update for label
//         $(this).prev().attr('for', newId);

//         //update id
//         this.id = newId;

//     }).end()

//     //inject new section
//     .appendTo('#tasks');
//     return false;
// });