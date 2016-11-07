@extends('main')

@section('title', '| View Client')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <h1 class="page_title"> CLIENT SUMMARY </h1>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-8">
            <!-- https://www.virendrachandak.com/techtalk/php-isset-vs-empty-vs-is_null/ -->
            @if(!empty($client->company_name)) <h2>Company: {{$client->company_name}}</h1> @endif
            @if(!empty($client->strata_plan_number)) <h3>Strata Plan #: {{$client->strata_plan_number}}</h3> @endif
            <h3>Name: {{$client->first_name.' '.$client->last_name}}</h3>
            <p class="lead-md"><strong>Title:</strong> {{$client->title}}</p>
            <hr>
            <p class="lead-md"><b>Address:</b> {{$client->fullMailingAddress()}}</p>
            <div class="row">
                @if(!empty($client->buzzer_code))
                <div class="col-md-6">
                    <p class="lead-md"><strong>Buzzer Code:</strong> {{$client->buzzer_code}}</p>
                </div>
                @endif
                @if(!empty($client->alarm_code))
                <div class="col-md-6">
                    <p class="lead-md"><strong>Alarm Code:</strong> {{$client->alarm_code}}</p>
                </div>
                @endif
                @if(!empty($client->lock_box))
                <div class="col-md-6">
                    <p class="lead-md"><strong>Lock Box:</strong> {{$client->lock_box}}</p>
                </div>
                @endif
                @if(!empty($client->lock_box_location))
                <div class="col-md-6">
                    <p class="lead-md"><strong>Lock Box Location:</strong> {{$client->lock_box_location}}</p>
                </div>
                @endif
            </div>

            <p class="lead-md"><b>Billing Address:</b> {{$client->fullBillingAddress()}}</p>
            <div class="row">
                <div class="col-md-6">
                    <p class="lead-md"><strong>Home:</strong>
                    {{(!empty($client->home_number))?$client->formatPhone($client->home_number):'-'}}
                    </p>
                </div>
                <div class="col-md-6">
                    <p class="lead-md"><strong>Cell:</strong>
                    {{(!empty($client->cell_number))?$client->formatPhone($client->cell_number):'-'}}
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <p class="lead-md"><strong>Work:</strong>
                    {{(!empty($client->work_number))?$client->formatPhone($client->work_number):'-'}}
                    </p>
                </div>
                <div class="col-md-6">
                    <p class="lead-md"><strong>Fax:</strong>
                    {{(!empty($client->fax_number))?$client->formatPhone($client->fax_number):'-'}}
                    </p>
                </div>
            </div>

            <p class="lead-md"><b>Email:</b> {{$client->email}}</p>
            @if(!empty($client->alternate_emai)) <p class="lead-md"><b>Alternate Email:</b> {{$client->alternate_email}}</p> @endif

            @if(!empty($client->quoted_rates)) <p class="lead-md"><b>Quoted Rates:</b> {{$client->quoted_rates}}</p> @endif
            @if(!empty($client->property_note)) <p class="lead-md paragraph-wrap"><b>Property Note:</b><br>{{$client->property_note}}</p> @endif

        </div>

        <!-- Side bar -->
        <div class="col-md-4">
            <div class="well">
                {{-- <dl class="dl-horizontal">
                    <dt>Creat at:</dt>
                    <!-- http://php.net/manual/en/function.date.php -->
                    <!-- http://php.net/manual/en/function.strtotime.php -->
                    <dd>{{ date('M j, Y - H:i', strtotime($client->created_at)) }}</dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>Last Update at:</dt>
                    <dd>{{ date('M j, Y - H:i', strtotime($client->updated_at)) }}</dd>
                </dl>
                <hr> --}}

                <div class="row">
                    <div class="col-sm-6">
                        {!! Html::linkRoute('clients.edit', 'Edit', array($client->id), array('class'=>'btn btn-primary btn-margin btn-block') ) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::open(['route' => ['clients.destroy',$client->id], 'method'=>'DELETE']) !!}
                        {{ Form::submit('Delete', array('class' => 'btn btn-danger btn-margin btn-block confirm-delete-modal', 'id'=>'delete'))}}
                        {!! Form::close() !!}
                        <div class="modal modal-effect-blur" id="modal-1">
                            <div class="modal-content">
                                <h3>Are you sure you want to delete?</h3>
                                <p class="text-center">*everything related to this Client will be delete as well</p>
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
                        {!! Html::linkRoute('sites.create', 'Add Site', array($client->id), array('class'=>'btn btn-default btn-block btn-margin') ) !!}
                    </div>
                    <div class="col-sm-12">
                        {!! Html::linkRoute('jobs.create', 'Create Job', array($client->id,'client'), array('class'=>'btn btn-default btn-block btn-margin') ) !!}
                    </div>

                </div>
            </div>
        </div>

    </div> <!-- /.row -->
    <!-- List of sites -->
    <div class="row">
        <hr>
        <h2 class="text-center">Sites</h2>
        <hr>
        <div class="col-md-12">
            <table class="table table-hover mobile-table">
                <thead>
                    <th>Address</th>
                    <th>Name</th>
                    <th>Title</th>

                    <th>Cellphone</th>
                    <th class="text-right">Action</th>
                </thead>
                <tbody>

                    @foreach($client->sites as $site)

                        <tr  class="table-row" data-href="{{route('sites.show',$site->id)}}">
                            <td data-label="Address">
                            {{$site->mailing_address.', '.$site->mailing_city}}</td>
                            <td data-label="Name">
                                @if(count($site->contacts)>0)
                                    {{$site->contacts->first()->first_name}}
                                    {{(!empty($site->contacts->first()->last_name))?$site->contacts->first()->last_name: ''}}
                                @else -
                                @endif
                            </td>
                            <td data-label="Title">
                                @if(count($site->contacts)>0)
                                    {{(!empty($site->contacts->first()->title))?$site->contacts->first()->title:'-'}}
                                @else -
                                @endif
                            </td>
                            <td data-label="Cellphone">
                                @if(count($site->contacts)>0)
                                    {{(!empty($site->contacts->first()->cell_number))?$site->formatPhone($site->contacts->first()->cell_number):'-'}}
                                @else -
                                @endif
                            </td>
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
                                    <li>{!! Html::linkRoute('jobs.create', 'Create Job from this Site', array($site->id,'site'), array('class'=>'')) !!}
                                    </li>
                                </ul>
                            </div>
                            </td>
                        </tr>

                    @endforeach


                </tbody>
            </table>

        </div>
    </div>

@endsection