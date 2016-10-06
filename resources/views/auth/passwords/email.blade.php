
@extends('main')

@section('title', '| Forgot my password')

@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">Reset Password</div>
                <div class="panel-body">
                    @if(session('status'))
                        <div class="alert alert-success">
                            {{session('status')}}
                        </div>
                    @endif
                    {!! Form::open(['route'=>'password.email']) !!}

                    <fieldset class="form-group required">
                    {{ Form::label('email', 'Email:', array('class'=>'control-label'))  }}
                    {{ Form::email('email',null, ['class' => 'form-control'])}}
                    </fieldset>

                    {{ Form::submit('Send Email',['class' => 'btn btn-primary btn-lg btn-block btn-margin'])}}

                    {!! Form::close() !!}
                </div>
            </div>

        </div>

    </div> <!-- /.row -->

@endsection
