@extends('main')

@section('title', '| Edit Job')

@section('stylesheets')
    {!! Html::style('css/parsley.css') !!}
@endsection

@section('content')

    <div class="row">
        <!-- model obj, array of other options -->
        {!! Form::model($job, ['route' => ['jobs.update',$job->id], 'method'=>'PUT', 'data-parsley-validate'=>''] ) !!}

        <div class="col-md-8">
            @if(!empty($site))
            <h2>Site ID: {{$site->id}}</h2>
            <hr>
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
            <hr>
            @endif

            <h3>Editing Job ID: {{$job->id+20100}}</h3>
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

                    <dt>Job Created at:</dt>
                    <!-- http://php.net/manual/en/function.date.php -->
                    <!-- http://php.net/manual/en/function.strtotime.php -->
                    <dd>{{ date('M j, Y - H:i', strtotime($job->created_at)) }}</dd>
                    <dt>Job Last Updated at:</dt>
                    <dd>{{ date('M j, Y - H:i', strtotime($job->updated_at)) }}</dd>
                </dl>
                <hr>

                <div class="row">
                    <div class="col-sm-6">
                        {{ Form::submit('Update', ['class' => 'btn btn-success btn-block'] )}}

                    </div>
                    <div class="col-sm-6">
                        <a href="{{url()->previous()}}" class="btn btn-danger btn-block">Cancel</a>
                    </div>
                </div>

            </div>
        </div>

        {!! Form::close() !!}
    </div> <!-- /.row -->

@endsection

@section('scripts')
    {!! Html::script('js/parsley.min.js') !!}
@endsection
