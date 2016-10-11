@extends('main')

@section('title', '| All Jobs')

@section('stylesheets')
    {!! Html::style('css/parsley.css') !!}
    {!! Html::style('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/css/bootstrap-datepicker.min.css')!!}
@endsection

@section('content')

    <div class="row">
        <div class="col-md-5">
            <h1>All Invoices</h1>
        </div>

        <div class="col-md-7 search-bar">

            <div class="form-inline">

                {!! Form::open(array('route' => 'invoices.search', 'method'=>'get', 'data-parsley-validate'=>'')) !!}
                {{ Form::label('date_from', 'Date:')}}
                <div class="form-group input-group input-daterange">
                    {{ Form::text('date_from',null, array('class' => 'form-control', 'id'=>'date_from','maxlength'=>'255'))}}
                    <span class="input-group-addon">to</span>
                    {{ Form::text('date_to',null, array('class' => 'form-control','id'=>'date_to', 'maxlength'=>'255'))}}
                </div>
                {{ Form::text('keyword',null, array('class' => 'form-control','maxlength'=>'255', 'placeholder'=>'keyword...'))}}
                {{ Form::submit('Search Invoice', array('class' => 'btn btn-primary search-buttom'))}}

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
                    <th>Company</th>
                    <th>Contact</th>
                    <th class="text-center">Issued Date</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Status</th>
                    <th class="text-right">Action</th>
                </thead>
                <tbody>
                @if(count($jobs)>0)
                    @foreach($jobs as $index => $job)
                    @set('status', count($job->pendinginvoices)>0 ? '' : 'disabled')
                    <tr>
                        <th data-label="#">{{$job->id+20100}}</th>
                        <th data-label="Company">{{!empty($job->client->company_name) ? $job->client->company_name : '-'}}</th>
                        @if(isset($job->site))
                            <th data-label="Contact">{{$job->site->first_name.' '.$job->site->last_name}}</th>
                        @else
                            <th data-label="Contact">{{$job->client->first_name.' '.$job->client->last_name}}</th>
                        @endif
                        <td data-label="Issued Date" class="td-status">{{(!empty($job->invoiced_at)) ? date('M j, Y', strtotime($job->invoiced_at)) : '-'}}</td>
                        <td data-label="Total" class="td-status">$ {{(count($job->pendinginvoices)>0) ? $totals[$index] : '-'}}</td>
                        <td data-label="Status" class="td-status">{{($job->status) ? 'Completed' : 'Pending'}}</td>
                        <td data-label="Action" class="text-right">
                        {!! Html::linkRoute('invoices.show', 'View', array($job->id), array('class'=>'btn btn-default btn-sm  btn-sm-margin'.$status))!!}
                        </td>
                    </tr>

                    @endforeach
                @else
                    <tr>
                        <td colspan="7" class="text-center  no-item"><b>There is no invoice</b></td>
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
    {!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/js/bootstrap-datepicker.min.js')!!}
    {!! Html::script('js/default.js') !!}
    {!! Html::script('js/datepicker.js') !!}
@endsection