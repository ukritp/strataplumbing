@extends('main')

@section('title', '| Edit Estimate Invoice')

@section('stylesheets')
    {!! Html::style('css/parsley.css') !!}
    {!! Html::style('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/css/bootstrap-datepicker.min.css')!!}
@endsection

@section('content')

    <div class="row">
        <div class="col-md-8">

        <h3>Editing Estimate Invoice for Job ID: {{$estimate->job->id+20100}}</h3>
        <!-- model obj, array of other options -->
        {!! Form::model($estimate, ['route' => ['estimates.update',$estimate->id], 'method'=>'PUT', 'data-parsley-validate'=>''] ) !!}

        {{ Form::label('date_from', 'Issued Date:', array('class'=>'control-label'))}}
        <div class="form-group input-group input-daterange">
            {{ Form::text('date_from',date('Y-m-d', strtotime($estimate->invoiced_from)), array('class' => 'form-control', 'id'=>'date_from','maxlength'=>'255'))}}
            <span class="input-group-addon">to</span>
            {{ Form::text('date_to',date('Y-m-d', strtotime($estimate->invoiced_to)), array('class' => 'form-control','id'=>'date_to', 'maxlength'=>'255'))}}
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

        @set('hour_validation_pattern','^\d*\.?((25)|(50)|(5)|(75)|(0)|(00))?$')
        @set('cost_validation_pattern','\d{1,3}[,\\.]?(\\d{1,2})?')

        <!-- Extra's section -->
        <legend><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Extra's
        <a id="add-extras" class="btn btn-primary btn-sm add-button">Add</a>
        </legend>

        <div class="row">
            <div class="col-xs-10">
                <label for="extras_description">Description:</label>
            </div>
            <div class="col-xs-2">
                <label for="extras_cost">Cost:</label>
            </div>
        </div>

        <div class="row" id="extras-add">
            @foreach($estimate->extras_table as $index => $extra)
                <input name="extras_id[]" type="hidden" value="{{$extra->id}}">
                <span class="extras-row-span">
                <div class="col-xs-10" id="extras-row-{{$index}}">
                    <fieldset class="form-group">
                        <textarea class="form-control description" id="extras_description{{$index}}" required="" name="extras_description[]" cols="50" rows="10" placeholder="Description">{{$extra->extras_description}}</textarea>
                    </fieldset>
                </div>
                <div class="col-xs-2" id="extras-row-{{$index}}">
                    <fieldset class="form-group">
                        <input type="text" class="form-control" id="extras_cost{{$index}}" data-parsley-type="{{$cost_validation_pattern}}" maxlength="255" name="extras_cost[]" value="{{$extra->extras_cost}}">
                    </fieldset>
                    <fieldset class="form-group">
                        <a id="remove-extras-{{$index}}" class="btn btn-danger btn-sm btn-block remove-extras">
                        <i class="glyphicon glyphicon-remove"></i>
                        </a>
                    </fieldset>
                </div>
                </span>
            @endforeach
        </div>
        <!-- End Extra's section -->

        <!-- Materials section -->
        <legend><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Material
        <a id="add-estimate-material" class="btn btn-primary btn-sm add-button">Add</a>
        </legend>

        <div class="row">
            <div class="col-xs-6">
                <label for="material_name">Description:</label>
            </div>
            <div class="col-xs-2">
                <label for="material_quantity">Quantity:</label>
            </div>
            <div class="col-xs-2">
                <label for="material_cost">Cost:</label>
            </div>
        </div>

        <div class="row" id="estimate-material-add">
            @foreach($estimate->materials as $i => $material)
                <input name="material_id[]" type="hidden" value="{{$material->id}}">
                <span class="material-row-span">
                    <div class="col-xs-6" id="material-row-{{$i}}">
                        <fieldset class="form-group">
                            <input type="text" class="form-control" required="" id="material_name_0" maxlength="255" name="material_name[]"  value="{{$material->material_name}}">
                        </fieldset>
                    </div>
                    <div class="col-xs-2" id="material-row-{{$i}}">
                        <fieldset class="form-group">
                            <input type="text" class="form-control" required="" id="material_quantity_{{$i}}" data-parsley-type="digits" maxlength="255" name="material_quantity[]" value="{{$material->material_quantity}}">
                        </fieldset>
                    </div>
                    <div class="col-xs-2" id="material-row-{{$i}}">
                        <fieldset class="form-group">
                            <input type="text" class="form-control" required="" id="material_cost_{{$i}}" data-parsley-type="digits" maxlength="255" name="material_cost[]" value="{{$material->material_cost}}">
                        </fieldset>
                    </div>
                    <div class="col-xs-2" id="material-row-{{$i}}">
                        <fieldset class="form-group">
                            <a id="remove-material-{{$i}}" class="btn btn-danger btn-sm btn-block remove-material">
                            <i class="glyphicon glyphicon-remove"></i></a>
                        </fieldset>
                    </div>
                </span>
            @endforeach
        </div>
        <!-- End Materials section -->


        {{ Form::hidden('job_id', $estimate->job->id) }}

        </div>

        <!-- Side bar -->
        <div class="col-md-4">
            <div class="well">
                <div class="form-group">
                @if(!empty($estimate->job->client->company_name))<h2 class="text-center">{{$estimate->job->client->company_name}}</h2> @endif
                <h3 class="text-center">{{$estimate->job->client->first_name.' '.$estimate->job->client->last_name}}</h3>
                <br>
                <p class="lead-md"><strong>Title:</strong> {{$estimate->job->client->title}}</p>
                <p class="lead-md"><strong>Cell:</strong> {{$estimate->job->client->cell_number}}</p>
                <p class="lead-md"><strong>Email:</strong> {{$estimate->job->client->email}}</p>
                {{-- <p class="lead-md"><strong>Created at:</strong> {{ date('M j, Y - H:i', strtotime($estimate->job->created_at)) }}</p>
                <p class="lead-md"><strong>Last Updated at:</strong> {{ date('M j, Y - H:i', strtotime($estimate->job->updated_at)) }}</p> --}}
            </div>
            <div class="row">
                <div class="col-md-6">
                {{ Form::submit('Update', array('class' => 'btn btn-success btn-block '))}}
                </div>

                <div class="col-md-6">
                    <a href="{{url()->previous()}}" class="btn btn-danger btn-block ">Cancel</a>
                </div>
            </div>
            {!! Form::close() !!}
        </div>


    </div> <!-- /.row -->

@endsection

@section('scripts')
    {!! Html::script('js/parsley.min.js') !!}
    {!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/js/bootstrap-datepicker.min.js')!!}
    {!! Html::script('js/datepicker.js') !!}
@endsection
