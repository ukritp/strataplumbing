
@extends('main')

@section('title', '| Login')

@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">

            {!! Form::open() !!}

            <fieldset class="form-group required">
            {{ Form::label('email', 'Email:', array('class'=>'control-label'))  }}
            {{ Form::email('email',null, ['class' => 'form-control'])}}
            </fieldset>

            <fieldset class="form-group required">
            {{ Form::label('password', 'Password:', array('class'=>'control-label'))  }}
            {{ Form::password('password', ['class' => 'form-control'])}}
            </fieldset>

            <fieldset class="form-group">
            {{ Form::checkbox('remember')}} {{ Form::label('remember', 'Remember')  }}
            </fieldset>

            <p>{!! Html::linkRoute('password.reset', 'Forget Password ?', array(''), array('class'=>'btn btn-link'))!!}</p>

            {{ Form::submit('Log In',['class' => 'btn btn-primary btn-lg btn-block btn-margin'])}}

            {!! Form::close() !!}

        </div>

    </div> <!-- /.row -->

@endsection
