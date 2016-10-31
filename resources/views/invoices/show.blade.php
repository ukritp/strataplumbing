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
        </div>
    </div>
    <br>
    <div class="row">
        <!-- Contact info -->
        <div class="col-md-9">
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
                @if(!empty($job->approval_status))
                <div class="lead-approval">
                    @if($job->approval_status == 'pending')
                            <p class="lead"><strong>Approval Status:</strong> Pending</p>
                    @elseif($job->approval_status == 'declined')
                            <p class="lead"><strong>Approval Status:</strong> Declined</p>
                    @elseif($job->approval_status == 'approved')
                            <p class="lead"><strong>Approval Status:</strong> Approved</p>
                    @endif
                    @if(!empty($job->approval_note))
                    <p class="lead paragraph-wrap"><strong>Approval Note:</strong><br>{{$job->approval_note}}</p>
                    @endif
                </div>
                @endif
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


        <!-- Finalize Invoice form =============================================== -->
        {!! Form::open(array('route' => 'invoices.store', 'data-parsley-validate'=>'')) !!}

        <div class="col-md-3">
            @if($job->status)
                <p class="lead"><strong>Invoice Date:</strong>
                    {{date('M j, Y', strtotime($job->invoiced_at))}}
                </p>
                {!! Html::linkRoute('invoices.create', 'See Final Invoice', array($job->id), array('class'=>'btn btn-lg btn-success btn-block', 'target'=>'_blank') ) !!}
                <div class="row">
                    <div class="col-sm-12">
                        {!! Html::linkRoute('invoices.edit', 'Edit Invoice', array($job->id), array('class'=>'btn btn-primary btn-lg btn-block btn-margin') ) !!}
                    </div>
                </div>
            @else
                @if( (count($job->pendinginvoices)==count($job->techniciansGroupByDateCount)) || ($job->is_estimate) )

                    <fieldset class="form-group required">
                    {{ Form::label('invoiced_at', 'Invoice Date: (YYYY-MM-DD)', array('class'=>'control-label'))  }}
                    {{ Form::text('invoiced_at',Carbon::now()->toDateString(), array('class' => 'form-control', 'required'=>'',  'maxlength'=>'255'))}}
                    </fieldset>

                    <fieldset class="form-group required">
                    {{ Form::label('labor_discount', 'Labor Discount: % ', array('class'=>'control-label'))  }}
                    {{ Form::text('labor_discount',0, array(
                                    'class' => 'form-control',
                                    'required'=>'',
                                    'maxlength'=>'255',
                                    'data-parsley-pattern' =>'\d+(\.\d{1,2})?'
                                ))}}
                    </fieldset>

                    <fieldset class="form-group required">
                    {{ Form::label('material_discount', 'Material Discount: % ', array('class'=>'control-label'))  }}
                    {{ Form::text('material_discount',0, array(
                                    'class' => 'form-control',
                                    'required'=>'',
                                    'maxlength'=>'255',
                                    'data-parsley-pattern' =>'\d+(\.\d{1,2})?'
                                ))}}
                    </fieldset>

                    <div class="row price-adjustment-row">
                        <div class="col-xs-12">
                            <fieldset class="form-group">
                            {{ Form::label('price_adjustment_title', 'Price Adjustment Title: ')  }}
                            {{ Form::text('price_adjustment_title',null, array(
                                            'class'     => 'form-control',
                                            'maxlength' => '255'
                                        ))}}
                            </fieldset>
                        </div>
                        <div class="col-xs-8">
                            <fieldset class="form-group">
                            {{ Form::label('price_adjustment_amount', 'Amount:')  }}
                            {{ Form::text('price_adjustment_amount',null, array(
                                'class'                => 'form-control',
                                'data-parsley-pattern' =>'\d+(\.\d{1,2})?'
                            ))}}
                            </fieldset>
                        </div>
                        <div class="col-xs-4">
                            <fieldset class="form-group">
                            {{ Form::label('price_adjustment_type', 'Type:')  }}
                            {{ Form::select('price_adjustment_type', array(
                                '0' => '$',
                                '1' => '%'),
                                null,
                                array('class' => 'form-control')
                            )}}
                            </fieldset>
                        </div>
                    </div>


                    <fieldset class="form-group">
                    {{ Form::label('is_trucked', 'Truck Services?  ')  }}
                    {{ Form::checkbox('is_trucked_chbx',1,false, array('id'=>'is_trucked_chbx'))}}
                    {{ Form::hidden('is_trucked', '0') }}
                    {{ Form::text('truck_services_amount',null, array(
                        'class'                => 'form-control',
                        'disabled'             => 'disabled',
                        'id'                   => 'truck_services_amount',
                        'placeholder'          => 'Truck Services Amount...',
                        'data-parsley-pattern' =>'\d+(\.\d{1,2})?',
                        'maxlength'            => '255'
                    ))}}
                    </fieldset>

                    {{ Form::hidden('job_id', $job->id) }}
                    {{ Form::submit('Finalize Invoice', array('class' => 'btn btn-success btn-lg btn-block btn-margin'))}}
                @endif
            @endif

            @if($job->approval_status != 'approved')
            <div class="row">
                <div class="col-sm-12">
                    <a href="{{url('/invoices/approval/' . $job->id)}}" class="btn btn-warning btn-lg btn-block btn-margin">Send for approval</a>
                </div>
            </div>
            @endif

            <div class="row">
                <div class="col-sm-12">
                    {!! Html::linkRoute('jobs.show', 'Back to Job Summary', array($job->id), array('class'=>'btn btn-default btn-lg btn-block btn-margin') ) !!}
                </div>
            </div>
        </div>
        {!! Form::close() !!}

    </div> <!-- /.row -->
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
                        @forelse($job->estimates->first()->materials as $material)
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
        @if($job->price_adjustment_type ==0)
            @set('price_adjustment_amount', $job->price_adjustment_amount)
        @else
            @set('price_adjustment_amount', $total*($job->price_adjustment_amount)/100)
        @endif
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
                <p>
                {{$job->price_adjustment_title}}
                @if($job->price_adjustment_type == 1)
                    {{'- '.$job->price_adjustment_amount.' %'}}
                @endif
                </p>
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


@endsection

@section('scripts')
    {!! Html::script('js/parsley.min.js') !!}
    {!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/js/bootstrap-datepicker.min.js') !!}
    {!! Html::script('js/datepicker.js') !!}
@endsection