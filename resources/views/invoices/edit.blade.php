@extends('main')

@section('title', '| Edit Invoice')

@section('stylesheets')
    {!! Html::style('css/parsley.css') !!}
    {!! Html::style('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/css/bootstrap-datepicker.min.css') !!}
@endsection

@section('content')

    <div class="row">
        <!-- Contact info -->
        <div class="col-md-9">
            <div class="jumbotron">
                @if(isset($contact->company_name))
                    <h2>Company: {{$contact->company_name}}</h2>
                @elseif(isset($contact->client->company_name))
                    <h2>Company: {{$contact->client->company_name}}</h2>
                @endif
                <h3>Contact: {{$contact->first_name.' '.$contact->last_name}}</h3>
                @if(!empty($contact->relationship))<p class="lead"><strong>Relationship:</strong> {{$contact->relationship}}</p>@endif
                <p class="lead"><strong>Address:</strong> {{
                    ucwords(strtolower($contact->mailing_address)).', '.
                    ucwords(strtolower($contact->mailing_city)).', '.
                    strtoupper($contact->mailing_province).' '.
                    strtoupper($contact->mailing_postalcode)
                }}
                </p>
                <p class="lead"><strong>Billing Address:</strong> {{
                    ucwords(strtolower($contact->billing_address)).', '.
                    ucwords(strtolower($contact->billing_city)).', '.
                    strtoupper($contact->billing_province).' '.
                    strtoupper($contact->billing_postalcode)
                }}
                </p>
                <p class="lead"><strong>Email:</strong><br>{{$contact->email}}</p>
                <p class="lead"><strong>Project Manager:</strong> {{$job->project_manager}}</p>
                @if(!empty($job->approval_status))
                <div class="lead-approval">
                    @if($job->approval_status == 'pending')
                            <p class="lead"><strong>Approval Status:</strong> Pending</p>
                    @elseif($job->approval_status == 'declined')
                            <p class="lead"><strong>Approval Status:</strong> Declined</p>
                    @elseif($job->approval_status == 'approved')
                            <p class="lead"><strong>Approval Status:</strong> Approved</p>
                    @endif
                    @if(!empty($job->approval_note))
                    <p class="lead paragraph-wrap"><strong>Approval Note:</strong><br>{{$job->approval_note}}</p>
                    @endif
                </div>
                @endif
                @set('job_type', ($job->is_estimate)? 'estimate' : 'regular')
                <p class="lead job-type type-{{$job_type}}"><strong>Job Type: {{$job_type}}</strong></p>
                <p class="lead paragraph-wrap"><strong>Scope Of Works:</strong><br>{{$job->scope_of_works}}</p>
                <p class="lead lead-status"><strong>Status:</strong> <span>{{($job->status) ? 'Completed' : 'Pending'}}</span></p>
                <p class="lead"><strong>Quoted Rate:</strong>{{(!empty($job->quoted_rate)) ? $job->quoted_rate : '-'}}</p>
                {{-- <p class="lead"><strong>Days working for this job:</strong> {{count($job->techniciansGroupByDateCount)}}</p>
                <p class="lead"><strong>Days added to this invoice:</strong> {{count($job->pendinginvoices)}}</p>
                <p class="lead"><strong>Days added missing:</strong> {{count($job->techniciansGroupByDateCount)-count($job->pendinginvoices)}}</p> --}}
            </div>
        </div> <!-- END Contact info -->


        <!-- Finalize Invoice form =============================================== -->
        {!! Form::model($job, ['route' => ['invoices.update',$job->id], 'method'=>'PUT', 'data-parsley-validate'=>''] ) !!}

        <div class="col-md-3">
            <fieldset class="form-group required">
            {{ Form::label('invoiced_at', 'Invoice Date: (YYYY-MM-DD)', array('class'=>'control-label'))  }}
            {{ Form::text('invoiced_at',date('Y-m-d', strtotime($job->invoiced_at)), array('class' => 'form-control', 'required'=>'',  'maxlength'=>'255'))}}
            </fieldset>

            <fieldset class="form-group required">
            {{ Form::label('labor_discount', 'Labor Discount: % ', array('class'=>'control-label'))  }}
            {{ Form::text('labor_discount',null, array(
                            'class' => 'form-control',
                            'required'=>'',
                            'maxlength'=>'255',
                            'data-parsley-pattern' =>'\d+(\.\d{1,2})?'
                        ))}}
            </fieldset>

            <fieldset class="form-group required">
            {{ Form::label('material_discount', 'Material Discount: % ', array('class'=>'control-label'))  }}
            {{ Form::text('material_discount',null, array(
                            'class' => 'form-control',
                            'required'=>'',
                            'maxlength'=>'255',
                            'data-parsley-pattern' =>'\d+(\.\d{1,2})?'
                        ))}}
            </fieldset>

            <div class="row price-adjustment-row">
                <div class="col-xs-12">
                    <fieldset class="form-group">
                    {{ Form::label('price_adjustment_title', 'Price Adjustment Title: ')  }}
                    {{ Form::text('price_adjustment_title',null, array(
                                    'class'     => 'form-control',
                                    'maxlength' => '255'
                                ))}}
                    </fieldset>
                </div>
                <div class="col-xs-8">
                    <fieldset class="form-group">
                    {{ Form::label('price_adjustment_amount', 'Amount:')  }}
                    {{ Form::text('price_adjustment_amount',null, array(
                        'class'                => 'form-control',
                        'data-parsley-pattern' =>'\d+(\.\d{1,2})?'
                    ))}}
                    </fieldset>
                </div>
                <div class="col-xs-4">
                    <fieldset class="form-group">
                    {{ Form::label('price_adjustment_type', 'Type:')  }}
                    {{ Form::select('price_adjustment_type', array(
                        '0' => '$',
                        '1' => '%'),
                        null,
                        array('class' => 'form-control')
                    )}}
                    </fieldset>
                </div>
            </div>

            <fieldset class="form-group">
            {{ Form::label('is_trucked', 'Truck Services?  ')  }}
            <?php
            $chbx = '';
            $attr_name ='';
            $attr_value = '';
            if($job->is_trucked){
                $chbx=true;
            }else{
                $chbx=false;
                $attr_name ='disabled';
                $attr_value = 'disabled';
            }
            ?>
            {{ Form::checkbox('is_trucked_chbx',1,$chbx, array('id'=>'is_trucked_chbx'))}}
            {{ Form::hidden('is_trucked', null) }}
            {{ Form::text('truck_services_amount',null, array(
                'class'                => 'form-control',
                $attr_name             => $attr_value,
                'id'                   => 'truck_services_amount',
                'placeholder'          => 'Truck Services Amount...',
                'data-parsley-pattern' =>'\d+(\.\d{1,2})?',
                'maxlength'            => '255'
            ))}}
            </fieldset>

            {{ Form::hidden('job_id', $job->id) }}
            {{ Form::submit('Update Invoice', array('class' => 'btn btn-success btn-lg btn-block btn-margin'))}}

            <div class="row">
                <div class="col-sm-12">
                    <a href="{{url()->previous()}}" class="btn btn-danger btn-lg btn-block btn-margin">Cancel</a>
                </div>
            </div>
        </div>
        {!! Form::close() !!}

    </div> <!-- /.row -->

@endsection

@section('scripts')
    {!! Html::script('js/parsley.min.js') !!}
    {!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/js/bootstrap-datepicker.min.js') !!}
    {!! Html::script('js/datepicker.js') !!}
@endsection