$(document).ready(function () {

    // https://github.com/digitalBush/jquery.maskedinput
    // Mask input for phone number
    $("#home_number").mask("(999) 999-9999");
    $("#cell_number").mask("(999) 999-9999");
    $("#work_number").mask("(999) 999-9999");
    $("#fax_number").mask("(999) 999-9999");
    $("#mailing_postalcode").mask("a9a 9a9");
    $("#billing_postalcode").mask("a9a 9a9");

    $("#client-site-form").submit(function(e) {
        // alert("before: "+$("#home-number").val());
        $("#home_number").val( $( "#home_number" ).data( $.mask.dataName )() );
        $("#cell_number").val( $( "#cell_number" ).data( $.mask.dataName )() );
        $("#work_number").val( $( "#work_number" ).data( $.mask.dataName )() );
        $("#fax_number").val( $( "#fax_number" ).data( $.mask.dataName )() );
        $("#mailing_postalcode").val( $( "#mailing_postalcode" ).data( $.mask.dataName )() );

        if($("#mail_to_bill_checkbox").is(":checked")){
            $("#billing_postalcode").val( $( "#mailing_postalcode" ).data( $.mask.dataName )() );
        }else{
            $("#billing_postalcode").val( $( "#billing_postalcode" ).data( $.mask.dataName )() );
        }

        // alert("after: "+$("#home-number").val());
        // e.preventDefault();
    });


});