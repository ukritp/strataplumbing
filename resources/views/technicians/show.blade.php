@extends('main')

@section('title', '| View Technician')

@section('content')

@set('user', \Auth::user()->roles()->first()->name)

    <div class="row">
        <div class="col-md-12">
            <h1 class="page_title"> TECHNICIAN SUMMARY </h1>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-8">
            @set('contact_first_name', $technician->job->client->first_name)
            @set('contact_last_name', $technician->job->client->last_name)
            @if(isset($technician->job->site))
                @if(count($technician->job->site->contacts)>0)
                    @set('contact_first_name', $job->site->contacts->first()->first_name)
                    @set('contact_last_name', $job->site->contacts->first()->last_name)
                @endif
                <h3>Contact: {{$contact_first_name.' '.$contact_last_name}}</h3>
                <p class="lead-md"><strong>Site Address:</strong> {{$technician->job->site->fullMailingAddress()}}
                </p>
                <div class="row">
                    @if(!empty($technician->job->site->buzzer_code))
                    <div class="col-md-6">
                        <p class="lead-md"><strong>Buzzer Code:</strong> {{$technician->job->site->buzzer_code}}</p>
                    </div>
                    @endif
                    @if(!empty($technician->job->site->alarm_code))
                    <div class="col-md-6">
                        <p class="lead-md"><strong>Alarm Code:</strong> {{$technician->job->site->alarm_code}}</p>
                    </div>
                    @endif
                    @if(!empty($technician->job->site->lock_box))
                    <div class="col-md-6">
                        <p class="lead-md"><strong>Lock Box:</strong> {{$technician->job->site->lock_box}}</p>
                    </div>
                    @endif
                    @if(!empty($technician->job->site->lock_box_location))
                    <div class="col-md-6">
                        <p class="lead-md"><strong>Lock Box Location:</strong> {{$technician->job->site->lock_box_location}}</p>
                    </div>
                    @endif
                </div>
            @else
                <h3>Contact: {{$contact_first_name.' '.$contact_last_name}}</h3>
                <p class="lead-md"><strong>Address:</strong> {{$technician->job->client->fullMailingAddress()}}
                </p>
                <div class="row">
                    @if(!empty($technician->job->client->buzzer_code))
                    <div class="col-md-6">
                        <p class="lead-md"><strong>Buzzer Code:</strong> {{$technician->job->client->buzzer_code}}</p>
                    </div>
                    @endif
                    @if(!empty($technician->job->client->alarm_code))
                    <div class="col-md-6">
                        <p class="lead-md"><strong>Alarm Code:</strong> {{$technician->job->client->alarm_code}}</p>
                    </div>
                    @endif
                    @if(!empty($technician->job->client->lock_box))
                    <div class="col-md-6">
                        <p class="lead-md"><strong>Lock Box:</strong> {{$technician->job->client->lock_box}}</p>
                    </div>
                    @endif
                    @if(!empty($technician->job->client->lock_box_location))
                    <div class="col-md-6">
                        <p class="lead-md"><strong>Lock Box Location:</strong> {{$technician->job->client->lock_box_location}}</p>
                    </div>
                    @endif
                </div>
            @endif

            <hr>
            <h3 class="header-blue">Job # {{$technician->job->id+20100}}</h3>
            <hr>
            <p class="lead lead-md"><strong>Project Manager:</strong> {{$technician->job->project_manager}}</p>
            <p class="lead lead-md paragraph-wrap"><strong>Scope Of Works:</strong><br>{{$technician->job->scope_of_works}}</p>
            {{-- <p class="lead lead-md"><strong>Purchase Order Number:</strong><br>{{$technician->job->purchase_order_number}}</p> --}}
            <div class="row">
                <div class="col-md-6">
                    @if(!empty($technician->job->first_name)) <p class="lead lead-md"><strong>Tenant:</strong> {{$technician->job->first_name.' '.$technician->job->last_name}}</p> @endif
                </div>
                <div class="col-md-6">
                    @if(!empty($technician->job->cell_number)) <p class="lead lead-md"><strong>Cell:</strong> {{$technician->job->cell_number}}</p> @endif
                </div>
            </div>
            <hr>

            <p class="lead-md"><strong>Technician Detail Created At:</strong> {{date('M j, Y', strtotime($technician->pendinginvoiced_at))}}</p>
            <p class="lead-md"><strong>Technician name:</strong> {{$technician->technician_name}}</p>
            <p class="lead-md paragraph-wrap"><strong>Technician Details:</strong><br>{{$technician->tech_details}}</p>

            <table class="table table-bordered material-table">
                <thead style="background-color: #ddd;">
                    <th>Material Name</th>
                    <th class="text-center">Quantity</th>
                </thead>
                <tbody>

                    @forelse($technician->materials as $material)
                    <tr>
                        <td>{{$material->material_name}}</td>
                        <td class="text-center">{{$material->material_quantity}}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="text-center">There are no materials used</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <br>
            @if(!empty($technician->flushing_hours)) <p class="lead-md"><strong>Flushing Hours:</strong> {{$technician->flushing_hours}}</p> @endif
            @if(!empty($technician->camera_hours)) <p class="lead-md"><strong>Camera Hours:</strong> {{$technician->camera_hours}}</p> @endif
            @if(!empty($technician->main_line_auger_hours)) <p class="lead-md"><strong>Main Line Auger Hours:</strong> {{$technician->main_line_auger_hours}}</p> @endif
            @if(!empty($technician->other_hours)) <p class="lead-md"><strong>Other Hours:</strong> {{$technician->other_hours}}</p> @endif
            @if(!empty($technician->notes)) <p class="lead-md paragraph-wrap"><strong>Recommendations / Notes:</strong><br>{{$technician->notes}}</p>@endif
            <p class="lead-md"><strong>Equipment Left on Site:</strong> {{($technician->equipment_left_on_site) ? 'yes - ' : 'no'}}{{$technician->equipment_name}}</p>

        </div>


        <!-- Side bar -->
        <div class="col-md-4">
            <div class="well">
                <div class="form-group hidden-xs">
                    @if(!empty($client->company_name))<h2 class="text-center">{{$client->company_name}}</h2> @endif
                    <h3 class="text-center">{{$client->first_name.' '.$client->last_name}}</h3>
                    <br>
                    <p class="lead-md"><strong>Title:</strong> {{$client->title}}</p>
                    <p class="lead-md"><strong>Cell:</strong> {{$client->cell_number}}</p>
                    <p class="lead-md"><strong>Email:</strong> {{$client->email}}</p>
                    {{-- <p class="lead-md"><strong>Created at:</strong> {{ date('M j, Y - H:i', strtotime($technician->created_at)) }}</p>
                    <p class="lead-md"><strong>Last Updated at:</strong> {{ date('M j, Y - H:i', strtotime($technician->updated_at)) }}</p> --}}
                </div>
                {{--<dl class="dl-horizontal hidden-xs">
                    <dt>Title:</dt>
                    <dd>{{$client->title}}</dd>
                    <dt>Cell:</dt>
                    <dd>{{$client->cell_number}}</dd>
                    <dt>Email:</dt>
                    <dd>{{$client->email}}</dd>

                    <dt>Created at:</dt>
                    <!-- http://php.net/manual/en/function.date.php -->
                    <!-- http://php.net/manual/en/function.strtotime.php -->
                    <dd>{{ date('M j, Y - H:i', strtotime($technician->created_at)) }}</dd>
                    <dt>Last Update at:</dt>
                    <dd>{{ date('M j, Y - H:i', strtotime($technician->updated_at)) }}</dd>
                </dl>--}}
                <hr>

                @can('technician-gate', $technician)
                <div class="row">
                    <div class="col-sm-6">
                        {!! Html::linkRoute('technicians.edit', 'Edit', array($technician->id), array('class'=>'btn btn-primary btn-margin btn-block') ) !!}
                    </div>

                    <div class="col-sm-6 hidden-xs">
                        {!! Form::open(['route' => ['technicians.destroy',$technician->id], 'method'=>'DELETE']) !!}
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
                @endcan

                <div class="row">
                    {{-- <div class="col-sm-12 hidden-xs">
                        {!! Html::linkRoute('technicians.index', 'All technician details from this job', array($technician->job->id), array('class'=>'btn btn-default btn-block btn-margin') ) !!}
                    </div> --}}

                    <div class="col-sm-12">
                        {!! Html::linkRoute('jobs.show', 'Job Summary', array($technician->job->id), array('class'=>'btn btn-default btn-block btn-margin') ) !!}
                    </div>
                    @if($user === 'Admin' || $user === 'Owner')
                        @set('status', count($technician->job->pendinginvoices)>0 ? '' : 'disabled')
                        <div class="col-sm-12">
                            {!! Html::linkRoute('invoices.show', 'Invoice Summary', array($technician->job->id), array('class'=>'btn btn-default btn-block btn-margin '.$status))!!}
                        </div>
                    @endif
                </div>

            </div>
        </div>

    </div> <!-- /.row -->

@endsection