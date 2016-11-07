@extends('main')

@section('title', '| Create New Client')

@section('stylesheets')
	{!! Html::style('css/parsley.css') !!}
@endsection

@section('content')

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>Create New Client</h1>
            <hr>

            {!! Form::open(array('route' => 'clients.store', 'id' => 'client-site-form', 'data-parsley-validate'=>'')) !!}

                <fieldset class="form-group">
			    {{ Form::label('company_name', 'Company Name:')  }}
			    {{ Form::text('company_name',null, array('class' => 'form-control', 'maxlength'=>'255', 'tabindex' => '1'))}}
                </fieldset>

                <fieldset class="form-group">
                {{ Form::label('strata_plan_number', 'Strata Plan Number:')  }}
                {{ Form::text('strata_plan_number',null, array('class' => 'form-control', 'maxlength'=>'255', 'tabindex' => '2'))}}
                </fieldset>

                <div class="row">
                    <div class="col-md-6">
                        <fieldset class="form-group required">
                        {{ Form::label('first_name', 'First Name:', array('class'=>'control-label'))  }}
                        {{ Form::text('first_name',null, array('class' => 'form-control', 'required'=>'', 'maxlength'=>'255', 'tabindex' => '3'))}}
                        </fieldset>
                    </div>
                    <div class="col-md-6">
                        <fieldset class="form-group required">
                        {{ Form::label('last_name', 'Last Name:')  }}
                        {{ Form::text('last_name',null, array('class' => 'form-control', 'maxlength'=>'255', 'tabindex' => '4'))}}
                        </fieldset>
                    </div>
                </div>

                <fieldset class="form-group">
                {{ Form::label('title', 'Title:')  }}
                {{ Form::text('title',null, array('class' => 'form-control', 'maxlength'=>'255' , 'tabindex' => '5'))}}
                </fieldset>

                <div class="row">
                    <div class="col-md-6">
                        <fieldset class="form-group">
                        {{ Form::label('home_number', 'Home Number:')  }}
                        {{ Form::text('home_number',null, array(
                            'class'               => 'form-control',
                            'tabindex'            => '6'
                            //'minlength'         => '10' ,
                            //'maxlength'         => '10'
                            //'data-parsley-type' => 'digits'
                        ))}}
                        </fieldset>
                    </div>
                    <div class="col-md-6">
                        <fieldset class="form-group">
                        {{ Form::label('cell_number', 'Cell Number:')  }}
                        {{ Form::text('cell_number',null, array(
                            'class'    => 'form-control',
                            'tabindex' => '7'
                        ))}}
                        </fieldset>
                    </div>
                    <div class="col-md-6">
                        <fieldset class="form-group">
                        {{ Form::label('work_number', 'Work Number:')  }}
                        {{ Form::text('work_number',null, array(
                            'class'    => 'form-control',
                            'tabindex' => '8'
                        ))}}
                        </fieldset>
                    </div>
                    <div class="col-md-6">
                        <fieldset class="form-group">
                        {{ Form::label('fax_number', 'Fax Number:')  }}
                        {{ Form::text('fax_number',null, array(
                            'class'    => 'form-control',
                            'tabindex' => '9'
                        ))}}
                        </fieldset>
                    </div>
                </div>

                <fieldset class="form-group">
                {{ Form::label('email', 'Email:')  }}
                {{ Form::text('email',null, array('class' => 'form-control', 'maxlength'=>'255', 'tabindex' => '10','data-parsley-type'=>'email'))}}
                </fieldset>

                <fieldset class="form-group">
                {{ Form::label('alternate_email', 'Alternate Email:')  }}
                {{ Form::text('alternate_email',null, array('class' => 'form-control', 'maxlength'=>'255', 'tabindex' => '11','data-parsley-type'=>'email'))}}
                </fieldset>

                <fieldset class="form-group">
                <legend><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span> Address:</legend>
                <div class="row">
                    <div class="col-md-6">
                        <fieldset class="form-group required">
                        {{ Form::label('mailing_address', 'Address:', array('class'=>'control-label'))  }}
                        {{ Form::text('mailing_address',null, array('class' => 'form-control', 'required'=>'', 'tabindex' => '12', 'maxlength'=>'255'))}}
                        </fieldset>
                    </div>
                    <div class="col-md-6">
                        <fieldset class="form-group">
                        {{ Form::label('mailing_city', 'City:')  }}
                        {{ Form::text('mailing_city',null, array('class' => 'form-control','tabindex' => '13', 'maxlength'=>'50'))}}
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
                            array('class' => 'form-control','tabindex' => '')
                        )}}
                        </fieldset>
                    </div>
                    <div class="col-md-6">
                        <fieldset class="form-group">
                        {{ Form::label('mailing_postalcode', 'Postal Code:')  }}
                        {{ Form::text('mailing_postalcode',null, array(
                            'class' => 'form-control',
                            'tabindex' => '15'
                            //'maxlength'=>'6'
                        ))}}
                        </fieldset>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <fieldset class="form-group">
                        {{ Form::label('buzzer_code', 'Buzzer Code:')  }}
                        {{ Form::text('buzzer_code',null, array(
                            'class'             => 'form-control',
                            'tabindex'          =>'16',
                            //'data-parsley-type' =>'digits'
                        ))}}
                        </fieldset>
                    </div>
                    <div class="col-md-6">
                        <fieldset class="form-group">
                        {{ Form::label('alarm_code', 'Alarm Code:')  }}
                        {{ Form::text('alarm_code',null, array(
                            'class'             => 'form-control',
                            'tabindex'          =>'17',
                            //'data-parsley-type' =>'digits'
                        ))}}
                        </fieldset>

                    </div>
                    <div class="col-md-6">
                        <fieldset class="form-group">
                        {{ Form::label('lock_box', 'Lock Box:')  }}
                        {{ Form::text('lock_box',null, array(
                            'class'    => 'form-control',
                            'tabindex' =>'18',
                        ))}}
                        </fieldset>
                    </div>
                    <div class="col-md-6">
                        <fieldset class="form-group">
                        {{ Form::label('lock_box_location', 'Lock Box Location:')  }}
                        {{ Form::text('lock_box_location',null, array(
                            'class'    => 'form-control',
                            'tabindex' =>'19',
                        ))}}
                        </fieldset>
                    </div>
                </div>

                </fieldset>

                </fieldset>

                <fieldset class="form-group">
                <legend><span class="glyphicon glyphicon-usd" aria-hidden="true"></span> Billing Address:</legend>

                <div class="checkbox">
                    <label>
                    <input type="checkbox" name="mail_to_bill_checkbox" id="mail_to_bill_checkbox" value="1" tabindex="20"> Same as Address
                    </label>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <fieldset class="form-group">
                        {{ Form::label('billing_address', 'Address:')  }}
                        {{ Form::text('billing_address',null, array('class' => 'form-control','tabindex' => '21', 'maxlength'=>'255'))}}
                        </fieldset>
                    </div>
                    <div class="col-md-6">
                        <fieldset class="form-group">
                        {{ Form::label('billing_city', 'City:')  }}
                        {{ Form::text('billing_city',null, array('class' => 'form-control', 'tabindex' => '22','maxlength'=>'50'))}}
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
                            array('class' => 'form-control','tabindex' => '')
                        )}}
                        </fieldset>
                    </div>
                    <div class="col-md-6">
                        <fieldset class="form-group">
                        {{ Form::label('billing_postalcode', 'Postal Code:')  }}
                        {{ Form::text('billing_postalcode',null, array('class' => 'form-control', 'tabindex' => '24'))}}
                        </fieldset>
                    </div>
                </div>
                </fieldset>



                <fieldset class="form-group">
                {{ Form::label('quoted_rates', 'Quoted Rates:')  }}
                {{ Form::text('quoted_rates',null, array('class' => 'form-control','tabindex' => '25', 'maxlength'=>'255' ))}}
                </fieldset>

                <fieldset class="form-group">
			    {{ Form::label('property_note', 'Propety Note:')  }}
			    {{ Form::textarea('property_note',null, array('class' => 'form-control','tabindex' => '26'))}}
                </fieldset>

			    {{ Form::submit('Create Client', array('class' => 'btn btn-success btn-lg btn-block btn-margin', 'tabindex' => '27'))}}

                <div class="row">
                    <div class="col-sm-12">
                        <a href="{{url()->previous()}}" class="btn btn-danger btn-lg btn-block btn-margin" tabindex="28">Cancel</a>
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