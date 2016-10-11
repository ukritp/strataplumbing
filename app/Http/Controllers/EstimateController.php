<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Job;
use App\Estimate;
use App\Extra;
use App\Technician;

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
        //
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
