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

        <fieldset class="form-group" >
        {{ Form::label('extras', "Extra's:")  }}
        {{ Form::textarea('extras', null, array(
            'class'    => 'form-control description',
            'id'       => 'extras',
        ))}}
        </fieldset>

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