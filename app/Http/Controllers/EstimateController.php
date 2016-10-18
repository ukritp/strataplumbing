<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Job;
use App\Estimate;
use App\Extra;
use App\Technician;
use App\Material;

use Carbon\Carbon;
use Session;

class EstimateController extends Controller
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
        $job = Job::find($id);
        return view('estimates.create')->withJob($job);
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
            'date_from'        => '',
            'date_to'          => '',
            'description'          => 'required',
            'cost'                 => 'numeric|required',

            'extras_description.*' => '',
            'extras_cost.*'        => 'max:255',

            'material_name.*' => '',
            'material_quantity.*' => '',
            'material_cost.*'        => 'max:255',

            'job_id'               => 'required|numeric',
            'technician_id.*'      => 'required|numeric'
        ));

        // store the data in database
        $estimate = new Estimate;
        $estimate->description   = $request->description;
        $estimate->cost          = $request->cost;
        $estimate->invoiced_from = $request->date_from;
        $estimate->invoiced_to   = $request->date_to;

        $estimate->job_id        = $request->job_id;
        $estimate->save();

        // check if there is extras
        if(isset($request->extras_description)){
            //print_r($request->extras_description);
            for($i = 0; $i < count($request->extras_description); ++$i) {

                $extra = new Extra;

                $extra->extras_description = $request->extras_description[$i];
                $extra->extras_cost        = $request->extras_cost[$i];
                $extra->estimate_id        = $estimate->id;

                $extra->save();
            }
        }

        // update technician
        foreach($request->technician_id as $technician_id){
            // echo $technician_id,'<br>';
            $technician = Technician::find($technician_id);

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

        Session::flash('success','The Estimate Invoice was successfully created');

        // redirect to another page
        return redirect()->route('estimates.show',$estimate->id);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $estimate = Estimate::find($id);

        return view('estimates.show')->withEstimate($estimate);
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
        $estimate = Estimate::find($id);
        return view('estimates.edit')->withEstimate($estimate);
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
        $this->validate($request, array(
            'date_from'        => '',
            'date_to'          => '',
            'description'          => 'required',
            'cost'                 => 'numeric|required',

            'extras_description.*' => '',
            'extras_cost.*'        => 'max:255',

            'job_id'               => 'required|numeric',
            'technician_id.*'      => 'required|numeric'
        ));

        $estimate = Estimate::find($id);
        $estimate->description   = $request->description;
        $estimate->cost          = $request->cost;
        $estimate->invoiced_from = $request->date_from;
        $estimate->invoiced_to   = $request->date_to;

        $estimate->save();

        // check if there is extras
        if(isset($request->extras_id) || isset($request->extras_description)){

            $exist_extras = Extra::where('estimate_id',$id)->get();
            $exist_extras_ids = array();
            // if there are existing materials
            if(count($exist_extras) > 0){
                foreach($exist_extras as $index => $exist_extra){
                    $exist_extras_ids[$index] = $exist_extra->id;
                }
            }
            Extra::where('estimate_id', $estimate->id)->delete();

            for($i = 0; $i < count($request->extras_description); ++$i) {

                $extra = new Extra;

                if(isset($exist_extras_ids[$i])){
                    $extra->id                = $exist_extras_ids[$i];
                }

                $extra->extras_description = $request->extras_description[$i];
                $extra->extras_cost        = $request->extras_cost[$i];
                $extra->estimate_id        = $estimate->id;

                $extra->save();
            }
        }

        // update technician
        foreach($request->technician_id as $technician_id){
            // echo $technician_id,'<br>';
            $technician = Technician::find($technician_id);

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

                    if(isset($request->material_name[$technician_id][$index])){
                        $material->material_name     = $request->material_name[$technician_id][$index];
                        $material->material_quantity = $request->material_quantity[$technician_id][$index];
                        $material->material_cost     = $request->material_cost[$technician_id][$index];
                        $material->technician_id     = $technician->id;

                        $material->save();
                    }else{
                        $material->delete();
                    }
                } // END foreach material
            } // END if isset material_id
        } // END foreach technician

        Session::flash('success','The Estimate Invoice was successfully updated');

        // redirect to another page
        return redirect()->route('estimates.show',$estimate->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $estimate = Estimate::find($id);
        //$technicians  = Technician::where('pending_invoice_id',$pendinginvoice->id)->get();
        $job_id = $estimate->job_id;
        $job = Job::find($job_id);

        foreach($job->technicians as $technician){

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
        if(count($estimate->extras_table) >0) {
            Extra::where('estimate_id', $estimate->id)->delete();
        }

        $estimate->delete();

        $job->status = 0;
        $job->save();

        // set flash Session
        Session::flash('success','The Pending Estimate Invoice was successfully deleted');

        return redirect()->route('jobs.show',$job_id);
    }
}
