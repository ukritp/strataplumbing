@extends('main')

@section('title', '| Edit Client')

@section('stylesheets')
    {!! Html::style('css/parsley.css') !!}
@endsection

@section('content')

    <div class="row">
        <!-- model obj, array of other options -->
        {!! Form::model($client, ['route' => ['clients.update',$client->id], 'method'=>'PUT', 'id' => 'client-site-form','data-parsley-validate'=>''] ) !!}

        <div class="col-md-8">
            <h2>Editing Client ID: {{$client->id}}</h2>
            <hr>

                <fieldset class="form-group">
                {{ Form::label('company_name', 'Company Name:')  }}
                {{ Form::text('company_name',null, array('class' => 'form-control', 'maxlength'=>'255', 'tabindex' => '1'))}}
                </fieldset>

                <fieldset class="form-group">
                {{ Form::label('strata_plan_number', 'Strata Plan Number:')  }}
                {{ Form::text('strata_plan_number',null, array('class' => 'form-control', 'maxlength'=>'255','tabindex' => '2'))}}
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
                        </fieldset>
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
                            array('class' => 'form-control','tabindex' => '14')
                        )}}
                        </fieldset>
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

                <fieldset class="form-group">
                {{ Form::label('buzzer_code', 'Buzzer Code:')  }}
                {{ Form::text('buzzer_code',null, array(
                    'class'             => 'form-control',
                    'tabindex' => '16',
                    //'required'          =>'',
                    'data-parsley-type' =>'digits'

                ))}}
                </fieldset>

                </fieldset>

                <fieldset class="form-group">
                <legend><span class="glyphicon glyphicon-usd" aria-hidden="true"></span> Billing Address:</legend>

                <div class="checkbox">
                    <label>
                    <input type="checkbox" name="mail_to_bill_checkbox" id="mail_to_bill_checkbox" value="1" tabindex="17"> Same as Address
                    </label>
                </div>
                <div class="row" id="billing-address-row">
                    <div class="col-md-6">
                        <fieldset class="form-group">
                        {{ Form::label('billing_address', 'Address:')  }}
                        {{ Form::text('billing_address',null, array('class' => 'form-control','tabindex' => '18', 'maxlength'=>'255'))}}
                        </fieldset>
                        <fieldset class="form-group">
                        {{ Form::label('billing_city', 'City:')  }}
                        {{ Form::text('billing_city',null, array('class' => 'form-control', 'tabindex' => '19','maxlength'=>'50'))}}
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
                            array('class' => 'form-control','tabindex' => '20')
                        )}}
                        </fieldset>
                        <fieldset class="form-group">
                        {{ Form::label('billing_postalcode', 'Postal Code:')  }}
                        {{ Form::text('billing_postalcode',null, array('class' => 'form-control', 'tabindex' => '21'))}}
                        </fieldset>
                    </div>
                </div>
                </fieldset>



                <fieldset class="form-group">
                {{ Form::label('quoted_rates', 'Quoted Rates:')  }}
                {{ Form::text('quoted_rates',null, array('class' => 'form-control','tabindex' => '22', 'maxlength'=>'255' ))}}
                </fieldset>

                <fieldset class="form-group">
                {{ Form::label('property_note', 'Propety Note:')  }}
                {{ Form::textarea('property_note',null, array('class' => 'form-control','tabindex' => '23'))}}
                </fieldset>

        </div>

        <!-- Side bar -->
        <div class="col-md-4">
            <div class="well">
                <dl class="dl-horizontal">
                    <dt>Creat at:</dt>
                    <!-- http://php.net/manual/en/function.date.php -->
                    <!-- http://php.net/manual/en/function.strtotime.php -->
                    <dd>{{ date('M j, Y - H:i', strtotime($client->created_at)) }}</dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>Last Update at:</dt>
                    <dd>{{ date('M j, Y - H:i', strtotime($client->updated_at)) }}</dd>
                </dl>
                <hr>

                <div class="row">
                    <div class="col-sm-6">
                        {{ Form::submit('Update', ['class' => 'btn btn-success btn-block', 'tabindex' => '24'] )}}

                    </div>
                    <div class="col-sm-6">
                        <a href="{{url()->previous()}}" class="btn btn-danger btn-block" tabindex="25">Cancel</a>
                    </div>
                </div>


            </div>
        </div>

        {!! Form::close() !!}
    </div> <!-- /.row -->

@endsection

@section('scripts')
    {!! Html::script('js/parsley.min.js') !!}
    {!! Html::script('js/maskedinput.min.js') !!}
    {!! Html::script('js/maskedinput.js') !!}
    {!! Html::script('js/default.js') !!}
@endsection
