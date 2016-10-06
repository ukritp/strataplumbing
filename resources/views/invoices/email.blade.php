<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8"> <!-- utf-8 works for most cases -->
    <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn't be necessary -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
    <title>Strata Plumbing</title> <!-- The title tag shows in email notifications, like Android 4.4. -->
    <!-- CSS Reset -->
    <style type="text/css">
        /* What it does: Remove spaces around the email design added by some email clients. */
        /* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
        html,
        body {
            margin: 0 auto !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
        }
        /* What it does: Stops email clients resizing small text. */
        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }
        /* What is does: Centers email on Android 4.4 */
        div[style*="margin: 16px 0"] {
            margin:0 !important;
        }
        /* What it does: Stops Outlook from adding extra spacing to tables. */
        table,
        td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }
        /* What it does: Fixes webkit padding issue. Fix for Yahoo mail table alignment bug. Applies table-layout to the first 2 tables then removes for anything nested deeper. */
        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
            margin: 0 auto !important;
        }
        table table table {
            table-layout: auto;
        }
        /* What it does: Uses a better rendering method when resizing images in IE. */
        img {
            -ms-interpolation-mode:bicubic;
        }
        /* What it does: A work-around for iOS meddling in triggered links. */
        .mobile-link--footer a,
        a[x-apple-data-detectors] {
            color:inherit !important;
            text-decoration: underline !important;
        }
    </style>
    <!-- Progressive Enhancements -->
    <style>

        /* What it does: Hover styles for buttons */
        .button-td,
        .button-a {
            transition: all 100ms ease-in;
        }
        .button-td:hover,
        .button-a:hover {
            background: #555555 !important;
            border-color: #555555 !important;
        }
        /* Media Queries */
        @media screen and (max-width: 600px) {

            .email-container {
                width: 100% !important;
                margin: auto !important;
            }

            /* What it does: Forces elements to resize to the full width of their container. Useful for resizing images beyond their max-width. */
            .fluid,
            .fluid-centered {
                max-width: 100% !important;
                height: auto !important;
                margin-left: auto !important;
                margin-right: auto !important;
            }
            /* And center justify these ones. */
            .fluid-centered {
                margin-left: auto !important;
                margin-right: auto !important;
            }

            /* What it does: Forces table cells into full-width rows. */
            .stack-column,
            .stack-column-center {
                display: block !important;
                width: 100% !important;
                max-width: 100% !important;
                direction: ltr !important;
            }
            /* And center justify these ones. */
            .stack-column-center {
                text-align: center !important;
            }

            /* What it does: Generic utility class for centering. Useful for images, buttons, and nested tables. */
            .center-on-narrow {
                text-align: center !important;
                display: block !important;
                margin-left: auto !important;
                margin-right: auto !important;
                float: none !important;
            }
            table.center-on-narrow {
                display: inline-block !important;
            }
        }
        @media only screen and (max-width:480px){
            table{
                font-size:10px;
            }
        }
    </style>
</head>

@set('full_name', isset($site) ?  $site->first_name.' '.$site->last_name : $client->first_name.' '.$client->last_name)
@set('client_site_address', ucwords(strtolower($client->mailing_address)).', '.ucwords(strtolower($client->mailing_city)).', '.strtoupper($client->mailing_province).' '.strtoupper($client->mailing_postalcode))
@set('client_billing_address', ucwords(strtolower($client->billing_address)).', '.ucwords(strtolower($client->billing_city)).', '.strtoupper($client->billing_province).' '.strtoupper($client->billing_postalcode))
@set('site_address', isset($site) ? ucwords(strtolower($site->mailing_address)).', '.ucwords(strtolower($site->mailing_city)).', '.strtoupper($site->mailing_province).' '.strtoupper($site->mailing_postalcode) : $client_site_address)
@set('billing_address', isset($site) ? ucwords(strtolower($site->billing_address)).', '.ucwords(strtolower($site->billing_city)).', '.strtoupper($site->billing_province).' '.strtoupper($site->billing_postalcode) : $client_billing_address)

