@extends('main')

@section('title', '| All Revised Technician Details')

@section('stylesheets')
    {!! Html::style('css/parsley.css') !!}
@endsection

@section('content')

    <div class="row">
        <div class="col-md-7">
            <h1>All Revised Technician Details</h1>
        </div>

        <div class="col-md-5 search-bar">
            <div class="form-inline">
            {!! Form::open(array('route' => 'clients.create', 'data-parsley-validate'=>'')) !!}

            {{ Form::text('search_txt',null, array('class' => 'form-control','required'=>'', 'maxlength'=>'255'))}}
            {{ Form::submit('Search Technician Details', array('class' => 'btn btn-primary search-buttom'))}}

            {!! Form::close() !!}
            </div>
        </div>

        <div class="col-md-12">
            <!-- <hr> gotta be inside this column to work -->
            <hr>
        </div>
    </div> <!-- /.row -->

    <div class="row">
        <div class="col-md-12">
            <table class="table table-hover">
                <thead>
                    <th>#</th>
                    <th>Job #</th>
                    <th>Technician Details</th>
                    <th>Revised Details</th>
                    <th class="text-center">Action</th>
                </thead>
                <tbody>

                    @foreach($revisions as $revision)

                    <tr>
                        <th>{{$revision->id}}</th>
                        <th>{{$technicians[$revision->id]->job_id}}</th>

                        <td>{{substr($technicians[$revision->id]->tech_details, 0,50)}}{{strlen($technicians[$revision->id]->tech_details)>50 ? '....' : ''}}</td>
                        <td>{{substr($revision->revised_tech_details, 0,50)}}{{strlen($revision->revised_tech_details)>50 ? '....' : ''}}</td>
                        <td class="text-center">
                        {!! Html::linkRoute('revisions.show', 'View', array($revision->id), array('class'=>'btn btn-default btn-sm'))!!}
                        </td>
                    </tr>

                    @endforeach

                </tbody>
            </table>

        </div>

    </div> <!-- /.row -->
    

@endsection

@section('scripts')
    {!! Html::script('js/parsley.min.js') !!}
@endsection