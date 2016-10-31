@extends('main')

@section('title', '| View Invoice')

@section('stylesheets')
    {!! Html::style('css/parsley.css') !!}
    {!! Html::style('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/css/bootstrap-datepicker.min.css') !!}
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <h1 class="page_title"> INVOICE SUMMARY </h1>
            @if($job->approval_status == 'pending')
                <h3 style="text-align: center; color: red;">Pending for project manager approval</h3>
            @elseif($job->approval_status == 'approved')
                <h3 style="text-align: center; color: green;">Project manager approved this invoice</h3>
            @elseif($job->approval_status == 'declined')
                <h3 style="text-align: center; color: red;">Project manager declined this invoice</h3>
            @endif

            <h3 style="text-align: center; color: blue;">(Scroll down to add comments and finalize Approval Request)</h3>
        </div>
    </div>
    <br>
    <div class="row">
        <!-- Contact info -->
        <div class="col-md-12">
            <div class="jumbotron">
                @if(isset($contact->company_name))
                    <h2>Company: {{$contact->company_name}}</h2>
                @elseif(isset($contact->client->company_name))
                    <h2>Company: {{$contact->client->company_name}}</h2>
                @endif
                <h3>Contact: {{$contact->first_name.' '.$contact->last_name}}</h3>
                @if(!empty($contact->relationship))<p class="lead"><strong>Relationship:</strong> {{$contact->relationship}}</p>@endif
                <p class="lead"><strong>Address:</strong> {{
                    ucwords(strtolower($contact->mailing_address)).', '.
                    ucwords(strtolower($contact->mailing_city)).', '.
                    strtoupper($contact->mailing_province).' '.
                    strtoupper($contact->mailing_postalcode)
                }}
                </p>
                <p class="lead"><strong>Billing Address:</strong> {{
                    ucwords(strtolower($contact->billing_address)).', '.
                    ucwords(strtolower($contact->billing_city)).', '.
                    strtoupper($contact->billing_province).' '.
                    strtoupper($contact->billing_postalcode)
                }}
                </p>
                <p class="lead"><strong>Email:</strong><br>{{$contact->email}}</p>
                <p class="lead"><strong>Project Manager:</strong> {{$job->project_manager}}</p>
                @set('job_type', ($job->is_estimate)? 'estimate' : 'regular')
                <p class="lead job-type type-{{$job_type}}"><strong>Job Type: {{$job_type}}</strong></p>
                <p class="lead paragraph-wrap"><strong>Scope Of Works:</strong><br>{{$job->scope_of_works}}</p>
                <p class="lead lead-status"><strong>Status:</strong> <span>{{($job->status) ? 'Completed' : 'Pending'}}</span></p>
                <p class="lead"><strong>Quoted Rate:</strong>{{(!empty($job->quoted_rate)) ? $job->quoted_rate : '-'}}</p>
                {{-- <p class="lead"><strong>Days working for this job:</strong> {{count($job->techniciansGroupByDateCount)}}</p>
                <p class="lead"><strong>Days added to this invoice:</strong> {{count($job->pendinginvoices)}}</p>
                <p class="lead"><strong>Days added missing:</strong> {{count($job->techniciansGroupByDateCount)-count($job->pendinginvoices)}}</p> --}}
            </div>
        </div> <!-- END Contact info -->
    {{--modal window for sent for approval--}}
    <!-- Modal -->

    <div class="row">
        <div class="col-md-12">

            <!-- Pending Invoices foreach -->
            @set('total',0)
            @set('labor_total',0)
            @set('material_total',0)

            @if(!$job->is_estimate)

                @foreach ($job->pendinginvoices as $index => $pendinginvoice)

                <table class="table table-invoice">

                    <thead>
                        <th>Date</th>
                        <th>Details</th>
                        <th class="text-right">Amount</th>
                    </thead>

                    <tbody>

                    @if(!$job->is_estimate)
                        <tr>
                            <td style="width:10%;">
                            <b>{{date('M j, Y', mktime(0, 0, 0,$pendinginvoice->month, $pendinginvoice->date, $pendinginvoice->year))}}</b>
                            {!! Html::linkRoute('pendinginvoices.edit', 'Edit', array($pendinginvoice->id), array('class'=>'btn btn-xs btn-info btn-block btn-margin') ) !!}
                            </td>
                            <td style="white-space: pre-line; width:80%;">{{$pendinginvoice->description}}</td>
                            <td style="width:10%;"></td>
                        </tr>
                    @endif
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
                                <td  style="text-indent: 20px;">First 1/2 hour</td>
                                <td class="text-right">$ {{number_format($first_half_hour,2,'.',',')}}</td>
                            </tr>
                        @endif
                        @if($pendinginvoice->first_one_hour)
                            @set('hour_name', 'Additional')
                            <tr>
                                <td></td>
                                <td style="text-indent: 20px;">First 1 hour</td>
                                <td class="text-right">$ {{number_format($first_one_hour,2,'.',',')}}</td>
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
                            @set('other_subtotal', $technician->other_hours*$technician->other_hours_cost)
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
                {{-- <div class="row invoice-subtotal">
                    <div class="col-md-10">
                        <p class="text-right"><strong>SUB-TOTAL</strong></p>
                    </div>
                    <div class="col-md-2">
                        <p class="total-cost">$ {{number_format($subtotal,2,'.',',')}}</p>
                    </div>
                </div> --}}
                @endforeach <!-- END Pending Invoice foreach -->

            {{-- if esitmate job type --}}
            @else

                <table class="table table-invoice">
                    <thead>
                        <th>Date</th>
                        <th>Details</th>
                        <th class="text-right">Amount</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="width:10%;">
                            <b>
                            {{date('M j', strtotime($job->estimates->first()->invoiced_from))}}
                            -
                            {{date('M j', strtotime($job->estimates->first()->invoiced_to))}}
                            </b>
                            {!! Html::linkRoute('estimates.edit', 'Edit', array($job->estimates->first()->id), array('class'=>'btn btn-xs btn-info btn-block btn-margin') ) !!}
                            </td>
                            <td style="white-space: pre-line; width:80%;">{{$job->estimates->first()->description}}</td>
                            @set('labor_total',$job->estimates->first()->cost)
                            <td class="text-right" style="width:10%;">$ {{number_format($job->estimates->first()->cost,2,'.',',')}}</td>
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
                                <td style="white-space: pre-line; width:80%;">- {{$extra->extras_description}}</td>
                                <td class="text-right" style="width:10%;">
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
                        @foreach($job->technicians as $technician)
                            @forelse($technician->materials as $material)
                            <tr>
                                <td></td>
                                <td>{{$material->material_quantity.' x '.$material->material_name}}</td>
                                @set('total', number_format($material->material_quantity*$material->material_cost,2,'.',','))
                                <td class="text-right" style="width:10%;"> {{($total < 0)? '$ ('.$total.')' : '$ '.$total }}</td>
                            </tr>
                            <?php
                            $material_total += $material->material_quantity*$material->material_cost;;
                            ?>
                            @empty
                            @endforelse
                        @endforeach
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

            @set('truck_services_amount',0)
            @if($job->is_trucked)
                @set('truck_services_amount',$job->truck_services_amount)
            @endif
            @if($truck_services_amount!=0)
            <div class="row invoice-truck">
                <div class="col-md-9 col-md-offset-1 invoice-truck-text">
                    <p>Truck Services</p>
                </div>
                <div class="col-md-2">
                    <p class="total-cost">$ {{number_format($truck_services_amount,2,'.',',')}}</p>
                </div>
            </div>
            @endif {{-- END if truck --}}
            <?php $total = $total + $truck_services_amount; ?>
        </div>
    </div>

    <!-- Labor Discount -->
    @set('labor_discount', $job->labor_discount/100)
    @set('labor_deduction',0)
    @if($labor_discount!=0)
        @set('labor_deduction', $labor_total*$labor_discount)
    @endif
    <!-- Material Discount -->
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
    <!-- Calculate Total -->
    @set('total_before_gst',$total-$labor_deduction-$material_deduction-$price_adjustment_amount)
    @set('gst_percentage',0.05)
    @set('gst',$total_before_gst*$gst_percentage)
    @set('grand_total',$total_before_gst+$gst)

    <div class="row invoice-grandtotal">
        <div class="col-">
        </div>
        <div class="col-md-10">

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
        <div class="col-md-2">
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

    <div class="row" style="margin-top: 25px;">
        <div class="col-md-12">
            <form action="{{url('/invoice/approval/send/'.$job->id)}}" id="send-approval" method="post">
                <div class="form-group">
                    <label for="comment">Comment:</label>
                    <textarea <?php if($job->approval_status == 'approved')echo "readonly"; ?> class="form-control" rows="8" name="comment" form="send-approval">{{$job->approval_note}}</textarea>
                </div>
                {{csrf_field()}}
                @if($job->approval_status == null || $job->approval_status == 'declined')
                    <input type="hidden" name="send_for_approval" val="1">
                    <button style="width: 200px; float: right;" class="btn btn-success btn-lg btn-block btn-margin">Send for approval</button>
                @elseif($job->approval_status == 'pending')
                    <button style="width: 200px; float: right;" class="btn btn-success btn-lg send-approval-button" route="approve">Approve</button>
                    <button style="width: 200px; float: right; margin-right: 20px;" class="btn btn-danger btn-lg send-approval-button" route="cancel">Decline</button>
                @endif
            </form>
        </div>

    </div>


@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            $('.send-approval-button').click(function(event){
                event.preventDefault();

                if($(this).attr('route') == "approve")
                    $('#send-approval').attr('action', "{{url('/invoice/approval/approve/'.$job->id)}}");
                else
                    $('#send-approval').attr('action', "{{url('/invoice/approval/decline/'.$job->id)}}");

                $('#send-approval').submit();
            })
        });
    </script>
    {!! Html::script('js/parsley.min.js') !!}
    {!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/js/bootstrap-datepicker.min.js') !!}
    {!! Html::script('js/datepicker.js') !!}
@endsection