<!-- ========================================BODY PART======================================== -->
<body bgcolor="#eeeeee" width="100%" style="margin: 0;background-color:#eeeeee !important;">

<table cellspacing="0" cellpadding="0" bordercolor="#eeeeee" border="0" align="center" bgcolor="#ffffff" width="800" style="margin: auto;" class="email-container">
    {{-- <tr>
        <td rowspan="5" width="100" height="100%" valign="top">

        {!! Html::image('images/side-curve-no-logo.png', 'Strata Logo', array('width'=>'100','height'=>'100%','border'=>'0','align'=>'left','style'=>'width:100px;max-width:100px;height:100%;'))!!} --}}

        {{-- {!! Html::image('images/strata-logo-circle.png', 'Strata Logo', array('width'=>'75','height'=>'80','border'=>'0','style'=>'width:75px;height:80px;position:absolute;top:55px;left:35px;'))!!} --}}

       {{--  </td>
    </tr> --}}

    <!-- Hero Image, Flush : BEGIN -->
    <tr>
        <td style="text-align:center;">
            {!! Html::image('images/header-logo-email.png', 'Strata Logo', array('width'=>'800','height'=>'auto','border'=>'0','align'=>'center','style'=>'width:100%;max-width:800px;'))!!}
        </td>
    </tr>
    <!-- Hero Image, Flush : END -->

    <!-- 2 Even Columns : BEGIN -->
    <tr>
        <td align="center" valign="top" style="padding: 10px;">
            <table cellspacing="0" cellpadding="0" border="0" width="100%">
                <tr>
                    <!-- Column : BEGIN -->
                    <td class="stack-column-center" style="width:60%;" valign="top">
                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                            <tr>
                                <td style="font-family: sans-serif; font-size: 12px; mso-height-rule: exactly; line-height: 10px; color: #555555; padding: 0 10px 10px; text-align: left;font-weight: bold;" class="center-on-narrow">
                                    <p><span style="color:#1a83c6;">INVOICE #</span> {{$job->id+20100}}</p>
                                    <p><span style="color:#1a83c6;">TO:</span>
                                        {{isset($client->company_name) ? $client->company_name.' - ' : ''}}
                                        {{$full_name}}
                                    </p>
                                    <p><span style="color:#1a83c6;">BILLING ADDRESS:</span> {{$billing_address}}</p>
                                    <p><span style="color:#1a83c6;">SITE ADDRESS:</span> {{$site_address}}</p>
                                    <p><span style="color:#1a83c6;">DATE:</span> {{date('M j, Y', strtotime($job->invoiced_at))}}</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <!-- Column : END -->
                    <!-- Column : BEGIN -->
                    <td class="stack-column-center" style="width:40%;" valign="top">
                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                            <tr>
                                <td style="font-family: sans-serif; font-size: 12px; mso-height-rule: exactly; line-height: 10px; color: #555555; padding: 0 10px 10px; text-align: right;font-weight: bold;" class="center-on-narrow">
                                    <p>#386 - 2242 Kingsway</p>
                                    <p>Vancouver, BC V5N 5X6</p>
                                    <p>Office: (604) 588 - 8062</p>
                                    <p>Dispatch: (604) 588 - 8038</p>
                                    <p>info@strataplumbing.com</p>
                                    <p style="color:red;">24 HRS EMERGENCY SERVICES</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <!-- Column : END -->
                </tr>
            </table>
        </td>
    </tr>
    <!-- 2 Even Columns : END -->

    <!-- MAIN TECH DETAIL Section ================================================-->
    <tr>
        <td align="center" valign="top" style="padding: 10px 20px; text-align: left; font-family: sans-serif; font-size: 12px; mso-height-rule: exactly; line-height: 12px; color: #555555;">
            <!-- Pending Invoices foreach -->
            @set('total',0)
            @set('labor_total',0)
            @set('material_total',0)
            @foreach ($job->pendinginvoices as $index => $pendinginvoice)
            @if($index != 0)    <br>    @endif
            <table cellspacing="0" cellpadding="0" border="0" width="100%">
                <tr style="background-color:#1a83c6;font-size:12px;font-weight: bold;color: #fff;">
                    <td style="width:15%;padding: 8px;">Date</td>
                    <td style="width:67%;padding: 8px;">Details</td>
                    <td style="width:20%;padding: 8px;text-align:right;">Amount</td>
                </tr>

                <!-- Tech Detail Section  ================================================ -->
                <tr>
                    <td style="padding-top:8px;width:15%;" valign="top"><b>{{date('M j, Y', mktime(0, 0, 0,$pendinginvoice->month, $pendinginvoice->date, $pendinginvoice->year))}}</b></td>
                    <td style="padding-top:8px;white-space:pre-line;width:67%;">{{$pendinginvoice->description}}</td>
                    <td style="padding-top:8px;width:20%;"></td>
                </tr>

                <!-- Labor Description Section  ================================================ -->
                <tr>
                    <td style="padding-top:8px;"></td>
                    <td style="padding-top:8px;"><b>
                    @if(!empty($pendinginvoice->labor_description))
                        {{$pendinginvoice->labor_description}}
                    @else
                        {{count($pendinginvoice->technicians)}} Man with equipment
                    @endif
                    </b></td>
                    <td style="padding-top:8px;"></td>
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
                        <td style="padding-top:8px;"></td>
                        <td style="padding-top:8px;text-indent: 20px;">First 1/2 hour</td>
                        <td style="padding-top:8px;text-align:right;">$ {{number_format($first_half_hour,2,'.',',')}}</td>
                    </tr>
                @endif
                <tr>
                    <td style="padding-top:8px;"></td>
                    <td style="padding-top:8px;text-indent: 20px;">{{$hour_name}} hours = {{$labor_hours}} @ {{number_format($pendinginvoice->hourly_rates,2,'.',',')}} /hr </td>
                    <td style="padding-top:8px;text-align:right;">$ {{number_format($man_hour_total,2,'.',',')}}</td>
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
                    <td style="padding-top:8px;"></td>
                    <td style="padding-top:8px;text-indent:20px;">Other hours (flushing, camera, main line auger, etc)</td>
                    <td style="padding-top:8px;text-align:right;" >$ {{number_format($other_hours_total,2,'.',',')}}</td>
                </tr>
                @endif

                <!-- Material Section ================================================-->
                @set('material_subtotal',0)
                @foreach($pendinginvoice->technicians as $index => $technician)
                    @if(count($technician->materials)>0 && $index==0)
                        <tr>
                            <td style="padding-top:8px;"></td>
                            <td style="padding-top:8px;"><b>Materials List</b></td>
                            <td style="padding-top:8px;"></td>
                        </tr>
                    @endif
                    @foreach($technician->materials as $material)
                    <tr>
                        <td style="padding-top:8px;"></td>
                        <td style="padding-top:8px;text-indent:20px;">{{$material->material_quantity.' - '.$material->material_name}}</td>
                        <td style="padding-top:8px;text-align:right;">$ {{number_format($material->material_quantity*$material->material_cost,2,'.',',')}}</td>
                    </tr>
                    <?php $material_subtotal += $material->material_quantity*$material->material_cost?>
                    @endforeach
                @endforeach <!-- END Materials foreach -->

            </table>
            @set('subtotal', $first_half_hour+$man_hour_total+$other_hours_total+$material_subtotal)
            <?php
            $material_total += $material_subtotal;
            $labor_total += $first_half_hour+$man_hour_total;
            $total += $subtotal;
            ?>
            @endforeach <!-- END Pending Invoice foreach -->

            <!-- Truck service Section ================================================-->
            @set('truck_services_amount',0)
            @if($job->is_trucked)
                @set('truck_services_amount',$job->truck_services_amount)
            @endif
            @if($truck_services_amount!=0)
            <table cellspacing="0" cellpadding="0" border="0" width="100%">
                <tr>
                    <td style="width:15%;padding-top:8px;"></td>
                    <td style="width:67%;padding-top:8px;text-indent:20px;">Truck Services</td>
                    <td style="width:20%;padding-top:8px;text-align:right;">$ {{number_format($truck_services_amount,2,'.',',')}}</td>
                </tr>
            </table>
            @endif

        </td>
    </tr>

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

    <!-- TOTAL Section ================================================-->
    <tr>
        <td align="center" valign="top" style="padding: 30px 20px 50px; font-weight: bold; font-family: sans-serif; font-size: 12px; mso-height-rule: exactly; line-height: 12px; color: #555555;">
            <table cellspacing="0" cellpadding="0" border="0" width="100%">
                <!-- subtotal Section ================================================-->
                <tr>
                    <td style="width:85%;padding-top:8px;text-align:right;">SUB-TOTAL</td>
                    <td style="width:20%;padding-top:8px;text-align:right;">$ {{number_format($total,2,'.',',')}}</td>
                </tr>
                <!-- labor deduction Section ================================================-->
                @if($labor_deduction!=0)
                <tr>
                    <td style="width:85%;padding-top:8px;text-align:right;">LABOR DISCOUNT - {{$job->labor_discount.' %'}}</td>
                    <td style="width:20%;padding-top:8px;text-align:right;">$ ({{number_format($labor_deduction,2,'.',',')}})</td>
                </tr>
                @endif
                <!-- Material deduction Section ================================================-->
                @if($material_deduction!=0)
                <tr>
                    <td style="width:85%;padding-top:8px;text-align:right;">MATERIAL DISCOUNT - {{$job->material_discount.' %'}}</td>
                    <td style="width:20%;padding-top:8px;text-align:right;">$ ({{number_format($material_deduction,2,'.',',')}})</td>
                </tr>
                @endif
                <!-- Price adjustment Section ================================================-->
                @if($price_adjustment_amount!=0)
                <tr>
                    <td style="width:85%;padding-top:8px;text-align:right;">{{$job->price_adjustment_title}}</td>
                    <td style="width:20%;padding-top:8px;text-align:right;">$ ({{number_format($price_adjustment_amount,2,'.',',')}})</td>
                </tr>
                @endif
                <!-- GST Section ================================================-->
                <tr>
                    <td style="width:85%;padding-top:8px;text-align:right;">GST</td>
                    <td style="width:20%;padding-top:8px;text-align:right;">$ {{number_format($gst,2,'.',',')}}</td>
                </tr>
                <!-- Total Section ================================================-->
                <tr>
                    <td style="width:85%;padding-top:8px;text-align:right;">TOTAL</td>
                    <td style="width:20%;padding-top:8px;text-align:right;">$ {{number_format($grand_total,2,'.',',')}}</td>
                </tr>
            </table>
        </td>
    </tr>
    <!-- FOOTER Section ================================================-->
    <tr  style="border-top:1px solid #ddd;">
        <td align="center" valign="top" style="padding: 0px 10px 10px;">
            <table cellspacing="0" cellpadding="0" border="0" width="100%">
                <tr>
                    <!-- Column : BEGIN -->
                    <td class="stack-column-center" style="width:45%;">
                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                            <tr>
                                <td style="font-family: sans-serif; font-size: 9px; mso-height-rule: exactly; line-height: 5px; color: #555555; padding: 0 10px 10px; text-align: left;" class="center-on-narrow">
                                    <P>*A monthly late payment charge of 1.5% is applied on unpaid balances.</P>
                                    <P>*A charge of $25 is applied on payments returned by your financial institution.</P>
                                    <p>*Please make cheques payable to: Strata Plumbing Drainage & Heating</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <!-- Column : END -->
                    <!-- Column : BEGIN -->
                    <td class="stack-column-center"  style="width:55%;">
                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                            <tr>
                                <td style="font-family: sans-serif; font-size: 12px; mso-height-rule: exactly; line-height: 1px; color: #555555; padding: 0 10px 10px; text-align: right;font-weight: 900;color:#1a83c6;" class="center-on-narrow">
                                    <p style="font-size:30px;letter-spacing:5px;">THANK YOU</p>
                                    <p style="font-size:16px;letter-spacing:0px;">WE APPRECIATE YOUR BUSINESS</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <!-- Column : END -->
                </tr>
            </table>
        </td>
    </tr>
    <!-- FOOTER : END -->

</table>

</body>
</html>
