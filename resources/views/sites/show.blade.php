@extends('main')

@section('title', '| View Site')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <h1 class="page_title"> SITE SUMMARY </h1>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-8">

            <h2>{{$site->first_name.' '.$site->last_name}}</h2>
            <p class="lead"><strong>Relationship:</strong> {{$site->relationship}}</p>
            @if(!empty($site->additional_contact)) <p class="lead"><strong>Additional Contact:</strong> {{$site->additional_contact}}</p> @endif
            <hr>
            <p class="lead"><b>Address:</b> {{$site->fullMailingAddress()}}</p>
            @if(!empty($site->buzzer_code)) <p class="lead"><strong>Buzzer Code:</strong> {{$site->buzzer_code}}</p> @endif
            <p class="lead"><b>Billing Address:</b> {{$site->fullBillingAddress()}}</p>
            <div class="row">
                <div class="col-md-6">
                    <p class="lead"><strong>Home:</strong>
                    {{(!empty($site->home_number))?$site->formatPhone($site->home_number):'-'}}
                    </p>
                </div>
                <div class="col-md-6">
                    <p class="lead"><strong>Cell:</strong>
                    {{(!empty($site->cell_number))?$site->formatPhone($site->cell_number):'-'}}
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <p class="lead"><strong>Work:</strong>
                    {{(!empty($site->work_number))?$site->formatPhone($site->work_number):'-'}}
                    </p>
                </div>
                <div class="col-md-6">
                    <p class="lead"><strong>Fax:</strong>
                    {{(!empty($site->fax_number))?$site->formatPhone($site->fax_number):'-'}}
                    </p>
                </div>
            </div>

            <p class="lead"><strong>Email:</strong> {{$site->email}}</p>
            @if(!empty($site->alternate_emai)) <p class="lead">Alternate Email: {{$site->alternate_email}}</p> @endif
            @if(!empty($site->property_note)) <p class="lead paragraph-wrap"><strong>Property Note:</strong><br>{{$site->property_note}}</p> @endif
        </div>


        <!-- Side bar -->
        <div class="col-md-4">
            <div class="well">
                <div class="form-group">
                    @if(!empty($client->company_name))
                    <h2 class="text-center">
                        {!! Html::linkRoute('clients.show', $client->company_name, array($client->id), array('class'=>''))!!}
                    </h2>
                    @endif
                    <h3 class="text-center">{{$client->first_name.' '.$client->last_name}}</h3>
                    <br>
                    <p class="lead-md"><strong>Title:</strong> {{$client->title}}</p>
                    <p class="lead-md"><strong>Cell:</strong> {{$client->cell_number}}</p>
                    <p class="lead-md"><strong>Email:</strong> {{$client->email}}</p>
                    <p class="lead-md"><strong>Site Created at:</strong> {{ date('M j, Y - H:i', strtotime($site->created_at)) }}</p>
                    <p class="lead-md"><strong>Site Last Updated at:</strong> {{ date('M j, Y - H:i', strtotime($site->updated_at)) }}</p>
                </div>
                {{-- <dl class="dl-horizontal">
                    <dt>Title:</dt>
                    <dd>{{$client->title}}</dd>
                    <dt>Cell:</dt>
                    <dd>{{$client->cell_number}}</dd>
                    <dt>Email:</dt>
                    <dd>{{$client->email}}</dd>

                    <dt>Creat at:</dt>
                    <!--  http://php.net/manual/en/function.date.php -->
                    <!-- http://php.net/manual/en/function.strtotime.php -->
                    <dd>{{ date('M j, Y - H:i', strtotime($site->created_at)) }}</dd>
                    <dt>Last Update at:</dt>
                    <dd>{{ date('M j, Y - H:i', strtotime($site->updated_at)) }}</dd>
                </dl> --}}
                <hr>

                <div class="row">
                    <div class="col-sm-6">
                        {!! Html::linkRoute('sites.edit', 'Edit', array($site->id), array('class'=>'btn btn-primary btn-margin btn-block') ) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::open(['route' => ['sites.destroy',$site->id], 'method'=>'DELETE']) !!}
                        {{ Form::submit('Delete', array('class' => 'btn btn-danger btn-block btn-margin confirm-delete-modal', 'id'=>'delete'))}}
                        {!! Form::close() !!}
                        <div class="modal modal-effect-blur" id="modal-1">
                            <div class="modal-content">
                                <h3>Are you sure you want to delete?</h3>
                                <p class="text-center">*all jobs, technician details, materials and invoices associated with this site will be delete as well</p>
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
                        {!! Html::linkRoute('jobs.create', 'Create Job', array($site->id,'site'), array('class'=>'btn btn-default btn-block btn-margin') ) !!}
                    </div>
                    <div class="col-sm-12">
                        {!! Html::linkRoute('clients.show', 'Client Summary', array($site->client->id), array('class'=>'btn btn-default btn-block btn-margin') ) !!}
                    </div>

                    {{-- <div class="col-sm-12">
                        {!! Html::linkRoute('sites.index', 'All sites from '.$client->company_name, array($client->id), array('class'=>'btn btn-default btn-block btn-margin') ) !!}
                    </div> --}}
                </div>

            </div>
        </div>

    </div> <!-- /.row -->

@endsection

@section('scripts')
    {!! Html::script('js/default.js') !!}
@endsection