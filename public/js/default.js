$(document).ready(function () {

    // sticky navbar after scroll-----------------------------
    // $(window).bind('scroll', function () {
    //     // console.log($(window).scrollTop());
    //     if ($(window).scrollTop() > $('.thumbnail-logo').outerHeight()) {
    //         $('#main-navbar').addClass('navbar-fixed-top');
    //     } else {
    //         $('#main-navbar').removeClass('navbar-fixed-top');
    //     }
    // });

    // Table tr click link
    $(".table-row td:not(:last-child)").click(function() {
        window.document.location = $(this).parent().data("href");
    });
    $(".table-row th:not(:last-child)").click(function() {
        window.document.location = $(this).parent().data("href");
    });

    // Invoice talbe has no action column at the end
    $(".table-row-no-action th").click(function() {
        window.document.location = $(this).parent().data("href");
    });
    $(".table-row-no-action td").click(function() {
        window.document.location = $(this).parent().data("href");
    });

	// Mailing to Billing if checked -----------------------------
	// http://jsfiddle.net/GaryC123/3gtSn/1/
	// $("#mail_to_bill_checkbox").change(function(){
	//     if($(this).is(":checked")){
	// 		$("[id^='billing_']").each(function(){
	// 			data=$(this).attr("id");
	// 			tmpID = data.split('billing_');
	// 			$(this).val($("#mailing_"+tmpID[1]).val());
 //                $(this).prop('readonly', true);
	// 		})
 //            // $("#billing-address-row").slideUp();
	//     }else{
	// 		$("[id^='billing_']").each(function(){
	// 			$(this).val("");
 //                $(this).prop('readonly', false);
	// 		})
 //            // $("#billing-address-row").slideDown();
 //    	}
	// })
 //    $("#mail_to_client_bill_checkbox").change(function(){
 //        if($(this).is(":checked")){
 //            $("[id^='billing_']").each(function(){
 //                $(this).prop('readonly', true);
 //            })
 //        }else{
 //            $("[id^='billing_']").each(function(){
 //                $(this).prop('readonly', false);
 //            })
 //        }
 //    })

    // Different billing address for client --------------------------------------
    if($('#different_billing_address').val() == 1){
        $("#different_billing_address_chbx").prop( "checked", true );
    }else{
        $(".client-billing-row").hide();
    }
    $("#different_billing_address_chbx").change(function(){
        if($(this).is(":checked")){
            $(".client-billing-row").slideDown();
            $(".client-billing-row :input").attr("data-parsley-required","true");
            $("#different_billing_address").val('1');
        }else{
            $(".client-billing-row :input").attr("data-parsley-required","false");
            $(".client-billing-row :input").val("");
            $(".client-billing-row #billing_province").val("BC");
            $(".client-billing-row").slideUp();
            $("#different_billing_address").val('0');
        }
    })

    // Radio button for billing address when creating site -----------------------
    $("#billing-address-row").hide();
    // same as client's billing address
    $("#radiobox_billing1").change(function(){
        if($(this).is(":checked")){
            $("[id^='billing_']").each(function(){
                $(this).val("");
                $(this).prop('readonly', true);
                $("#billing-address-row").slideUp();
            })
        }
    })
    // same as site mailing address
    $("#radiobox_billing2").change(function(){
        if($(this).is(":checked")){
            $("[id^='billing_']").each(function(){
                data=$(this).attr("id");
                tmpID = data.split('billing_');
                $(this).val($("#mailing_"+tmpID[1]).val());
                $(this).prop('readonly', true);
                $("#billing-address-row").slideUp();
            })
        }
    })
    // input another address
    $("#radiobox_billing3").change(function(){
        if($(this).is(":checked")){
            $("[id^='billing_']").each(function(){
                $(this).val("");
                $(this).prop('readonly', false);
                $("#billing-address-row").slideDown();
            })
        }
    })

    $(".type-estimate").css('color','#477610');

    // toggle for tenant-----------------------------
    if($('#tenant_contact_info').val() != ''){
        $("#tenant_checkbox").prop( "checked", true );
    }else{
        $(".toggle").hide();
    }
    $("#tenant_checkbox").change(function(){
        if($(this).is(":checked")){
            $(".toggle").show();
            // $(".toggle :input").attr("data-parsley-required","true");
        }else{
            // $(".toggle :input").attr("data-parsley-required","false");
            $(".toggle :input").val("");
            $(".toggle").hide();
        }
    })

    // Add/Remove Material-----------------------------
    var counter=0;
    $('#add-material').click(function(){
        counter += 1;
        $('#material-add').prepend(
        '<span><div class="col-xs-6" id="material-row-'+counter+'">' +
            '<fieldset class="form-group">' +
            // '<label for="material_name_'+counter+'">Material Name:</label>'+
            '<input type="text" id="material_name_'+counter+'[]" name="material_name[]" class="form-control" placeholder="Material Name" required maxlength="255">'+
            '</fieldset>' +
        '</div>'+
        '<div class="col-xs-3"  id="material-row-'+counter+'">' +
            '<fieldset class="form-group">' +
            // '<label for="material_quantity_'+counter+'">Quantity:</label>'+
            '<input type="text" id="material_quantity_'+counter+'[]" name="material_quantity[]" class="form-control" placeholder="Quantity" required maxlength="255" data-parsley-type="digits">'+
            '</fieldset>' +
        '</div>'+
        '<div class="col-xs-3"  id="material-row-'+counter+'">' +
            '<fieldset class="form-group">' +
            '<a id="remove-material-'+counter+'" class="btn btn-danger btn-sm btn-block remove-material"><i class="glyphicon glyphicon-remove"></i></a>'+
            '</fieldset>' +
        '</div></span>'
        );
        document.getElementById("material_name_"+counter+"[]").focus();
    });
    $("body").on("click", ".remove-material", function (){
        $(this).closest("span").remove();
    });

    // Add material in pending invoice
    $('.add-revised-material').click(function(){
        counter += 1;
        var tech_id = $(this).attr('data-tech-id');
        //alert(tech_id);
        $('#material-add-'+tech_id).prepend(
        '<span class="material-row-span"><div class="col-xs-5 col-xs-offset-1" id="material-row-'+counter+'">' +
            '<fieldset class="form-group">' +
            '<input type="text" id="material_name_'+counter+'[]" name="material_name_add['+tech_id+'][]" placeholder="Material Name" class="form-control" required maxlength="255">'+
            '</fieldset>' +
        '</div>'+
        '<div class="col-xs-2"  id="material-row-'+counter+'">' +
            '<fieldset class="form-group">' +
            '<input type="text" id="material_quantity_'+counter+'[]" name="material_quantity_add['+tech_id+'][]" placeholder="Quantity" class="form-control" required maxlength="255" data-parsley-type="digits">'+
            '</fieldset>' +
        '</div>'+
        '<div class="col-xs-2"  id="material-row-'+counter+'">' +
            '<fieldset class="form-group">' +
            '<input type="text" id="material_cost_'+counter+'[]" name="material_cost_add['+tech_id+'][]" placeholder="Cost" class="form-control" required maxlength="255">'+
            '</fieldset>' +
        '</div>'+
        '<div class="col-xs-1 off-set-1"  id="material-row-'+counter+'">' +
            '<fieldset class="form-group">' +
            '<a id="remove-material-'+counter+'" class="btn btn-danger btn-sm remove-material-revised"><i class="glyphicon glyphicon-remove"></i></a>'+
            '</fieldset>' +
        '</div></span>'
        );
        document.getElementById("material_name_"+counter+"[]").focus();
    });
    $("body").on("click", ".remove-material-revised", function (){
        $(this).parents(".material-row-span").remove();
    });

    // Add/Remove Material-----------------------------
    var i=0;
    $('#add-estimate-material').click(function(){
        i += 1;
        $('#estimate-material-add').prepend(
        '<span><div class="col-xs-6" id="material-row-'+i+'">' +
            '<fieldset class="form-group">' +
            '<input type="text" id="material_name_'+i+'[]" name="material_name[]" class="form-control" placeholder="Material Name" required maxlength="255">'+
            '</fieldset>' +
        '</div>'+
        '<div class="col-xs-2"  id="material-row-'+i+'">' +
            '<fieldset class="form-group">' +
            '<input type="text" id="material_quantity_'+i+'[]" name="material_quantity[]" class="form-control" placeholder="Quantity" required maxlength="255" data-parsley-type="digits">'+
            '</fieldset>' +
        '</div>'+
        '<div class="col-xs-2"  id="material-row-'+i+'">' +
            '<fieldset class="form-group">' +
            '<input type="text" id="material_cost_'+i+'[]" name="material_cost[]" placeholder="Cost" class="form-control" required maxlength="255">'+
            '</fieldset>' +
        '</div>'+
        '<div class="col-xs-2"  id="material-row-'+i+'">' +
            '<fieldset class="form-group">' +
            '<a id="remove-material-'+i+'" class="btn btn-danger btn-sm btn-block remove-material"><i class="glyphicon glyphicon-remove"></i></a>'+
            '</fieldset>' +
        '</div></span>'
        );
        document.getElementById("material_name_"+i+"[]").focus();
    });
    $("body").on("click", ".remove-material", function (){
        $(this).closest("span").remove();
    });

    // Add/Remove Extra's-----------------------------
    var index=0;
    $('#add-extras').click(function(){
        index += 1;
        $('#extras-add').prepend(
        '<span><div class="col-xs-10" id="extras-row-'+index+'">' +
            '<fieldset class="form-group">' +
            // '<label for="extras_description'+index+'">Description:</label>'+
            // '<input type="text" id="extras_description'+index+'[]" name="extras_description[]" class="form-control" placeholder="Description" required maxlength="255">'+
            '<textarea class="form-control description" id="extras_description'+index+'[]" required="" name="extras_description[]" cols="50" rows="10" placeholder="Description"></textarea>'+
            '</fieldset>' +
        '</div>'+
        '<div class="col-xs-2"  id="extras-row-'+index+'">' +
            '<fieldset class="form-group">' +
            // '<label for="extras_cost'+index+'">Cost: $</label>'+
            '<input type="text" id="extras_cost'+index+'[]" name="extras_cost[]" class="form-control" placeholder="Cost" maxlength="255">'+
            '</fieldset>' +
        // '</div>'+
        // '<div class="col-xs-3"  id="extras-row-'+index+'">' +
            '<fieldset class="form-group">' +
            '<a id="remove-extras-'+index+'" class="btn btn-danger btn-sm btn-block remove-extras"><i class="glyphicon glyphicon-remove"></i></a>'+
            '</fieldset>' +
        '</div></span>'
        );
        document.getElementById("extras_description"+index+"[]").focus();
    });
    $("body").on("click", ".remove-extras", function (){
        $(this).closest("span").remove();
    });

    // Equipment left on site checkbox to hidden input-----------------------------
    $("#equipment_left_on_site_chbx").change(function(){
        if($(this).is(":checked")){
            $("#equipment_left_on_site").val('1');
            $("#equipment_name").removeAttr('disabled');
            $("#equipment_name").attr("required","");
        }else{
            $("#equipment_left_on_site").val('0');
            $("#equipment_name").val('');
            $("#equipment_name").removeAttr('required');
            $("#equipment_name").attr("disabled","disabled");

        }
    })

    // Equipment left on site checkbox to hidden input on revised page-----------------------------
    $(".equipment_left_on_site_revised_chbx").change(function(){
        var isChecked = this.checked;
        if(isChecked) {
            $(this).parents(".equipment-left-div").find(".equipment_left_on_site").val('1');
            $(this).parents(".equipment-left-div").find(".equipment_name").prop("disabled",false);
        } else {
            $(this).parents(".equipment-left-div").find(".equipment_left_on_site").val('0');
            $(this).parents(".equipment-left-div").find(".equipment_name").prop("disabled",true);
            $(this).parents(".equipment-left-div").find(".equipment_name").val('');
        }
    })

    // Add Hyphen point on the Tech detail area when press enter-----------------------------
    $(".tech_details").focus(function() {
        if(document.getElementById('tech_details').value === ''){
            document.getElementById('tech_details').value +='- ';
        }
    });
    $(".tech_details").keyup(function(event){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
            document.getElementById('tech_details').value +='- ';
        }
        var txtval = document.getElementById('tech_details').value;
        if(txtval.substr(txtval.length - 1) == '\n'){
            document.getElementById('tech_details').value = txtval.substring(0,txtval.length - 1);
        }
    });

    // Add Hyphen point on the Description area when press enter-----------------------------
    // $(".description").focus(function() {
    //     if(document.getElementById('description').value === ''){
    //         document.getElementById('description').value +='- ';
    //     }
    // });
    // $(".description").keyup(function(event){
    //     var keycode = (event.keyCode ? event.keyCode : event.which);
    //     if(keycode == '13'){
    //         document.getElementById('description').value +='- ';
    //     }
    //     var txtval = document.getElementById('description').value;
    //     if(txtval.substr(txtval.length - 1) == '\n'){
    //         document.getElementById('description').value = txtval.substring(0,txtval.length - 1);
    //     }
    // });

    // Truck Overhead-----------------------------
    $("#is_trucked_chbx").change(function(){
        if($(this).is(":checked")){
            $("#is_trucked").val('1');
            $("#truck_services_amount").removeAttr('disabled');
            $("#truck_services_amount").attr("required","");
            document.getElementById("truck_services_amount").focus();
        }else{
            $("#is_trucked").val('0');
            $("#truck_services_amount").val('');
            $("#truck_services_amount").removeAttr('required');
            $("#truck_services_amount").attr("disabled","disabled");
        }
    })

    // First 1/2 Hour-----------------------------
    $("#seperate_first_half_hour_chbx").change(function(){
        if($(this).is(":checked")){
            // put 1 in hidden field
            $("#seperate_first_half_hour").val('1');
            // remove disable on the mount txtbx
            $("#first_half_hour_amount").removeAttr('disabled');
            $("#first_half_hour_amount").attr("required","");
            document.getElementById("first_half_hour_amount").focus();
            // uncheck the 1 hour chbx and put 0 in its hidden field
            $("#seperate_first_one_hour_chbx").prop( "checked", false );
            $("#seperate_first_one_hour").val('0');
            // disabled the 1 hour txtbx and its value
            $("#first_one_hour_amount").val('');
            $("#first_one_hour_amount").attr("disabled","disabled");
        }else{
            $("#seperate_first_half_hour").val('0');
            $("#first_half_hour_amount").val('');
            $("#first_half_hour_amount").removeAttr('required');
            $("#first_half_hour_amount").attr("disabled","disabled");

        }
    })

    // First 1 Hour-----------------------------
    $("#seperate_first_one_hour_chbx").change(function(){
        if($(this).is(":checked")){
            $("#seperate_first_one_hour").val('1');
            $("#first_one_hour_amount").removeAttr('disabled');
            $("#first_one_hour_amount").attr("required","");
            document.getElementById("first_one_hour_amount").focus();

            $("#seperate_first_half_hour_chbx").prop( "checked", false );
            $("#seperate_first_half_hour").val('0');

            $("#first_half_hour_amount").val('');
            $("#first_half_hour_amount").attr("disabled","disabled");

        }else{
            $("#seperate_first_one_hour").val('0');
            $("#first_one_hour_amount").val('');
            $("#first_one_hour_amount").removeAttr('required');
            $("#first_one_hour_amount").attr("disabled","disabled");

        }
    })
    if ( $('.tech-update-btn').length ){
        $('.tech-update-btn').on('click', function(){
            $('#tech-update-form').submit();
        });
    }
    // Confirm cancel-----------------------------
    cancel_confirmation_modal.init();

    // Confirm delete-----------------------------
    delete_confirmation_modal.init();

    // Add/Remove Contact-----------------------------
    contact_add_row.init();

});

