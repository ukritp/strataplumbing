@extends('main')

@section('title', '| View Invoice')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <h1 class="page_title"> PENDING INVOICE SUMMARY </h1>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-8">
			@if(!empty($pendinginvoice->job->site))
                <h2>Job ID: {{$pendinginvoice->job->id+20100}}</h2>
                <hr>
                <h3>Contact: {{$pendinginvoice->job->site->first_name.' '.$pendinginvoice->job->site->last_name}}</h3>
                <p class="lead"><strong>Relationship:</strong> {{$pendinginvoice->job->site->relationship}}</p>
                <p class="lead"><strong>Address:</strong> {{
                    ucwords(strtolower($pendinginvoice->job->site->mailing_address)).', '.
                    ucwords(strtolower($pendinginvoice->job->site->mailing_city)).', '.
                    strtoupper($pendinginvoice->job->site->mailing_province).' '.
                    strtoupper($pendinginvoice->job->site->mailing_postalcode)
                }}
                </p>
                @if(!empty($pendinginvoice->job->site->buzzer_code)) <p class="lead"><strong>Buzzer Code:</strong> {{$pendinginvoice->job->site->buzzer_code}}</p> @endif
                <div class="row">
                    <div class="col-md-6">
                        <p class="lead"><strong>Cell:</strong> {{$pendinginvoice->job->site->cell_number}}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="lead"><strong>Email:</strong> {{$pendinginvoice->job->site->email}}</p>
                    </div>
                </div>
                <hr>
            @else
                <h2>Job ID: {{$pendinginvoice->job->id+20100}}</h2>
                <hr>
                <p class="lead"><strong>Project Manager:</strong> {{$pendinginvoice->job->project_manager}}</p>
                <p class="lead"><strong>Address:</strong> {{
                    ucwords(strtolower($pendinginvoice->job->client->mailing_address)).', '.
                    ucwords(strtolower($pendinginvoice->job->client->mailing_city)).', '.
                    strtoupper($pendinginvoice->job->client->mailing_province).' '.
                    strtoupper($pendinginvoice->job->client->mailing_postalcode)
                }}
                </p>
            @endif

        </div>


        <!-- Side bar -->
        <div class="col-md-4">
            <div class="well">
                <div class="form-group">
                    @if(!empty($pendinginvoice->job->client->company_name))<h2 class="text-center">{{$pendinginvoice->job->client->company_name}}</h2> @endif
                    <h3 class="text-center">{{$pendinginvoice->job->client->first_name.' '.$pendinginvoice->job->client->last_name}}</h3>
                    <br>
                    <p class="lead-md"><strong>Title:</strong> {{$pendinginvoice->job->client->title}}</p>
                    <p class="lead-md"><strong>Cell:</strong> {{$pendinginvoice->job->client->cell_number}}</p>
                    <p class="lead-md"><strong>Email:</strong> {{$pendinginvoice->job->client->email}}</p>
                    <p class="lead-md"><strong>Created at:</strong> {{ date('M j, Y - H:i', strtotime($pendinginvoice->job->created_at)) }}</p>
                    <p class="lead-md"><strong>Last Updated at:</strong> {{ date('M j, Y - H:i', strtotime($pendinginvoice->job->updated_at)) }}</p>
                </div>
                {{--
                <dl class="dl-horizontal">
                    <dt>Title:</dt>
                    <dd>{{$pendinginvoice->job->client->title}}</dd>
                    <dt>Cell:</dt>
                    <dd>{{$pendinginvoice->job->client->cell_number}}</dd>
                    <dt>Email:</dt>
                    <dd>{{$pendinginvoice->job->client->email}}</dd>

                    <dt>Job Created at:</dt>
                    <dd>{{ date('M j, Y - H:i', strtotime($pendinginvoice->job->created_at)) }}</dd>
                    <dt>Job Last Updated at:</dt>
                    <dd>{{ date('M j, Y - H:i', strtotime($pendinginvoice->job->updated_at)) }}</dd>
                </dl>--}}
                <hr>

                <div class="row">
                    <div class="col-sm-6">
                        {!! Html::linkRoute('pendinginvoices.edit', 'Edit', array($pendinginvoice->id), array('class'=>'btn btn-primary btn-margin btn-block') ) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::open(['route' => ['pendinginvoices.destroy',$pendinginvoice->id], 'method'=>'DELETE']) !!}
                        {{ Form::submit('Delete', array('class' => 'btn btn-danger btn-block btn-margin confirm-delete-modal', 'id'=>'delete'))}}
                        {!! Form::close() !!}
                        <div class="modal modal-effect-blur" id="modal-1">
                            <div class="modal-content">
                                <h3>Are you sure you want to delete?</h3>
                                <div>
                                    <button class="modal-delete">Delete</button>
                                    <button class="modal-delete-cancel">Cancel</button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-overlay"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        {!! Html::linkRoute('jobs.show', 'View this job', array($pendinginvoice->job_id), array('class'=>'btn btn-default btn-block btn-margin') ) !!}
                    </div>
                    @set('status', count($pendinginvoice->job->pendinginvoices)>0 ? '' : 'disabled')
                    <div class="col-sm-12">
                        {!! Html::linkRoute('invoices.show', 'View Invoice', array($pendinginvoice->job->id), array('class'=>'btn btn-default btn-block btn-margin '.$status))!!}
                    </div>
                </div>

            </div>
        </div>

    </div> <!-- /.row -->

    <div class="row">
        <div class="col-md-12">
            <table class="table table-pending-invoice">
            	<thead>
        			<th>Date</th>
        	        <th class="td-description">Description</th>
        	        <th class="text-right">Cost</th>
                </thead>
                <tbody>
                    <tr>
                        <td data-label="Date" class="date">{{date('M j, Y', mktime(0, 0, 0,$pendinginvoice->month, $pendinginvoice->date, $pendinginvoice->year))}}</td>
                        <td data-label="Description" class="td-description">{{$pendinginvoice->description}}</td>
                        <td></td>
                    </tr>

                    <!-- Labor Description Section  ================================================ -->
                    <tr>
                    	<td></td>
                    	<td data-label="Description"><b>
                        @if(!empty($pendinginvoice->labor_description))
                            {{$pendinginvoice->labor_description}}
                        @else
                            {{count($pendinginvoice->technicians)}} Man with equipment
                        @endif
                        </b></td>
                    	<td></td>
                    </tr>


                    <!-- Labor Cost Section  ================================================ -->
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
                        	<td>First 1/2 hour</td>
                        	<td class="text-right">$ {{number_format($first_half_hour,2,'.',',')}}</td>
                        </tr>
                    @endif
                    @if($pendinginvoice->first_one_hour)
                        @set('hour_name', 'Additional')
                        <tr>
                            <td></td>
                            <td>First 1 hour</td>
                            <td class="text-right">$ {{number_format($first_one_hour,2,'.',',')}}</td>
                        </tr>
                    @endif
                    <tr>
                    	<td></td>
                    	<td>{{$hour_name}} hours = {{$labor_hours}} @ {{number_format($pendinginvoice->hourly_rates,2,'.',',')}} /hr </td>
                    	<td class="text-right">$ {{number_format($man_hour_total,2,'.',',')}}</td>
                    </tr>

                    <!-- Other Hours Section  ================================================ -->
                    @set('other_hours_total',0)
                    @foreach($pendinginvoice->technicians as $technician)
                        @set('flushing_subtotal', $technician->flushing_hours*$technician->flushing_hours_cost)
                        @set('camera_subtotal', $technician->camera_hours*$technician->camera_hours_cost)
                        @set('main_line_auger_subtotal', $technician->main_line_auger_hours*$technician->main_line_auger_hours_cost)
                        @set('other_subtotal', $technician->other_hours*$technician->other_hours_cost)
                        <?php $other_hours_total += $flushing_subtotal+$camera_subtotal+$main_line_auger_subtotal+$other_subtotal?>
                    @endforeach
                    <tr>
                    	<td></td>
                    	<td>Other hours (flushing, camera, main line auger, etc)</td>
                    	<td class="text-right">$ {{number_format($other_hours_total,2,'.',',')}}</td>
                    </tr>


                    <!-- Material Section ================================================-->
                    @set('material_total',0)
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
                			<td>{{$material->material_quantity.' - '.$material->material_name}}</td>
                			<td class="text-right">$ {{number_format($material->material_quantity*$material->material_cost,2,'.',',')}}</td>
                		</tr>
                		<?php $material_total += $material->material_quantity*$material->material_cost?>
                		@endforeach
                	@endforeach


                </tbody>
            </table>

            @set('subtotal', $first_half_hour+$man_hour_total+$other_hours_total+$material_total)
            @set('labor_discount', $pendinginvoice->labor_discount/100)
            @set('material_discount', $pendinginvoice->material_discount/100)
            <div class="row invoice-grandtotal">
        	    <div class="col-md-10">
        	        <p>SUB-TOTAL</p>

        	    </div>
                @set('man_hour_total_discount', $man_hour_total*$labor_discount)
                @set('material_total_discount', $material_total*$material_discount)
                @set('total', $subtotal-$man_hour_total_discount-$material_total_discount )
        	    <div class="col-md-2">
        	        <p class="total-cost">$ {{number_format($subtotal,2,'.',',')}}</p>

        	    </div>
        	</div>
        </div>
    </div>

@endsection

@section('scripts')
    {!! Html::script('js/default.js') !!}
@endsection