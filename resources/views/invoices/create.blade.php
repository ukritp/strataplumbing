<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<title>Strata Plumbing</title>

{{ Html::style('css/sweetalert.css')}}
{{-- {{ Html::style('https://cdn.jsdelivr.net/sweetalert2/4.0.15/sweetalert2.min.css')}} --}}

<!-- Bootstrap -->
{{ Html::style('css/bootstrap.min.css') }}
{{ Html::style('css/print.css') }}
</head>
<body>

@set('full_name', isset($site) ?  $site->first_name.' '.$site->last_name : $client->first_name.' '.$client->last_name)
@set('client_site_address', ucwords(strtolower($client->mailing_address)).', '.ucwords(strtolower($client->mailing_city)).', '.strtoupper($client->mailing_province).' '.strtoupper($client->mailing_postalcode))
@set('client_billing_address', ucwords(strtolower($client->billing_address)).', '.ucwords(strtolower($client->billing_city)).', '.strtoupper($client->billing_province).' '.strtoupper($client->billing_postalcode))
@set('site_address', isset($site) ? ucwords(strtolower($site->mailing_address)).', '.ucwords(strtolower($site->mailing_city)).', '.strtoupper($site->mailing_province).' '.strtoupper($site->mailing_postalcode) : $client_site_address)
@set('billing_address', isset($site) ? ucwords(strtolower($site->billing_address)).', '.ucwords(strtolower($site->billing_city)).', '.strtoupper($site->billing_province).' '.strtoupper($site->billing_postalcode) : $client_billing_address)
@set('email', isset($site) ?  $site->email : $client->email)

<div class="container">

