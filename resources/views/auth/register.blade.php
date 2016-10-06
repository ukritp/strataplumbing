
@extends('main')

@section('title', '| Register')

@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">

            {!! Form::open() !!}

            <fieldset class="form-group required">
            {{ Form::label('name', 'Name:', array('class'=>'control-label'))  }}
            {{ Form::text('name',null, ['class' => 'form-control'])}}
            </fieldset>

            <fieldset class="form-group required">
            {{ Form::label('email', 'Email:', array('class'=>'control-label'))  }}
            {{ Form::email('email',null, ['class' => 'form-control'])}}
            </fieldset>

            <fieldset class="form-group required">
            {{ Form::label('password', 'Password:', array('class'=>'control-label'))  }}
            {{ Form::password('password', ['class' => 'form-control'])}}
            </fieldset>

            <fieldset class="form-group required">
            {{ Form::label('password_confirmation', 'Confirm Password:', array('class'=>'control-label'))  }}
            {{ Form::password('password_confirmation', ['class' => 'form-control'])}}
            </fieldset>

            {{ Form::submit('Register',['class' => 'btn btn-primary btn-lg btn-block btn-margin'])}}

            {!! Form::close() !!}

        </div>

    </div> <!-- /.row -->

@endsection
