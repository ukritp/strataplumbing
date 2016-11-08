<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\TechnicianRequest;
use App\Client;
use App\Site;
use App\Job;
use App\Technician;
use App\Material;
use Carbon\Carbon;
use DB;
use Session;

class TechnicianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $user = \Auth::user()->roles()->first();
        //echo $user->name;
        if($id == '0'){
            if( $user->name === 'Technician'){
                $technicians  = Technician::where('user_id',\Auth::user()->id)
                                ->orderby('pendinginvoiced_at','desc')
                                ->join('jobs', function ($join) {
                                    $join->on('job_id', '=', 'jobs.id')
                                         ->where('jobs.status', '=', '0');
                                })
                                ->paginate(25);
            }else{
                $technicians  = Technician::orderby('pendinginvoiced_at','desc')
                                ->join('jobs', function ($join) {
                                    $join->on('job_id', '=', 'jobs.id')
                                         ->where('jobs.status', '=', '0');
                                })
                                ->paginate(25);
            }
        }
        else{
            $technicians  = Technician::where('job_id',$id)
                                ->join('jobs', function ($join) {
                                    $join->on('job_id', '=', 'jobs.id')
                                         ->where('jobs.status', '=', '0');
                                })
                                ->orderBy('pendinginvoiced_at', 'desc')
                                ->paginate(25);
        }

        return view('technicians.index')->withTechnicians($technicians);
    }

    /**
     * Search Job
     *
     * @param  string keyword
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        //echo $request->keyword;

        $search = new Technician;
        //$technicians = $search->technicianSearchByKeyword($request->keyword)->paginate(20);

        $technicians = Technician::search($request->keyword)->paginate(25)->appends(['keyword' => $request->keyword]);;

        if(count($technicians)==0){
            $technicians = Technician::search($request->keyword, ['job.client.mailing_address', 'job.site.mailing_address'])
                                ->paginate(25)
                                ->appends(['keyword' => $request->keyword]);;
        }

        //echo count($sites);
        foreach($technicians as $technician){
           // echo $technician->id.'<br>';
        }
        return view('technicians.index')->withTechnicians($technicians);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $job    = Job::find($id);
        $site   = Site::find($job->site_id);
        $client = Client::find($job->client_id);
        $contact = Client::find($job->client_id);

        if(!empty($site)){
            $contact   = Site::find($job->site_id);
        }

        return view('technicians.create')->withJob($job)->withContact($contact)->withClient($client)->withSite($site);

        //return view('technicians.create')->withJob($job)->withSite($site)->withClient($client);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TechnicianRequest $request)
    {

        //echo $request->pendinginvoiced_at;
        // store the data in database
        $technician = new Technician;
        $technician->pendinginvoiced_at     = $request->pendinginvoiced_at;
        $technician->technician_name        = $request->technician_name;
        $technician->tech_details           = $request->tech_details;
        $technician->flushing_hours         = $request->flushing_hours;
        $technician->camera_hours           = $request->camera_hours;
        $technician->main_line_auger_hours  = $request->main_line_auger_hours;
        $technician->other_hours            = $request->other_hours;
        $technician->notes                  = $request->notes;
        $technician->equipment_left_on_site = $request->equipment_left_on_site;
        $technician->equipment_name         = $request->equipment_name;
        $technician->job_id                 = $request->job_id;
        $technician->user_id                = \Auth::user()->id;

        $technician->save();

        // check if there is materials
        if(isset($request->material_name_add)){
            //print_r($request->material_name);
            for($i = 0; $i < count($request->material_name_add); ++$i) {
                //echo $request->material_name[$i];
                //echo $request->material_quantity[$i];
                //echo '<br>';
                $material = new Material;

                $material->material_name     = $request->material_name_add[$i];
                $material->material_quantity = $request->material_quantity_add[$i];
                $material->technician_id     = $technician->id;

                $material->save();
            }
        }

        // change JOB back to pending status
        $job = Job::find($request->job_id);
        $job->status = 0;
        $job->invoiced_at = null;
        $job->save();

        Session::flash('success','The Technician Details was successfully created');

        // redirect to another page
        return redirect()->route('technicians.show',$technician->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $technician = Technician::find($id);
        $job = Job::find($technician->job_id);
        $site = Site::find($job->site_id);
        $client = Client::find($job->client_id);

        return view('technicians.show')->withTechnician($technician)->withSite($site)->withClient($client);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $technician = Technician::findOrFail($id);
        // Only
        if (\Auth::user()->cannot('technician-gate', $technician)) {
            Session::flash('error','Unauthorized action.');
            return redirect()->route('technicians.show',$technician->id);
        }

        $materials  = Material::where('technician_id',$technician->id)->orderby('id','asc')->paginate(20);
        $job = Job::find($technician->job_id);
        $site = Site::find($job->site_id);
        $client = Client::find($job->client_id);
        $contact = Client::find($job->client_id);

        if(!empty($site)){
            $contact   = Site::find($job->site_id);
        }

        return view('technicians.edit')->withTechnician($technician)->withMaterials($materials)->withJob($job)->withContact($contact)->withClient($client);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TechnicianRequest $request, $id)
    {
        // store the data in database
        $technician = Technician::findOrFail($id);

        if ($request->user()->cannot('technician-gate', $technician)) {
            Session::flash('error','Unauthorized action.');
            return redirect()->route('technicians.show',$technician->id);
        }

        $technician->pendinginvoiced_at     = $request->pendinginvoiced_at;
        $technician->technician_name        = $request->technician_name;
        $technician->tech_details           = $request->tech_details;
        $technician->flushing_hours         = $request->flushing_hours;
        $technician->camera_hours           = $request->camera_hours;
        $technician->main_line_auger_hours  = $request->main_line_auger_hours;
        $technician->other_hours            = $request->other_hours;
        $technician->notes                  = $request->notes;
        $technician->equipment_left_on_site = $request->equipment_left_on_site;
        $technician->equipment_name         = $request->equipment_name;
        $technician->job_id                 = $request->job_id;

        $technician->save();

        // Update the existing material
        if(isset($request->material_id)){
            // echo 'update|';

            // Technician doesnt delete any existing materials
            if(count($request->material_id) == count($request->material_id_exist)){
                // echo 'no-delete|';
                foreach($request->material_id as $index => $material_id){

                    $material = Material::find($material_id);

                    $material->material_name     = $request->material_name[$index];
                    $material->material_quantity = $request->material_quantity[$index];
                    $material->technician_id     = $technician->id;

                    $material->save();
                }

            // Technician deletes some materials
            }else{

                // echo 'delete|';

                // get original materials before delete
                $exist_materials = Material::where('technician_id',$technician->id)->get();
                $exist_material_ids = array();
                $exist_material_names = array();
                $exist_material_quantities = array();
                $exist_material_costs = array();
                if(count($exist_materials) > 0){
                    foreach($exist_materials as $index => $exist_material){
                        $exist_material_ids[$index] = $exist_material->id;
                        $exist_material_names[$index] = $exist_material->material_name;
                        $exist_material_quantities[$index] = $exist_material->material_quantity;
                        $exist_material_costs[$index] = $exist_material->material_cost;
                    }
                }

                // print_r($exist_material_ids);
                // echo '<br>';
                // print_r($request->material_id_exist);

                // deleter original materials
                Material::where('technician_id', $technician->id)->delete();

                // loop thru the material lists after delete
                foreach($request->material_id_exist as $index => $material_id){
                    // echo 'exist|';

                    // add material using the ids from the existing
                    $material = new Material;

                    $material->id                = $material_id;
                    $material->material_name     = $request->material_name[$index];
                    $material->material_quantity = $request->material_quantity[$index];
                    $material->technician_id     = $technician->id;

                    $material->save();
                }

                // at the end update the material costs
                foreach($exist_material_ids as $index => $exist_material_id){
                    // echo 'cost-update|';

                    $material = Material::find($exist_material_id);
                    // $material = Material::where('id',$exist_material_id)->get();
                    if( count($material) > 0){
                        $material->material_cost     = $exist_material_costs[$index];
                        $material->save();
                    }

                }
            }

        }

        // Add the new material
        if(isset($request->material_name_add)){
            // echo 'add|';

            foreach($request->material_name_add as $index => $material_add){
                $material = new Material;

                $material->material_name     = $request->material_name_add[$index];
                $material->material_quantity = $request->material_quantity_add[$index];
                $material->technician_id     = $technician->id;

                $material->save();
            }
        }

        // if(isset($request->material_id) || isset($request->material_name)){

        //     $exist_materials = Material::where('technician_id',$id)->get();
        //     $exist_material_ids = array();
        //     // if there are existing materials
        //     if(count($exist_materials) > 0){
        //         foreach($exist_materials as $index => $exist_material){
        //             $exist_material_ids[$index] = $exist_material->id;
        //         }
        //     }
        //     // print_r($exist_material_ids);

        //     //print_r($request->material_id);
        //     // DB::table('materials')->whereIn('id', $request->material_id)->delete();
        //     Material::where('technician_id', $technician->id)->delete();

        //     for($i = 0; $i < count($request->material_name); ++$i) {
        //         $material = new Material;
        //         // use the same existing id
        //         if(isset($exist_material_ids[$i])){
        //             $material->id                = $exist_material_ids[$i];
        //         }
        //         $material->material_name     = $request->material_name[$i];
        //         $material->material_quantity = $request->material_quantity[$i];
        //         $material->technician_id     = $technician->id;

        //         $material->save();
        //     }
        // }

        Session::flash('success','The Technician Details was successfully updated');
        return redirect()->route('technicians.show',$technician->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        // find the client by id
        $technician = Technician::find($id);

        // delete all materials used in this tech detail
        Material::where('technician_id', $technician->id)->delete();

        // delete the data
        $technician->delete();

        // set flash Session
        Session::flash('success','The Technician Details was successfully deleted');

        // return a view
        return redirect()->route('technicians.index','0');
    }
}
