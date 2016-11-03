
@extends('main')

@section('title', '| Home page')


@section('content')
    <div class="row">
        {{-- <div class="col-md-12">

            {!! Form::open(array('route' => 'pages.search','method'=>'get', 'data-parsley-validate'=>'')) !!}
            <div class="input-group">
                <input type="text" name="keyword" id="keyword" class="form-control input-lg" placeholder="Search all...." maxlegnth="255" required>
                <span class="input-group-btn">
                    <button class="btn btn-primary btn-lg" type="submit">SEARCH</button>
                </span>
            </div>
            {!! Form::close() !!}
            <hr>
        </div> --}}

    </div> <!-- /.row -->

    <div class="row">
    	<div class="col-md-12">
            {{-- <div class="col-md-12"> --}}
                @if(!isset($clients)&&!isset($sites)&&!isset($jobs)&&!isset($technicians))

                @else

                @set('results', count($clients)+count($sites)+count($jobs)+count($technicians))

                {{-- c{{count($clients)}}
                s{{count($sites)}}
                j{{count($jobs)}}
                t{{count($technicians)}} --}}

                <p class="lead"><strong>Found: {{count($clients)+count($sites)+count($jobs)+count($technicians)}} Results for "{{Request::get('keyword')}}"</strong></p>

                <table class="table table-hover table-hover-blue mobile-table">
                    <thead>
                        <th style="width:10%;">Type</th>
                        <th>Company</th>
                        <th>Contact Info</th>
                        <th>Address</th>
                        <th class="text-center" style="width:10%;">Status</th>
                        <th class="text-center" style="width:10.5%;">Invoiced At</th>
                        <th class="text-right" style="width:12.5%;">Action</th>
                    </thead>
                    <tbody>
                        <!-- If there are Clients ===================================================== -->
                        @if(count($clients)>0)
                            @foreach($clients as $client)
                                @set('type','Client')
                                <tr>
                                    <th data-label="Type">{{$type}}</th>
                                    <th data-label="Company">{{$client->company_name}}</th>
                                    <td data-label="Contact Info">{{$client->first_name.' '.$client->last_name}}</td>
                                    <td data-label="Address">{{
                                    ucwords(strtolower($client->mailing_address)).', '.
                                    ucwords(strtolower($client->mailing_city))
                                    }}</td>
                                    <td data-label="Status" class="td-status">-</td>
                                    <td data-label="Invoiced At" class="td-invoice">-</td>
                                    <td data-label="Action" class="text-right">
                                    <div class="btn-group">
                                        <button type="button"
                                            class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="glyphicon glyphicon-plus"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-button-right">
                                            <li>{!! Html::linkRoute('clients.show', 'View', array($client->id), array('class'=>'')) !!}</li>
                                            <li>{!! Html::linkRoute('clients.edit', 'Edit', array($client->id), array('class'=>'')) !!}</li>
                                            <li>{!! Html::linkRoute('jobs.create', 'Create Job', array($client->id,'client'), array('class'=>'')) !!}
                                            </li>
                                        </ul>
                                    </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                        <!-- If there are Sites ===================================================== -->
                        @if(count($sites)>0)
                            @foreach($sites as $site)
                                @set('type','Site')
                                <tr>
                                    <th data-label="Type">{{$type}}</th>
                                    <th data-label="Company">{{$site->client->company_name}}</th>
                                    <td data-label="Contact Info">
                                        @if(count($site->contacts)>0)
                                            {{$site->contacts->first()->first_name}}
                                            {{$site->contacts->first()->last_name}}
                                        @else -
                                        @endif
                                    </td>
                                    <td data-label="Address">{{
                                    ucwords(strtolower($site->mailing_address)).', '.
                                    ucwords(strtolower($site->mailing_city))
                                    }}</td>
                                    <td data-label="Status" class="td-status">-</td>
                                    <td data-label="Invoiced At" class="td-invoice">-</td>
                                    <td data-label="Action" class="text-right">
                                    <div class="btn-group">
                                        <button type="button"
                                            class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="glyphicon glyphicon-plus"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-button-right">
                                            <li>{!! Html::linkRoute('sites.show', 'View', array($site->id), array('class'=>'')) !!}</li>
                                            <li>{!! Html::linkRoute('sites.edit', 'Edit', array($site->id), array('class'=>'')) !!}</li>
                                            <li>{!! Html::linkRoute('jobs.create', 'Create Job', array($site->id,'site'), array('class'=>'')) !!}
                                            </li>
                                        </ul>
                                    </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                        <!-- If there are Jobs ===================================================== -->
                        @if(count($jobs)>0)
                            @foreach($jobs as $job)
                                @set('status', ( (count($job->pendinginvoices)>0) || (count($job->estimates)>0) )? '' : 'disabled')
                                @set('invoice_link', ( (count($job->pendinginvoices)>0) || (count($job->estimates)>0) ) ? route('invoices.show', $job->id) : '#')
                                @set('job_type', ($job->is_estimate)? 'estimate' : 'regular')

                                @set('type','Job')
                                <tr>
                                    <th data-label="Type" class="th-type">{{$type}} #{{$job->id+20100}}<br><span class="job-type type-{{$job_type}}">{{$job_type}}</span>
                                    </th>
                                    <th data-label="Company">{{isset($job->client->company_name) ? $job->client->company_name : '-'}}</th>
                                    @if(isset($job->site))
                                        <td data-label="Contact Info">{{$job->site->first_name.' '.$job->site->last_name}}</td>
                                        <td data-label="Address">{{
                                        ucwords(strtolower($job->site->mailing_address)).', '.
                                        ucwords(strtolower($job->site->mailing_city))
                                        }}</td>
                                    @else
                                        <td data-label="Contact Info">{{$job->client->first_name.' '.$job->client->last_name}}</td>
                                        <td data-label="Address">{{
                                        ucwords(strtolower($job->client->mailing_address)).', '.
                                        ucwords(strtolower($job->client->mailing_city))
                                        }}</td>
                                    @endif
                                    <th data-label="Status"  class="td-status" >
                                        @if($job->status)
                                            <span class="status-completed">Completed</span>
                                        @else
                                            <span class="status-pending">Pending</span>
                                        @endif
                                    </th>

                                    <td data-label="Invoiced At" class="td-invoice">{{(!empty($job->invoiced_at)) ? date('M j, Y', strtotime($job->invoiced_at)) : '-'}}</td>

                                    <td data-label="Action" class="text-right">
                                    <div class="btn-group">
                                        <button type="button"
                                            class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="glyphicon glyphicon-plus"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-button-right">
                                            <li>{!! Html::linkRoute('jobs.show', 'View', array($job->id), array('class'=>'')) !!}</li>
                                            <li>{!! Html::linkRoute('jobs.edit', 'Edit', array($job->id), array('class'=>'')) !!}</li>
                                            <li class="{{$status}}">
                                                <a href="{{$invoice_link}}">View Invoice</a>
                                            </li>
                                        </ul>
                                    </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                        <!-- If there are Technicians ===================================================== -->
                        {{-- @if(count($technicians)>0)
                            @foreach($technicians as $technician)
                                @set('type','Technician')
                                <tr>
                                    <th data-label="Type">{{$type}}</th>
                                    <th data-label="Company">{{isset($technician->job->client->company_name) ? $technician->job->client->company_name : '-'}}</th>
                                    @if(isset($technician->job->site))
                                        <td data-label="Contact Info" class="hidden-xs">{{$technician->job->site->first_name.' '.$technician->job->site->last_name}}</td>
                                        <td data-label="Address">{{
                                        ucwords(strtolower($technician->job->site->mailing_address)).', '.
                                        ucwords(strtolower($technician->job->site->mailing_city))
                                        }}</td>
                                    @else
                                        <td data-label="Contact Info" class="hidden-xs">{{$technician->job->client->first_name.' '.$technician->job->client->last_name}}</td>
                                        <td data-label="Address">{{
                                        ucwords(strtolower($technician->job->client->mailing_address)).', '.
                                        ucwords(strtolower($technician->job->client->mailing_city))
                                        }}</td>
                                    @endif
                                    <td data-label="Status" class="text-center">-</td>
                                    <td data-label="Invoiced At" class="text-center">-</td>

                                    <td data-label="Action" class="text-right">
                                    {!! Html::linkRoute('technicians.show', 'View', array($technician->id), array('class'=>'btn btn-default btn-sm btn-sm-margin'))!!}
                                    {!! Html::linkRoute('technicians.edit', 'Edit', array($technician->id), array('class'=>'btn btn-default btn-sm btn-sm-margin'))!!}
                                    </td>
                                </tr>
                            @endforeach
                        @endif --}}

                    </tbody>
                </table>

                @endif
            {{-- </div> --}}

        </div>

        {{-- <div class="col-md-2">
            <div class="form-group">
             {!! Html::linkRoute('clients.create','Create Client', array(), array('class'=>'btn  btn-warning btn-block btn-margin') ) !!}
             </div>
             <div class="form-group">
             {!! Html::linkRoute('clients.index','Clients', array(), array('class'=>'btn  btn-warning btn-block btn-margin') ) !!}
             </div>
             <div class="form-group">
             {!! Html::linkRoute('jobs.index','Open Jobs', array('0'), array('class'=>'btn  btn-warning btn-block btn-margin') ) !!}
             </div>
             <div class="form-group">
             {!! Html::linkRoute('technicians.index','Technician Details', array('0'), array('class'=>'btn  btn-warning btn-block btn-margin') ) !!}
             </div>
             <div class="form-group">
             {!! Html::linkRoute('invoices.index','Completed Invoices', array('0'), array('class'=>'btn  btn-warning btn-block btn-margin') ) !!}
             </div>
        </div> --}}
    </div>



@endsection