<div class="row no-gutter main-row" style="width:100%;">
    <div class="col-xs-3 strata-side-logo">

        <div class="strata-logo">
            {{ Html::image('images/strata-logo-circle.png', 'Strataplumbing', array('width'=>'150px'))}}
        </div>
        <div class="side-logo-print">
            {{ Html::image('images/side-curve-no-logo.png')}}
        </div>

    </div>
    <div class="col-xs-9">
    <div class="row main-container">
        <div class="col-xs-12">

        <div class="row row-content no-gutter">
            <div class="col-xs-12 header">
                <div class="col-xs-8 left-header">
                    <p><span>INVOICE #</span> {{$job->id+20100}}</p>
                    <p><span>TO:</span>
                        {{isset($client->company_name) ? $client->company_name.' - ' : ''}}
                        {{$full_name}}
                    </p>
                    <p><span>BILLING ADDRESS:</span> {{$billing_address}}</p>
                    <p><span>SITE ADDRESS:</span> {{$site_address}}</p>
                    <p><span>DATE:</span> {{date('M j, Y', strtotime($job->invoiced_at))}}</p>
                </div>
                <div class="col-xs-4 right-header">
                    <p>#386 - 2242 Kingsway</p>
                    <p>Vancouver, BC V5N 5X6</p>
                    <p>Office: (604) 588 - 8062</p>
                    <p>Dispatch: (604) 588 - 8038</p>
                    <p>info@strataplumbing.com</p>
                    <p class="red">24 HRS EMERGENCY SERVICES</p>
                </div>
            </div>
        </div>

        <div class="row invoice-row-pdf no-gutter">

            <div class="row invoice-row-pdf">
                <div class="col-xs-12">
                    <!-- Pending Invoices foreach -->
                    @set('total',0)
                    @set('labor_total',0)
                    @set('material_total',0)
                    @foreach ($job->pendinginvoices as $index => $pendinginvoice)
                    <br>
                    <table class="table table-invoice">

                        <thead>
                            <th style="width:15%;">Date</th>
                            <th style="width:67%;">Details</th>
                            <th style="width:20%;" class="text-right">Amount</th>
                        </thead>

                        <tbody>
                            <tr>
                                <td style="width:15%;""><b>{{date('M j, Y', mktime(0, 0, 0,$pendinginvoice->month, $pendinginvoice->date, $pendinginvoice->year))}}</b></td>
                                <td style="white-space: pre-line;width:67%;">{{$pendinginvoice->description}}</td>
                                <td style="width:20%;""></td>
                            </tr>

                            <!-- Labor Description Section  ================================================ -->
                            <tr>
                                <td></td>
                                <td><b>
                                @if(!empty($pendinginvoice->labor_description))
                                    {{$pendinginvoice->labor_description}}
                                @else
                                    {{count($pendinginvoice->technicians)}} Man with equipment
                                @endif
                                </b></td>
                                <td></td>
                            </tr>

                            <!-- Labor Cost Section Section  ================================================ -->
                            @set('first_half_hour',0)
                            @set('labor_hours', $pendinginvoice->total_hours)
                            @if($pendinginvoice->first_half_hour)
                                @set('first_half_hour',95)
                                @set('labor_hours', $pendinginvoice->total_hours-0.5)
                            @endif

                            @set('man_hour_total', $labor_hours*$pendinginvoice->hourly_rates )
                            @set('hour_name', 'Total')
                            @if($pendinginvoice->first_half_hour)
                                @set('hour_name', 'Additional')
                                <tr>
                                    <td></td>
                                    <td style="text-indent: 20px;">First 1/2 hour</td>
                                    <td class="text-right">$ {{number_format($first_half_hour,2,'.',',')}}</td>
                                </tr>
                            @endif
                            <tr>
                                <td></td>
                                <td style="text-indent: 20px;">{{$hour_name}} hours = {{$labor_hours}} @ {{number_format($pendinginvoice->hourly_rates,2,'.',',')}} /hr </td>
                                <td class="text-right">$ {{number_format($man_hour_total,2,'.',',')}}</td>
                            </tr>

                            <!-- Other Hours Section  ================================================ -->
                            @set('other_hours_total',0)
                            @foreach($pendinginvoice->technicians as $technician)
                                @set('flushing_subtotal', $technician->flushing_hours*$technician->flushing_hours_cost)
                                @set('camera_subtotal', $technician->camera_hours*$technician->camera_hours_cost)
                                @set('main_line_auger_subtotal', $technician->main_line_auger_hours*$technician->main_line_auger_hours_cost)
                                @set('other_subtotal', $technician->other_hours*$technician->other_hours)
                                <?php $other_hours_total += $flushing_subtotal+$camera_subtotal+$main_line_auger_subtotal+$other_subtotal?>
                            @endforeach
                            @if($other_hours_total!=0)
                            <tr>
                                <td></td>
                                <td style="text-indent: 20px;">Other hours (flushing, camera, main line auger, etc)</td>
                                <td class="text-right">$ {{number_format($other_hours_total,2,'.',',')}}</td>
                            </tr>
                            @endif


                            <!-- Material Section ================================================-->
                            @set('material_subtotal',0)
                            @foreach($pendinginvoice->technicians as $index => $technician)
                                @if(count($technician->materials)>0 && $index==0)
                                    <tr>
                                        <td></td>
                                        <td><b>Materials List</b></td>
                                        <td></td>
                                    </tr>
                                @endif
                                @foreach($technician->materials as $material)
                                <tr>
                                    <td></td>
                                    <td style="text-indent: 20px;">{{$material->material_quantity.' - '.$material->material_name}}</td>
                                    <td class="text-right">$ {{number_format($material->material_quantity*$material->material_cost,2,'.',',')}}</td>
                                </tr>
                                <?php $material_subtotal += $material->material_quantity*$material->material_cost?>
                                @endforeach
                            @endforeach <!-- END Materials foreach -->

                        </tbody>
                    </table>

                    @set('subtotal', $first_half_hour+$man_hour_total+$other_hours_total+$material_subtotal)
                    <?php
                    $material_total += $material_subtotal;
                    $labor_total += $first_half_hour+$man_hour_total;
                    $total += $subtotal;
                    ?>
                    @endforeach <!-- END Pending Invoice foreach -->

                    @set('truck_services_amount',0)
                    @if($job->is_trucked)
                        @set('truck_services_amount',$job->truck_services_amount)
                    @endif
                    @if($truck_services_amount!=0)
                    <div class="row invoice-truck no-gutter">
                        <div class="col-xs-9 col-xs-offset-1 invoice-truck-text">
                            <p>Truck Services</p>
                        </div>
                        <div class="col-xs-2">
                            <p class="total-cost">$ {{number_format($truck_services_amount,2,'.',',')}}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @set('labor_discount', $job->labor_discount/100)
            @set('labor_deduction',0)
            @if($labor_discount!=0)
                @set('labor_deduction', $labor_total*$labor_discount)
            @endif
            @set('material_discount', $job->material_discount/100)
            @set('material_deduction',0)
            @if($material_discount!=0)
                @set('material_deduction', $material_total*$material_discount)
            @endif
            <!-- Price Adjustment -->
            @set('price_adjustment_amount',0)
            @if($job->price_adjustment_amount!=0)
                @set('price_adjustment_amount', $job->price_adjustment_amount)
            @endif
            @set('total_before_gst',$total+$truck_services_amount-$labor_deduction-$material_deduction-$price_adjustment_amount)
            @set('gst_percentage',0.05)
            @set('gst',$total_before_gst*$gst_percentage)
            @set('grand_total',$total_before_gst+$gst)
            <div class="row invoice-grandtotal-pdf">
                <div class="col-xs-9 invoice-grandtotal-pdf-col">
                    <p>SUB-TOTAL</p>
                    @if($labor_deduction!=0)
                    <p>LABOR DISCOUNT - {{$job->labor_discount.' %'}}</p>
                    @endif
                    @if($material_deduction!=0)
                        <p>MATERIAL DISCOUNT - {{$job->material_discount.' %'}}</p>
                    @endif
                    @if($price_adjustment_amount!=0)
                        <p>{{$job->price_adjustment_title}}</p>
                    @endif
                    {{-- <p>TOTAL BEFORE GST</p> --}}
                    <p>GST</p>
                    <p>TOTAL</p>
                </div>
                <div class="col-xs-3 invoice-grandtotal-pdf-col">
                    <p class="total-cost">$ {{number_format($total,2,'.',',')}}</p>
                    @if($labor_deduction!=0)
                        <p class="total-cost total-cost-discount">$ ({{number_format($labor_deduction,2,'.',',')}})</p>
                    @endif
                    @if($material_deduction!=0)
                        <p class="total-cost total-cost-discount">$ ({{number_format($material_deduction,2,'.',',')}})</p>
                    @endif
                    @if($price_adjustment_amount!=0)
                        <p class="total-cost total-cost-discount">$ ({{number_format($price_adjustment_amount,2,'.',',')}})</p>
                    @endif
                    {{-- <p class="total-cost">$ {{number_format($total_before_gst,2,'.',',')}}</p> --}}
                    <p class="total-cost">$ {{number_format($gst,2,'.',',')}}</p>
                    <p class="total-cost">$ {{number_format($grand_total,2,'.',',')}}</p>
                </div>
            </div>

        </div> <!-- END Row invoice-row -->

        <div class="row bottom-text">
            <div class="col-xs-7 bottom-text-left">
                <P>*A monthly late payment charge of 1.5% is applied on unpaid balances.</P>
                <P>*A charge of $25 is applied on payments returned by your financial institution.</P>
                <p class="bottom-text-small">*Please make cheques payable to: Strata Plumbing Drainage & Heating</p>
            </div>
            <div class="col-xs-5 bottom-text-right">
                <p class="bottom-text-large">THANK YOU</p>
                <p class="bottom-text-big">WE APPRECIATE YOUR BUSINESS</p>
            </div>
        </div>

        </div>
    </div> <!-- /.main-container -->

