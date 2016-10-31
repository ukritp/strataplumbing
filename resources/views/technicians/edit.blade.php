@extends('main')

@section('title', '| Edit Technician Details')

@section('stylesheets')
    {!! Html::style('css/parsley.css') !!}
    {!! Html::style('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/css/bootstrap-datepicker.min.css')!!}
@endsection

@section('content')

    <div class="row">
        <!-- model obj, array of other options -->
        {!! Form::model($technician, ['route' => ['technicians.update',$technician->id], 'method'=>'PUT', 'data-parsley-validate'=>''] ) !!}

        <div class="col-md-8">
            <h3>Contact: {{$contact->first_name.' '.$contact->last_name}}</h3>
            @if(!empty($contact->relationship))<p class="lead"><strong>Relationship:</strong> {{$contact->relationship}}</p>@endif
            <p class="lead"><strong>contact Address:</strong> {{
                ucwords(strtolower($contact->mailing_address)).', '.
                ucwords(strtolower($contact->mailing_city)).', '.
                strtoupper($contact->mailing_province).' '.
                strtoupper($contact->mailing_postalcode)
            }}
            </p>
            @if(!empty($contact->buzzer_code)) <p class="lead"><strong>Buzzer Code:</strong> {{$contact->buzzer_code}}</p> @endif
            <div class="row">
                <div class="col-md-6">
                    <p class="lead"><strong>Cell:</strong> {{$contact->cell_number}}</p>
                </div>
                <div class="col-md-6">
                    <p class="lead"><strong>Email:</strong> {{$contact->email}}</p>
                </div>
            </div>

            <hr>
            <h3>Job ID: {{$job->id+20100}}</h3>
            <p class="lead lead-md"><strong>Project Manager:</strong> {{$job->project_manager}}</p>
            <p class="lead lead-md"><strong>Scope Of Works:</strong><br>{{$job->scope_of_works}}</p>
            <p class="lead lead-md"><strong>Purchase Order Number:</strong><br>{{$job->purchase_order_number}}</p>
            <div class="row">
                <div class="col-md-6">
                    @if(!empty($job->first_name)) <p class="lead lead-md"><strong>Tenant:</strong> {{$job->first_name.' '.$job->last_name}}</p> @endif
                </div>
                <div class="col-md-6">
                    @if(!empty($job->cell_number)) <p class="lead lead-md"><strong>Cell:</strong> {{$job->cell_number}}</p> @endif
                </div>
            </div>

            <fieldset class="form-group required">
            {{ Form::label('pendinginvoiced_at', 'Date: (YYYY-MM-DD)', array('class'=>'control-label'))  }}
            {{ Form::text('pendinginvoiced_at',date('Y-m-d', strtotime($technician->pendinginvoiced_at)), array('class' => 'form-control', 'required'=>'', 'maxlength'=>'255'))}}
            </fieldset>

            <fieldset class="form-group required">
            {{ Form::label('technician_name', 'Technician Name:', array('class'=>'control-label'))  }}
            {{ Form::text('technician_name',null, array('class' => 'form-control', 'required'=>'', 'maxlength'=>'255'))}}
            </fieldset>

            <fieldset class="form-group required">
            {{ Form::label('tech_details', 'Technician Details:', array('class'=>'control-label'))  }}
            {{ Form::textarea('tech_details',null, array('class' => 'form-control  tech_details','required'=>''))}}
            </fieldset>

            <legend><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Material
            <a id="add-material" class="btn btn-primary btn-sm add-button">Add</a>
            </legend>

            @if(count($technician->materials)!=0)
                <div class="row">
                    <div class="col-xs-6">
                        {{ Form::label('material_name', 'Material Name:')  }}
                    </div>
                    <div class="col-xs-2">
                        {{ Form::label('material_quantity', 'Quantity:')  }}
                    </div>
                </div>
            @endif

            <div class="row" id="material-add">
                <?php $i=0;?>
                @foreach($materials as $material)
                    <input name="material_id[]" type="hidden" value="{{$material->id}}">
                    <span class="material-row-span">
                    <div class="col-xs-6" id="material-row-{{$i}}">
                        <fieldset class="form-group">
                            <input type="text" class="form-control" required="" id="material_name_0" maxlength="255" name="material_name[]"  value="{{$material->material_name}}">
                        </fieldset>
                    </div>
                    <div class="col-xs-3" id="material-row-{{$i}}">
                        <fieldset class="form-group">
                            <input type="text" class="form-control" required="" id="material_quantity_{{$i}}" data-parsley-type="digits" maxlength="255" name="material_quantity[]" value="{{$material->material_quantity}}">
                        </fieldset>
                    </div>
                    <div class="col-xs-3" id="material-row-{{$i}}">
                        <fieldset class="form-group">
                            <a id="remove-material-{{$i}}" class="btn btn-danger btn-sm btn-block remove-material">
                            <i class="glyphicon glyphicon-remove"></i></a>
                        </fieldset>
                    </div>
                    </span>
                @endforeach
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
            <?php
            $chbx = '';
            $attr_name ='';
            $attr_value = '';
            if($technician->equipment_left_on_site){
                $chbx=true;
            }else{
                $chbx=false;
                $attr_name ='disabled';
                $attr_value = 'disabled';
            }
            ?>
            {{ Form::checkbox('equipment_left_on_site_chbx',1,$chbx, array('id'=>'equipment_left_on_site_chbx'))}}
            {{ Form::hidden('equipment_left_on_site', null) }}
            {{ Form::text('equipment_name',null, array(
                    'class'     => 'form-control',
                    $attr_name  => $attr_value,
                    'id'        => 'equipment_name',
                    'maxlength' => '255'
                ))}}
            </fieldset>

            {{ Form::hidden('job_id', $job->id) }}
        </div>

        <!-- Side bar -->
        <div class="col-md-4">
            <div class="well well-mobile">
                <div class="form-group hidden-xs">
                    @if(!empty($client->company_name))<h2 class="text-center">{{$client->company_name}}</h2> @endif
                    <h3 class="text-center">{{$client->first_name.' '.$client->last_name}}</h3>
                </div>
                <dl class="dl-horizontal hidden-xs">
                    <dt>Title:</dt>
                    <dd>{{$client->title}}</dd>
                    <dt>Cell:</dt>
                    <dd>{{$client->cell_number}}</dd>
                    <dt>Email:</dt>
                    <dd>{{$client->email}}</dd>

                    <dt>Details Created:</dt>
                    <!-- http://php.net/manual/en/function.date.php -->
                    <!-- http://php.net/manual/en/function.strtotime.php -->
                    <dd>{{ date('M j, Y - H:i', strtotime($technician->created_at)) }}</dd>
                    <dt>Details Last Updated:</dt>
                    <dd>{{ date('M j, Y - H:i', strtotime($technician->updated_at)) }}</dd>
                </dl>
                <hr>

                <div class="row">
                    <div class="col-sm-6 form-group">
                        {{ Form::submit('Update', ['class' => 'btn btn-success btn-block'] )}}
                    </div>
                    {!! Form::close() !!}

                    <div class="col-sm-6 ">
                        <div class="modal modal-effect-blur" id="modal-1">
                            <div class="modal-content">
                                <h3>Are you sure you want to cancel?</h3>
                                <p class="text-center">*everything you edited so far will be gone</p>
                                <div>
                                    <button class="modal-yes">Yes</button>
                                    <button class="modal-no">No</button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-overlay"></div>
                        <a class="btn btn-danger btn-block confirm-cancel-modal" data-href="{{url()->previous()}}">Cancel</a>
                    </div>
                </div>

            </div>
        </div>


    </div> <!-- /.row -->

@endsection

@section('scripts')
    {!! Html::script('js/parsley.min.js') !!}
    {!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/js/bootstrap-datepicker.min.js')!!}
    {!! Html::script('js/datepicker.js') !!}
@endsection
