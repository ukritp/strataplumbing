@extends('main')

@section('title', '| Revise Technician Details')

@section('stylesheets')
	{!! Html::style('css/parsley.css') !!}
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <h1>Create Pending Invoice for Job ID: {{$job->id}}</h1>
        <p class="lead"><b>For the day:</b> {{date('M j, Y', strtotime($technicians->last()->updated_at))}}</p>
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

        {!! Form::open(array('route' => 'revisions.store', 'data-parsley-validate'=>'')) !!}    

        <div class="row">

            <div class="col-md-6 pending-invoice-column">
                {{ Form::label('consolidate-tech-details', 'Arrived on site to:')  }}
                <div class="form-group consolidate-tech-details">
                    @foreach($technicians as $technician)
                    <h3>{{ucwords(strtolower($technician->technician_name)).':'}}</h3>
                    <p>{{$technician->tech_details}}</p>
                    @endforeach
                </div>
                
                <!-- Other section -->
                <div class="row">
                    <?php $j=0;?>
                    @foreach($technicians as $technician)
                    <div class="material-each-tech">
                    <div class="col-md-12 grey-background">
                        <h4>Name: {{$technician->technician_name}}</h4>
                    </div>

                    <div class="col-md-10">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> <b>Materials List</b>
                    </div>
                    <div class="col-md-2">
                        <a id="add-revised-material" class="btn btn-primary btn-sm btn-block add-revised-material">Add</a>
                    </div>
                    
                    <div id="material-add" class="material-add">
                    <!-- Material section -->
                    <?php $i=0;?>
                    @foreach($technician->materials as $material)
                        {{ Form::hidden('material_id[]', $material->id) }}
                        <span class="material-row-span">
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
                                <a id="remove-material-{{$i}}" class="btn btn-danger btn-sm remove-material-revised">Remove</a>
                            </fieldset>
                        </div>
                        </span>
                    @endforeach <!-- End Foreach Materials -->
                    </div>
                    </div>
                    <!-- End Material -->
                    
                    <!-- Hours section -->
                    <div class="row">
                    <div class="col-md-7 col-md-offset-1">
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
                    <div class="col-md-3 off-set-1">
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
                    <div class="col-md-7 col-md-offset-1">
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
                    <div class="col-md-3 off-set-1">
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
                    <div class="col-md-7 col-md-offset-1">
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
                    <div class="col-md-3  off-set-1">
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
                    <div class="col-md-7 col-md-offset-1">
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
                    <div class="col-md-3 off-set-1">
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
                    <!-- End Hour -->

                    <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                    @if(!empty($technician->notes)) 
                        <p class="lead-md"><strong>Notes:</strong> {{$technician->notes}}</p>
                    @endif
                    </div>
                    </div>
                    
                    <div class="row">
                    <div class="col-md-10 col-md-offset-1 equipment-left-div">
                        <fieldset class="form-inline">
                        {{ Form::label('equipment_left_on_site_revised', 'Equipment Left on Site:')  }}
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
                        {{ Form::checkbox('equipment_left_on_site_revised_chbx',1,$chbx, array(
                            'id'=>'equipment_left_on_site_revised_chbx_'.$j,
                            'class'=>'equipment_left_on_site_revised_chbx'
                        ))}}
                        {{ Form::hidden('equipment_left_on_site[]',$technician->equipment_left_on_site, array(
                            'class'=>'equipment_left_on_site'
                        ))}}
                        {{ Form::text('equipment_name',$technician->equipment_name, array(
                                'class'     => 'form-control equipment_name',
                                $attr_name  => $attr_value,
                                'id'        => 'equipment_name_'.$j,
                                'maxlength' => '255'
                            ))}}
                        </fieldset>

                    </div>
                    </div>
                
                    @endforeach  <!-- End Foreach Technicians -->
                </div>
                

            </div>


            <div class="col-md-6">
                <fieldset class="form-group" >
                {{ Form::label('revised_tech_details', 'Pending Invoice:')  }}
                {{ Form::textarea('revised_tech_details',null, array(
                    'class' => 'form-control',
                    'required'=>'',
                    'id' => 'revised_tech_details'
                ))}}
                </fieldset>
            </div>

        

            <div class="col-md-12">
                {{ Form::hidden('technician_id', $technician->id) }}
                {{ Form::hidden('is_revised', 1) }}
    		    {{ Form::submit('Revise Technician Details', array('class' => 'btn btn-success btn-lg btn-block btn-margin'))}}
            </div>

            {!! Form::close() !!}
        </div>
    </div>
</div> <!-- /.row -->
    

@endsection

@section('scripts')
    {!! Html::script('js/default.js') !!}
	{!! Html::script('js/parsley.min.js') !!}
@endsection