@extends('main')

@section('title', '| Estimate Invoice')

@section('stylesheets')
    {!! Html::style('css/parsley.css') !!}
    {!! Html::style('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/css/bootstrap-datepicker.min.css')!!}
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <h1>Create Estimate Invoice for Job ID: {{$job->id+20100}}</h1>

        {{ Form::label('date_from', 'Issued Date:')}}
        <div class="form-group input-group input-daterange">
            {{ Form::text('date_from',null, array('class' => 'form-control', 'id'=>'date_from','maxlength'=>'255'))}}
            <span class="input-group-addon">to</span>
            {{ Form::text('date_to',null, array('class' => 'form-control','id'=>'date_to', 'maxlength'=>'255'))}}
        </div>
    </div>
</div> <!-- /.row -->


@endsection

@section('scripts')
    {!! Html::script('js/parsley.min.js') !!}
    {!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/js/bootstrap-datepicker.min.js')!!}
    {!! Html::script('js/default.js') !!}
    {!! Html::script('js/datepicker.js') !!}
@endsection