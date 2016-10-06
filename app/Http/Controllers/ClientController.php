<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\ClientRequest;

// use Client Model itself in this Controller
use App\Client;
use App\Site;
use App\Job;
use App\Technician;
use App\Material;
use App\PendingInvoice;

// use Session
use Session;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::paginate(25);

        // $pathToFile = public_path().'/images/logo.jpg';
        // return response()->download($pathToFile);

        // return a view with clients parameter
        return view('clients.index')->withClients($clients);
    }

    /**
     * Search client
     *
     * https://laracasts.com/discuss/channels/laravel/search-option-in-laravel-5?page=1
     * @param  string keyword
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        //echo $request->keyword;

        $search = new Client;
        //$clients = $search->clientSearchByKeyword($request->keyword)->get();

        $clients = Client::search($request->keyword)->paginate(25)->appends(['keyword' => $request->keyword]);
        //echo count($clients);
        if(count($clients)==0){
            $clients = Client::search($request->keyword, ['mailing_address', 'billing_address'])->paginate(25)->appends(['keyword' => $request->keyword]);
        }
        //echo count($clients);
        foreach($clients as $client){
            //echo $client->id;
        }

        return view('clients.index')->withClients($clients);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // go to view create in clients folder
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request)
    {
        // Validate all request in ClientRequest in App\Http\Requests\ClientRequest

        // store the data in database
        $client = new Client;
        $client->company_name       = $request->company_name;
        $client->strata_plan_number = $request->strata_plan_number;
        $client->first_name         = $request->first_name;
        $client->last_name          = $request->last_name;
        $client->title              = $request->title;

        $client->mailing_address    = $request->mailing_address;
        $client->mailing_city       = $request->mailing_city;
        $client->mailing_province   = $request->mailing_province;
        $client->mailing_postalcode = $request->mailing_postalcode;
        $client->buzzer_code        = $request->buzzer_code;

        $client->billing_address    = $request->billing_address;
        $client->billing_city       = $request->billing_city;
        $client->billing_province   = $request->billing_province;
        $client->billing_postalcode = $request->billing_postalcode;

        $client->home_number        = $request->home_number;
        $client->cell_number        = $request->cell_number;
        $client->work_number        = $request->work_number;
        $client->fax_number         = $request->fax_number;

        $client->email              = $request->email;
        $client->alternate_email    = $request->alternate_email;

        $client->quoted_rates       = $request->quoted_rates;
        $client->property_note        = $request->property_note;

        $client->save();

        // use session to store .... for a while -> flash( 'key', 'value')
        // use Put() for long term til session is removed
        Session::flash('success','The Client was successfully saved');

        // redirect to another page
        return redirect()->route('clients.show',$client->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Find client by ID
        $client = Client::find($id);
        // go to view + pass parameter $client named Client
        return view('clients.show')->withClient($client);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // find the client in DB and save as var
        $client = Client::find($id); // find ID

        // return a view
        return view('clients.edit')->withClient($client);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClientRequest $request, $id)
    {

        // update the data to DB
        $client = Client::find($id);

        $client->company_name       = $request->company_name;
        $client->strata_plan_number = $request->strata_plan_number;
        $client->first_name         = $request->first_name;
        $client->last_name          = $request->last_name;
        $client->title              = $request->title;

        $client->mailing_address    = $request->mailing_address;
        $client->mailing_city       = $request->mailing_city;
        $client->mailing_province   = $request->mailing_province;
        $client->mailing_postalcode = $request->mailing_postalcode;
        $client->buzzer_code        = $request->buzzer_code;

        $client->billing_address    = $request->billing_address;
        $client->billing_city       = $request->billing_city;
        $client->billing_province   = $request->billing_province;
        $client->billing_postalcode = $request->billing_postalcode;

        $client->home_number        = $request->home_number;
        $client->cell_number        = $request->cell_number;
        $client->work_number        = $request->work_number;
        $client->fax_number         = $request->fax_number;

        $client->email              = $request->email;
        $client->alternate_email    = $request->alternate_email;

        $client->quoted_rates       = $request->quoted_rates;
        $client->property_note      = $request->property_note;

        $client->save();

        // set flash Session
        Session::flash('success','The Client was successfully updated');

        // redirect to clients.show
        return redirect()->route('clients.show',$client->id);
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
        $client = Client::find($id);

        $client_info = $client->company_name.' - '.$client->first_name.' '.$client->last_name;

        $sites  = Site::where('client_id',$client->id)->get();

        $site_delete_ids = array();
        $job_delete_ids = array();
        $technician_delete_ids = array();
        if(count($sites)>0){
            foreach($sites as $site_index => $site){
                $site_delete_ids[$site_index] = $site->id;

                foreach($site->jobs as $job_index => $job){
                    $job_delete_ids[$job_index] = $job->id;

                    foreach($job->technicians as $tech_index => $technician){
                        $technician_delete_ids[$tech_index] = $technician->id;
                        Material::where('technician_id', $technician->id)->delete();
                    }

                    Technician::destroy($technician_delete_ids);
                    PendingInvoice::where('job_id', $job->id)->delete();

                }

                Job::destroy($job_delete_ids);
            }
            Site::destroy($site_delete_ids);
        }

        $jobs  = Job::where('client_id',$client->id)->get();
        $job_delete_ids = array();
        $technician_delete_ids = array();
        if(count($jobs)>0){
            foreach($jobs as $job_index => $job){
                $job_delete_ids[$job_index] = $job->id;
                //echo $job->id.'<br>';
                foreach($job->technicians as $tech_index => $technician){
                    $technician_delete_ids[$tech_index] = $technician->id;
                    Material::where('technician_id', $technician->id)->delete();
                }

                Technician::destroy($technician_delete_ids);
                PendingInvoice::where('job_id', $job->id)->delete();

            }

            Job::destroy($job_delete_ids);
        }

        // delete the data
        $client->delete();

        // set flash Session
        Session::flash('success','The Client and everything related were successfully deleted');

        // return a view
        return redirect()->route('clients.index');
    }


}
