@extends('main')

@section('title', '| Pening Invoice')

@section('stylesheets')
	{!! Html::style('css/parsley.css') !!}
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <h1>Create Pending Invoice for Job ID: {{$technicians->last()->job_id+20100}}</h1>
        <p class="lead"><b>For the day:</b> {{date('M j, Y', strtotime($technicians->last()->pendinginvoiced_at))}}</p>
        <p class="lead"><strong>Project Manager:</strong> {{$technicians->last()->job->project_manager}}</p>
        <p class="lead">
            <b>There were {{count($technicians)}} technician for this day:</b>
            @foreach($technicians as $technician)
                @if($technician != $technicians->last())
                    {{ucwords(strtolower($technician->technician_name)).', '}}
                @else
                    {{ucwords(strtolower($technician->technician_name))}}
                @endif
            @endforeach
        </p>

        {!! Form::open(array('route' => 'pendinginvoices.store', 'data-parsley-validate'=>'')) !!}

        <div class="row">
            <!-- Left section -->
            <div class="col-md-6 pending-invoice-column">
                {{ Form::label('consolidate-tech-details', 'Description:')  }}
                <div class="form-group consolidate-tech-details">
                    @set('consolidated_details','')
                    @foreach($technicians as $technician)
                    <?php $consolidated_details .= $technician->tech_details."\r\n\r\n" ?>
                    <h3>{{ucwords(strtolower($technician->technician_name)).':'}}</h3>
                    <p class="paragraph-wrap">{{$technician->tech_details}}</p>
                    @endforeach
                </div>

                <!-- Tech info section -->
                <div class="row">

                    @foreach($technicians as $i => $technician)
                    <div class="material-each-tech">
                        <div class="col-md-12 grey-background">
                            <h4>Name: {{$technician->technician_name}}</h4>
                        </div>
                        <input type="hidden" name="technician_id[]" value="{{$technician->id}}">

                        @set('hour_validation_pattern','^\d*\.?((25)|(50)|(5)|(75)|(0)|(00))?$')
                        @set('cost_validation_pattern','\d{1,3}[,\\.]?(\\d{1,2})?')


                        <!-- Materials section -->
                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-xs-10 col-xs-offset-1">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> <b>Material</b>
                                <a data-tech-id="{{$technician->id}}" class="btn btn-primary btn-sm add-button add-revised-material">Add</a>
                            </div>
                        </div>



                        @if(count($technician->materials)!=0)
                            <div class="row">
                                <div class="col-xs-5 col-xs-offset-1">
                                    {{ Form::label('material_name', 'Material Name:')  }}
                                </div>
                                <div class="col-xs-2">
                                    {{ Form::label('material_quantity', 'Quantity:')  }}
                                </div>
                                <div class="col-xs-3 off-set-1">
                                    {{ Form::label('material_cost_', 'Cost: $')  }}
                                </div>
                            </div>
                        @endif

                        <div class="row" id="material-add-{{$technician->id}}">
                        </div>

                        @foreach($technician->materials as $j => $material)

                            <input type="hidden" name="material_id[{{$technician->id}}][]" value="{{$material->id}}">
                            <div class="row">
                            <div class="col-xs-5 col-xs-offset-1" id="material-row-{{$j}}">
                                <fieldset class="form-group">
                                    {{-- {{ Form::label('material_name_'.$j, 'Material Name:')  }} --}}
                                    <input type="text" id="material_name" name="material_name[{{$technician->id}}][]" value="{{$material->material_name}}" class="form-control" maxlength="255" required>
                                </fieldset>
                            </div>
                            <div class="col-xs-2" id="material-row-{{$j}}">
                                <fieldset class="form-group">
                                    {{-- {{ Form::label('material_quantity_'.$j, 'Quantity:')  }} --}}
                                    <input type="text" id="material_quantity" name="material_quantity[{{$technician->id}}][]" value="{{$material->material_quantity}}" class="form-control" data-parsley-type="digits"  maxlength="255" required>
                                </fieldset>
                            </div>
                            <div class="col-xs-3 off-set-1" id="material-row-{{$j}}">
                                <fieldset class="form-group">
                                    {{-- {{ Form::label('material_cost_'.$j, 'Cost: $')  }} --}}
                                    <input type="text" id="material_cost" name="material_cost[{{$technician->id}}][]" value="{{$material->material_cost}}" class="form-control" data-parsley-pattern="{{$cost_validation_pattern}}"  maxlength="255" required>
                                </fieldset>
                            </div>
                            </div>
                        @endforeach <!-- Materials section -->

                        <!-- Hours section -->
                        <div class="row">

                        <!-- Flushing hours section -->
                        <div class="col-xs-7 col-xs-offset-1">
                            <fieldset class="form-group">
                            {{ Form::label('flushing_hours', 'Flushing Hours:')  }}
                            <input type="text" id="flushing_hours[]" name="flushing_hours[{{$technician->id}}]" value="{{$technician->flushing_hours}}" class="form-control" data-parsley-pattern="{{$hour_validation_pattern}}"  maxlength="255">
                            </fieldset>
                        </div>
                        <div class="col-xs-3 off-set-1">
                            <fieldset class="form-group">
                            {{ Form::label('flushing_hours_cost', 'Cost: $')  }}
                            <input type="text" id="flushing_hours_cost[]" name="flushing_hours_cost[{{$technician->id}}]" value="{{$technician->flushing_hours_cost}}" class="form-control" data-parsley-pattern="{{$cost_validation_pattern}}"  maxlength="255">
                            </fieldset>
                        </div>
                        <!-- Camera hours section -->
                        <div class="col-xs-7 col-xs-offset-1">
                            <fieldset class="form-group">
                            {{ Form::label('camera_hours', 'Camera Hours:')  }}
                            <input type="text" id="camera_hours[]" name="camera_hours[{{$technician->id}}]" value="{{$technician->camera_hours}}" class="form-control" data-parsley-pattern="{{$hour_validation_pattern}}"  maxlength="255">
                            </fieldset>
                        </div>
                        <div class="col-xs-3 off-set-1">
                            <fieldset class="form-group">
                            {{ Form::label('camera_hours_cost', 'Cost: $')  }}
                            <input type="text" id="camera_hours_cost[]" name="camera_hours_cost[{{$technician->id}}]" value="{{$technician->camera_hours_cost}}" class="form-control" data-parsley-pattern="{{$cost_validation_pattern}}"  maxlength="255">
                            </fieldset>
                            </fieldset>
                        </div>
                        <!-- Main Line Auger hours section -->
                        <div class="col-xs-7 col-xs-offset-1">
                            <fieldset class="form-group">
                            {{ Form::label('main_line_auger_hours', 'Main Line Auger Hours:')  }}
                            <input type="text" id="main_line_auger_hours[]" name="main_line_auger_hours[{{$technician->id}}]" value="{{$technician->main_line_auger_hours}}" class="form-control" data-parsley-pattern="{{$hour_validation_pattern}}"  maxlength="255">
                            </fieldset>
                        </div>
                        <div class="col-xs-3  off-set-1">
                            <fieldset class="form-group">
                            {{ Form::label('main_line_auger_hours_cost', 'Cost: $')  }}
                            <input type="text" id="main_line_auger_hours_cost[]" name="main_line_auger_hours_cost[{{$technician->id}}]" value="{{$technician->main_line_auger_hours_cost}}" class="form-control" data-parsley-pattern="{{$cost_validation_pattern}}"  maxlength="255">
                            </fieldset>
                        </div>
                        <!-- Other hours section -->
                        <div class="col-xs-7 col-xs-offset-1">
                            <fieldset class="form-group">
                            {{ Form::label('other_hours', 'Other Hours:')  }}
                            <input type="text" id="other_hours[]" name="other_hours[{{$technician->id}}]" value="{{$technician->other_hours}}" class="form-control" data-parsley-pattern="{{$hour_validation_pattern}}"  maxlength="255">
                            </fieldset>
                            </fieldset>
                        </div>
                        <div class="col-xs-3 off-set-1">
                            <fieldset class="form-group">
                            {{ Form::label('other_hours_cost', 'Cost: $')  }}
                            <input type="text" id="other_hours_cost[]" name="other_hours_cost[{{$technician->id}}]" value="{{$technician->other_hours_cost}}" class="form-control" data-parsley-pattern="{{$cost_validation_pattern}}"  maxlength="255">
                            </fieldset>
                        </div>

                        </div> <!-- END Hours section -->

                        <!-- Note section -->
                        @if(!empty($technician->notes))
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1">
                                <p class="lead-md paragraph-wrap"><strong>Notes:</strong><br>{{$technician->notes}}</p>
                            </div>
                        </div>
                        @endif <!-- END Note section -->


                        <!-- Equipment left on site section -->
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 equipment-left-div">
                                <fieldset class="form-inline">
                                {{ Form::label('equipment_left_on_site_revised', 'Equipment Left on Site:')  }}

                                @set('chbx','')
                                @set('attr_name','')
                                @set('attr_value','')
                                @if($technician->equipment_left_on_site)
                                    @set('chbx',true)
                                @else
                                    @set('chbx',false)
                                    @set('attr_name','disabled')
                                    @set('attr_value','disabled')
                                @endif

                                {{ Form::checkbox('equipment_left_on_site_revised_chbx',1,$chbx, array(
                                    'id'=>'equipment_left_on_site_revised_chbx_'.$i,
                                    'class'=>'equipment_left_on_site_revised_chbx'
                                ))}}
                                <input type="hidden" class="equipment_left_on_site" name="equipment_left_on_site[{{$technician->id}}]" value="{{$technician->equipment_left_on_site}}">
                                <input type="text" id="equipment_name" name="equipment_name[{{$technician->id}}]" value="{{$technician->equipment_name}}" class="form-control equipment_name" {{$attr_name}}="{{$attr_value}}"  maxlength="255">
                                </fieldset>

                            </div>
                        </div>  <!-- END Equipment left on site sectgion -->

                    </div>

                    @endforeach   <!-- END foreach Technicians -->

                </div>

            </div>  <!-- END Left section -->

            <!-- Right section -->
            <div class="col-md-6">
                <fieldset class="form-group required" >
                {{ Form::label('description', 'Description:', array('class'=>'control-label'))  }}
                {{ Form::textarea('description', $consolidated_details, array(
                    'class'    => 'form-control description',
                    'id'       => 'description',
                    'required' =>''
                ))}}
                </fieldset>

                <fieldset class="form-group">
                {{ Form::label('labor_description', 'Labor Description (eg. 2 men with equipment): ')  }}
                {{ Form::text('labor_description',null, array(
                                'class'     => 'form-control',
                                //'required'  => '',
                                'maxlength' => '255'
                            ))}}
                </fieldset>

                <div class="row">
                    <div class="col-xs-6">
                        <fieldset class="form-group required">
                        {{ Form::label('total_hours', 'Total Labor Hours: ', array('class'=>'control-label'))  }}
                        {{ Form::text('total_hours',null, array(
                                        'class'     => 'form-control',
                                        'required'  => '',
                                        'maxlength' => '255',
                                        'data-parsley-pattern' => '^\d*\.?((25)|(50)|(5)|(75)|(0)|(00))?$'
                                    ))}}
                        </fieldset>
                    </div>
                    <div class="col-xs-6">
                        <fieldset class="form-group required">
                        {{ Form::label('hourly_rates', 'Hourly Rates: $', array('class'=>'control-label'))  }}
                        {{ Form::text('hourly_rates',null, array(
                                        'class' => 'form-control',
                                        'required'=>'',
                                        'maxlength'=>'255',
                                        'data-parsley-pattern' =>'\d+(\.\d{1,2})?'
                                    ))}}
                        </fieldset>
                    </div>
                </div>

                <fieldset class="form-inline">
                {{ Form::label('seperate_first_half_hour', 'Charge first 1/2 hour:')  }}
                {{ Form::checkbox('seperate_first_half_hour_chbx',1,false, array('id'=>'seperate_first_half_hour_chbx'))}}
                {{ Form::hidden('seperate_first_half_hour', '0') }}
                {{ Form::text('first_half_hour_amount',null, array(
                    'class'                => 'form-control',
                    'disabled'             => 'disabled',
                    'id'                   => 'first_half_hour_amount',
                    'data-parsley-pattern' =>'\d+(\.\d{1,2})?',
                    'maxlength'            => '255'
                ))}}
                </fieldset>
                <br>
                <fieldset class="form-inline">
                {{ Form::label('seperate_first_one_hour', 'Charge first 1 hour:')  }}
                {{ Form::checkbox('seperate_first_one_hour_chbx',1,false, array('id'=>'seperate_first_one_hour_chbx'))}}
                {{ Form::hidden('seperate_first_one_hour', '0') }}
                {{ Form::text('first_one_hour_amount',null, array(
                    'class'                => 'form-control',
                    'disabled'             => 'disabled',
                    'id'                   => 'first_one_hour_amount',
                    'data-parsley-pattern' =>'\d+(\.\d{1,2})?',
                    'maxlength'            => '255'
                ))}}
                </fieldset>

            </div> <!-- END Right section -->

            <div class="col-md-12">
                {{ Form::hidden('job_id', $technicians->last()->job_id) }}
                {{ Form::hidden('date', date('d', strtotime($technicians->last()->pendinginvoiced_at))) }}
                {{ Form::hidden('month', date('m', strtotime($technicians->last()->pendinginvoiced_at))) }}
                {{ Form::hidden('year', date('Y', strtotime($technicians->last()->pendinginvoiced_at))) }}
                {{ Form::hidden('is_revised', 1) }}
    		    {{ Form::submit('Create Pending Invoice', array('class' => 'btn btn-success btn-lg btn-block btn-margin'))}}
                <fieldset class="form-group">
                {!! Html::linkRoute('jobs.show', 'Back to Job', array($technicians->last()->job_id), array('class'=>'btn btn-danger  btn-lg btn-block btn-margin') ) !!}
                </fieldset>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
</div> <!-- /.row -->


@endsection

@section('scripts')
	{!! Html::script('js/parsley.min.js') !!}
@endsection