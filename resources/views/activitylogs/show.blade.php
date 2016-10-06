@extends('main')

@section('title', '| View Activity Logs')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <p class="lead"><b>Time:</b> {{(date('M j, Y - H:i', strtotime($activity->created_at)))}}</p>
            <p class="lead"><b>User:</b> {{$activity->causer['name']}}</p>
            <p class="lead"><b>Activity:</b> {{$activity->description}}</p>
            <p class="lead"><b>Subject:</b> {{substr($activity->subject_type, 4).' # '.$activity->subject_id}}</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            @if($activity->description == 'updated') <h2>New:</h2> @endif

            @foreach($activity->changes['attributes'] as $key => $value)
                <p><b>{{ $key }}:</b> {{ $value }}</p>
            @endforeach
        </div>

        <div class="col-md-6">
            @if($activity->description == 'updated') <h2>Old:</h2> @endif

            @if( isset($activity->changes['old']))
                @foreach($activity->changes['old'] as $key => $value)
                    <p><b>{{ $key }}:</b> {{ $value }}</p>
                @endforeach
            @endif
        </div>

    </div> <!-- /.row -->

@endsection

@section('scripts')
    {!! Html::script('js/default.js') !!}
@endsection