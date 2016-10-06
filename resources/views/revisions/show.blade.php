@extends('main')

@section('title', '| View Revised Technician Details')

@section('content')

    <div class="row">
        <div class="col-md-8">

            <h3>{{$site->first_name.' '.$site->last_name}}</h3>
            <p class="lead"><strong>Relationship:</strong> {{$site->relationship}}</p>
            <p class="lead"><strong>Site Address:</strong> {{
                ucwords(strtolower($site->mailing_address)).', '.
                ucwords(strtolower($site->mailing_city)).', '.
                strtoupper($site->mailing_province).' '.
                strtoupper($site->mailing_postalcode)
            }}
            </p>
            @if(!empty($site->buzzer_code)) <p class="lead"><strong>Buzzer Code:</strong> {{$site->buzzer_code}}</p> @endif
            <div class="row">
                <div class="col-md-6">    
                    <p class="lead"><strong>Cell:</strong> {{$site->cell_number}}</p>
                </div>
                <div class="col-md-6">  
                    <p class="lead"><strong>Email:</strong> {{$site->email}}</p>
                </div>  
            </div>

            <hr>
            <p class="lead lead-md"><strong>Scope Of Works:</strong><br>{{$job->scope_of_works}}</p>
            <p class="lead lead-md"><strong>Purchase Order Number:</strong><br>{{$job->purchase_order_number}}</p>
            @if(!empty($job->first_name)) <p class="lead">Tenant: {{$job->first_name.' '.$job->last_name}}</p> @endif
            @if(!empty($job->cell_number)) <p class="lead">Cell: {{$job->cell_number}}</p> @endif
            <hr>
            <p class="lead-md"><strong>Arrived on site to (Revised):</strong><br>{{$revision->revised_tech_details}}</p>

            <table class="table">
                <thead>
                    <th>Material Used</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-center">Price</th>
                    <th class="text-center">Total $</th>
                </thead>
                <tbody>
                    <?php $material_subtotal = 0 ?>
                    @foreach($materials as $material)
                    <?php 
                    $cost = $material->material_quantity*$material->material_cost;
                    $material_subtotal += $cost;
                    ?>
                    <tr>
                        <td>{{$material->material_name}}</td>
                        <td class="text-center">{{$material->material_quantity}}</td>
                        <td class="text-center">{{$material->material_cost}}</td>
                        <td class="text-center">${{$cost}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-center">${{$material_subtotal}}</td>
                    </tr>
                </tbody>
                <thead>
                    <th>Type</th>
                    <th class="text-center">Hours</th>
                    <th class="text-center">Cost $</th>
                    <th class="text-center">Total $</th>
                </thead>

                <?php 
                $flushing_subtotal = $technician->flushing_hours*$revision->flushing_hours_cost;
                $camera_subtotal = $technician->camera_hours*$revision->camera_hours_cost;
                $big_auger_subtotal = $technician->big_auger_hours*$revision->big_auger_hours_cost;
                $small_and_medium_auger_subtotal = $technician->small_and_medium_auger_hours*$revision->small_and_medium_auger_hours_cost;
                $hours_subtotal = $flushing_subtotal+$camera_subtotal+$big_auger_subtotal+$small_and_medium_auger_subtotal;
                ?>
                <tbody>
                    <tr>
                        <td>Flushing Hours:</td>
                        <td class="text-center">{{$technician->flushing_hours}}</td>
                        <td class="text-center">{{$revision->flushing_hours_cost}}</td>
                        <td class="text-center">{{$flushing_subtotal}}</td>
                    </tr>
                    <tr>
                        <td>Camera Hours:</td>
                        <td class="text-center">{{$technician->camera_hours}}</td>
                        <td class="text-center">{{$revision->camera_hours_cost}}</td>
                        <td class="text-center">{{$camera_subtotal}}</td>
                    </tr>
                    <tr>
                        <td>Big Auger Hours:</td>
                        <td class="text-center">{{$technician->big_auger_hours}}</td>
                        <td class="text-center">{{$revision->big_auger_hours_cost}}</td>
                        <td class="text-center">{{$big_auger_subtotal}}</td>
                    </tr>
                    <tr>
                        <td>Small & Medium Auger Hours:</td>
                        <td class="text-center">{{$technician->small_and_medium_auger_hours}}</td>
                        <td class="text-center">{{$revision->small_and_medium_auger_hours_cost}}</td>
                        <td class="text-center">{{$small_and_medium_auger_subtotal}}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-center">${{$hours_subtotal}}</td>
                    </tr>
                </tbody>
            </table>
            @if(!empty($technician->notes)) <p class="lead-md"><strong>Notes:</strong><br>{{$technician->notes}}</p>@endif
            <p class="lead-md"><strong>Equipment Left on Site:</strong> {{($technician->equipment_left_on_site) ? 'yes' : 'no'}}</p>

        </div>


        <!-- Side bar -->
        <div class="col-md-4">
            <div class="well">
                <div class="form-group">
                    @if(!empty($client->company_name))<h2 class="text-center">{{$client->company_name}}</h2> @endif
                    <h3 class="text-center">{{$client->first_name.' '.$client->last_name}}</h3>
                </div>
                <dl class="dl-horizontal">
                    <dt>Title:</dt>
                    <dd>{{$client->title}}</dd>
                    <dt>Cell:</dt>
                    <dd>{{$client->cell_number}}</dd>
                    <dt>Email:</dt>
                    <dd>{{$client->email}}</dd>

                    <dt>Creat at:</dt>
                    <!-- http://php.net/manual/en/function.date.php -->
                    <!-- http://php.net/manual/en/function.strtotime.php -->
                    <dd>{{ date('M j, Y - H:i', strtotime($site->created_at)) }}</dd>
                    <dt>Last Update at:</dt>
                    <dd>{{ date('M j, Y - H:i', strtotime($site->updated_at)) }}</dd>
                </dl>
                <hr>

                <div class="row">
                    <div class="col-sm-6">
                        {!! Html::linkRoute('technicians.edit', 'Edit', array($technician->id), array('class'=>'btn btn-primary btn-block') ) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::open(['route' => ['technicians.destroy',$technician->id], 'method'=>'DELETE']) !!}
                        {{ Form::submit('Delete', array('class' => 'btn btn-danger btn-block confirm-delete-modal', 'id'=>'delete'))}}
                        {!! Form::close() !!}
                        <div class="modal modal-effect-blur" id="modal-1">
                            <div class="modal-content">
                                <h3>Are you sure you want to delete?</h3>
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

                </div>
                
            </div>  
        </div>

    </div> <!-- /.row -->
    
@endsection