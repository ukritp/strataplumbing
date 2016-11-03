<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\JobRequest;

use App\Client;
use App\Site;
use App\Job;
use App\Estimate;
use App\Extras;
use App\Technician;
use App\Material;
use App\PendingInvoice;
use Session;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {

        if($id == '0')  $jobs  = Job::orderby('id','desc')->where('status',0)->paginate(25);
        else            $jobs  = Job::where('site_id',$id)->orderby('id','asc')->paginate(25);

        return view('jobs.index')->withJobs($jobs);
    }

    /**
     * Search Job
     *
     * @param  string keyword
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        // echo $request->keyword;

        $search = new Job;
        //$jobs = $search->jobSearchByKeyword($request->keyword)->get();

        $jobs = Job::search($request->keyword)->paginate(25)->appends(['keyword' => $request->keyword]);
        if(count($jobs)==0){
            $jobs = Job::search($request->keyword, [
                        'client.mailing_address',
                        'site.mailing_address',
                        'estimates.description',
                        'estimates.extras_table.extras_description'
                    ])->paginate(25)->appends(['keyword' => $request->keyword]);
        }
        // check id
        // echo 'count = '.count($jobs);
        if(count($jobs)==0){
            $id = $request->keyword-20100;
            //echo $id;
            $jobs = Job::search($id, ['id'])->paginate(25)->appends(['keyword' => $request->keyword]);
        }
        // echo 'count = '.count($jobs);

        // check status
        if(count($jobs)==0){
            $keyword = '';
            if($request->keyword == 'regular'){
                $keyword = '%0%';
            }else if($request->keyword == 'estimate'){
                $keyword = 1;
            }
            if($keyword!=''){
                $jobs = Job::search($keyword, ['is_estimate'])->paginate(25)->appends(['keyword' => $request->keyword]);
            }
        }
        // echo 'count = '.count($jobs);

        // check job type
        if(count($jobs)==0){
            $keyword = '';
            if($request->keyword == 'pending'){
                $keyword = '%0%';
            }else if($request->keyword =='complete' || $request->keyword == 'completed'){
                $keyword = 1;
            }
            if($keyword!=''){
                $jobs = Job::search($keyword, ['status'])->paginate(25)->appends(['keyword' => $request->keyword]);
            }
        }

        // echo 'count = '.count($jobs);

        foreach($jobs as $job){
            //echo $job->id;
        }

        return view('jobs.index')->withJobs($jobs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id,$type)
    {
        if($type =='client'){

            $client = Client::find($id);
            return view('jobs.create')->withClient($client);

        }else if($type =='site'){

            $site = Site::find($id);
            $client = Client::find($site->client_id);
            return view('jobs.create')->withSite($site)->withClient($client);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JobRequest $request)
    {

        // store the data in database
        $job = new Job;
        $job->scope_of_works        = $request->scope_of_works;
        $job->is_estimate           = $request->is_estimate;
        $job->project_manager       = $request->project_manager;
        $job->purchase_order_number = $request->purchase_order_number;
        $job->first_name            = $request->first_name;
        $job->last_name             = $request->last_name;
        $job->cell_number           = $request->cell_number;
        $job->client_id             = $request->client_id;

        if(isset($request->site_id)){
            $job->site_id = $request->site_id;
        }

        $job->save();

        // use session to store .... for a while -> flash( 'key', 'value')
        // use Put() for long term til session is removed
        Session::flash('success','The Jobs was successfully created');

        // redirect to another page
        return redirect()->route('jobs.show',$job->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $job = Job::find($id);

        return view('jobs.show')->withJob($job);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $job   = Job::find($id);
        $site = Site::find($job->site_id);
        $client = Client::find($job->client_id);   // find client ID

        return view('jobs.edit')->withJob($job)->withSite($site)->withClient($client);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(JobRequest $request, $id)
    {

        // store the data in database
        $job = Job::find($id);
        $job->scope_of_works        = $request->scope_of_works;
        $job->is_estimate           = $request->is_estimate;
        $job->project_manager       = $request->project_manager;
        $job->purchase_order_number = $request->purchase_order_number;
        $job->first_name            = $request->first_name;
        $job->last_name             = $request->last_name;
        $job->cell_number           = $request->cell_number;
        $job->client_id             = $request->client_id;

        if(isset($request->site_id)){
            $job->site_id = $request->site_id;
        }

        $job->save();

        // use session to store .... for a while -> flash( 'key', 'value')
        // use Put() for long term til session is removed
        Session::flash('success','The Jobs was successfully updated');

        // redirect to another page
        return redirect()->route('jobs.show',$job->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // find the client by id
        $job = Job::find($id);

        $technicians  = Technician::where('job_id',$job->id)->get();
        $pendinginvoices = PendingInvoice::where('job_id',$job->id)->get();

        $technician_delete_ids = array();
        $pendinginvoice_delete_ids = array();
        $material_delete_ids = array();

        if(count($technicians)>0){
            foreach($technicians as $tech_index => $technician){
                $technician_delete_ids[$tech_index] = $technician->id;
                $materials = Material::where('technician_id', $technician->id)->delete();
            }
        }
        if(count($pendinginvoices)>0){
            foreach($pendinginvoices as $pi_index => $pendinginvoice){
                $pendinginvoice_delete_ids[$pi_index] = $pendinginvoice->id;
            }
        }
        Technician::destroy($technician_delete_ids);
        PendingInvoice::destroy($pendinginvoice_delete_ids);

        // delete the data
        $job->delete();

        // set flash Session
        Session::flash('success','The Job was successfully deleted');

        // return a view
        return redirect()->route('jobs.index','0');
    }
}
