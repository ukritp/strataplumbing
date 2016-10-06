<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<title>Strata Plumbing</title>

<!-- Bootstrap -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<link href="/css/print.css" rel="stylesheet" type="text/css" media="screen">
<link href="/css/print.css" rel="stylesheet" type="text/css" media="print">
<style type="text/css">
    @import url(/css/print.css) print;
</style>
</head>
<body>

@set('client_address', ucwords(strtolower($client->billing_address)).', '.ucwords(strtolower($client->billing_city)).', '.strtoupper($client->billing_province).' '.strtoupper($client->billing_postalcode))

@set('site_address', isset($site) ? ucwords(strtolower($client->billing_address)).', '.ucwords(strtolower($client->billing_city)).', '.strtoupper($client->billing_province).' '.strtoupper($client->billing_postalcode) : $client_address)

<div class="container">

    <div id="header-image">
        <img src="/images/header-logo.png" class="img-responsive" alt="strataplumbing">
    </div>
<div class="main-container">
    <div class="row row-content no-gutter">
        <div class="col-xs-10 col-xs-offset-1 header">
            <div class="col-xs-6 left-header">
                <p><span>TO:</span>

                    @if(isset($client->company_name))
                        {{$client->company_name.' - '}}
                    @endif
                    @if(isset($site))
                        {{$site->first_name.' '.$site->last_name}}
                    @else
                        {{$client->first_name.' '.$client->last_name}}
                    @endif

                </p>

                <p><span>INVOICE #</span> {{$job->id+20100}}</p>
                <p><span>ADDRESS:</span> {{$client_address}}</p>
                <p><span>SITE:</span> {{$site_address}}</p>
                <p><span>DATE:</span> {{date('M j, Y', strtotime($job->invoiced_at))}}</p>
                {{-- <p><span>SCOPE OF WORK:</span> {{$job->scope_of_works}}</p> --}}
            </div>
            <div class="col-xs-6 right-header">
                <p>#386 - 2242 Kingsway</p>
                <p>Vancouver, BC V5N 5X6</p>
                <p>(604) 588 - 8038</p>
                <p>info@strataplumbing.com</p>
                <p class="red">24 HRS EMERGENCY SERVICES</p>
            </div>
        </div>
    </div>

    <div class="row invoice-row-pdf no-gutter">

        <div class="row invoice-row-pdf">
            <div class="col-xs-10 col-xs-offset-1">
                <!-- Pending Invoices foreach -->
                @set('total',0)
                @set('labor_total',0)
                @set('material_total',0)
                @foreach ($job->pendinginvoices as $index => $pendinginvoice)

                <table class="table table-invoice">
                @if($index == 0)
                    <thead>
                        <th>Date</th>
                        <th>Description</th>
                        <th class="text-right">Cost</th>
                    </thead>
                @endif
                    <tbody>
                        <tr>
                            <td style="width:15%;"><b>{{date('M j, Y', mktime(0, 0, 0,$pendinginvoice->month, $pendinginvoice->date, $pendinginvoice->year))}}</b></td>
                            <td style="white-space: pre-line; width:75%;">{{$pendinginvoice->description}}</td>
                            <td style="width:10%;"></td>
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
                        <tr>
                            <td></td>
                            <td style="text-indent: 20px;">Other hours (flushing, camera, main line auger, etc)</td>
                            <td class="text-right">$ {{number_format($other_hours_total,2,'.',',')}}</td>
                        </tr>



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
        @if($job->is_trucked)
            @set('truck_overhead',10)
        @else
            @set('truck_overhead',0)
        @endif
        @set('total_before_gst',$total+$truck_overhead-$labor_deduction-$material_deduction)
        @set('gst_percentage',0.05)
        @set('gst',$total_before_gst*$gst_percentage)
        @set('grand_total',$total_before_gst+$gst)
        <div class="row invoice-grandtotal-pdf">
            <div class="col-xs-9 invoice-grandtotal-pdf-col">
                <p>SUB-TOTAL</p>
                @if($labor_discount!=0)
                <p>LABOR DISCOUNT - {{$job->labor_discount.' %'}}</p>
                @endif
                @if($material_discount!=0)
                    <p>MATERIAL DISCOUNT - {{$job->material_discount.' %'}}</p>
                @endif
                <p>TRUCK OVERHEAD</p>
                <p>TOTAL BEFORE GST</p>
                <p>GST</p>
                <p>TOTAL</p>
            </div>
            <div class="col-xs-2 invoice-grandtotal-pdf-col">
                <p class="total-cost">$ {{number_format($total,2,'.',',')}}</p>
                @if($labor_discount!=0)
                    <p class="total-cost total-cost-discount">$ ({{number_format($labor_deduction,2,'.',',')}})</p>
                @endif
                @if($material_discount!=0)
                    <p class="total-cost total-cost-discount">$ ({{number_format($material_deduction,2,'.',',')}})</p>
                @endif
                <p class="total-cost">$ {{number_format($truck_overhead,2,'.',',')}}</p>
                <p class="total-cost">$ {{number_format($total_before_gst,2,'.',',')}}</p>
                <p class="total-cost">$ {{number_format($gst,2,'.',',')}}</p>
                <p class="total-cost">$ {{number_format($grand_total,2,'.',',')}}</p>
            </div>
        </div>

    </div> <!-- END Row invoice-row -->

    <div class="row bottom-text">
        <div class="col-xs-8 col-xs-offset-2">
            <P>*TERMS & CONDISIONS: PAYMENT UPON RECEIPT OF INVOICE.</P>
            <P>INTEREST CHARGED AT 2% PER MONTH ON OVERDUE ACCOUNTS.</P>
            <br>
            <p class="bottom-text-big">**WE APPRECIATE YOUR BUSINESS**</p>
            <p class="bottom-text-small">Please make cheque payable to: Strata Plumbing Heating & Drainage</p>
        </div>
    </div>

</div>

    <!-- Print Button on right side of the screen -->
    <div class="print-button hidden-print">
        <a class="btn btn-info btn-block" onclick="javascript:window.print()">Print</a>
        <a class="btn btn-info btn-block" href="javascript:emailCurrentPage()">Email</a>
    </div>

    <div id="footer-image">
        <img src="/images/invoice-footer.png" class="img-responsive" alt="strataplumbing">
    </div>
</div> <!-- /.container -->

</body>

<script language="javascript">
    function emailCurrentPage(){
        window.location.href="mailto:{{$client->email}}?subject="+document.title+"&body="+escape(window.location.href);
    }
</script>
</html>