@extends('main')

@section('title', '| All Jobs')

@section('stylesheets')
    {!! Html::style('css/parsley.css') !!}
@endsection

@section('content')

    <div class="row">
        <div class="col-md-8">
            <h1>All Jobs</h1>
        </div>

        <div class="col-md-4 search-bar">
            <div class="form-inline">
            {!! Form::open(array('route' => 'jobs.search','method'=>'get', 'data-parsley-validate'=>'')) !!}

            {{ Form::text('keyword',null, array('class' => 'form-control','required'=>'', 'maxlength'=>'255'))}}
            {{ Form::submit('Search Jobs', array('class' => 'btn btn-primary search-buttom'))}}

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
            <table class="table table-hover mobile-table">
                <thead>
                    <th>#</th>
                    <th>PM</th>
                    <th>Type</th>
                    <th>Company</th>
                    <th>Name</th>
                    <th>Site Address</th>
                    <!--<th>Scope Of Works</th>-->
                    <th class="text-center">PO Number</th>
                    <th class="text-center">Status</th>
                    <th class="text-right">Action</th>
                </thead>
                <tbody>
                @if(count($jobs)>0)
                    @foreach($jobs as $job)
                    @set('status', count($job->pendinginvoices)>0 ? '' : 'disabled')
                    @set('invoice_link', count($job->pendinginvoices)>0 ? route('invoices.show', $job->id) : '#')
                    @set('job_type', ($job->is_estimate)? 'estimate' : 'regular')
                    <tr>
                        <th data-label="#">{!! Html::linkRoute('jobs.show', $job->id+20100, array($job->id), array('class'=>'')) !!}</th>
                        <th data-label="PM">{{$job->project_manager}}</th>
                        <th data-label="Type" class="job-type type-{{$job_type}}">{{($job->is_estimate)? 'Estimate':'Regular'}}</th>
                        <th data-label="Company">{{!empty($job->client->company_name) ? $job->client->company_name : '-'}}</th>
                        @if(isset($job->site))
                            <td data-label="Name">{{$job->site->first_name.' '.$job->site->last_name}}</td>
                            <td data-label="Address">{{
                            ucwords(strtolower($job->site->mailing_address)).', '.
                            ucwords(strtolower($job->site->mailing_city))
                            }}</td>
                        @else
                            <td data-label="Name">{{$job->client->first_name.' '.$job->client->last_name}}</td>
                            <td data-label="Address">{{
                            ucwords(strtolower($job->client->mailing_address)).', '.
                            ucwords(strtolower($job->client->mailing_city))
                            }}</td>
                        @endif
                        <!--<td>{{substr($job->scope_of_works, 0,50)}}{{strlen($job->scope_of_works)>50 ? '....' : ''}}</td>-->
                        <td data-label="PO Number" class="td-status">{{(!empty($job->purchase_order_number)) ? $job->purchase_order_number : '-'}}</td>
                        <td data-label="Status" class="td-status">{{($job->status) ? 'Completed' : 'Pending'}}</td>
                        <td data-label="Action" class="text-right">
                        <div class="btn-group">
                            <button type="button"
                                class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="glyphicon glyphicon-plus"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-button-right">
                                <li>{!! Html::linkRoute('jobs.show', 'View', array($job->id), array('class'=>'')) !!}</li>
                                <li>{!! Html::linkRoute('jobs.edit', 'Edit', array($job->id), array('class'=>'')) !!}</li>
                                <li class="{{$status}}">
                                    <a href="{{$invoice_link}}">View Invoice</a>
                                </li>

                            </ul>
                        </div>
                        {{-- {!! Html::linkRoute('jobs.show', 'View', array($job->id), array('class'=>'btn btn-default btn-sm btn-sm-margin'))!!}
                        {!! Html::linkRoute('jobs.edit', 'Edit', array($job->id), array('class'=>'btn btn-default btn-sm btn-sm-margin') ) !!}
                        {!! Html::linkRoute('invoices.show', 'View Invoice', array($job->id), array('class'=>'btn btn-default btn-sm btn-sm-margin '.$status))!!} --}}
                        </td>
                    </tr>

                    @endforeach
                @else
                    <tr>
                        <td colspan="9" class="text-center no-item"><b>There is no job</b></td>
                    </tr>
                @endif

                </tbody>
            </table>

        </div>
        <div class="text-center"> {!!$jobs->render();!!}</div>
    </div> <!-- /.row -->


@endsection

@section('scripts')
    {!! Html::script('js/parsley.min.js') !!}
    {!! Html::script('js/default.js') !!}
@endsection