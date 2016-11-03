<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Client;
use App\Site;
use App\Job;
use App\Contact;
use App\Technician;

class PageController extends Controller
{
    # Controller:
    # take to model
    # receive from model
    # complie the data from model
    # send the data to corrected view

    public function getIndex(){

        return view('pages.home');

    }

    public function getSearch(Request $request){

        $keyword = $request->keyword;

        $replace_words = array('street','avenue','ave','boulevard','blvd','road','drive','crescent');

        $keyword = str_replace($replace_words, '', $request->keyword);

        // get Clients
        $clients = Client::search($keyword)->get();
        if(count($clients)==0){
            $clients = Client::search($keyword, ['mailing_address'])->get();
        }

        // get Sites
        $sites = Site::search($keyword)->get();
        if(count($sites)==0){
            $sites = Site::search($keyword, ['mailing_address'])->get();
        }

        // get Jobs
        $jobs = Job::search($keyword)->get();
        if(count($jobs)==0){
            $jobs = Job::search($keyword, ['client.mailing_address', 'site.mailing_address'])->get();
        }
        // check id
        // echo 'count = '.count($jobs);
        if(count($jobs)==0){
            $id = $request->keyword-20100;
            //echo $id;
            $jobs = Job::search($id, ['id'])->get();
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

        // check status
        if(count($jobs)==0){
            $keyword = '';
            if($request->keyword == 'pending'){
                $keyword = '%0%';
            }else if($request->keyword =='complete' || $request->keyword == 'completed'){
                $keyword =1;
            }
            if($keyword!=''){
                $jobs = Job::search($keyword, ['status'])->get();
            }

        }
        // echo 'count = '.count($jobs);

        // get Technicians
        $technicians = Technician::search($keyword)->get();
        if(count($technicians)==0){
            $technicians = Technician::search($keyword, ['job.client.mailing_address', 'job.site.mailing_address'])->get();
        }

        return view('pages.home')->withClients($clients)->withSites($sites)->withJobs($jobs)->withTechnicians($technicians);

    }
}
