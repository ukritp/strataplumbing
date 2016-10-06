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
                                ->paginate(25);
            }else{
                $technicians  = Technician::orderby('pendinginvoiced_at','desc')
                                ->paginate(25);
            }
        }
        else{
            $technicians  = Technician::where('job_id',$id)
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
        $contact = Client::find($job->client_id);

        if(!empty($site)){
            $contact   = Site::find($job->site_id);
        }

        return view('technicians.create')->withJob($job)->withContact($contact);

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
        if(isset($request->material_name)){
            //print_r($request->material_name);
            for($i = 0; $i < count($request->material_name); ++$i) {
                //echo $request->material_name[$i];
                //echo $request->material_quantity[$i];
                //echo '<br>';
                $material = new Material;

                $material->material_name     = $request->material_name[$i];
                $material->material_quantity = $request->material_quantity[$i];
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

        if(isset($request->material_id) || isset($request->material_name)){

            $exist_materials = Material::where('technician_id',$id)->get();
            $exist_material_ids = array();
            // if there are existing materials
            if(count($exist_materials) > 0){
                foreach($exist_materials as $index => $exist_material){
                    $exist_material_ids[$index] = $exist_material->id;
                }
            }
            // print_r($exist_material_ids);

            //print_r($request->material_id);
            // DB::table('materials')->whereIn('id', $request->material_id)->delete();
            Material::where('technician_id', $technician->id)->delete();

            for($i = 0; $i < count($request->material_name); ++$i) {
                $material = new Material;
                // use the same existing id
                if(isset($exist_material_ids[$i])){
                    $material->id                = $exist_material_ids[$i];
                }
                $material->material_name     = $request->material_name[$i];
                $material->material_quantity = $request->material_quantity[$i];
                $material->technician_id     = $technician->id;

                $material->save();
            }
        }

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
