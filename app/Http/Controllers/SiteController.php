<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\SiteRequest;

use App\Client;
use App\Site;
use App\Job;
use App\Technician;
use App\Material;
use App\PendingInvoice;

use Session;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        if($id == '0'){
            $sites  = Site::orderby('id','desc')->paginate(25);
        }else{
            $sites  = Site::where('client_id',$id)->orderby('id','desc')->paginate(25);
        }

        $clients = array();
        // get clients name from client_id in site table
        foreach($sites as $site){
            $clients[$site->id] = Client::find($site->client_id);
        }

        return view('sites.index')->withSites($sites);
    }

    /**
     * Search client
     *
     * @param  string keyword
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        //echo $request->keyword;

        $search_site = new Site;
        //$sites = $search_site->siteSearchByKeyword($request->keyword)->get();

        $sites = Site::search($request->keyword)->paginate(25)->appends(['keyword' => $request->keyword]);
        //echo count($sites);
        if(count($sites)==0){
            $sites = Site::search($request->keyword, ['mailing_address', 'billing_address','relationship'])
                        ->paginate(25)
                        ->appends(['keyword' => $request->keyword]);
        }

        //echo count($sites);
        foreach($sites as $site){
            //echo $site->id;
        }

        return view('sites.index')->withSites($sites);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $client = Client::find($id); // find ID

        return view('sites.create')->withClient($client);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SiteRequest $request)
    {

        // store the data in database
        $site = new Site;
        $site->first_name         = $request->first_name;
        $site->last_name          = $request->last_name;
        $site->relationship       = $request->relationship;

        $site->additional_contact = $request->additional_contact;

        $site->mailing_address    = $request->mailing_address;
        $site->mailing_city       = $request->mailing_city;
        $site->mailing_province   = $request->mailing_province;
        $site->mailing_postalcode = $request->mailing_postalcode;
        $site->buzzer_code        = $request->buzzer_code;

        if($request->radiobox_billing == '1'){
            $client = Client::find($request->client_id);
            $site->billing_address    = $client->billing_address;
            $site->billing_city       = $client->billing_city;
            $site->billing_province   = $client->billing_province;
            $site->billing_postalcode = $client->billing_postalcode;
        }else if($request->radiobox_billing == '2'){
            $site->billing_address    = $request->mailing_address;
            $site->billing_city       = $request->mailing_city;
            $site->billing_province   = $request->mailing_province;
            $site->billing_postalcode = $request->mailing_postalcode;
        }else if($request->radiobox_billing == '3'){
            $site->billing_address    = $request->billing_address;
            $site->billing_city       = $request->billing_city;
            $site->billing_province   = $request->billing_province;
            $site->billing_postalcode = $request->billing_postalcode;
        }else{
            $site->billing_address    = $request->billing_address;
            $site->billing_city       = $request->billing_city;
            $site->billing_province   = $request->billing_province;
            $site->billing_postalcode = $request->billing_postalcode;
        }

        $site->home_number        = $request->home_number;
        $site->cell_number        = $request->cell_number;
        $site->work_number        = $request->work_number;
        $site->fax_number         = $request->fax_number;

        $site->email              = $request->email;
        $site->alternate_email    = $request->alternate_email;
        $site->property_note      = $request->property_note;
        $site->client_id          = $request->client_id;

        $site->save();

        // use session to store .... for a while -> flash( 'key', 'value')
        // use Put() for long term til session is removed
        Session::flash('success','The Site was successfully saved');

        // redirect to another page
        return redirect()->route('sites.show',$site->id);
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
        $site = Site::find($id);                // find site ID
        $client = Client::find($site->client_id);   // find client ID

        return view('sites.show')->withSite($site)->withClient($client);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $site   = Site::find($id);
        $client = Client::find($site->client_id);

        // return a view
        return view('sites.edit')->withSite($site)->withClient($client);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SiteRequest $request, $id)
    {

        // store the data in database
        $site = Site::find($id);
        $site->first_name         = $request->first_name;
        $site->last_name          = $request->last_name;
        $site->relationship       = $request->relationship;
        $site->additional_contact = $request->additional_contact;

        $site->mailing_address    = $request->mailing_address;
        $site->mailing_city       = $request->mailing_city;
        $site->mailing_province   = $request->mailing_province;
        $site->mailing_postalcode = $request->mailing_postalcode;
        $site->buzzer_code        = $request->buzzer_code;

        if($request->radiobox_billing == '1'){
            $client = Client::find($request->client_id);
            $site->billing_address    = $client->billing_address;
            $site->billing_city       = $client->billing_city;
            $site->billing_province   = $client->billing_province;
            $site->billing_postalcode = $client->billing_postalcode;
        }else if($request->radiobox_billing == '2'){
            $site->billing_address    = $request->mailing_address;
            $site->billing_city       = $request->mailing_city;
            $site->billing_province   = $request->mailing_province;
            $site->billing_postalcode = $request->mailing_postalcode;
        }else if($request->radiobox_billing == '3'){
            $site->billing_address    = $request->billing_address;
            $site->billing_city       = $request->billing_city;
            $site->billing_province   = $request->billing_province;
            $site->billing_postalcode = $request->billing_postalcode;
        }else{
            $site->billing_address    = $request->billing_address;
            $site->billing_city       = $request->billing_city;
            $site->billing_province   = $request->billing_province;
            $site->billing_postalcode = $request->billing_postalcode;
        }

        $site->home_number        = $request->home_number;
        $site->cell_number        = $request->cell_number;
        $site->work_number        = $request->work_number;
        $site->fax_number         = $request->fax_number;

        $site->email              = $request->email;
        $site->alternate_email    = $request->alternate_email;
        $site->property_note      = $request->property_note;
        $site->client_id          = $request->client_id;

        $site->save();

        // use session to store .... for a while -> flash( 'key', 'value')
        // use Put() for long term til session is removed
        Session::flash('success','The Site was successfully updated');

        // redirect to another page
        return redirect()->route('sites.show',$site->id);
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
        $site = Site::find($id);

        $jobs  = Job::where('site_id',$site->id)->get();

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
        $site->delete();

        // set flash Session
        Session::flash('success','The Site and jobs related were successfully deleted');

        // return a view
        return redirect()->route('sites.index','0');
    }
}
