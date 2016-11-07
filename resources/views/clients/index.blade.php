@extends('main')

@section('title', '| All Clients')

@section('stylesheets')
    {!! Html::style('css/parsley.css') !!}
@endsection

@section('content')

    <div class="row">
        <div class="col-md-7">
            <h1>All Clients</h1>
        </div>

        <div class="col-md-3 search-bar">
            <div class="form-inline">
            {!! Form::open(array('route' => 'clients.search','method'=>'get', 'data-parsley-validate'=>'')) !!}
            <div class="input-group">
                <input type="text" name="keyword" id="keyword" class="form-control " placeholder="Search clients" maxlegnth="255" required>
                <span class="input-group-btn">
                    <button class="btn btn-primary " type="submit"><i class="glyphicon glyphicon-search"></i></button>
                </span>
            </div>
            {!! Form::close() !!}
            </div>
        </div>

        <div class="col-md-2">
            {!! Html::linkRoute('clients.create','Create client', array(), array('class'=>'btn btn-warning btn-block btn-margin') ) !!}
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
                    <th>#</th>
                    <th>Company</th>
                    <th style="width:15%;">Contact</th>
                    <th>Title</th>
                    <th>Address</th>
                    <th class="text-right">Action</th>
                </thead>
                <tbody>
                @if(count($clients)>0)
                    @foreach($clients as $client)

                        <tr class="table-row" data-href="{{route('clients.show',$client->id)}}">
                            <th data-label="#" class="td-id">{{$client->id}}</th>
                            <th data-label="Company" class="td-company-name">
                            @if(!empty($client->company_name))
                            {{$client->company_name}}
                            @else
                            -
                            @endif
                            </th>
                            <td data-label="Contact" class="td-contact">
                            {{$client->first_name.' '.$client->last_name}}
                            </td>
                            <td data-label="Title">{{(!empty($client->title)) ? $client->title : '-'}}</td>
                            <td data-label="Address">{{$client->mailing_address.', '.$client->mailing_city}}</td>
                            <td data-label="Action" class="text-right">
                            <div class="btn-group">
                                <button type="button"
                                    class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="glyphicon glyphicon-plus"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-button-right">
                                    <li>{!! Html::linkRoute('clients.show', 'View', array($client->id), array('class'=>'')) !!}</li>
                                    <li>{!! Html::linkRoute('clients.edit', 'Edit', array($client->id), array('class'=>'')) !!}</li>
                                    <li>{!! Html::linkRoute('jobs.create', 'Create Job', array($client->id,'client'), array('class'=>'')) !!}
                                    </li>
                                    <li>{!! Html::linkRoute('sites.create', 'Add Site', array($client->id), array('class'=>'') ) !!}</li>
                                </ul>
                            </div>
                           {{--  {!! Html::linkRoute('clients.show', 'View', array($client->id), array('class'=>'btn btn-default btn-sm btn-sm-margin'))!!}
                            {!! Html::linkRoute('clients.edit', 'Edit', array($client->id), array('class'=>'btn btn-default btn-sm btn-sm-margin') ) !!}
                            {!! Html::linkRoute('jobs.create', 'Create Job', array($client->id,'client'), array('class'=>'btn btn-default btn-sm btn-sm-margin') ) !!} --}}
                            </td>
                        </tr>

                    @endforeach
                @else
                        <tr>
                            <td colspan="7" class="text-center no-item"><b>There is no client</b></td>
                        </tr>
                @endif

                </tbody>
            </table>

        </div>
        <div class="text-center"> {!!$clients->render();!!}</div>

    </div> <!-- /.row -->


@endsection

@section('scripts')
    {!! Html::script('js/parsley.min.js') !!}
@endsection