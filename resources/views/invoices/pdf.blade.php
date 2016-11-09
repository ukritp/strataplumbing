<!DOCTYPE html>
<html lang="en">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Strata Plumbing</title>

<!-- SITE5 IS GOOD WITH USING URL() -->
{{-- <link type="text/css" media="all" rel="stylesheet" href="{{ url('css/bootstrap.min.css') }}"> --}}
{{-- <link type="text/css" media="all" rel="stylesheet" href="{{ url('css/pdf.css') }}"> --}}


<!-- SITEGROUND MUST BE ABSOLUTE PATH, CANNOTE USE OTHERS AT ALL -->
<link rel="stylesheet" href="/home/stratapl/public_html/css/bootstrap.min.css">
<link rel="stylesheet" href="/home/stratapl/public_html/css/pdf.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato" >

<!-- localhost must also be absolute path, or put it in here, bootstrap is good with external source link -->
{{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" > --}}
{{-- <style type="text/css">

</style> --}}
</head>

<body>
<?php
$shown_site_address_1 = ucwords(strtolower($client->mailing_address));
$shown_site_address_2 = ucwords(strtolower($client->mailing_city)).' '.
                        strtoupper($client->mailing_province).' '.
                        strtoupper($client->mailing_postalcode);

$shown_billing_address_1 = ucwords(strtolower($client->billing_address));
$shown_billing_address_2 = ucwords(strtolower($client->billing_city)).' '.
                           strtoupper($client->billing_province).' '.
                           strtoupper($client->billing_postalcode);

$full_name = $client->first_name.' '.$client->last_name;
$email     = $client->email;

$issued_date = date('M j, Y', strtotime($job->invoiced_at));

// if($job->is_estimate){
//     $issued_date = date('M j', strtotime($job->estimates->first()->invoiced_from)).' - '.date('M j', strtotime($job->estimates->first()->invoiced_to));
//     $issued_date .= ', '.date('Y', strtotime($job->estimates->first()->invoiced_from));
// }

if(isset($site)){

    if(!empty($site->billing_address)){
        if(count($site->contacts)>0){
            $full_name = $site->contacts->first()->first_name.' '.$site->contacts->first()->last_name;
            $email     = $site->contacts->first()->email;
        }
        $shown_billing_address_1 = ucwords(strtolower($site->billing_address));
        $shown_billing_address_2 = ucwords(strtolower($site->billing_city)).' '.
                                   strtoupper($site->billing_province).' '.
                                   strtoupper($site->billing_postalcode);
    }

    $shown_site_address_1 = ucwords(strtolower($site->mailing_address));
    $shown_site_address_2 = ucwords(strtolower($site->mailing_city)).' '.
                            strtoupper($site->mailing_province).' '.
                            strtoupper($site->mailing_postalcode);

}
?>

<div class="container " id="container">

<div class="row no-gutter">
    <!-- LEFT LOGO & CURLY SIDE BAR -->
    <div class="col-xs-3 strata-side-logo " id="strata-side-logo" style="height:<?php echo $set_height.'px'?> !important;">
        {{-- {{ Html::image('images/side-curve-no-logo.png', 'Strataplumbing')}} --}}
        {{-- <img src="/images/side-curve-no-logo.png"> --}}
    </div> <!-- ./END - LEFT LOGO & CURLY SIDE BAR -->

    <!-- RIGHT AREA -->
    <div class="col-xs-9" id="invoice-col">

        <!-- HEADER -->
        <div class="row header">
            <div class="col-xs-12 header">
                <div class="col-xs-8 left-header">
                <div class="row">
                    <div class="col-xs-3">
                        <p><span>INVOICE#</span></p>
                    </div>
                    <div class="col-xs-9">
                        <p>{{$job->id+20100}}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-3">
                        <p><span>TO:</span></p>
                    </div>
                    <div class="col-xs-9">
                        <p>
                        @if(!empty($client->strata_plan_number))
                            {{'Strata Plan '.$client->strata_plan_number}}
                            <br>
                        @endif
                        {{!empty($client->company_name) ? $client->company_name.' - ' : ''}}
                        {{$full_name}}
                    </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-3">
                        <p><span>BILLING<br>ADDRESS:</span>
                    </div>
                    <div class="col-xs-9">
                        {{$shown_billing_address_1}}
                        <br>
                        {{$shown_billing_address_2}}
                    </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-3">
                        <p><span>SITE<br>ADDRESS:</span>
                    </div>
                    <div class="col-xs-9">
                        {{$shown_site_address_1}}
                        <br>
                        {{$shown_site_address_2}}
                    </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-3">
                        <p><span>DATE:</span></p>
                    </div>
                    <div class="col-xs-9">
                        <p>{{$issued_date}}</p>
                    </p>
                    </div>
                </div>
                </div>
            <div class="col-xs-4 right-header">
                <p>#386 - 2242 Kingsway</p>
                <p>Vancouver, BC V5N 5X6</p>
                <p>Office: (604) 588 - 8062</p>
                <p>Dispatch: (604) 588 - 8038</p>
                <p>info@strataplumbing.com</p>
                <p class="red">24 HR EMERGENCY SERVICES</p>
            </div>
        </div> <!-- ./ END - HEADER -->

        <!-- TABLE INVOICE -->
        <div class="row" >
            <div class="col-xs-12">

                <!-- Pending Invoices foreach -->
                @set('total',0)
                @set('labor_total',0)
                @set('material_total',0)

                @if(!$job->is_estimate)

                    @foreach ($job->pendinginvoices as $index => $pendinginvoice)

                    <table class="table table-condensed table-invoice ">

                        <thead>
                            <th style="width:15%;">Date</th>
                            <th style="width:67%;">Details</th>
                            <th style="width:20%;" class="text-right">Amount</th>
                        </thead>
                        <tbody>
                            <tr class="tr-first">
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
                            @set('first_one_hour',0)
                            @set('labor_hours', $pendinginvoice->total_hours)
                            @if($pendinginvoice->first_half_hour)
                                @set('first_half_hour',$pendinginvoice->first_half_hour_amount)
                                @set('labor_hours', $pendinginvoice->total_hours-0.5)
                            @endif
                            @if($pendinginvoice->first_one_hour)
                                @set('first_one_hour',$pendinginvoice->first_one_hour_amount)
                                @set('labor_hours', $pendinginvoice->total_hours-1)
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
                                <?php $other_hours_total += $flushing_subtotal+$camera_subtotal+$main_line_auger_subtotal+$other_subtotal;?>
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
                                <?php $material_subtotal += $material->material_quantity*$material->material_cost;?>
                                @endforeach
                            @endforeach <!-- END Materials foreach -->

                        </tbody>
                    </table>
                    @set('subtotal', $first_half_hour+$first_one_hour+$man_hour_total+$other_hours_total+$material_subtotal)
                    <?php
                    $material_total += $material_subtotal;
                    $labor_total += $first_half_hour+$first_one_hour+$man_hour_total;
                    $total += $subtotal;
                    ?>
                    @endforeach <!-- END - Pending Invoice foreach -->

                {{-- if esitmate job type --}}
                @else

                    <table class="table table-invoice">
                        <thead>
                            <th style="width:15%;">Date</th>
                            <th style="width:67%;">Details</th>
                            <th style="width:20%;" class="text-right">Amount</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="width:15%;">
                                <b>
                                {{date('M j', strtotime($job->estimates->first()->invoiced_from))}}
                                -
                                {{date('M j', strtotime($job->estimates->first()->invoiced_to))}}
                                </b>
                                </td>
                                <td style="white-space: pre-line; width:67%;">{{$job->estimates->first()->description}}</td>
                                @set('labor_total',$job->estimates->first()->cost)
                                <td class="text-right" style="width:20%;">$ {{number_format($job->estimates->first()->cost,2,'.',',')}}</td>
                            </tr>

                            <!-- Extra's Section  ================================================ -->
                            <tr>
                                <td></td>
                                <td><b>Extra's</b></td>
                                <td></td>
                            </tr>
                            @set('extras_total',0)
                            @forelse($job->estimates->first()->extras_table as $extra)
                                <tr>
                                    <td></td>
                                    <td style="white-space: pre-line; width:67%;text-indent: 20px;">- {{$extra->extras_description}}</td>
                                    <td class="text-right" style="width:20%;">
                                        {{(!empty($extra->extras_cost))? '$ '.number_format($extra->extras_cost,2,'.',','):''}}
                                    </td>
                                </tr>
                                <?php
                                $extras_total += $extra->extras_cost;
                                ?>
                            @empty
                            @endforelse

                            <!-- Material Section  ================================================ -->
                            <tr>
                                <td></td>
                                <td><b>Materials</b></td>
                                <td></td>
                            </tr>
                            @set('material_total',0)
                            @forelse($job->estimates->first()->materials as $material)
                                <tr>
                                    <td></td>
                                    <td style="width:67%;text-indent: 20px;">{{$material->material_quantity.' x '.$material->material_name}}</td>
                                    @set('total', number_format($material->material_quantity*$material->material_cost,2,'.',','))
                                    <td class="text-right" style="width:20%;">{{($total < 0)? '$ ('.$total.')' : '$ '.$total}}</td>
                                </tr>
                                <?php
                                $material_total += $material->material_quantity*$material->material_cost;;
                                ?>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                    <?php
                    // echo $estimate_subtotal.'<br>';
                    // echo $extras_subtotal.'<br>';
                    // echo $material_subtotal.'<br>';
                    $total = $labor_total + $extras_total + $material_total;
                    // echo $total;
                    ?>

                @endif {{-- END if esitmate job type --}}

                <!-- TRUCK SERVICE -->
                @set('truck_services_amount',0)
                @if($job->is_trucked)
                    @set('truck_services_amount',$job->truck_services_amount)
                @endif
                @if($truck_services_amount!=0)
                <div class="row invoice-truck ">
                    <div class="col-xs-10 invoice-truck-text ">
                        <p style="text-indent: 25px;">Truck Services</p>
                    </div>
                    <div class="col-xs-2 ">
                        <p class="total-cost">$ {{number_format($truck_services_amount,2,'.',',')}}</p>
                    </div>
                </div>
                @endif <!-- ./ END - TRUCK SERVICE -->
                <?php $total = $total + $truck_services_amount; ?>
            </div>
        </div> <!-- ./ END - TABLE INVOICE -->

        <!-- TOTAL AREA -->
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
            @if($job->price_adjustment_type ==0)
                @set('price_adjustment_amount', $job->price_adjustment_amount)
            @else
                @set('price_adjustment_amount', $total*($job->price_adjustment_amount)/100)
            @endif
        @endif
        @set('total_before_gst',$total-$labor_deduction-$material_deduction-$price_adjustment_amount)
        @set('gst_percentage',0.05)
        @set('gst',$total_before_gst*$gst_percentage)
        @set('grand_total',$total_before_gst+$gst)
        <div class="row invoice-grandtotal-pdf">
            <div class="col-xs-10 ">
                <p>SUB-TOTAL</p>
                @if($labor_deduction!=0)
                <p>LABOR DISCOUNT - {{$job->labor_discount.' %'}}</p>
                @endif
                @if($material_deduction!=0)
                    <p>MATERIAL DISCOUNT - {{$job->material_discount.' %'}}</p>
                @endif
                @if($price_adjustment_amount!=0)
                    <p>
                    {{$job->price_adjustment_title}}
                    @if($job->price_adjustment_type == 1)
                        {{'- '.$job->price_adjustment_amount.' %'}}
                    @endif
                    </p>
                @endif
                <p>GST</p>
                <p>TOTAL</p>
            </div>
            <div class="col-xs-2 ">
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
                <p class="total-cost">$ {{number_format($gst,2,'.',',')}}</p>
                <p class="total-cost">$ {{number_format($grand_total,2,'.',',')}}</p>
            </div>
        </div> <!-- ./END - TOTAL AREA -->

        <!-- BOTTOM TEXT -->
        <div class="row bottom-text">
            {{-- <div class="col-xs-8 bottom-text-left">
                <P>*A monthly late payment charge of 1.5% is applied on unpaid balances.</P>
                <P>*A charge of $25 is applied on payments returned by your financial institution.</P>
                <p>*Please make cheques payable to: Strata Plumbing Drainage & Heating</p>
            </div>
            <div class="col-xs-4 bottom-text-right">
                <p class="bottom-text-large">THANK YOU</p>
                <p class="bottom-text-big">WE APPRECIATE YOUR BUSINESS</p>
            </div> --}}

            <div class="col-xs-12">
                <P class="bottom-text-small">*A monthly late payment charge of 1.5% is applied on unpaid balances.</P>
                <P class="bottom-text-small">*A charge of $25 is applied on payments returned by your financial institution.</P>

                <p class="bottom-text-large">THANK YOU</p>
                <p class="bottom-text-big">WE APPRECIATE YOUR BUSINESS</p>
                <p class="bottom-text-big">*Please make cheques payable to : Strata Plumbing Drainage & Heating*</p>
            </div>
        </div> <!-- ./ END - BOTTOM TEXT -->


    </div> <!-- ./ END - RIGHT AREA -->

</div> <!-- ./ END - row -->
</div> <!-- ./ END - container -->

</body>

</html>