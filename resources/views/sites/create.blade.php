@extends('main')

@section('title', '| Create New Site')

@section('stylesheets')
	{!! Html::style('css/parsley.css') !!}
@endsection

@section('content')

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>Create New Site</h1>

            <div class="jumbotron">
                @if(!empty($client->company_name)) <h2>Company: {{$client->company_name}}</h2> @endif
                <h3>{{$client->first_name.' '.$client->last_name}}</h3>
                <p class="lead"><strong>Title:</strong> {{$client->title}}</p>
                <p class="lead"><strong>Address:</strong> {{$client->fullMailingAddress()}}</p>
                @if(!empty($client->buzzer_code)) <p class="lead"><strong>Buzzer Code:</strong> {{$client->buzzer_code}}</p> @endif
                <div class="row">
                    <div class="col-md-6">
                        <p class="lead"><strong>Cell:</strong> {{$client->cell_number}}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="lead"><strong>Email:</strong> {{$client->email}}</p>
                    </div>
                </div>
            </div>

            {!! Form::open(array('route' => 'sites.store', 'id' => 'client-site-form', 'data-parsley-validate'=>'')) !!}


                <div class="row">
                    <div class="col-md-6">
                        <fieldset class="form-group required">
                        {{ Form::label('first_name', 'First Name:', array('class'=>'control-label'))  }}
                        {{ Form::text('first_name',null, array('class' => 'form-control', 'required'=>'', 'tabindex'=>'1', 'maxlength'=>'255'))}}
                        </fieldset>
                    </div>
                    <div class="col-md-6">
                        <fieldset class="form-group required">
                        {{ Form::label('last_name', 'Last Name:')  }}
                        {{ Form::text('last_name',null, array('class' => 'form-control','tabindex'=>'2', 'maxlength'=>'255'))}}
                        </fieldset>
                    </div>
                </div>

                <fieldset class="form-group required">
                {{ Form::label('relationship', 'Relationship:', array('class'=>'control-label'))  }}
                {{ Form::text('relationship',null, array('class' => 'form-control','required'=>'','tabindex'=>'3', 'maxlength'=>'255'))}}
                </fieldset>

                <fieldset class="form-group">
                {{ Form::label('additional_contact', 'Additional Contact:')  }}
                {{ Form::text('additional_contact',null, array('class' => 'form-control', 'tabindex'=>'4', 'maxlength'=>'255'))}}
                </fieldset>

                <fieldset class="form-group">
                <legend><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span> Site Address:</legend>
                <div class="row">
                    <div class="col-md-6">
                        <fieldset class="form-group required">
                        {{ Form::label('mailing_address', 'Address:', array('class'=>'control-label'))  }}
                        {{ Form::text('mailing_address',null, array('class' => 'form-control', 'required'=>'','tabindex'=>'5', 'maxlength'=>'255'))}}
                        </fieldset>
                        <fieldset class="form-group">
                        {{ Form::label('mailing_city', 'City:')  }}
                        {{ Form::text('mailing_city',null, array('class' => 'form-control', 'tabindex'=>'6','maxlength'=>'50'))}}
                        </fieldset>
                        <fieldset class="form-group">
                        {{ Form::label('home_number', 'Home Number:')  }}
                        {{ Form::text('home_number',null, array(
                            'class'             => 'form-control',
                            'tabindex'=>'9',

                        ))}}
                        </fieldset>

                        <fieldset class="form-group">
                        {{ Form::label('cell_number', 'Cell Number:')  }}
                        {{ Form::text('cell_number',null, array(
                            'class'             => 'form-control',
                            'tabindex'=>'10',

                        ))}}
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
                            array('class' => 'form-control', 'tabindex'=>'7')
                        )}}
                        </fieldset>
                        <fieldset class="form-group">
                        {{ Form::label('mailing_postalcode', 'Postal Code:')  }}
                        {{ Form::text('mailing_postalcode',null, array('class' => 'form-control', 'tabindex'=>'8'))}}
                        </fieldset>

                         <fieldset class="form-group">
                        {{ Form::label('work_number', 'Work Number:')  }}
                        {{ Form::text('work_number',null, array(
                            'class'             => 'form-control',
                            'tabindex'=>'11',

                        ))}}
                        </fieldset>

                        <fieldset class="form-group">
                        {{ Form::label('fax_number', 'Fax Number:')  }}
                        {{ Form::text('fax_number',null, array(
                            'class'             => 'form-control',
                            'tabindex'=>'12',
                        ))}}
                        </fieldset>
                    </div>
                </div>

                <fieldset class="form-group">
                {{ Form::label('buzzer_code', 'Buzzer Code:')  }}
                {{ Form::text('buzzer_code',null, array(
                    'class'             => 'form-control',
                    'tabindex'=>'13',
                    //'required'          =>'',
                    'data-parsley-type' =>'digits'

                ))}}
                </fieldset>

                </fieldset>

                <fieldset class="form-group">
                <legend><span class="glyphicon glyphicon-usd" aria-hidden="true"></span> Billing Address:</legend>

                <div class="radio">
                    <label>
                        <input type="radio" name="radiobox_billing" id="radiobox_billing1" value="1" tabindex="14">
                        Same as Client's Billing Address
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="radiobox_billing" id="radiobox_billing2" value="2" tabindex="15">
                        Same as Site Address
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="radiobox_billing" id="radiobox_billing3" value="3" tabindex="16">
                        Other
                    </label>
                </div>


              {{--   <div class="checkbox">
                    <label>
                    <input type="checkbox" name="mail_to_client_bill_checkbox" id="mail_to_client_bill_checkbox" value="1" tabindex="13"> Same as Client's Billing Address
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                    <input type="checkbox" name="mail_to_bill_checkbox" id="mail_to_bill_checkbox" value="1" tabindex="14"> Same as Site Address
                    </label>
                </div> --}}
                <div class="row" id="billing-address-row">
                    <div class="col-md-6">
                        <fieldset class="form-group">
                        {{ Form::label('billing_address', 'Address:')  }}
                        {{ Form::text('billing_address',null, array('class' => 'form-control', 'tabindex'=>'17','maxlength'=>'255'))}}
                        </fieldset>
                        <fieldset class="form-group">
                        {{ Form::label('billing_city', 'City:')  }}
                        {{ Form::text('billing_city',null, array('class' => 'form-control','tabindex'=>'18', 'maxlength'=>'50'))}}
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
                            array('class' => 'form-control' ,'tabindex'=>'19')
                        )}}
                        </fieldset>
                        <fieldset class="form-group">
                        {{ Form::label('billing_postalcode', 'Postal Code:')  }}
                        {{ Form::text('billing_postalcode',null, array('class' => 'form-control', 'tabindex'=>'20'))}}
                        </fieldset>
                    </div>
                </div>
                </fieldset>

                <fieldset class="form-group">
                {{ Form::label('email', 'Email:')  }}
                {{ Form::text('email',null, array('class' => 'form-control', 'maxlength'=>'255', 'tabindex'=>'21','data-parsley-type'=>'email'))}}
                </fieldset>

                <fieldset class="form-group">
                {{ Form::label('alternate_email', 'Alternate Email:')  }}
                {{ Form::text('alternate_email',null, array('class' => 'form-control', 'maxlength'=>'255', 'tabindex'=>'22','data-parsley-type'=>'email'))}}
                </fieldset>

                <fieldset class="form-group">
			    {{ Form::label('property_note', 'Property Note:')  }}
			    {{ Form::textarea('property_note',null, array('class' => 'form-control', 'tabindex'=>'23'))}}
                </fieldset>

                {{ Form::hidden('client_id', $client->id) }}

			    {{ Form::submit('Create Site', array('class' => 'btn btn-success btn-lg btn-block btn-margin', 'tabindex'=>'24'))}}
                <div class="row">
                    <div class="col-sm-12">
                        <a href="{{url()->previous()}}" class="btn btn-danger btn-lg btn-block btn-margin" tabindex="25">Cancel</a>
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
    {!! Html::script('js/default.js') !!}
@endsection