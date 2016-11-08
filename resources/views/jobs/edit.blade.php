@extends('main')

@section('title', '| Edit Job')

@section('stylesheets')
    {!! Html::style('css/parsley.css') !!}
@endsection

@section('content')

    <div class="row">
        <div class="col-md-6" style="background-color: #eee;">
            {{-- Client information --}}
            @if(!empty($client->company_name)) <h3><strong>Company:</strong> {{$client->company_name}}</h3> @endif
            @if(!empty($client->strata_plan_number)) <p class="lead-md"><strong>Strata Plan #:</strong> {{$client->strata_plan_number}}</p> @endif
            <p class="lead-md"><strong>Name:</strong> {{$client->first_name.' '.$client->last_name}}</p>
            <p class="lead-md"><strong>Title:</strong> {{$client->title}}</p>
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

            {{-- SITE INFORMATION --}}
            @if(isset($site))
                <h3>Additional Site</h3>

                <p class="lead-md"><strong>Site Address:</strong> {{$site->fullMailingAddress()}}</p>
                <p class="lead-md"><b>Billing Address:</b> {{$site->fullBillingAddress()}}</p>
                <div class="row">
                    @if(!empty($site->buzzer_code))
                    <div class="col-md-6">
                        <p class="lead-md"><strong>Buzzer Code:</strong> {{$site->buzzer_code}}</p>
                    </div>
                    @endif
                    @if(!empty($site->alarm_code))
                    <div class="col-md-6">
                        <p class="lead-md"><strong>Alarm Code:</strong> {{$site->alarm_code}}</p>
                    </div>
                    @endif
                    @if(!empty($site->lock_box))
                    <div class="col-md-6">
                        <p class="lead-md"><strong>Lock Box:</strong> {{$site->lock_box}}</p>
                    </div>
                    @endif
                    @if(!empty($site->lock_box_location))
                    <div class="col-md-6">
                        <p class="lead-md"><strong>Lock Box Location:</strong> {{$site->lock_box_location}}</p>
                    </div>
                    @endif
                </div>
                @if(count($site->contacts)>0)
                    <p class="lead-md"><strong>Additional Contact:</strong></p>
                    @foreach($site->contacts as $index => $contact)
                        <div style="margin: 1% 0;padding: 2%;border:1px solid #999;">
                            @if(!empty($contact->company_name))
                            <p class="lead-md"><strong>Company:</strong> {{$contact->company_name}}</p>
                            @endif
                            @if(!empty($contact->first_name))
                            <p class="lead-md"><strong>Name:</strong> {{$contact->first_name.' '.(!empty($contact->last_name))?$contact->last_name:''}}</p>
                            @endif
                            @if(!empty($contact->title))
                            <p class="lead-md"><strong>Title:</strong> {{$contact->title}}</p>
                            @endif

                            <div class="row">
                                @if(!empty($contact->home_number))
                                <div class="col-md-6">
                                    <p class="lead-md"><strong>Home Number:</strong> {{$site->formatPhone($contact->home_number)}}</p>
                                </div>
                                @endif
                                @if(!empty($contact->cell_number))
                                <div class="col-md-6">
                                    <p class="lead-md"><strong>Cell Number:</strong> {{$site->formatPhone($contact->cell_number)}}</p>
                                </div>
                                @endif
                                @if(!empty($contact->work_number))
                                <div class="col-md-6">
                                    <p class="lead-md"><strong>Work Number:</strong> {{$site->formatPhone($contact->work_number)}}</p>
                                </div>
                                @endif
                                @if(!empty($contact->fax_number))
                                <div class="col-md-6">
                                    <p class="lead-md"><strong>Fax Number:</strong> {{$site->formatPhone($contact->fax_number)}}</p>
                                </div>
                                @endif
                            </div>

                            <div class="row">
                                @if(!empty($contact->email))
                                <div class="col-md-6">
                                    <p class="lead-md"><strong>Email:</strong> {{$contact->email}}</p>
                                </div>
                                @endif
                                @if(!empty($contact->alternate_email))
                                <div class="col-md-6">
                                    <p class="lead-md"><strong>Alternate Email:</strong> {{$contact->alternate_email}}</p>
                                </div>
                                @endif
                            </div>
                        </div>

                    @endforeach
                    @if(!empty($site->property_note)) <p class="lead-md paragraph-wrap"><strong>Property Note:</strong><br>{{$site->property_note}}</p> @endif

                @endif
            @endif

        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                <!-- model obj, array of other options -->
                {!! Form::model($job, ['route' => ['jobs.update',$job->id], 'method'=>'PUT', 'data-parsley-validate'=>''] ) !!}

                    <h3>Editing Job ID: {{$job->id+20100}}</h3>
                    <p class="lead-md">
                        <strong>For site address:</strong>
                        @if(isset($site))
                            {{$site->fullMailingAddress()}}
                        @else
                            {{$client->fullMailingAddress()}}
                        @endif
                    </p>
                    <hr>
                    <fieldset class="form-group required">
                    {{ Form::label('project_manager', 'Project Manager:', array('class'=>'control-label'))  }}
                    {{ Form::select('project_manager', array(
                        'PC' => 'Peter Campa',
                        'JB' => 'Jess Gunther',
                        'JG' => 'Johan Becker'),
                        'PC',
                        array('class' => 'form-control')
                    )}}
                    </fieldset>

                    <fieldset class="form-group required">
                    {{ Form::label('is_estimate', 'Job Type:', array('class'=>'control-label'))  }}
                    <br>
                    <label class="radio-inline">
                        <input type="radio" name="is_estimate" id="is_estimate1" value="0" {{($job->is_estimate=='0')?'checked':''}}> Regular Job
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="is_estimate" id="is_estimate2" value="1" {{($job->is_estimate=='1')?'checked':''}}> Estimate Job
                    </label>
                    </fieldset>

                    <fieldset class="form-group required">
                    {{ Form::label('scope_of_works', 'Scope Of Works:', array('class'=>'control-label'))  }}
                    {{ Form::textarea('scope_of_works',null, array('class' => 'form-control','required'=>''))}}
                    </fieldset>

                    <div class="checkbox">
                        <label>
                        <input type="checkbox" name="tenant_checkbox" id="tenant_checkbox"> There is a tenant?
                        </label>
                    </div>

                    <div class="row toggle">
                        <div class="col-md-12">
                            <fieldset class="form-group">
                            {{ Form::label('tenant_contact_info', 'Contact Info:')  }}
                            {{ Form::text('tenant_contact_info',null, array('class' => 'form-control', 'maxlength'=>'255'))}}
                            </fieldset>
                        </div>
                    </div>

                    <fieldset class="form-group">
                    {{ Form::label('purchase_order_number', 'Purchase Order Number:')  }}
                    {{ Form::text('purchase_order_number',null, array('class' => 'form-control', 'maxlength'=>'255'))}}
                    </fieldset>

                    {{ Form::hidden('client_id', $client->id) }}
                    @if(isset($site))
                        {{ Form::hidden('site_id', $site->id) }}
                    @endif
                    <div class="row">
                        <div class="col-sm-6">
                            {{ Form::submit('Update', ['class' => 'btn btn-success btn-block'] )}}

                        </div>
                        <div class="col-sm-6">
                            <a href="{{url()->previous()}}" class="btn btn-danger btn-block">Cancel</a>
                        </div>
                    </div>
                </div>


                {!! Form::close() !!}
                </div>
            </div> <!-- /.row -->
        </div>
    </div>

@endsection

@section('scripts')
    {!! Html::script('js/parsley.min.js') !!}
@endsection