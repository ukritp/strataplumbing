<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Client;
use App\Site;
use App\Job;
use App\Technician;
use App\Material;
use App\PendingInvoice;

use Carbon\Carbon;
use DB;
use Session;

class PendingInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {

        $technician = Technician::find($id);

        $date = date('d', strtotime($technician->pendinginvoiced_at));
        $month = date('m', strtotime($technician->pendinginvoiced_at));
        $year = date('Y', strtotime($technician->pendinginvoiced_at));
        //*echo $month,' '.$day.' '.$year;

        $job        = Job::find($technician->job_id);

        $technicians = Technician::where('job_id',$job->id)->whereBetween('pendinginvoiced_at',[
            Carbon::create($year, $month, $date)->startOfDay(),
            Carbon::create($year, $month, $date)->endOfDay()
        ])->get();

        return view('pendinginvoices.create')->withTechnicians($technicians);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, array(

            'description'                  => 'required',
            'labor_description'            => 'max:255',

            'seperate_first_half_hour'     => 'required|numeric',
            'first_half_hour_amount'       => 'numeric',
            'seperate_first_one_hour'      => 'required|numeric',
            'first_one_hour_amount'        => 'numeric',
            'total_hours'                  => 'required|numeric',
            'hourly_rates'                 => 'required|numeric',
            'date'                         => 'required|numeric|digits:2',
            'month'                        => 'required|numeric|digits:2',
            'year'                         => 'required|numeric|digits:4',

            //'material_name'              => 'required',
            //'material_quantity'          => 'required',
            //'material_cost'              => 'required',

            'flushing_hours.*'             => 'numeric',
            'camera_hours.*'               => 'numeric',
            'main_line_auger_hours.*'      => 'numeric',
            'other_hours.*'                => 'numeric',

            'flushing_hours_cost.*'        => 'numeric',
            'camera_hours_cost.*'          => 'numeric',
            'main_line_auger_hours_cost.*' => 'numeric',
            'other_hours_cost.*'           => 'numeric',

            'equipment_left_on_site.*'     => 'required',
            'equipment_name.*'             => '',

            'job_id'                       => 'required|numeric',
            'technician_id.*'              => 'required|numeric'

        ));

        foreach ($request->technician_id as $index => $tech_id) {
            $technician = Technician::find($tech_id);
            if($technician->pending_invoice_id){
                $session_date = date('M j, Y', mktime(0, 0, 0,$request->month, $request->date, $request->year));
                Session::flash('error','Error, The Pending Invoice for '.$session_date.' has already been created');
                // redirect to another page
                return redirect()->route('jobs.show',$request->job_id);
            }
        }

        // store the data in database
        $pendinginvoice = new PendingInvoice;
        $pendinginvoice->description            = $request->description;
        $pendinginvoice->total_hours            = $request->total_hours;
        $pendinginvoice->hourly_rates           = $request->hourly_rates;
        $pendinginvoice->labor_description      = $request->labor_description;

        $pendinginvoice->first_half_hour        = $request->seperate_first_half_hour;
        $pendinginvoice->first_half_hour_amount = $request->first_half_hour_amount;
        $pendinginvoice->first_one_hour         = $request->seperate_first_one_hour;
        $pendinginvoice->first_one_hour_amount  = $request->first_one_hour_amount;
        $pendinginvoice->date                   = $request->date;
        $pendinginvoice->month                  = $request->month;
        $pendinginvoice->year                   = $request->year;
        $pendinginvoice->job_id                 = $request->job_id;

        $pendinginvoice->save();
        //echo '<pre>'; print_r($request->material_id); echo '</pre>';
        //echo '<pre>'; print_r($request->material_cost); echo '</pre>';

        //echo $pendinginvoice->id;

        // update technician
        foreach($request->technician_id as $technician_id){
            // echo $technician_id,'<br>';
            $technician = Technician::find($technician_id);
            //echo $technician->technician_name;

            $technician->flushing_hours             = $request->flushing_hours[$technician_id];
            $technician->camera_hours               = $request->camera_hours[$technician_id];
            $technician->main_line_auger_hours      = $request->main_line_auger_hours[$technician_id];
            $technician->other_hours                = $request->other_hours[$technician_id];

            $technician->flushing_hours_cost        = $request->flushing_hours_cost[$technician_id];
            $technician->camera_hours_cost          = $request->camera_hours_cost[$technician_id];
            $technician->main_line_auger_hours_cost = $request->main_line_auger_hours_cost[$technician_id];
            $technician->other_hours_cost           = $request->other_hours_cost[$technician_id];

            $technician->equipment_left_on_site       = $request->equipment_left_on_site[$technician_id];
            // if there is no equipment left no need to update equipment name
            if($request->equipment_left_on_site[$technician_id]){
                $technician->equipment_name               = $request->equipment_name[$technician_id];
            }else{
                $technician->equipment_name = '';
            }
            $technician->pending_invoice_id = $pendinginvoice->id;

            $technician->save();

            // Add the new material
            if(isset($request->material_name_add[$technician_id])){
                // echo '<pre>'; print_r($request->material_name_add[$technician_id]); echo '</pre>';
                foreach($request->material_name_add[$technician_id] as $index => $material_add){
                    $material = new Material;

                    $material->material_name     = $request->material_name_add[$technician_id][$index];
                    $material->material_quantity = $request->material_quantity_add[$technician_id][$index];
                    $material->material_cost     = $request->material_cost_add[$technician_id][$index];
                    $material->technician_id     = $technician->id;

                    $material->save();
                }
            }

            // Update the existing material
            if(isset($request->material_id[$technician_id])){
                // echo '<br>-------------------<br>';
                // echo '<pre>'; print_r($request->material_id[$technician_id]); echo '</pre>';

                foreach($request->material_id[$technician_id] as $index => $material_id){
                    //echo $index.'-'.$material_id.'<br>';

                    $material = Material::find($material_id);

                    $material->material_name     = $request->material_name[$technician_id][$index];
                    $material->material_quantity = $request->material_quantity[$technician_id][$index];
                    $material->material_cost     = $request->material_cost[$technician_id][$index];
                    $material->technician_id     = $technician->id;

                    $material->save();

                }
            }
        }

        $session_date = date('M j, Y', mktime(0, 0, 0,$pendinginvoice->month, $pendinginvoice->date, $pendinginvoice->year));
        Session::flash('success','The Invoice for '.$session_date.' was successfully created');

        // redirect to another page
        return redirect()->route('pendinginvoices.show',$pendinginvoice->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $pendinginvoice = PendingInvoice::find($id);

        return view('pendinginvoices.show')->withPendinginvoice($pendinginvoice);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $pendinginvoice = PendingInvoice::find($id);

        $job = Job::find($pendinginvoice->job_id);

        $technicians = Technician::where('job_id',$job->id)->whereBetween('pendinginvoiced_at',[
            Carbon::create($pendinginvoice->year, $pendinginvoice->month, $pendinginvoice->date)->startOfDay(),
            Carbon::create($pendinginvoice->year, $pendinginvoice->month, $pendinginvoice->date)->endOfDay()
        ])->get();

        //$technicians = Technician::where('pendinginvoice_id',$pendinginvoice->id)->get();

        return view('pendinginvoices.edit')->withPendinginvoice($pendinginvoice)->withTechnicians($technicians);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate($request, array(

            'description'                  => 'required',
            'labor_description'            => 'max:255',
            // 'labor_discount'            => 'numeric|max:255',
            // 'material_discount'         => 'numeric|max:255',
            'seperate_first_half_hour'     => 'required|numeric',
            'first_half_hour_amount'       => 'numeric',
            'seperate_first_one_hour'      => 'required|numeric',
            'first_one_hour_amount'        => 'numeric',
            'total_hours'                  => 'required|numeric',
            'hourly_rates'                 => 'required|numeric',
            'date'                         => 'required|numeric|digits:2',
            'month'                        => 'required|numeric|digits:2',
            'year'                         => 'required|numeric|digits:4',

            //'material_name'              => 'required',
            //'material_quantity'          => 'required',
            //'material_cost'              => 'required',

            'flushing_hours.*'             => 'numeric',
            'camera_hours.*'               => 'numeric',
            'main_line_auger_hours.*'      => 'numeric',
            'other_hours.*'                => 'numeric',

            'flushing_hours_cost.*'        => 'numeric',
            'camera_hours_cost.*'          => 'numeric',
            'main_line_auger_hours_cost.*' => 'numeric',
            'other_hours_cost.*'           => 'numeric',

            'equipment_left_on_site.*'     => 'required',
            'equipment_name.*'             => '',

            'job_id'                       => 'required|numeric',
            'technician_id.*'              => 'required|numeric'

        ));

        // store the data in database
        $pendinginvoice = PendingInvoice::find($id);
        $pendinginvoice->description            = $request->description;
        $pendinginvoice->total_hours            = $request->total_hours;
        $pendinginvoice->hourly_rates           = $request->hourly_rates;
        $pendinginvoice->labor_description      = $request->labor_description;
        // $pendinginvoice->labor_discount      = $request->labor_discount;
        // $pendinginvoice->material_discount   = $request->material_discount;
        $pendinginvoice->first_half_hour        = $request->seperate_first_half_hour;
        $pendinginvoice->first_half_hour_amount = $request->first_half_hour_amount;
        $pendinginvoice->first_one_hour         = $request->seperate_first_one_hour;
        $pendinginvoice->first_one_hour_amount  = $request->first_one_hour_amount;
        $pendinginvoice->date                   = $request->date;
        $pendinginvoice->month                  = $request->month;
        $pendinginvoice->year                   = $request->year;
        $pendinginvoice->job_id                 = $request->job_id;

        $pendinginvoice->save();
        //echo '<pre>'; print_r($request->material_id); echo '</pre>';
        //echo '<pre>'; print_r($request->material_cost); echo '</pre>';

        //echo $pendinginvoice->id;

        // update technician
        foreach($request->technician_id as $technician_id){

            $technician = Technician::find($technician_id);
            //echo $technician->technician_name;

            $technician->flushing_hours             = $request->flushing_hours[$technician_id];
            $technician->camera_hours               = $request->camera_hours[$technician_id];
            $technician->main_line_auger_hours      = $request->main_line_auger_hours[$technician_id];
            $technician->other_hours                = $request->other_hours[$technician_id];

            $technician->flushing_hours_cost        = $request->flushing_hours_cost[$technician_id];
            $technician->camera_hours_cost          = $request->camera_hours_cost[$technician_id];
            $technician->main_line_auger_hours_cost = $request->main_line_auger_hours_cost[$technician_id];
            $technician->other_hours_cost           = $request->other_hours_cost[$technician_id];

            $technician->equipment_left_on_site     = $request->equipment_left_on_site[$technician_id];
            // if there is no equipment left no need to update equipment name
            if($request->equipment_left_on_site[$technician_id]){
                $technician->equipment_name               = $request->equipment_name[$technician_id];
            }else{
                $technician->equipment_name = '';
            }
            $technician->pending_invoice_id  = $pendinginvoice->id;

            $technician->save();

            // Add the new material
            if(isset($request->material_name_add[$technician_id])){
                // echo '<pre>'; print_r($request->material_name_add[$technician_id]); echo '</pre>';
                foreach($request->material_name_add[$technician_id] as $index => $material_add){
                    $material = new Material;

                    $material->material_name     = $request->material_name_add[$technician_id][$index];
                    $material->material_quantity = $request->material_quantity_add[$technician_id][$index];
                    $material->material_cost     = $request->material_cost_add[$technician_id][$index];
                    $material->technician_id     = $technician->id;

                    $material->save();
                }
            }

            // Update the existing material
            if(isset($request->material_id[$technician_id])){
                foreach($request->material_id[$technician_id] as $index => $material_id){
                    //echo $index.'-'.$material_id.'<br>';

                    $material = Material::find($material_id);

                    $material->material_name     = $request->material_name[$technician_id][$index];
                    $material->material_quantity = $request->material_quantity[$technician_id][$index];
                    $material->material_cost     = $request->material_cost[$technician_id][$index];
                    $material->technician_id     = $technician->id;

                    $material->save();

                }
            }

        }
        $session_date = date('M j, Y', mktime(0, 0, 0,$pendinginvoice->month, $pendinginvoice->date, $pendinginvoice->year));
        Session::flash('success','The Invoice for '.$session_date.' was successfully updated');

        // redirect to another page
        return redirect()->route('pendinginvoices.show',$pendinginvoice->id);
    }

    /**
     * Remove the specified resource from storage.
     *  - Update technicians table -> put all hours cost back to NULL
     *  - Update materials table -> put material cost back to NULL
     *  - Update jobs table -> change status back to 0 (pending)
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $pendinginvoice = PendingInvoice::find($id);
        //$technicians  = Technician::where('pending_invoice_id',$pendinginvoice->id)->get();
        $job_id = $pendinginvoice->job_id;
        $job = Job::find($job_id);
        foreach($pendinginvoice->technicians as $technician_id){

            $technician = Technician::find($technician_id->id);
            //echo $technician->technician_name;

            $technician->flushing_hours_cost        = null;
            $technician->camera_hours_cost          = null;
            $technician->main_line_auger_hours_cost = null;
            $technician->other_hours_cost           = null;

            $technician->pending_invoice_id         = null;

            $technician->save();

            // Update the material
            if(isset($technician->materials)){
                foreach($technician->materials as $material_id){
                    //echo $index.'-'.$material_id.'<br>';

                    $material = Material::find($material_id->id);

                    $material->material_cost     = null;

                    $material->save();

                }
            }
        }
        $pendinginvoice->delete();

        $job->status = 0;
        $job->save();

        // set flash Session
        Session::flash('success','The Pending Invoice was successfully deleted');

        // return a view adsfasdfa
        return redirect()->route('jobs.show',$job_id);

    }
}