</div>
    <!-- Print Button on right side of the screen -->
    <div class="print-button hidden-print">
        {{-- <a class="btn btn-info btn-block" onclick="javascript:window.print()">Print</a> --}}
        {{-- <a class="btn btn-info btn-block" id="create-pdf">PDF</a> --}}
        <a class="btn btn-info btn-block" target="_blank" id="alink">PDF</a>
        <input type="hidden" id="route" name="route" value="{{route('invoices.pdf',array($job->id,''))}}">
        <input type="hidden" id="email" name="email" value="{{$email}}">
        {{-- <a class="btn btn-info btn-block" href="javascript:emailCurrentPage()">Email</a> --}}
        <input type="hidden" id="email-route" name="route" value="{{route('invoices.email',array($job->id,''))}}">
        <a id="email-link" class="btn btn-info btn-block">Email</a>
    </div>
</div> <!-- /.container -->

</body>
{!! Html::script('js/sweetalert.min.js') !!}
{{-- {!! Html::script('https://cdn.jsdelivr.net/sweetalert2/4.0.15/sweetalert2.min.js') !!} --}}
{!! Html::script('https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js') !!}
@include('sweet::alert')
<script language="javascript">
 $(document).ready(function() {
    // var side_height = $(".header").height()+$(".invoice-row-pdf").height()+$(".invoice-grandtotal-pdf").height()+$(".bottom-text").height();
    var side_height = $(".main-container").height();
    $(".strata-side-logo").css({height: side_height});
    var route = $("#route").val();
    $("#alink").attr("href", route+"/"+side_height);

    var email_route = $("#email-route").val();
    $('#email-link').attr("href", email_route+"/"+side_height);

    // $('#email-link').on('click', function(e){
    //     e.preventDefault();
    //     swal({
    //         title: "Send this invoice to ",
    //         text: $("#email").val(),
    //         type: "info",
    //         showCancelButton: true,
    //         closeOnConfirm: true,
    //         showLoaderOnConfirm: false,
    //     }, function(isConfirm){
    //         if(isConfirm){
    //             alert($('#email-link').attr('href'));
    //             // $.ajax({
    //             //       url: $('#email-link').attr('href'),
    //             //       data: {
    //             //          format: 'json'
    //             //       },
    //             //       error: function() {
    //             //          $('#info').html('<p>An error has occurred</p>');
    //             //       },
    //             //       dataType: 'jsonp',
    //             //       success: function(data) {
    //             //          var $title = $('<h1>').text(data.talks[0].talk_title);
    //             //          var $description = $('<p>').text(data.talks[0].talk_description);
    //             //          $('#info')
    //             //             .append($title)
    //             //             .append($description);
    //             //       },
    //             //       type: 'GET'
    //             //    });

    //             // $('#email-link').trigger('click');
    //         }
    //     });
    // });
});
function emailCurrentPage(){
    // window.location.href="mailto:{{$client->email}}?subject="+document.title+" - Invoice&body="+escape(window.location.href);
    window.location.href="mailto:{{$client->email}}?subject="+document.title+" - Invoice";
}
</script>
</html>