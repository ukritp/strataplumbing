@extends('main')

@section('title', '| All Activity Logs')

@section('content')

    <div class="row">
        <div class="col-md-8">
            <h1>Activity Logs</h1>
        </div>

        <div class="col-md-4 search-bar">
            <div class="form-inline">
            {{-- {!! Form::open(array('route' => 'sites.search', 'method'=>'get', 'data-parsley-validate'=>'')) !!}

            {{ Form::text('keyword',null, array('class' => 'form-control','required'=>'', 'maxlength'=>'255'))}}
            {{ Form::submit('Search Logs', array('class' => 'btn btn-primary search-buttom'))}}

            {!! Form::close() !!} --}}
            </div>
        </div>

        <div class="col-md-12">
            <!-- <hr> gotta be inside this column to work -->
            <hr>
        </div>
    </div> <!-- /.row -->

    <div class="row">
        <div class="col-md-12">
            <table class="table table-hover mobile-table">
                <thead>
                    <th>Time</th>
                    <th>User</th>
                    <th>Activity</th>
                    <th>Subject</th>
                    {{-- <th>Description</th> --}}
                    <th class="text-right" style="width:10%;">Action</th>
                </thead>
                <tbody>

                    @forelse($activities as $index => $activity)
                    {{-- {{($index==0) ? print_r($activity->changes['attributes']) : ''}} --}}
                    <tr>
                        <td class="td-activity-time" data-label="Time">{{(date('M j, Y - H:i', strtotime($activity->created_at)))}}</td>
                        <td class="td-activity-user" data-label="User">{{$activity->causer['name']}}</td>
                        <td class="td-activity-activity" data-label="Activity">{{$activity->description}}</td>
                        <td class="td-activity-subject" data-label="Subject">{{substr($activity->subject_type, 4).' # '.$activity->subject_id}}</td>
                        {{-- <td class="td-activity-description" data-label="Description">{{$activity->changes}}</td> --}}
                        <td class="text-right" data-label="Action" >
                        {!! Html::linkRoute('activitylogs.show', 'View', array($activity->id), array('class'=>'btn btn-default btn-sm btn-sm-margin'))!!}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center  no-item">There are no Activity Logs</td>
                    </tr>
                    @endforelse

                </tbody>
            </table>

        </div>
        <div class="text-center"> {!!$activities->render();!!}</div>

    </div> <!-- /.row -->


@endsection