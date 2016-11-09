@extends('main')

@section('title', '| All Technician Details')

@section('stylesheets')
    {!! Html::style('css/parsley.css') !!}
@endsection

@section('content')

    <div class="row">
        <div class="col-md-9">
            <h1>All Technician Details</h1>
        </div>

        @set('user', \Auth::user()->roles()->first()->name)
        @if($user === 'Admin' || $user === 'Owner')
            <div class="col-md-3 search-bar">
                <div class="form-inline">
                {!! Form::open(array('route' => 'technicians.search','method'=>'get', 'data-parsley-validate'=>'')) !!}
                <div class="input-group">
                    <input type="text" name="keyword" id="keyword" class="form-control " placeholder="Search tech details" maxlegnth="255" required>
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
            <table class="table table-hover table-technician mobile-table">
                <thead>
                    <th class="td-status hidden-xs">Job #</th>
                    <th class="td-status ">Date</th>
                    <th class="td-status">Tech Name</th>
                    <th class="hidden-xs">Contact</th>
                    <th>Address</th>
                    <th class="hidden-xs" style="width:20%;">Technician Details</th>
                    <th class="td-status" style="width:8%;">Job Status</th>
                    <th class="text-right" style="width:10%;">Action</th>
                </thead>
                <tbody>
                @if(count($technicians)>0)
                    @set('job_id', array())
                    @foreach($technicians as $index => $technician)
                    @set('job_id[$index]',$technician->job_id)
                    <tr   class="table-row" data-href="{{route('technicians.show',$technician->id)}}">
                        @if($index == 0)
                            <th data-label="Job #" class="td-status">{{$technician->job_id+20100}}</th>
                        @elseif($job_id[$index] == $job_id[$index-1])
                            <th data-label="Job #" class="td-status">{{$technician->job_id+20100}}</th>
                        @else
                            <th data-label="Job #" class="td-status">{{$technician->job_id+20100}}</th>
                        @endif

                        <th data-label="Date" class="td-status">{{date('M j, Y', strtotime($technician->pendinginvoiced_at))}}</th>
                        <td data-label="Tech Name" class="td-status">{{$technician->technician_name}}</td>
                        @if(isset($technician->job->site))
                            <td data-label="Contact" class="hidden-xs">
                            @if(count($technician->job->site->contacts)>0)
                                @set('contact_first_name',!empty($technician->job->site->contacts->first()->first_name) ? $technician->job->site->contacts->first()->first_name:'-')
                                @set('contact_last_name',!empty($technician->job->site->contacts->first()->last_name) ? $technician->job->site->contacts->first()->last_name:'')
                                {{$contact_first_name.' '.$contact_last_name}}
                                 {{-- {{$job->site->contacts->first()->first_name.' '.$job->site->contacts->first()->last_name}} --}}
                            @else -
                            @endif
                            </td>
                            <td data-label="Address">{{
                            ucwords(strtolower($technician->job->site->mailing_address)).', '.
                            ucwords(strtolower($technician->job->site->mailing_city))
                            }}</td>
                        @else
                            <td data-label="Contact" class="hidden-xs">{{$technician->job->client->first_name.' '.$technician->job->client->last_name}}</td>
                            <td data-label="Address">{{
                            ucwords(strtolower($technician->job->client->mailing_address)).', '.
                            ucwords(strtolower($technician->job->client->mailing_city))
                            }}</td>
                        @endif
                        <td data-label="Technician Details" class="hidden-xs">{{substr($technician->tech_details, 0,40)}}{{strlen($technician->tech_details)>40 ? '....' : ''}}</td>
                        <td data-label="Job Status" class="td-status">{{($technician->job_status) ? 'Completed' : 'Pending'}}</td>
                        <td data-label="Action" class="text-right">

                        <div class="btn-group">
                            <button type="button"
                                class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="glyphicon glyphicon-plus"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-button-right">
                                <li>{!! Html::linkRoute('technicians.show', 'View', array($technician->id), array('class'=>''))!!}</li>
                                @can('technician-gate', $technician)
                                <li>{!! Html::linkRoute('technicians.edit', 'Edit', array($technician->id), array('class'=>''))!!}</li>
                                @endcan

                            </ul>
                        </div>

                        {{-- {!! Html::linkRoute('technicians.show', 'View', array($technician->id), array('class'=>'btn btn-default btn-sm btn-sm-margin'))!!}
                        @can('technician-gate', $technician)
                        {!! Html::linkRoute('technicians.edit', 'Edit', array($technician->id), array('class'=>'btn btn-default btn-sm btn-sm-margin'))!!}
                        @endcan --}}
                        </td>
                    </tr>

                    @endforeach
                @else
                    <tr>
                        <td colspan="8" class="text-center no-item"><b>There is no technician</b></td>
                    </tr>
                @endif
                </tbody>
            </table>

        </div>
        <div class="text-center"> {!!$technicians->render();!!}</div>

    </div> <!-- /.row -->


@endsection

@section('scripts')
    {!! Html::script('js/parsley.min.js') !!}
@endsection