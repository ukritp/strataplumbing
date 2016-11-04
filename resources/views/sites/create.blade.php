@extends('main')

@section('title', '| Create New Site')

@section('stylesheets')
	{!! Html::style('css/parsley.css') !!}
@endsection

@section('content')

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>Create New Site</h1>

            <div style="background-color: #eee; padding: 2%; margin:1% 0;">
                @if(!empty($client->company_name)) <h2>Company: {{$client->company_name}}</h2> @endif
                <h3>{{$client->first_name.' '.$client->last_name}}</h3>
                @if(!empty($client->title)) <p class="lead-md"><strong>Title:</strong> {{$client->title}}</p> @endif
                <p class="lead-md"><strong>Address:</strong> {{$client->fullMailingAddress()}}</p>
                @if(!empty($client->buzzer_code)) <p class="lead-md"><strong>Buzzer Code:</strong> {{$client->buzzer_code}}</p> @endif
                <div class="row">
                    @if(!empty($client->home_number))
                    <div class="col-md-6">
                        <p class="lead-md"><strong>Home:</strong> {{$client->formatPhone($client->home_number)}}</p>
                    </div>
                    @endif
                    @if(!empty($client->cell_number))
                    <div class="col-md-6">
                        <p class="lead-md"><strong>Cell:</strong> {{$client->formatPhone($client->cell_number)}}</p>
                    </div>
                    @endif
                    @if(!empty($client->work_number))
                    <div class="col-md-6">
                        <p class="lead-md"><strong>Work:</strong> {{$client->formatPhone($client->work_number)}}</p>
                    </div>
                    @endif
                    @if(!empty($client->fax_number))
                    <div class="col-md-6">
                        <p class="lead-md"><strong>Fax:</strong> {{$client->formatPhone($client->fax_number)}}</p>
                    </div>
                    @endif
                </div>
                <div class="row">
                    @if(!empty($client->email))
                    <div class="col-md-6">
                        <p class="lead-md"><strong>Email:</strong> {{$client->email}}</p>
                    </div>
                    @endif
                    @if(!empty($client->alternate_email))
                    <div class="col-md-6">
                        <p class="lead-md"><strong>Alternate Email:</strong> {{$client->alternate_email}}</p>
                    </div>
                    @endif
                </div>
            </div>

            {!! Form::open(array('route' => 'sites.store', 'id' => 'site-form', 'data-parsley-validate'=>'')) !!}

                <fieldset class="form-group">
                <legend><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span> Site Address:</legend>
                <div class="row">
                    <div class="col-md-6">
                        <fieldset class="form-group required">
                        {{ Form::label('mailing_address', 'Address:', array('class'=>'control-label'))  }}
                        {{ Form::text('mailing_address',null, array('class' => 'form-control', 'required'=>'','tabindex'=>'1', 'maxlength'=>'255'))}}
                        </fieldset>
                        <fieldset class="form-group">
                        {{ Form::label('mailing_city', 'City:')  }}
                        {{ Form::text('mailing_city',null, array('class' => 'form-control', 'tabindex'=>'2','maxlength'=>'50'))}}
                        </fieldset>
                    </div>
                    <div class="col-md-6">
                        <fieldset class="form-group">
                        {{ Form::label('mailing_province', 'Province:')  }}
                        {{ Form::select('mailing_province', array(
                            'BC' => 'British Columbia',
                            'AB' => 'Alberta',
                            'MB' => 'Manitoba',
                            'ON' => 'Ontario',
                            'QC' => 'Quebec',
                            'SK' => 'Saskatchewan',
                            'NS' => 'Nova Scotia',
                            'NB' => 'New Brunswick',
                            'PE' => 'Prince Edward Island',
                            'NL' => 'Newfoundland and Labrador'),
                            null,
                            array('class' => 'form-control', 'tabindex'=>'3')
                        )}}
                        </fieldset>
                        <fieldset class="form-group">
                        {{ Form::label('mailing_postalcode', 'Postal Code:')  }}
                        {{ Form::text('mailing_postalcode',null, array('class' => 'form-control', 'tabindex'=>'4'))}}
                        </fieldset>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <fieldset class="form-group">
                        {{ Form::label('buzzer_code', 'Buzzer Code:')  }}
                        {{ Form::text('buzzer_code',null, array(
                            'class'             => 'form-control',
                            'tabindex'          =>'5',
                            //'data-parsley-type' =>'digits'
                        ))}}
                        </fieldset>
                        <fieldset class="form-group">
                        {{ Form::label('lock_box', 'Lock Box:')  }}
                        {{ Form::text('lock_box',null, array(
                            'class'    => 'form-control',
                            'tabindex' =>'7',
                        ))}}
                        </fieldset>
                    </div>
                    <div class="col-md-6">
                        <fieldset class="form-group">
                        {{ Form::label('alarm_code', 'Alarm Code:')  }}
                        {{ Form::text('alarm_code',null, array(
                            'class'             => 'form-control',
                            'tabindex'          =>'6',
                            //'data-parsley-type' =>'digits'
                        ))}}
                        </fieldset>

                        <fieldset class="form-group">
                        {{ Form::label('lock_box_location', 'Lock Box Location:')  }}
                        {{ Form::text('lock_box_location',null, array(
                            'class'    => 'form-control',
                            'tabindex' =>'8',
                        ))}}
                        </fieldset>
                    </div>
                </div>

                </fieldset>

                <fieldset class="form-group">
                <legend><span class="glyphicon glyphicon-usd" aria-hidden="true"></span> Billing Address:</legend>

                <div class="radio">
                    <label>
                        <input type="radio" name="radiobox_billing" id="radiobox_billing1" value="1" tabindex="9">
                        Same as Client's Billing Address
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="radiobox_billing" id="radiobox_billing2" value="2" tabindex="10">
                        Same as Site Address
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="radiobox_billing" id="radiobox_billing3" value="3" tabindex="11">
                        Other
                    </label>
                </div>

                <div class="row" id="billing-address-row">
                    <div class="col-md-6">
                        <fieldset class="form-group">
                        {{ Form::label('billing_address', 'Address:')  }}
                        {{ Form::text('billing_address',null, array('class' => 'form-control', 'tabindex'=>'12','maxlength'=>'255'))}}
                        </fieldset>
                        <fieldset class="form-group">
                        {{ Form::label('billing_city', 'City:')  }}
                        {{ Form::text('billing_city',null, array('class' => 'form-control','tabindex'=>'13', 'maxlength'=>'50'))}}
                        </fieldset>
                    </div>
                    <div class="col-md-6">
                        <fieldset class="form-group">
                        {{ Form::label('billing_province', 'Province:')  }}
                        {{ Form::select('billing_province', array(
                            'BC' => 'British Columbia',
                            'AB' => 'Alberta',
                            'MB' => 'Manitoba',
                            'ON' => 'Ontario',
                            'QC' => 'Quebec',
                            'SK' => 'Saskatchewan',
                            'NS' => 'Nova Scotia',
                            'NB' => 'New Brunswick',
                            'PE' => 'Prince Edward Island',
                            'NL' => 'Newfoundland and Labrador'),
                            null,
                            array('class' => 'form-control' ,'tabindex'=>'14')
                        )}}
                        </fieldset>
                        <fieldset class="form-group">
                        {{ Form::label('billing_postalcode', 'Postal Code:')  }}
                        {{ Form::text('billing_postalcode',null, array('class' => 'form-control', 'tabindex'=>'15'))}}
                        </fieldset>
                    </div>
                </div>
                </fieldset>


                <legend><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Additional Contact
                <a id="add-contact" class="btn btn-primary btn-sm add-button">Add</a>
                </legend>

                <div class="row" id="contact-add">
                </div>

                <fieldset class="form-group">
			    {{ Form::label('property_note', 'Property Note:')  }}
			    {{ Form::textarea('property_note',null, array('class' => 'form-control', 'tabindex'=>'27'))}}
                </fieldset>

                {{ Form::hidden('client_id', $client->id) }}

			    {{ Form::submit('Create Site', array('class' => 'btn btn-success btn-lg btn-block btn-margin', 'tabindex'=>'28'))}}
                <div class="row">
                    <div class="col-sm-12">
                        <a href="{{url()->previous()}}" class="btn btn-danger btn-lg btn-block btn-margin" tabindex="29">Cancel</a>
                    </div>
                </div>

			{!! Form::close() !!}

        </div>
    </div> <!-- /.row -->


@endsection

@section('scripts')
    {!! Html::script('js/parsley.min.js') !!}
    {!! Html::script('js/maskedinput.min.js') !!}
    {!! Html::script('js/maskedinput.js') !!}
@endsection