/* Confirm delete function: https://paulund.co.uk/add-delete-confirmation-to-form */
var delete_confirmation_modal =
{
    init: function()
    {
        $('.confirm-delete-modal').on('click', function(e){
            if($(this).closest('form').attr('data-submit') == "true")
            {
                $(this).closest('form').removeAttr('data-submit');
                $('.modal-delete').closest('.modal').removeClass('modal-show');
                return true;
            } else {
                $('#modal-1').addClass('modal-show');
                return false;
            }
        });

        $('.modal-delete').on('click', function(){
            $(this).closest('.modal').prev('form').attr('data-submit', 'true');
            $('.confirm-delete-modal').trigger('click');
        });

        $('.modal-delete-cancel').on('click', function(){
            $(this).closest('.modal').removeClass('modal-show');
        });
    }
}

var cancel_confirmation_modal =
{
    init: function()
    {
        $('.confirm-cancel-modal').on('click', function(e){

            if($(this).attr('data-link') == "true")
            {
                $(this).removeAttr('data-link');
                $('.modal-yes').closest('.modal').removeClass('modal-show');
                window.location.href = $(this).attr('data-href');
            } else {
                $('#modal-1').addClass('modal-show');
            }
        });

        $('.modal-yes').on('click', function(){
            $('.confirm-cancel-modal').attr('data-link', 'true');
            $('.confirm-cancel-modal').trigger('click');
        });

        $('.modal-no').on('click', function(){
            $(this).closest('.modal').removeClass('modal-show');

            // to stop Form from submitting
            return false;
        });
    }
}


