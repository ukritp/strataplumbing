@extends('main')

@section('title', '| Create New Jobs')

@section('stylesheets')
	{!! Html::style('css/parsley.css') !!}
@endsection

@section('content')

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>Create New Job</h1>

            <div class="jumbotron">
                @if(!empty($client->company_name)) <h2>Company: {{$client->company_name}}</h2> @endif
                @if(isset($site))
                    <h3>{{$site->first_name.' '.$site->last_name}}</h3>
                    <p class="lead"><strong>Relationship:</strong> {{$site->relationship}}</p>
                    <p class="lead"><strong>Site Address:</strong> {{
                        ucwords(strtolower($site->mailing_address)).', '.
                        ucwords(strtolower($site->mailing_city)).', '.
                        strtoupper($site->mailing_province).' '.
                        strtoupper($site->mailing_postalcode)
                    }}
                    </p>
                    @if(!empty($site->buzzer_code)) <p class="lead"><strong>Buzzer Code:</strong> {{$site->buzzer_code}}</p> @endif
                    <div class="row">
                        <div class="col-md-6">
                            <p class="lead"><strong>Cell:</strong> {{$site->cell_number}}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="lead"><strong>Email:</strong> {{$site->email}}</p>
                        </div>
                    </div>
                @else
                    <h3>{{$client->first_name.' '.$client->last_name}}</h3>
                    <p class="lead"><strong>Address:</strong> {{
                        ucwords(strtolower($client->mailing_address)).', '.
                        ucwords(strtolower($client->mailing_city)).', '.
                        strtoupper($client->mailing_province).' '.
                        strtoupper($client->mailing_postalcode)
                    }}
                    </p>
                    @if(!empty($client->buzzer_code)) <p class="lead"><strong>Buzzer Code:</strong> {{$client->buzzer_code}}</p> @endif
                    <div class="row">
                        <div class="col-md-6">
                            <p class="lead"><strong>Cell:</strong> {{$client->cell_number}}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="lead"><strong>Email:</strong> {{$client->email}}</p>
                        </div>
                    </div>
                @endif

            </div>

            {!! Form::open(array('route' => 'jobs.store', 'data-parsley-validate'=>'')) !!}

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
                    <input type="radio" name="is_estimate" id="is_estimate1" value="0" checked> Regular Job
                </label>
                <label class="radio-inline">
                    <input type="radio" name="is_estimate" id="is_estimate2" value="1" > Estimate Job
                </label>
                </fieldset>

                <fieldset class="form-group required">
			    {{ Form::label('scope_of_works', 'Scope Of Work:', array('class'=>'control-label'))  }}
			    {{ Form::textarea('scope_of_works',null, array('class' => 'form-control','required'=>''))}}
                </fieldset>

                <div class="checkbox">
                    <label>
                    <input type="checkbox" name="tenant_checkbox" id="tenant_checkbox"> There is a tenant?
                    </label>
                </div>

                <div class="row toggle">
                    <div class="col-md-6">
                        <fieldset class="form-group">
                        {{ Form::label('first_name', 'First Name:')  }}
                        {{ Form::text('first_name',null, array('class' => 'form-control', 'maxlength'=>'255'))}}
                        </fieldset>
                    </div>
                    <div class="col-md-6">
                        <fieldset class="form-group">
                        {{ Form::label('last_name', 'Last Name:')  }}
                        {{ Form::text('last_name',null, array('class' => 'form-control', 'maxlength'=>'255'))}}
                        </fieldset>
                    </div>
                    <div class="col-md-12">
                        <fieldset class="form-group">
                        {{ Form::label('cell_number', 'Cell Number:')  }}
                        {{ Form::text('cell_number',null, array(
                            'class'             => 'form-control',
                            'minlength'         =>'10' ,
                            'maxlength'         =>'10',
                            'data-parsley-type' =>'digits'
                        ))}}
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

			    {{ Form::submit('Create Job', array('class' => 'btn btn-success btn-lg btn-block btn-margin'))}}

                <div class="row">
                    <div class="col-sm-12">
                        <a href="{{url()->previous()}}" class="btn btn-danger btn-lg btn-block btn-margin">Cancel</a>
                    </div>
                </div>

			{!! Form::close() !!}

        </div>
    </div> <!-- /.row -->


@endsection

@section('scripts')
	{!! Html::script('js/parsley.min.js') !!}
    {!! Html::script('js/default.js') !!}
@endsection