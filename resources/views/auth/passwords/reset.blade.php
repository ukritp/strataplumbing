
@extends('main')

@section('title', '| Reset my password')

@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">Reset Password</div>
                <div class="panel-body">
                    {!! Form::open(['route'=>'password.reset']) !!}

                    {{ Form::hidden('token',$token)}}

                    <fieldset class="form-group required">
                    {{ Form::label('email', 'Email:', array('class'=>'control-label'))  }}
                    {{ Form::email('email',$email, ['class' => 'form-control'])}}
                    </fieldset>

                    <fieldset class="form-group required">
                    {{ Form::label('password', 'New Password:', array('class'=>'control-label'))  }}
                    {{ Form::password('password',['class' => 'form-control'])}}
                    </fieldset>

                    <fieldset class="form-group required">
                    {{ Form::label('password_confirmation', 'Confirm New Password:', array('class'=>'control-label'))  }}
                    {{ Form::password('password_confirmation',['class' => 'form-control'])}}
                    </fieldset>

                    {{ Form::submit('Reset Password',['class' => 'btn btn-primary btn-lg btn-block btn-margin'])}}

                    {!! Form::close() !!}
                </div>
            </div>

        </div>

    </div> <!-- /.row -->

@endsection
