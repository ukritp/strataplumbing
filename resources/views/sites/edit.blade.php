@extends('main')

@section('title', '| Edit Site')

@section('stylesheets')
    {!! Html::style('css/parsley.css') !!}
@endsection

@section('content')

    <div class="row">
        <!-- model obj, array of other options -->
        {!! Form::model($site, ['route' => ['sites.update',$site->id], 'method'=>'PUT','id' => 'site-form', 'data-parsley-validate'=>''] ) !!}

        <div class="col-md-8">
            <h2>Editing Site ID: {{$site->id}}</h2>
            <hr>

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
                    @forelse($site->contacts as $index => $contact)
                        <input name="contact_id[]" type="hidden" value="{{$contact->id}}">

                        <span class="contact-span">

                        <div class="col-xs-12">
                            <fieldset class="form-group">
                                <input type="text" id="company_name{{$index}}" name="company_name[]" class="form-control" placeholder="Company Name"  maxlength="255" value="{{$contact->company_name}}">
                            </fieldset>
                        </div>

                        <div class="col-xs-6">
                            <fieldset class="form-group">
                                <input type="text" id="first_name{{$index}}" name="first_name[]" class="form-control" placeholder="First Name" required maxlength="255" value="{{$contact->first_name}}">
                            </fieldset>
                        </div>
                        <div class="col-xs-6">
                            <fieldset class="form-group">
                                <input type="text" id="last_name{{$index}}" name="last_name[]" class="form-control" placeholder="Last Name" maxlength="255" value="{{$contact->last_name}}">
                            </fieldset>
                        </div>

                        <div class="col-xs-12">
                            <fieldset class="form-group">
                                <input type="text" id="title{{$index}}" name="title[]" class="form-control" placeholder="Title"  maxlength="255" value="{{$contact->title}}">
                            </fieldset>
                        </div>

                        <div class="col-xs-3">
                            <fieldset class="form-group">
                                <input type="text" id="home_number{{$index}}" name="home_number[]" class="form-control home_number" placeholder="Home Number" value="{{$contact->home_number}}">
                            </fieldset>
                        </div>
                        <div class="col-xs-3">
                            <fieldset class="form-group">
                                <input type="text" id="work_number{{$index}}" name="work_number[]" class="form-control work_number" placeholder="Work Number" value="{{$contact->work_number}}">
                            </fieldset>
                        </div>
                        <div class="col-xs-3">
                            <fieldset class="form-group">
                                <input type="text" id="cell_number{{$index}}" name="cell_number[]" class="form-control cell_number" placeholder="Cell Number" value="{{$contact->cell_number}}">
                            </fieldset>
                        </div>
                        <div class="col-xs-3">
                            <fieldset class="form-group">
                                <input type="text" id="fax_number{{$index}}" name="fax_number[]" class="form-control fax_number" placeholder="Fax Number" value="{{$contact->fax_number}}">
                            </fieldset>
                        </div>

                        <div class="col-xs-5">
                            <fieldset class="form-group">
                                <input type="text" id="email{{$index}}" name="email[]" class="form-control" placeholder="Email" maxlength="255" data-parsley-type="email" value="{{$contact->email}}">
                            </fieldset>
                        </div>
                        <div class="col-xs-5">
                            <fieldset class="form-group">
                                <input type="text" id="alternate_email{{$index}}" name="alternate_email[]" class="form-control" placeholder="Altername Email" maxlength="255" data-parsley-type="email" value="{{$contact->alternate_email}}">
                            </fieldset>
                        </div>
                        <div class="col-xs-2">
                            <fieldset class="form-group">
                                <a id="remove-contact-{{$index}}" class="btn btn-danger btn-sm btn-block remove-contact"><i class="glyphicon glyphicon-remove"></i></a>
                            </fieldset>
                        </div>

                        </span>
                    @empty
                    @endforelse
                </div>

                <fieldset class="form-group">
                {{ Form::label('property_note', 'Property Note:')  }}
                {{ Form::textarea('property_note',null, array('class' => 'form-control', 'tabindex'=>'27'))}}
                </fieldset>


            {{ Form::hidden('client_id', $client->id) }}

        </div>

        <!-- Side bar -->
        <div class="col-md-4">
            <div class="well">
                <div class="form-group">
                    @if(!empty($client->company_name))<h2 class="text-center">{{$client->company_name}}</h2> @endif
                    <h3 class="text-center">{{$client->first_name.' '.$client->last_name}}</h3>
                </div>
                <dl class="dl-horizontal">
                    <dt>Title:</dt>
                    <dd>{{$client->title}}</dd>
                    <dt>Cell:</dt>
                    <dd>{{$client->cell_number}}</dd>
                    <dt>Email:</dt>
                    <dd>{{$client->email}}</dd>

                    {{-- <dt>Creat at:</dt>
                    <!-- http://php.net/manual/en/function.date.php -->
                    <!-- http://php.net/manual/en/function.strtotime.php -->
                    <dd>{{ date('M j, Y - H:i', strtotime($site->created_at)) }}</dd>
                    <dt>Last Update at:</dt>
                    <dd>{{ date('M j, Y - H:i', strtotime($site->updated_at)) }}</dd> --}}
                </dl>
                <hr>

                <div class="row">
                    <div class="col-sm-6">
                        {{ Form::submit('Update', ['class' => 'btn btn-success btn-block', 'tabindex'=>'24'] )}}

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
@endsection
