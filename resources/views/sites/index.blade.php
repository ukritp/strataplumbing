@extends('main')

@section('title', '| All Sites')

@section('stylesheets')
    {!! Html::style('css/parsley.css') !!}
@endsection

@section('content')

    <div class="row">
        <div class="col-md-9">
            <h1>All Sites</h1>
        </div>

        <div class="col-md-3 search-bar">
            <div class="form-inline">
            {!! Form::open(array('route' => 'sites.search', 'method'=>'get', 'data-parsley-validate'=>'')) !!}
            <div class="input-group">
                <input type="text" name="keyword" id="keyword" class="form-control " placeholder="Search sites" maxlegnth="255" required>
                <span class="input-group-btn">
                    <button class="btn btn-primary " type="submit"><i class="glyphicon glyphicon-search"></i></button>
                </span>
            </div>
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

                    <th>Company</th>
                    <th>Address</th>
                    <th>Name</th>
                    <th>Title</th>
                    <th class="text-right">Action</th>
                </thead>
                <tbody>
                    @if(count($sites)>0)
                        @foreach($sites as $index => $site)
                            <tr class="table-row" data-href="{{route('sites.show',$site->id)}}">
                                <th data-label="Company">{{(!empty($site->client->company_name)) ? $site->client->company_name : '-'}}</th>
                                <td data-label="Address">
                                {{$site->mailing_address.', '.$site->mailing_city}}
                                </td>
                                <td data-label="Name">
                                    @if(count($site->contacts)>0)
                                        {{$site->contacts->first()->first_name}}
                                        {{(!empty($site->contacts->first()->last_name))?$site->contacts->first()->last_name: ''}}
                                    @else -
                                    @endif
                                </td>
                                <td data-label="Title">
                                    @if(count($site->contacts)>0)
                                        {{(!empty($site->contacts->first()->title))?$site->contacts->first()->title:'-'}}
                                    @else -
                                    @endif
                                </td>
                                <td data-label="Action" class="text-right">
                                <div class="btn-group">
                                    <button type="button"
                                        class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="glyphicon glyphicon-plus"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-button-right">
                                        <li>{!! Html::linkRoute('sites.show', 'View', array($site->id), array('class'=>'')) !!}</li>
                                        <li>{!! Html::linkRoute('sites.edit', 'Edit', array($site->id), array('class'=>'')) !!}</li>
                                        <li>{!! Html::linkRoute('jobs.create', 'Create Job', array($site->id,'site'), array('class'=>'')) !!}
                                        </li>
                                    </ul>
                                </div>
                                </td>
                            </tr>

                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="text-center no-item"><b>There is no site</b></td>
                        </tr>
                    @endif


                </tbody>
            </table>

        </div>
        <div class="text-center"> {!!$sites->render();!!}</div>

    </div> <!-- /.row -->


@endsection

@section('scripts')
    {!! Html::script('js/parsley.min.js') !!}
@endsection