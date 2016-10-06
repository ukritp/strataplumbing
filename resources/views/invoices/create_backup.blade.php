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
<link href="/css/print.css" rel="stylesheet" type="text/css">
</head>
<body>

@set('client_address', ucwords(strtolower($client->billing_address)).', '.ucwords(strtolower($client->billing_city)).', '.strtoupper($client->billing_province).' '.strtoupper($client->billing_postalcode))

@set('site_address', isset($site) ? ucwords(strtolower($client->billing_address)).', '.ucwords(strtolower($client->billing_city)).', '.strtoupper($client->billing_province).' '.strtoupper($client->billing_postalcode) : $client_address) 

<div class="container">

    <img src="/images/invoice-header.png" class="img-responsive" alt="strataplumbing">

    <div class="row invoice-row-pdf no-gutter">
        <!-- Top area -->
        <div class="row">
            <div class="col-xs-10 col-xs-offset-1">
                <div class="row">
                    <!-- Company, contact info, job description -->
                    <div class="col-xs-12">

                        <div class="row">
                            <div class="col-xs-9">
                                <div class="element">
                                    <span class="blue-header">TO</span>
                                    <div class="blueborder">
                                        @if(isset($client->company_name))
                                            {{$client->company_name.' - '}}
                                        @endif
                                        @if(isset($site))
                                            {{$site->first_name.' '.$site->last_name}}
                                        @else
                                            {{$client->first_name.' '.$client->last_name}}
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="element">
                                    <span class="blue-header">INVOICE #</span>
                                    <div class="blueborder">
                                        {{$job->id+20100}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-9">
                                <div class="element">
                                    <span class="blue-header">ADDRESS</span>
                                    <div class="blueborder">
                                        {{$client_address}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="element">
                                    <span class="blue-header">ESTIMATE #</span>
                                    <div class="blueborder">
                                        -
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-6">
                                <div class="element">
                                    <span class="blue-header">SITE</span>
                                    <div class="blueborder">
                                        {{$site_address}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="element">
                                    <span class="blue-header">DATE</span>
                                    <div class="blueborder">
                                        {{date('M j, Y', strtotime($job->invoiced_at))}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="element">
                            <span class="blue-header">SCOPE OF WORK</span>
                            <div class="blueborder">
                                {{$job->scope_of_works}}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>


        <div class="row invoice-row-pdf">
            <div class="col-xs-10 col-xs-offset-1">
                <!-- Pending Invoices foreach -->
                @set('total',0)
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
                        <tr>
                            <td></td>
                            <td><b>{{count($pendinginvoice->technicians)}} Man with equipment</b></td>
                            <td></td>
                        </tr>
                        @set('first_half_hour',95)
                        @set('additional_hours', $pendinginvoice->total_hours-0.5)
                        @set('man_hour_total', $additional_hours*$pendinginvoice->hourly_rates)
                        <tr>
                            <td></td>
                            <td style="text-indent: 20px;">First 1/2 hour</td>
                            <td class="text-right">$ {{number_format($first_half_hour,2,'.',',')}}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="text-indent: 20px;">Additional hours = {{$additional_hours}} @ {{number_format($pendinginvoice->hourly_rates,2,'.',',')}} /hr</td>
                            <td class="text-right">$ {{number_format($man_hour_total,2,'.',',')}}</td>
                        </tr>
                        @set('other_hours_total',0)
                        <!-- Technician foreach -->
                        @foreach($pendinginvoice->technicians as $technician)
                            @set('flushing_subtotal', $technician->flushing_hours*$technician->flushing_hours_cost)
                            @set('camera_subtotal', $technician->camera_hours*$technician->camera_hours_cost)
                            @set('big_auger_subtotal', $technician->big_auger_hours*$technician->big_auger_hours_cost)
                            @set('sm_md_auger_subtotal', $technician->small_and_medium_auger_hours*$technician->flushing_hosmall_and_medium_auger_hours_costurs_cost)
                            <?php $other_hours_total += $flushing_subtotal+$camera_subtotal+$big_auger_subtotal+$sm_md_auger_subtotal?>
                        @endforeach
                        <tr>
                            <td></td>
                            <td style="text-indent: 20px;">Other hours (flushing, camera, big, medium and small auger)</td>
                            <td class="text-right">$ {{number_format($other_hours_total,2,'.',',')}}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><b>Materials List</b></td>
                            <td></td>
                        </tr>
                        @set('material_total',0)
                        <!-- Materials foreach -->
                        @foreach($pendinginvoice->technicians as $technician)
                            @foreach($technician->materials as $material)
                            <tr>
                                <td></td>
                                <td style="text-indent: 20px;">{{$material->material_quantity.' - '.$material->material_name}}</td>
                                <td class="text-right">$ {{number_format($material->material_quantity*$material->material_cost,2,'.',',')}}</td>
                            </tr>
                            <?php $material_total += $material->material_quantity*$material->material_cost?>
                            @endforeach
                        @endforeach <!-- END Materials foreach -->

                    </tbody>
                </table>
                
                @set('subtotal', $first_half_hour+$man_hour_total+$other_hours_total+$material_total)
                <?php $total += $subtotal ?>
                <div class="row invoice-subtotal">
                    <!-- <div class="col-xs-10">
                        <p class="text-right"><strong>SUB-TOTAL</strong></p>
                    </div>
                    <div class="col-xs-2">
                        <p class="total-cost">$ {{number_format($subtotal,2,'.',',')}}</p>
                    </div> -->
                </div>
                @endforeach <!-- END Pending Invoice foreach -->

            </div>
        </div>
        @if($job->is_trucked)
            @set('truck_overhead',10)
        @else 
            @set('truck_overhead',0)
        @endif
        @set('gst_percentage',0.05)
        @set('gst',$total*$gst_percentage)
        @set('grand_total',$total+$truck_overhead+$gst)
        
        <div class="row invoice-grandtotal-pdf">
            <div class="col-xs-9">
                <p>SUB-TOTAL</p>
                <p>TRUCK OVERHEAD</p>
                <p>GST</p>
                <p>TOTAL</p>
            </div>
            <div class="col-xs-2">
                <p class="total-cost">$ {{number_format($total,2,'.',',')}}</p>
                <p class="total-cost">$ {{number_format($truck_overhead,2,'.',',')}}</p>
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

    <img src="/images/invoice-footer.png" class="img-responsive" alt="strataplumbing">   

    <!-- Print Button on right side of the screen -->
    <div class="print-button hidden-print">
        <a class="btn btn-info btn-block" onclick="javascript:window.print()">Print</a>
        <a class="btn btn-info btn-block" href="javascript:emailCurrentPage()">Email</a>
    </div>

</div> <!-- /.container -->
    
</body>

<script language="javascript">
    function emailCurrentPage(){
        window.location.href="mailto:{{$client->email}}?subject="+document.title+"&body="+escape(window.location.href);
    }
</script>
</html>