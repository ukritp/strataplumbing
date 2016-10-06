$(document).ready(function () {
    // Date range validation-----------------------------------------------------
    // set default dates
    var start = new Date();
    // set end date to max one year period:
    var end = new Date(new Date().setYear(start.getFullYear()+1));

    $('#date_from').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
        // startDate : start,
        // endDate   : end
    // update "date_to" defaults whenever "date_from" changes
    }).on('changeDate', function(){
        // set the "date_to" start to not be later than "date_from" ends:
        // $('#date_to').datepicker('setStartDate', new Date($(this).val()));
        var dt = new Date($(this).val());
        dt.setDate(dt.getDate() + 2);
        $("#date_to").datepicker("setStartDate", dt);
    });

    $('#date_to').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
        // startDate : start,
        // endDate   : end
    // update "date_from" defaults whenever "date_to" changes
    }).on('changeDate', function(){
        // set the "date_from" end to not be later than "date_to" starts:
        // $('#date_from').datepicker('setEndDate', new Date($(this).val()));
        var dt = new Date($(this).val());
        dt.setDate(dt.getDate());
        $("#date_from").datepicker("setEndDate", dt);
    });


    //Datepicker -----------------------------
    $('#pendinginvoiced_at').datepicker({
        ignoreReadonly: true,
        todayHighlight:true,
        format: 'yyyy-mm-dd',
        autoclose: true
    });

    $('#invoiced_at').datepicker({
        ignoreReadonly: true,
        todayHighlight:true,
        format: 'yyyy-mm-dd',
        autoclose: true
    });
});