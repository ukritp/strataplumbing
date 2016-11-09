@extends('main')

@section('title', '| All Invoices')

@section('stylesheets')
    {!! Html::style('css/parsley.css') !!}
    {!! Html::style('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/css/bootstrap-datepicker.min.css')!!}
@endsection

@section('content')

    <div class="row">
        <div class="col-md-5">
            <h1>{{$header}} Invoices</h1>
        </div>

        @if($header == 'Issued')
        <div class="col-md-7 search-bar">

            <div class="form-inline">
                {!! Form::open(array('route' => 'invoices.search', 'method'=>'get', 'data-parsley-validate'=>'')) !!}
                {{ Form::label('date_from', 'Date:')}}
                <div class="form-group input-group input-daterange">
                    {{ Form::text('date_from',null, array('class' => 'form-control', 'id'=>'date_from','maxlength'=>'255'))}}
                    <span class="input-group-addon">to</span>
                    {{ Form::text('date_to',null, array('class' => 'form-control','id'=>'date_to', 'maxlength'=>'255'))}}
                </div>
                <div class="input-group">
                    <input type="text" name="keyword" id="keyword" class="form-control " placeholder="keyword..." maxlegnth="255">
                    <span class="input-group-btn">
                        <button class="btn btn-primary " type="submit"><i class="glyphicon glyphicon-search"></i></button>
                    </span>
                </div>

                {!! Form::close() !!}
            </div>
        </div>
        @endif
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
                    <th class="text-center">Invoice Date</th>

                    <th class="text-center">Approval Status</th>
                    <th class="text-right">Total</th>
                    {{-- <th class="text-right">Action</th> --}}
                </thead>
                <tbody>

                @if(count($jobs)>0)
                    @set('grand_total',0)
                    @foreach($jobs as $index => $job)
                    @set('status', count($job->pendinginvoices)>0 ? '' : 'disabled')
                    <tr class="table-row-no-action" data-href="{{route('invoices.show',$job->id)}}">
                        <th data-label="#">{{$job->id+20100}}</th>
                        <th data-label="Company">{{!empty($job->client->company_name) ? $job->client->company_name : '-'}}</th>
                        @if(isset($job->site))
                            <th data-label="Contact">
                            @set('contact_first_name',!empty($job->site->contacts->first()->first_name) ? $job->site->contacts->first()->first_name:'')
                            @set('contact_last_name',!empty($job->site->contacts->first()->last_name) ? $job->site->contacts->first()->last_name:'')
                            {{$contact_first_name.' '.$contact_last_name}}
                            </th>
                        @else
                            <th data-label="Contact">{{$job->client->first_name.' '.$job->client->last_name}}</th>
                        @endif
                        <td data-label="Invoiced Date" class="td-status">
                            {{(!empty($job->invoiced_at)) ? date('M j, Y', strtotime($job->invoiced_at)) : '-'}}
                        </td>

                        <td data-label="Approval Status" class="td-status">
                            {{(!is_null($job->approval_status))? $job->approval_status : '-'}}
                        </td>
                        <td data-label="Total" class="text-right"> $
                            @if( $job->is_estimate || count($job->pendinginvoices)>0 )
                                {{number_format($totals[$index],2,'.',',')}}
                            @else
                                -
                            @endif
                        </td>
                        {{-- <td data-label="Action" class="text-right">
                        {!! Html::linkRoute('invoices.show', 'View', array($job->id), array('class'=>'btn btn-default btn-sm  btn-sm-margin'.$status))!!}
                        </td> --}}
                    </tr>
                    <?php $grand_total += $totals[$index]; ?>
                    @endforeach
                    <tr>
                        <td colspan="6" class="text-right"><strong>TOTAL: $ {{number_format($grand_total,2,'.',',')}}</strong></td>
                    </tr>
                @else
                    <tr>
                        <td colspan="6" class="text-center  no-item"><b>There is no invoice</b></td>
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
    {!! Html::script('js/datepicker.js') !!}
@endsection