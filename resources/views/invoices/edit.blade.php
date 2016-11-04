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
            <div style="background-color: #eee; padding: 2%; margin:1% 0; min-height: 630px;">
                @set('contact_company_name', $job->client->company_name)
                @set('contact_first_name', $job->client->first_name)
                @set('contact_last_name', $job->client->last_name)
                @set('contact_home_number',$job->client->formatPhone($job->client->home_number))
                @set('contact_work_number',$job->client->formatPhone($job->client->work_number))
                @set('contact_cell_number',$job->client->formatPhone($job->client->cell_number))
                @set('contact_fax_number',$job->client->formatPhone($job->client->fax_number))
                @set('contact_email', $job->client->email)
                @set('contact_alternate_email', $job->client->alternate_email)
                @if(isset($job->site))
                    @if(count($job->site->contacts)>0)
                        @set('contact_company_name', $job->site->contacts->first()->company_name)
                        @set('contact_first_name', $job->site->contacts->first()->first_name)
                        @set('contact_last_name', $job->site->contacts->first()->last_name)
                        @set('contact_home_number',$job->client->formatPhone($job->site->contacts->first()->home_number))
                        @set('contact_work_number',$job->client->formatPhone($job->site->contacts->first()->work_number))
                        @set('contact_cell_number',$job->client->formatPhone($job->site->contacts->first()->cell_number))
                        @set('contact_fax_number',$job->client->formatPhone($job->site->contacts->first()->fax_number))
                        @set('contact_email', $job->site->contacts->first()->email)
                        @set('contact_alternate_email', $job->site->contacts->first()->alternate_email)
                    @endif
                @endif

                <h2>Company: {{$contact_company_name}}</h2>
                <h3>Contact: {{$contact_first_name}} {{(!empty($contact_last_name))?$contact_last_name:''}}</h3>
                <div class="row">
                    @if(!empty($contact_home_number))
                    <div class="col-md-6">
                        <p class="lead-md"><strong>Home:</strong> {{$contact_home_number}}</p>
                    </div>
                    @endif
                    @if(!empty($contact_cell_number))
                    <div class="col-md-6">
                        <p class="lead-md"><strong>Cell:</strong> {{$contact_cell_number}}</p>
                    </div>
                    @endif
                    @if(!empty($contact_work_number))
                    <div class="col-md-6">
                        <p class="lead-md"><strong>Work:</strong> {{$contact_work_number}}</p>
                    </div>
                    @endif
                    @if(!empty($contact_fax_number))
                    <div class="col-md-6">
                        <p class="lead-md"><strong>Fax:</strong> {{$contact_fax_number}}</p>
                    </div>
                    @endif
                </div>
                <div class="row">
                    @if(!empty($contact_email))
                    <div class="col-md-6">
                        <p class="lead-md"><strong>Email:</strong> {{$contact_email}}</p>
                    </div>
                    @endif
                    @if(!empty($contact_alternate_email))
                    <div class="col-md-6">
                        <p class="lead-md"><strong>Alternate Email:</strong> {{$contact_alternate_email}}</p>
                    </div>
                    @endif
                </div>
                <p class="lead-md"><strong>Address:</strong> {{$contact->fullMailingAddress()}}</p>
                <p class="lead-md"><strong>Billing Address:</strong> {{$contact->fullBillingAddress()}} </p>
                <p class="lead-md"><strong>Project Manager:</strong> {{$job->project_manager}}</p>
                @if(!empty($job->approval_status))
                <div class="lead-approval">
                    @if($job->approval_status == 'pending')
                            <p class="lead-md"><strong>Approval Status:</strong> Pending</p>
                    @elseif($job->approval_status == 'declined')
                            <p class="lead-md"><strong>Approval Status:</strong> Declined</p>
                    @elseif($job->approval_status == 'approved')
                            <p class="lead-md"><strong>Approval Status:</strong> Approved</p>
                    @endif
                    @if(!empty($job->approval_note))
                    <p class="lead-md paragraph-wrap"><strong>Approval Note:</strong><br>{{$job->approval_note}}</p>
                    @endif
                </div>
                @endif
                @set('job_type', ($job->is_estimate)? 'estimate' : 'regular')
                <p class="lead-md job-type type-{{$job_type}}"><strong>Job Type: {{$job_type}}</strong></p>
                <p class="lead-md paragraph-wrap"><strong>Scope Of Works:</strong><br>{{$job->scope_of_works}}</p>
                <p class="lead-md lead-status"><strong>Status:</strong> <span>{{($job->status) ? 'Completed' : 'Pending'}}</span></p>
                <p class="lead-md"><strong>Quoted Rate:</strong>{{(!empty($job->quoted_rate)) ? $job->quoted_rate : '-'}}</p>

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