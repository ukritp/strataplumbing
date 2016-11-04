@extends('main')

@section('title', '| Create New Technician Details')

@section('stylesheets')
	{!! Html::style('css/parsley.css') !!}
    {!! Html::style('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/css/bootstrap-datepicker.min.css')!!}
@endsection

@section('content')

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>Create New Technician Details</h1>

            <div style="background-color: #eee; padding: 2%; margin:1% 0;">

                @set('contact_first_name', $job->client->first_name)
                @set('contact_last_name', $job->client->last_name)
                @if(isset($job->site))
                    @if(count($job->site->contacts)>0)
                        @set('contact_first_name', $job->site->contacts->first()->first_name)
                        @set('contact_last_name', $job->site->contacts->first()->last_name)
                    @endif
                @endif
                <h3>Contact: {{$contact_first_name.' '.$contact_last_name}}</h3>
                <p class="lead-md"><strong>Address:</strong> {{$contact->fullMailindAddress()}}
                </p>

                @if(isset($job->site))
                    <?php
                    $buzzer_code = $job->client->buzzer_code;
                    $alarm_code = '';
                    $lock_box = '';
                    $lock_box_location = '';

                    if(count($job->site->contacts)>0){
                        $buzzer_code = $job->site->contacts->first()->buzzer_code;
                        $alarm_code = $job->site->contacts->first()->alarm_code;
                        $lock_box = $job->site->contacts->first()->lock_box;
                        $lock_box_location = $job->site->contacts->first()->lock_box_location;
                    }
                    ?>
                    <div class="row">
                        @if(!empty($buzzer_code))
                        <div class="col-md-6">
                            <p class="lead-md"><strong>Buzzer Code:</strong> {{$buzzer_code}}</p>
                        </div>
                        @endif
                        @if(!empty($alarm_code))
                        <div class="col-md-6">
                            <p class="lead-md"><strong>Alarm Code:</strong> {{$alarm_code}}</p>
                        </div>
                        @endif
                        @if(!empty($lock_box))
                        <div class="col-md-6">
                            <p class="lead-md"><strong>Lock Box:</strong> {{$lock_box}}</p>
                        </div>
                        @endif
                        @if(!empty($lock_box_location))
                        <div class="col-md-6">
                            <p class="lead-md"><strong>Lock Box Location:</strong> {{$lock_box_location}}</p>
                        </div>
                        @endif
                    </div>
                @else
                    @if(!empty($contact->buzzer_code)) <p class="lead-md"><strong>Buzzer Code:</strong> {{$contact->buzzer_code}}</p> @endif
                @endif

                <p class="lead-md"><strong>Project Manager:</strong> {{$job->project_manager}}</p>
                <p class="lead-md"><strong>Scope Of Works:</strong><br>{{$job->scope_of_works}}</p>

            </div>

            {!! Form::open(array('route' => 'technicians.store', 'data-parsley-validate'=>'')) !!}

                <fieldset class="form-group required">
                {{ Form::label('pendinginvoiced_at', 'Date: (YYYY-MM-DD)', array('class'=>'control-label'))  }}
                {{ Form::text('pendinginvoiced_at',null, array('class' => 'form-control', 'required'=>'',  'maxlength'=>'255'))}}
                </fieldset>

                <fieldset class="form-group required">
                {{ Form::label('technician_name', 'Technician Name:', array('class'=>'control-label'))  }}
                {{ Form::text('technician_name',null, array('class' => 'form-control', 'required'=>'', 'maxlength'=>'255'))}}
                </fieldset>

                @set('starting_words','Arrived on site to ')
                <fieldset class="form-group required">
			    {{ Form::label('tech_details', 'Technician Details:', array('class'=>'control-label'))  }}
			    {{ Form::textarea('tech_details',$starting_words, array('class' => 'form-control tech_details', 'id'=>'tech_details', 'required'=>'', 'placeholder'=>'Arrived on site to...'))}}
                </fieldset>

                <legend><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Material
                <a id="add-material" class="btn btn-primary btn-sm add-button">Add</a>
                </legend>

                <div class="row" id="material-add">
                </div>

                <fieldset class="form-group">
                {{ Form::label('flushing_hours', 'Flushing Hours:')  }}
                {{ Form::text('flushing_hours',null, [
                    'class' => 'form-control',
                    //'required'=>'',
                    'maxlength'=>'255',
                    'data-parsley-pattern' =>'^\d*\.?((25)|(50)|(5)|(75)|(0)|(00))?$'
                ])}}
                </fieldset>

                <fieldset class="form-group">
                {{ Form::label('camera_hours', 'Camera Hours:')  }}
                {{ Form::text('camera_hours',null, [
                    'class' => 'form-control',
                    //'required'=>'',
                    'maxlength'=>'255',
                    'data-parsley-pattern' =>'^\d*\.?((25)|(50)|(5)|(75)|(0)|(00))?$'
                ])}}
                </fieldset>

                <fieldset class="form-group">
                {{ Form::label('main_line_auger_hours', 'Main Line Auger Hours:')  }}
                {{ Form::text('main_line_auger_hours',null, [
                    'class' => 'form-control',
                    //'required'=>'',
                    'maxlength'=>'255',
                    'data-parsley-pattern' =>'^\d*\.?((25)|(50)|(5)|(75)|(0)|(00))?$'
                ])}}
                </fieldset>

                <fieldset class="form-group">
                {{ Form::label('other_hours', 'Other Hours:')  }}
                {{ Form::text('other_hours',null, [
                    'class' => 'form-control',
                    //'required'=>'',
                    'maxlength'=>'255',
                    'data-parsley-pattern' =>'^\d*\.?((25)|(50)|(5)|(75)|(0)|(00))?$'
                ])}}
                </fieldset>

                <fieldset class="form-group">
                {{ Form::label('notes', 'Recommendations / Notes:')  }}
                {{ Form::textarea('notes',null, array('class' => 'form-control'))}}
                </fieldset>

                <fieldset class="form-inline">
                {{ Form::label('equipment_left_on_site', 'Equipment Left on Site:')  }}
                {{ Form::checkbox('equipment_left_on_site_chbx',1,false, array('id'=>'equipment_left_on_site_chbx'))}}
                {{ Form::hidden('equipment_left_on_site', '0') }}
                {{ Form::text('equipment_name',null, array(
                    'class'     => 'form-control',
                    'disabled'  => 'disabled',
                    'id'        => 'equipment_name',
                    'maxlength' => '255'
                ))}}
                </fieldset>

                {{ Form::hidden('job_id', $job->id) }}

			    {{ Form::submit('Save Technician Details', array('class' => 'btn btn-success btn-lg btn-block btn-margin'))}}
                {!! Form::close() !!}

                <fieldset class="form-group">
                <div class="modal modal-effect-blur" id="modal-1">
                    <div class="modal-content">
                        <h3>Are you sure you want to cancel?</h3>
                        <p class="text-center">*everything you wrote so far will be gone</p>
                        <div>
                            <button class="modal-yes">Yes</button>
                            <button class="modal-no">No</button>
                        </div>
                    </div>
                </div>
                <div class="modal-overlay"></div>
                <a class="btn btn-danger btn-lg btn-block btn-margin confirm-cancel-modal" data-href="{{route('jobs.show',$job->id)}}">Cancel Tech Detail</a>
                </fieldset>


        </div>
    </div> <!-- /.row -->


@endsection

@section('scripts')
	{!! Html::script('js/parsley.min.js') !!}
    {!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/js/bootstrap-datepicker.min.js')!!}
    {!! Html::script('js/datepicker.js') !!}
@endsection