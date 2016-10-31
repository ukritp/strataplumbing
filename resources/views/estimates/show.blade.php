@extends('main')

@section('title', '| View Invoice')

@section('content')

<div class="row">
    <div class="col-md-12">
        <h1 class="page_title"> PENDING ESTIMATE INVOICE SUMMARY </h1>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-8">
        <h2>Job ID: {{$estimate->job->id+20100}}</h2>
        <hr>
        <p class="lead"><strong>Date From:</strong> {{date('M j', strtotime($estimate->invoiced_from))}}</p>
        <p class="lead"><strong>Date To:</strong> {{date('M j', strtotime($estimate->invoiced_to))}}</p>

        {{-- Description section --}}
        <table class="table">
            <thead>
                <th class="td-description" style="width:80%;">Description</th>
                <th class="text-right" style="width:20%;"> $ Cost</th>
            </thead>
            <tbody>
                <td class="td-description">{{$estimate->description}}</td>
                <td class="text-right">$ {{number_format($estimate->cost,2,'.',',')}}</td>
            </tbody>
        </table>
        <br>
        {{-- Extra's section --}}
        <table class="table">
            <thead>
                <th style="width:80%;">Extra's</th>
                <th class="text-right" style="width:20%;"> $ Cost</th>
            </thead>
            <tbody>
                @forelse($estimate->extras_table as $extra)
                    <tr>
                        <td class="td-description paragraph-wrap">- {{$extra->extras_description}}</td>
                        <td class="text-right">{{(!empty($extra->extras_cost))?number_format($extra->extras_cost,2,'.',','):''}}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="text-center">There are no Extra's</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Material section --}}
        <table class="table table-bordered material-table">
            <thead>
                <th>Material</th>
                <th class="text-center">Cost</th>
                <th class="text-center">Total</th>
            </thead>
            <tbody>

                @forelse($estimate->materials as $material)
                <tr>
                    <td>{{$material->material_quantity.' x '.$material->material_name}}</td>
                    <td class="text-center">{{$material->material_cost}}</td>
                    @set('total', number_format($material->material_quantity*$material->material_cost,2,'.',','))
                    <td class="text-center"> {{($total < 0)? '$ ('.$total.')' : '$ '.$total }}</td>
                </tr>
                @empty
                @endforelse

            </tbody>
        </table>


    </div>
    <div class="col-md-4">
        <div class="well">
            <div class="form-group">
                @if(!empty($estimate->job->client->company_name))<h2 class="text-center">{{$estimate->job->client->company_name}}</h2> @endif
                <h3 class="text-center">{{$estimate->job->client->first_name.' '.$estimate->job->client->last_name}}</h3>
                <br>
                <p class="lead-md"><strong>Title:</strong> {{$estimate->job->client->title}}</p>
                <p class="lead-md"><strong>Cell:</strong> {{$estimate->job->client->cell_number}}</p>
                <p class="lead-md"><strong>Email:</strong> {{$estimate->job->client->email}}</p>
                <p class="lead-md"><strong>Created at:</strong> {{ date('M j, Y - H:i', strtotime($estimate->job->created_at)) }}</p>
                <p class="lead-md"><strong>Last Updated at:</strong> {{ date('M j, Y - H:i', strtotime($estimate->job->updated_at)) }}</p>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    {!! Html::linkRoute('estimates.edit', 'Edit', array($estimate->id), array('class'=>'btn btn-primary btn-margin btn-block') ) !!}
                </div>
                <div class="col-sm-6">
                    {!! Form::open(['route' => ['estimates.destroy',$estimate->id], 'method'=>'DELETE']) !!}
                    {{ Form::submit('Delete', array('class' => 'btn btn-danger btn-block btn-margin confirm-delete-modal', 'id'=>'delete'))}}
                    {!! Form::close() !!}
                    <div class="modal modal-effect-blur" id="modal-1">
                        <div class="modal-content">
                            <h3>Are you sure you want to delete?</h3>
                            <p class="text-center">*all Extra's associated with this Estimate will be delete as well</p>
                            <div>
                                <button class="modal-delete">Delete</button>
                                <button class="modal-delete-cancel">Cancel</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-overlay"></div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    {!! Html::linkRoute('jobs.show', 'Job Summary', array($estimate->job_id), array('class'=>'btn btn-default btn-block btn-margin') ) !!}
                </div>
                @set('status', ($estimate->job->is_estimate) ? '' : 'disabled')
                <div class="col-sm-12">
                    {!! Html::linkRoute('invoices.show', 'Invoice Summary', array($estimate->job->id), array('class'=>'btn btn-default btn-block btn-margin '.$status))!!}
                </div>
            </div>
        </div>
    </div>
</div>


@endsection