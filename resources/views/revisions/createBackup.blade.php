@extends('main')

@section('title', '| Revise Technician Details')

@section('stylesheets')
	{!! Html::style('css/parsley.css') !!}
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <h1>Revise Technician Details</h1>

            {!! Form::open(array('route' => 'revisions.store', 'data-parsley-validate'=>'')) !!}    
            <div class="row">
            <div class="col-md-6">
                <fieldset class="form-group" disabled>
                {{ Form::label('tech_details', 'Arrived on site to:')  }}
                {{ Form::textarea('tech_details',$technician->tech_details, array('class' => 'form-control','required'=>''))}}
                </fieldset>
            </div>
            <div class="col-md-6">
                <fieldset class="form-group" >
                {{ Form::label('revised_tech_details', 'Arrived on site to (Revised):')  }}
                {{ Form::textarea('revised_tech_details',null, array('class' => 'form-control','required'=>''))}}
                </fieldset>
            </div>
            <div>
            
            <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <legend><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Material
                <a id="add-revised-material" class="btn btn-primary btn-sm add-button">Add</a>
                </legend>
                <div class="row" id="material-add">
                    <?php $i=0;?>
                    @foreach($materials as $material)
                        {{ Form::hidden('material_id[]', $material->id) }}
                        <span>
                        <div class="col-md-5" id="material-row-{{$i}}">
                            <fieldset class="form-group">
                                {{ Form::label('material_name_'.$i, 'Material Name:')  }}
                                {{ Form::text('material_name[]',$material->material_name, [
                                    'class' => 'form-control', 
                                    'required'=>'', 
                                    'id' => 'material_name_'.$i,
                                    'maxlength'=>'255'
                                ])}}
                            </fieldset>
                        </div>
                        <div class="col-md-2" id="material-row-{{$i}}">
                            <fieldset class="form-group">
                                {{ Form::label('material_quantity_'.$i, 'Quantity:')  }}
                                {{ Form::text('material_quantity[]',$material->material_quantity, [
                                    'class' => 'form-control', 
                                    'required'=>'', 
                                    'id' => 'material_quantity_'.$i,
                                    'data-parsley-type'=>'digits',
                                    'maxlength'=>'255'
                                ])}}
                            </fieldset>
                        </div>
                        <div class="col-md-3" id="material-row-{{$i}}">
                            <fieldset class="form-group">
                                {{ Form::label('material_cost_'.$i, 'Cost: $')  }}
                                {{ Form::text('material_cost[]',$material->material_cost, [
                                    'class' => 'form-control', 
                                    'required'=>'', 
                                    'id' => 'material_cost_'.$i,
                                    'data-parsley-pattern' =>'\d+(\.\d{1,2})?',
                                    'maxlength'=>'255'
                                ])}}
                            </fieldset>
                        </div>
                        <div class="col-md-2" id="material-row-{{$i}}">
                            <fieldset class="form-group">
                                <a id="remove-material-{{$i}}" class="btn btn-danger btn-sm remove-material">Remove</a>
                            </fieldset>
                        </div>
                        </span>
                    @endforeach
                </div>

                <div class="row">
                <div class="col-md-8">
                    <fieldset class="form-group">
                    {{ Form::label('flushing_hours', 'Flushing Hours:')  }}
                    {{ Form::text('flushing_hours',$technician->flushing_hours, [
                        'class' => 'form-control', 
                        'required'=>'', 
                        'maxlength'=>'255', 
                        'data-parsley-pattern' =>'^\d*\.?((25)|(50)|(5)|(75)|(0)|(00))?$'
                    ])}}
                    </fieldset>
                </div>
                <div class="col-md-4">
                    <fieldset class="form-group">
                    {{ Form::label('flushing_hours_cost', 'Cost: $')  }}
                    {{ Form::text('flushing_hours_cost',null, [
                        'class' => 'form-control', 
                        'required'=>'', 
                        'maxlength'=>'255', 
                        'data-parsley-pattern' =>'\d+(\.\d{1,2})?'
                    ])}}
                    </fieldset>
                </div>
                </div>

                <div class="row">
                <div class="col-md-8">
                    <fieldset class="form-group">
                    {{ Form::label('camera_hours', 'Camera Hours:')  }}
                    {{ Form::text('camera_hours',$technician->camera_hours, [
                        'class' => 'form-control', 
                        'required'=>'', 
                        'maxlength'=>'255', 
                        'data-parsley-pattern' =>'^\d*\.?((25)|(50)|(5)|(75)|(0)|(00))?$'
                    ])}}
                    </fieldset>
                </div>
                <div class="col-md-4">
                    <fieldset class="form-group">
                    {{ Form::label('camera_hours_cost', 'Cost: $')  }}
                    {{ Form::text('camera_hours_cost',null, [
                        'class' => 'form-control', 
                        'required'=>'', 
                        'maxlength'=>'255', 
                        'data-parsley-pattern' =>'\d+(\.\d{1,2})?'
                    ])}}
                    </fieldset>
                </div>
                </div>

                <div class="row">
                <div class="col-md-8">
                    <fieldset class="form-group">
                    {{ Form::label('big_auger_hours', 'Big Auger Hours:')  }}
                    {{ Form::text('big_auger_hours',$technician->big_auger_hours, [
                        'class' => 'form-control', 
                        'required'=>'', 
                        'maxlength'=>'255', 
                        'data-parsley-pattern' =>'^\d*\.?((25)|(50)|(5)|(75)|(0)|(00))?$'
                    ])}}
                    </fieldset>
                </div>
                <div class="col-md-4">
                    <fieldset class="form-group">
                    {{ Form::label('big_auger_hours_cost', 'Cost: $')  }}
                    {{ Form::text('big_auger_hours_cost',null, [
                        'class' => 'form-control', 
                        'required'=>'', 
                        'maxlength'=>'255', 
                        'data-parsley-pattern' =>'\d+(\.\d{1,2})?'
                    ])}}
                    </fieldset>
                </div>
                </div>

                <div class="row">
                <div class="col-md-8">
                    <fieldset class="form-group">
                    {{ Form::label('small_and_medium_auger_hours', 'Small & Medium Auger Hours:')  }}
                    {{ Form::text('small_and_medium_auger_hours',$technician->small_and_medium_auger_hours, [
                        'class' => 'form-control', 
                        'required'=>'', 
                        'maxlength'=>'255', 
                        'data-parsley-pattern' =>'^\d*\.?((25)|(50)|(5)|(75)|(0)|(00))?$'
                    ])}}
                    </fieldset>
                </div>
                <div class="col-md-4">
                    <fieldset class="form-group">
                    {{ Form::label('small_and_medium_auger_hours_cost', 'Cost: $')  }}
                    {{ Form::text('small_and_medium_auger_hours_cost',null, [
                        'class' => 'form-control', 
                        'required'=>'', 
                        'maxlength'=>'255', 
                        'data-parsley-pattern' =>'\d+(\.\d{1,2})?'
                    ])}}
                    </fieldset>
                </div>
                </div>

                <fieldset class="form-group">
                {{ Form::label('notes', 'Notes:')  }}
                {{ Form::textarea('notes',$technician->notes, array('class' => 'form-control'))}}
                </fieldset>

                <fieldset class="form-inline">
                {{ Form::label('equipment_left_on_site', 'Equipment Left on Site:')  }}
                <?php 
                $chbx = '';
                //echo $technician->equipment_left_on_site;
                if($technician->equipment_left_on_site){
                    $chbx=true;
                }else{
                    $chbx=false;
                }                                     
                ?>
                {{ Form::checkbox('equipment_left_on_site_chbx',1,$chbx, array('id'=>'equipment_left_on_site_chbx'))}}
                {{ Form::hidden('equipment_left_on_site', $technician->equipment_left_on_site) }}
                </fieldset>

                {{ Form::hidden('technician_id', $technician->id) }}
                {{ Form::hidden('is_revised', 1) }}
                
    		    {{ Form::submit('Revise Technician Details', array('class' => 'btn btn-success btn-lg btn-block btn-margin'))}}

                {!! Form::close() !!}

            </div>
            </div>
        </div>
    </div> <!-- /.row -->
    

@endsection

@section('scripts')
    {!! Html::script('js/default.js') !!}
	{!! Html::script('js/parsley.min.js') !!}
@endsection