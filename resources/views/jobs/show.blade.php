@extends('main')

@section('title', '| View Job')

@section('content')

@set('user', \Auth::user()->roles()->first()->name)

    <div class="row">
        <div class="col-md-12">
            <h1 class="page_title"> JOB SUMMARY </h1>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-8">
            @if(!empty($job->site))
                <h2 class="header-blue">One of {{$job->client->company_name}} Properties</h2>
                <hr>
                <p class="lead-md"><strong>Site Address:</strong>
                    {{$job->site->fullMailingAddress()}}
                </p>
                {{-- <p class="lead-md"><strong>Billing Address:</strong>
                    {{$job->site->fullBillingAddress()}}
                </p> --}}
                <div class="row">
                @if(!empty($job->site->buzzer_code))
                <div class="col-md-6">
                    <p class="lead-md"><strong>Buzzer Code:</strong> {{$job->site->buzzer_code}}</p>
                </div>
                @endif
                @if(!empty($job->site->alarm_code))
                <div class="col-md-6">
                    <p class="lead-md"><strong>Alarm Code:</strong> {{$job->site->alarm_code}}</p>
                </div>
                @endif
                @if(!empty($job->site->lock_box))
                <div class="col-md-6">
                    <p class="lead-md"><strong>Lock Box:</strong> {{$job->site->lock_box}}</p>
                </div>
                @endif
                @if(!empty($job->site->lock_box_location))
                <div class="col-md-6">
                    <p class="lead-md"><strong>Lock Box Location:</strong> {{$job->site->lock_box_location}}</p>
                </div>
                @endif
            </div>
                {{-- <div class="row">
                    <div class="col-md-6">
                        <p class="lead-md"><strong>Cell:</strong> {{$job->site->formatPhone($job->site->cell_number)}}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="lead-md"><strong>Email:</strong> {{$job->site->email}}</p>
                    </div>
                </div> --}}
            @else
                <p class="lead-md"><strong>Address:</strong>
                    {{$job->client->fullMailingAddress()}}
                </p>
                <div class="row">
                    @if(!empty($job->client->buzzer_code))
                    <div class="col-md-6">
                        <p class="lead-md"><strong>Buzzer Code:</strong> {{$job->client->buzzer_code}}</p>
                    </div>
                    @endif
                    @if(!empty($job->client->alarm_code))
                    <div class="col-md-6">
                        <p class="lead-md"><strong>Alarm Code:</strong> {{$job->client->alarm_code}}</p>
                    </div>
                    @endif
                    @if(!empty($job->client->lock_box))
                    <div class="col-md-6">
                        <p class="lead-md"><strong>Lock Box:</strong> {{$job->client->lock_box}}</p>
                    </div>
                    @endif
                    @if(!empty($job->client->lock_box_location))
                    <div class="col-md-6">
                        <p class="lead-md"><strong>Lock Box Location:</strong> {{$job->client->lock_box_location}}</p>
                    </div>
                    @endif
                </div>
                {{-- <p class="lead-md"><strong>Billing Address:</strong>
                    {{$job->client->fullBillingAddress()}}
                </p> --}}
            @endif
            <hr>
            <h3 class="header-blue">Job # {{$job->id+20100}}</h3>
            <hr>
            @set('job_type', ($job->is_estimate)? 'estimate' : 'regular')
            <p class="lead-md job-type type-{{$job_type}}"><strong>Job Type: {{$job_type}}</strong></p>
            <hr>
            <p class="lead-md"><strong>Purchase Order Number:</strong> {{$job->purchase_order_number}}</p>
            <p class="lead-md"><strong>Project Manager:</strong> {{$job->project_manager}}</p>
            <p class="lead-md paragraph-wrap"><strong>Scope Of Work:</strong><br>{{$job->scope_of_works}}</p>
            <p class="lead-md lead-status"><strong>Status:</strong> <span>{{($job->status) ? 'Completed' : 'Pending'}}</span></p>
            @if(!empty($job->tenant_contact_info)) <p class="lead-md"><strong>Tenant:</strong> {{$job->tenant_contact_info}}</p> @endif

            {{-- <p class="lead-md"><strong>Days working for this job:</strong> {{count($job->techniciansGroupByDateCount)}}</p>
            <p class="lead-md"><strong>Days added to this invoice:</strong> {{count($job->pendinginvoices)}}</p>
            <p class="lead-md"><strong>Days added missing:</strong> {{count($job->techniciansGroupByDateCount)-count($job->pendinginvoices)}}</p> --}}
        </div>


        <!-- Side bar -->
        <div class="col-md-4">
            <div class="well">

                @if($user === 'Admin' || $user === 'Owner')

                <div class="form-group">
                    @if(!empty($job->client->company_name))
                        @set('client_id',$job->client->id)
                        @if(isset($job->site))
                            @set('client_id',$job->site->client->id)
                        @endif
                        <h2 class="text-center">
                        {!! Html::linkRoute('clients.show', $job->client->company_name, array($client_id), array('class'=>''))!!}</h2>
                    @endif
                    <h3 class="text-center">{{$job->client->first_name.' '.$job->client->last_name}}</h3>
                    <br>
                    <p class="lead-md"><strong>Title:</strong> {{$job->client->title}}</p>
                    <p class="lead-md"><strong>Cell:</strong> {{$job->client->formatPhone($job->client->cell_number)}}</p>
                    <p class="lead-md"><strong>Email:</strong> {{$job->client->email}}</p>
                    {{-- <p class="lead-md"><strong>Job Created at:</strong> {{ date('M j, Y - H:i', strtotime($job->created_at)) }}</p>
                    <p class="lead-md"><strong>Job Last Updated at:</strong> {{ date('M j, Y - H:i', strtotime($job->updated_at)) }}</p> --}}
                </div>
                {{-- <dl class="dl-horizontal">
                    <dt>Title:</dt>
                    <dd>{{$job->client->title}}</dd>
                    <dt>Cell:</dt>
                    <dd>{{$job->client->cell_number}}</dd>
                    <dt>Email:</dt>
                    <dd>{{$job->client->email}}</dd>

                    <dt>Job Created at:</dt>
                    <!-- http://php.net/manual/en/function.date.php-->
                    <!-- http://php.net/manual/en/function.strtotime.php -->
                    <dd>{{ date('M j, Y - H:i', strtotime($job->created_at)) }}</dd>
                    <dt>Job Last Updated at:</dt>
                    <dd>{{ date('M j, Y - H:i', strtotime($job->updated_at)) }}</dd>
                </dl> --}}
                <hr>
                <div class="row">
                    <div class="col-sm-6">
                        {!! Html::linkRoute('jobs.edit', 'Edit', array($job->id), array('class'=>'btn btn-primary btn-margin btn-block') ) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::open(['route' => ['jobs.destroy',$job->id], 'method'=>'DELETE']) !!}
                        {{ Form::submit('Delete', array('class' => 'btn btn-danger btn-block btn-margin confirm-delete-modal', 'id'=>'delete'))}}
                        {!! Form::close() !!}
                        <div class="modal modal-effect-blur" id="modal-1">
                            <div class="modal-content">
                                <h3>Are you sure you want to delete?</h3>
                                <p class="text-center">*all technician details, materials and invoices associated with this job will be delete as well</p>
                                <div>
                                    <button class="modal-delete">Delete</button>
                                    <button class="modal-delete-cancel">Cancel</button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-overlay"></div>
                    </div>
                </div>
                @endif

                <div class="row">

                    <div class="col-sm-12">
                        {!! Html::linkRoute('technicians.create', 'Create Technician Details', array($job->id), array('class'=>'btn btn-default btn-block btn-margin') ) !!}
                    </div>


                    @if($user === 'Admin' || $user === 'Owner')
                        <div class="col-sm-12">
                            <button class="btn btn-default btn-block btn-margin" id="copy-button" data-clipboard-text="{{\URL::current()}}">Copy Current URL</button>
                        </div>
                        @if(!empty($job->site))
                        {{-- <div class="col-sm-12">
                            {!! Html::linkRoute('jobs.index', 'All jobs from this site', array($job->site->id), array('class'=>'btn btn-default btn-block btn-margin') ) !!}
                        </div> --}}
                        @endif
                        @set('status', ( (count($job->pendinginvoices)>0) || (count($job->estimates)>0) )? '' : 'disabled')
                        <div class="col-sm-12">
                            {!! Html::linkRoute('invoices.show', 'Invoice Summary', array($job->id), array('class'=>'btn btn-default btn-block btn-margin '.$status))!!}
                        </div>
                    @endif
                </div>

            </div>
        </div>

    </div> <!-- /.row -->

    <!-- List of Technician -->
    <div class="row">
        <hr>
        <h2 class="text-center">Technician Details Summary</h2>
        <hr>
        <div class="col-md-12">
            <table class="table table-hover table-hover-blue mobile-table">
                <thead>
                    <!-- <th>#</th> -->
                    <th>Date</th>
                    <th>Name</th>
                    <th>Details</th>
                    <th class="text-center hidden-xs">Equipment Left on Site</th>
                    <th class="text-right"  colspan="2">Action</th>
                </thead>
                <tbody>
                    @set('created_at', array())
                    @foreach($job->techniciansGroupByDate as $index => $technician)
                        @set('created_at[$index]',date('M j, Y', strtotime($technician->pendinginvoiced_at)))
                        @set('count_rowspan', count($job->techniciansCountByDate($technician->pendinginvoiced_at)))
                        <tr class="table-row" data-href="{{route('technicians.show',$technician->id)}}">
                            <!-- <th>{{$technician->id}}</th> -->
                            @if($index == 0)
                                <th data-label="Date" rowspan="{{$count_rowspan}}">{{$created_at[$index]}}</th>
                            @elseif($created_at[$index] == $created_at[$index-1])
                            @else
                                <th data-label="Date" rowspan="{{$count_rowspan}}">{{$created_at[$index]}}</th>
                            @endif
                            <td data-label="Name"><strong>{{$technician->technician_name}}</strong></td>
                            <td data-label="Details">{{substr($technician->tech_details, 0,50)}}{{strlen($technician->tech_details)>50 ? '....' : ''}}</td>
                            <td data-label="Equipment Left on Site" class="text-center hidden-xs">{{($technician->equipment_left_on_site) ? 'yes' : 'no'}}</td>
                            <td data-label="Action" class="text-right">
                            {{-- {!! Html::linkRoute('technicians.show', 'View', array($technician->id), array('class'=>'btn btn-default btn-sm btn-sm-margin') ) !!}
 --}}                            @can('technician-gate', $technician)
                            {!! Html::linkRoute('technicians.edit', 'Edit', array($technician->id), array('class'=>'btn btn-default btn-sm btn-sm-margin') ) !!}
                            @endcan
                            </td>

                            @if($user === 'Admin' || $user === 'Owner')

                                @if($job->is_estimate)
                                    @if($index == 0)
                                    @if(count($job->estimates)>0)
                                        <td class="create-invoice-column" rowspan="{{count($job->technicians)}}">
                                            {!! Html::linkRoute('estimates.show', 'View Invoice', array($job->estimates->first()->id), array('class'=>'btn btn-info btn-sm btn-block') ) !!}
                                            <br>
                                            {!! Html::linkRoute('estimates.edit', 'Edit Invoice', array($job->estimates->first()->id), array('class'=>'btn btn-info btn-sm btn-block') ) !!}
                                        </td>
                                    @else
                                        <td class="create-invoice-column" rowspan="{{count($job->technicians)}}">
                                            {!! Html::linkRoute('estimates.create', 'Create Invoice', array($job->id), array('class'=>'btn btn-info btn-sm btn-block') ) !!}
                                        </td>
                                    @endif
                                    @endif
                                @else

                                    @if($index == 0)
                                    <td class="create-invoice-column" rowspan="{{$count_rowspan}}">
                                        @if(!is_null($technician->pending_invoice_id))
                                            {!! Html::linkRoute('pendinginvoices.edit', 'Edit Invoice', array($technician->pending_invoice_id), array('class'=>'btn btn-info btn-sm btn-block') ) !!}
                                            <br>
                                            {!! Html::linkRoute('pendinginvoices.show', 'View Invoice', array($technician->pending_invoice_id), array('class'=>'btn btn-info btn-sm btn-block') ) !!}
                                        @else
                                            {!! Html::linkRoute('pendinginvoices.create', 'Add To Invoice', array($technician->id), array('class'=>'btn btn-info btn-sm btn-block') ) !!}
                                        @endif
                                    @elseif($created_at[$index] == $created_at[$index-1])
                                        {{-- Nothing is this elseif but it has to be there --}}
                                    @else
                                    </td>
                                    <td class="create-invoice-column" rowspan="{{$count_rowspan}}">
                                        @if(!is_null($technician->pending_invoice_id))
                                            {!! Html::linkRoute('pendinginvoices.edit', 'Edit Invoice', array($technician->pending_invoice_id), array('class'=>'btn btn-info btn-sm btn-block') ) !!}
                                            <br>
                                            {!! Html::linkRoute('pendinginvoices.show', 'View Invoice', array($technician->pending_invoice_id), array('class'=>'btn btn-info btn-sm btn-block') ) !!}
                                        @else
                                            {!! Html::linkRoute('pendinginvoices.create', 'Add To Invoice', array($technician->id), array('class'=>'btn btn-info btn-sm btn-block') ) !!}
                                        @endif
                                    @endif

                                @endif
                            </td>
                            @endif

                        </tr>

                    @endforeach


                </tbody>
            </table>

        </div>
    </div>

@endsection

@section('scripts')
    {!! Html::script('//cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.4.0/clipboard.min.js') !!}
    <script type="text/javascript">
        $(document).ready(function () {
            new Clipboard('#copy-button');
        });
    </script>
@endsection