// ADD/REMOVE CONTACT
var contact_add_row =
{
    init: function()
    {
        var counter = 0;
        var tabindex = Number($('#billing_postalcode').attr('tabindex'));
        if( $('.remove-contact').length > 0 ){
            var tabindex = Number($('.remove-contact:last-child').attr('tabindex'));
        }
        $('#add-contact').click(function(){
            // alert(tabindex);
            $('#contact-add').prepend(
            '<span class="contact-span">'+
                // Company Name
                '<div class="col-xs-12">'+
                    '<fieldset class="form-group">' +
                        '<input type="text" id="company_name'+counter+'" name="company_name[]" class="form-control" placeholder="Company Name"  maxlength="255" tabindex="'+ (tabindex += 1) +'">'+
                    '</fieldset>' +
                '</div>'+
                // First name + Last name
                '<div class="col-xs-6">'+
                    '<fieldset class="form-group">' +
                        '<input type="text" id="first_name'+counter+'" name="first_name[]" class="form-control" placeholder="First Name" required maxlength="255" tabindex="'+ (tabindex += 1) +'">'+
                    '</fieldset>' +
                '</div>'+
                '<div class="col-xs-6">'+
                    '<fieldset class="form-group">' +
                        '<input type="text" id="last_name'+counter+'" name="last_name[]" class="form-control" placeholder="Last Name" maxlength="255" tabindex="'+ (tabindex += 1) +'">'+
                    '</fieldset>' +
                '</div>'+
                // Title
                '<div class="col-xs-12">'+
                    '<fieldset class="form-group">' +
                        '<input type="text" id="title'+counter+'" name="title[]" class="form-control" placeholder="Title"  maxlength="255" tabindex="'+ (tabindex += 1) +'">'+
                    '</fieldset>' +
                '</div>'+
                // All numbers
                '<div class="col-xs-3">'+
                    '<fieldset class="form-group">' +
                        '<input type="text" id="home_number'+counter+'" name="home_number[]" class="form-control home_number" placeholder="Home Number" tabindex="'+ (tabindex += 1) +'">'+
                    '</fieldset>' +
                '</div>'+
                '<div class="col-xs-3">'+
                    '<fieldset class="form-group">' +
                        '<input type="text" id="work_number'+counter+'" name="work_number[]" class="form-control work_number" placeholder="Work Number" tabindex="'+ (tabindex += 1) +'">'+
                    '</fieldset>' +
                '</div>'+
                '<div class="col-xs-3">'+
                    '<fieldset class="form-group">' +
                        '<input type="text" id="cell_number'+counter+'" name="cell_number[]" class="form-control cell_number" placeholder="Cell Number" tabindex="'+ (tabindex += 1) +'">'+
                    '</fieldset>' +
                '</div>'+
                '<div class="col-xs-3">'+
                    '<fieldset class="form-group">' +
                        '<input type="text" id="fax_number'+counter+'" name="fax_number[]" class="form-control fax_number" placeholder="Fax Number" tabindex="'+ (tabindex += 1) +'">'+
                    '</fieldset>' +
                '</div>'+

                // Email + Alternate email
                '<div class="col-xs-5">'+
                    '<fieldset class="form-group">' +
                        '<input type="text" id="email'+counter+'" name="email[]" class="form-control" placeholder="Email" maxlength="255" data-parsley-type="email" tabindex="'+ (tabindex += 1) +'">'+
                    '</fieldset>' +
                '</div>'+
                '<div class="col-xs-5">'+
                    '<fieldset class="form-group">' +
                        '<input type="text" id="alternate_email'+counter+'" name="alternate_email[]" class="form-control" placeholder="Altername Email" maxlength="255" data-parsley-type="email" tabindex="'+ (tabindex += 1) +'">'+
                    '</fieldset>' +
                '</div>'+
                '<div class="col-xs-2">'+
                    '<fieldset class="form-group">' +
                        '<a id="remove-contact-'+counter+'" class="btn btn-danger btn-sm btn-block remove-contact" tabindex="'+ (tabindex += 1) +'"><i class="glyphicon glyphicon-remove"></i></a>'+
                    '</fieldset>' +
                '</div>'+
                // '<div class="col-xs-12"><hr></div>'+
            '</span>'
            );
            $("#home_number"+counter).mask("(999) 999-9999");
            $("#cell_number"+counter).mask("(999) 999-9999");
            $("#work_number"+counter).mask("(999) 999-9999");
            $("#fax_number"+counter).mask("(999) 999-9999");
            document.getElementById("first_name"+counter).focus();
            $('#property_note').attr('tabindex',tabindex += 1);
            $('#site-submit').attr('tabindex',tabindex += 1);
            $('#site-cancel').attr('tabindex',tabindex += 1);
            counter += 1;
        });
        // remove contact
        $("body").on("click", ".remove-contact", function (){
            $(this).closest("span").remove();
        });
    }
}
