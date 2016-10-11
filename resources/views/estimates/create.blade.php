@extends('main')

@section('title', '| Estimate Invoice')

@section('stylesheets')
    {!! Html::style('css/parsley.css') !!}
    {!! Html::style('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/css/bootstrap-datepicker.min.css')!!}
@endsection

@section('content')

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h1>Create Estimate Invoice for Job ID: {{$job->id+20100}}</h1>

        {!! Form::open(array('route' => 'estimates.store', 'data-parsley-validate'=>'')) !!}

        {{ Form::label('date_from', 'Issued Date:', array('class'=>'control-label'))}}
        <div class="form-group input-group input-daterange">
            {{ Form::text('date_from',null, array('class' => 'form-control', 'id'=>'date_from','maxlength'=>'255'))}}
            <span class="input-group-addon">to</span>
            {{ Form::text('date_to',null, array('class' => 'form-control','id'=>'date_to', 'maxlength'=>'255'))}}
        </div>

        <fieldset class="form-group required" >
        {{ Form::label('description', 'Description:', array('class'=>'control-label'))  }}
        {{ Form::textarea('description', null, array(
            'class'    => 'form-control description',
            'id'       => '',
            'required' =>''
        ))}}
        </fieldset>

        <fieldset class="form-group required">
        {{ Form::label('cost', 'Cost: $', array('class'=>'control-label'))  }}
        {{ Form::text('cost',null, array(
                        'class' => 'form-control',
                        'required'=>'',
                        'maxlength'=>'255',
                        'data-parsley-pattern' =>'\d+(\.\d{1,2})?'
                    ))}}
        </fieldset>

        <fieldset class="form-group" >
        {{ Form::label('extras', "Extra's:")  }}
        {{ Form::textarea('extras', null, array(
            'class'    => 'form-control description',
            'id'       => 'extras',
        ))}}
        </fieldset>

        @set('hour_validation_pattern','^\d*\.?((25)|(50)|(5)|(75)|(0)|(00))?$')
        @set('cost_validation_pattern','\d{1,3}[,\\.]?(\\d{1,2})?')

        <!-- Extra's section -->
        <legend><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Extra's
        <a id="add-extras" class="btn btn-primary btn-sm add-button">Add</a>
        </legend>

        <div class="row" id="extras-add">
        </div>



        <!-- Materials section -->
        <div class="col-md-12 grey-background">
            <h4>Materials</h4>
        </div>
        @foreach($job->technicians as $index => $technician)
        <div class="material-each-tech">

            @if(count($technician->materials)!=0)
                <div class="col-xs-10 col-xs-offset-1">
                    <h4>Name: {{$technician->technician_name}}</h4>
                    <hr>
                </div>
                <div class="row">
                    <div class="col-xs-10 col-xs-offset-1">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> <b>Material</b>
                        <a data-tech-id="{{$technician->id}}" class="btn btn-primary btn-sm add-button add-revised-material">Add</a>
                    </div>
                </div>

                <div class="row" id="material-add-{{$technician->id}}">
                </div>

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
        </div>
        @endforeach {{-- end foreach job->tech --}}

        {{ Form::submit('Create Estimate Invoice', array('class' => 'btn btn-success btn-lg btn-block btn-margin'))}}
        <fieldset class="form-group">
        {!! Html::linkRoute('jobs.show', 'Back to Job', array($job->id), array('class'=>'btn btn-danger  btn-lg btn-block btn-margin') ) !!}
        </fieldset>

        {!! Form::close() !!}
    </div>
</div> <!-- /.row -->


@endsection

@section('scripts')
    {!! Html::script('js/parsley.min.js') !!}
    {!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/js/bootstrap-datepicker.min.js')!!}
    {!! Html::script('js/default.js') !!}
    {!! Html::script('js/datepicker.js') !!}
@endsection