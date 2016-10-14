@extends('main')

@section('title', '| All Invoices')

@section('stylesheets')
    {!! Html::style('css/parsley.css') !!}
    {!! Html::style('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/css/bootstrap-datepicker.min.css')!!}
@endsection

@section('content')

    <div class="row">
        <div class="col-md-5">
            <h1>Pending Invoices</h1>
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
                <th class="text-center">Invoice Date</th>
                <th class="text-center">Total</th>
                <th class="text-center">Approval Status</th>
                <th class="text-right">Action</th>
                </thead>
                <tbody>
                @if(count($jobs)>0)
                    @set('grand_total',0)
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
                            <td data-label="Total" class="td-status"> $
                                @if( $job->is_estimate || count($job->pendinginvoices)>0 )
                                    {{number_format($totals[$index],2,'.',',')}}
                                @else
                                    -
                                @endif
                            </td>
                            <td data-label="Approval Status" class="td-status">
                                {{(!is_null($job->approval_status))? $job->approval_status : '-'}}
                            </td>
                            <td data-label="Action" class="text-right">
                                <a href="{{url('/invoices/approval/'.$job->id)}}" class="btn btn-default btn-sm  btn-sm-margin">View</a>
                            </td>
                        </tr>

                    <?php $grand_total += $totals[$index]; ?>
                    @endforeach
                    <tr>
                        <td colspan="7" class="text-right"><strong>TOTAL: $ {{number_format($grand_total,2,'.',',')}}</strong></td>
                    </tr>
                @else
                    <tr>
                        <td colspan="7" class="text-center  no-item"><b>There is no invoice</b></td>
                    </tr>
                @endif

                </tbody>
            </table>

        </div>
        <div class="text-center"> {!!$jobs->render()!!}</div>
    </div> <!-- /.row -->


@endsection

@section('scripts')
    {!! Html::script('js/parsley.min.js') !!}
    {!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/js/bootstrap-datepicker.min.js')!!}
    {!! Html::script('js/default.js') !!}
    {!! Html::script('js/datepicker.js') !!}
@endsection