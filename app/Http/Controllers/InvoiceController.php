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
use Mail;
use SnappyPDF;
// use PDF;
use Alert;
use Storage;

use DB;
use Session;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //
        $jobs  = Job::orderby('id','asc')->where('status',1)->paginate(25);

        $grand_totals = $this->calculateGrandTotal($jobs);

        return view('invoices.index')->withJobs($jobs)->withTotals($grand_totals);
    }

    /**
     * Search Invoice
     *
     * @param  string keyword
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        // echo 'from'.$request->date_from;
        // echo 'to'.$request->date_to;

        $search = new Job;
        $jobs = $jobs = Job::where('status',1)->paginate(25);
        if( $request->keyword =='' && ($request->date_from!='' || $request->date_to!='')){
            $jobs = $search->invoicesByDateRange($request->date_from,$request->date_to);
        }
        else if($request->keyword != ''){
            $jobs = Job::where('status',1)->search($request->keyword, [
                    'project_manager'        => 20,
                    'purchase_order_number'  => 20,
                    'client.company_name'    => 10,
                    'client.first_name'      => 10,
                    'client.last_name'       => 10,
                    'client.billing_address' => 10,
                    'site.billing_address'   => 10,
                    'client.billing_city'    => 10,
                    'site.billing_city'      => 10,
                    'site.first_name'        => 5,
                    'site.last_name'         => 5,
                    'first_name'             => 5,
                    'last_name'              => 5,
                    'cell_number'            => 5,
                    ])
                    ->paginate(25)
                    ->appends(['keyword' => $request->keyword]);
            if(count($jobs)==0){
                $id = $request->keyword-20100;
                //echo $id;
                $jobs = Job::where('status',1)->search($id, ['id'])->paginate(1)->appends(['keyword' => $request->keyword]);
            }
        }
        $grand_totals = $this->calculateGrandTotal($jobs);

        return view('invoices.index')->withJobs($jobs)->withTotals($grand_totals);
    }

    /**
     *
     *
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $job = Job::find($id);
        $site   = Site::find($job->site_id);
        $client = Client::find($job->client_id);

        return view('invoices.create')->withJob($job)->withClient($client)->withSite($site);

    }
    /**
    * Creaate PDF
     * wrapper for laravel: https://github.com/barryvdh/laravel-snappy
     * real library: https://github.com/KnpLabs/snappy
     * http://www.kingpabel.com/php-html-to-pdf-snappy/
     * https://thajegan76.wordpress.com/category/laravel/
     * https://github.com/barryvdh/laravel-snappy/issues/9
     * https://naveensnayak.wordpress.com/2011/07/26/wkhtmltopdf-with-php/
     * all option: https://github.com/barryvdh/laravel-snappy/issues/1
     *
     * https://github.com/barryvdh/laravel-dompdf
     * https://packagist.org/packages/barryvdh/laravel-dompdf
     * https://github.com/dompdf/dompdf/wiki/Usage#set_base_path
     */
    public function pdf($id,$height)
    {
        $job = Job::find($id);
        $site   = Site::find($job->site_id);
        $client = Client::find($job->client_id);

        $set_height = $this->setHeight($height);

        // echo 'page: '.$pages.' = '.$set_height;

        // $set_height = $height;

        //------ DOM PDF
        // $pdf = PDF::loadHTML('<h1>Test</h1>');
        // $view =  \View::make('invoices.pdf', compact('job', 'site','client' ));
        // $pdf = PDF::loadHTML($view)->setPaper('a4');
        // return $pdf->stream();
        // return $pdf->download('invoice.pdf');

        //------ SNAPPY PDF
        // $pdf = SnappyPDF::loadHTML('<h1>Test</h1>');

        // $pdf = SnappyPDF::loadView('invoices.pdf',  compact('job','site','client','set_height'))->setPaper('A4')->setOrientation('portrait');

        $pdf = SnappyPDF::loadView('invoices.pdf',  compact('job','site','client','set_height'))
                ->setOption('zoom',1)
                ->setOption('enable-javascript',true)
                ->setOption('javascript-delay',3000)
                ->setPaper('A4')
                ->setOrientation('portrait');

        // $pdf->setOption('header-html', 'http://www.pikemere.co.uk/testerpdf.html');
        // $pdf->setOption('footer-html', 'http://www.pikemere.co.uk/testerpdf.html');

        return $pdf->inline();
        // return $pdf->download('invoice.pdf');
    }

    /**
     * Email Invoice
     * https://scotch.io/tutorials/ultimate-guide-on-sending-email-in-laravel
     * http://stackoverflow.com/questions/37498657/how-to-attach-a-laravel-blade-view-in-mail
     * https://sendgrid.com/docs/Integrate/Frameworks/laravel.html
     * http://laravelcoding.com/blog/laravel-5-beauty-sending-mail-and-using-queues
     *
     * https://github.com/uxweb/sweet-alert
     * https://limonte.github.io/sweetalert2/
     *
     *
     * @param  string keyword
     * @return \Illuminate\Http\Response
     */
    public function email($id,$height)
    {
        $job = Job::find($id);
        $site   = Site::find($job->site_id);
        $client = Client::find($job->client_id);

        $set_height = $this->setHeight($height);

        $pdf = SnappyPDF::loadView('invoices.pdf',  compact('job','site','client','set_height'))
                ->setOption('zoom',1)
                ->setOption('enable-javascript',true)
                ->setOption('javascript-delay',3000)
                ->setPaper('A4')
                ->setOrientation('portrait');

        // $server = '/home/stratapl/'; // siteground
        $server = '/home/wovvecom/'; // site5

        $path = $server.'tmp/invoice'.$job->id.'-'.Carbon::now().'.pdf';
        $pdf->save($path);

        $attach = $path;
        $display = 'Strataplumbing Invoice - '.date('M j, Y', strtotime($job->invoiced_at));

        if(!empty($client->email)){
            Mail::send('invoices.email_blank', ['job' => $job, 'site'=>$site,'client'=>$client], function ($message) use ($attach,$display)
            {
                $message->from('noreply@strataplumbing.com', 'Strataplumbing');

                // mokada@castlecs.com
                // upornpatanapaisarnkul@castlecs.com
                // albina@castlecs.com
                $message->to('ukrit@castlecs.com');

                // $message->bcc('upornpatanapaisarnkul@castlecs.com');
                $message->bcc('topporo@hotmail.com');

                //Attach file
                $message->attach($attach, ['as' => $display]);

                //Add a subject
                $message->subject("Strataplumbing - Invoice");
            });

            if( count(Mail::failures()) > 0 ) {
               // foreach(Mail::failures as $email_address) {
               //     echo "$email_address <br />";
               //  }
                Alert::error('Failed to send an email', 'Oops!')->persistent("Close");

            } else {
                Alert::success('The email was sent to '.$client->email, 'Successful' )->persistent("Close");
            }

        }else{
            Alert::error('This client does not have an email address', 'Oops!')->persistent("Close");
        }

        // return response()->json(['response' => 'This is get method']);
        return view('invoices.create')->withJob($job)->withClient($client)->withSite($site);
    }

    public function setHeight($height)
    {
        $html_to_pdf_height_ratio = 0.672;
        $one_page_height = 1024;

        $px_difference = 105;

        $pages = ($height*$html_to_pdf_height_ratio)/$one_page_height;
        // $set_height = $one_page_height*ceil($pages);

        if($height <= 1550){
            $pages = 1;
        }

        $ceil_pages = ceil($pages);
        if($ceil_pages == 1){
            $set_height = 1019;
        }else{
            $set_height = 1019 + (1024* ($ceil_pages-1));
        }

        return $set_height;
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

            'invoiced_at'             => '',

            'labor_discount'          => 'numeric',
            'material_discount'       => 'numeric',
            'price_adjustment_title'  => 'max:255',
            'price_adjustment_amount' => 'numeric',
            'is_trucked'              => 'required|numeric',
            'truck_services_amount'   => 'numeric',

            'job_id'                  => 'required|numeric'
        ));

        // store the data in database
        $job = Job::find($request->job_id);
        $invoiced_at = Carbon::create($request->year, $request->month, $request->date, 0);
        //echo $invoiced_at;
        //echo $request->invoiced_at;
        $job->invoiced_at             = $request->invoiced_at;
        $job->labor_discount          = $request->labor_discount;
        $job->material_discount       = $request->material_discount;
        $job->price_adjustment_title  = $request->price_adjustment_title;
        $job->price_adjustment_amount = $request->price_adjustment_amount;
        $job->is_trucked              = $request->is_trucked;
        $job->truck_services_amount   = $request->truck_services_amount;
        $job->status = 1;

        $job->save();

        // redirect to another page
        return redirect()->route('invoices.show',$job->id);
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
        $site   = Site::find($job->site_id);
        $contact = Client::find($job->client_id);

        if(!empty($site)){
            $contact   = Site::find($job->site_id);
        }

        // echo count($job->pendinginvoices);
        // echo '<Br>';
        // echo count($job->techniciansGroupByDateCount);

        return view('invoices.show')->withJob($job)->withContact($contact);

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
        $job = Job::find($id);
        $site   = Site::find($job->site_id);
        $contact = Client::find($job->client_id);

        if(!empty($site)){
            $contact   = Site::find($job->site_id);
        }

        return view('invoices.edit')->withJob($job)->withContact($contact);
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

            'invoiced_at'             => '',
            'labor_discount'          => 'numeric',
            'material_discount'       => 'numeric',
            'price_adjustment_title'  => 'max:255',
            'price_adjustment_amount' => 'numeric',
            'is_trucked'              => 'required|numeric',
            'truck_services_amount'   => 'numeric',

            'job_id'                  => 'required|numeric'
        ));
        // store the data in database
        $job = Job::find($request->job_id);
        $invoiced_at = Carbon::create($request->year, $request->month, $request->date, 0);
        //echo $invoiced_at;
        //echo $request->invoiced_at;
        $job->invoiced_at             = $request->invoiced_at;
        $job->labor_discount          = $request->labor_discount;
        $job->material_discount       = $request->material_discount;
        $job->price_adjustment_title  = $request->price_adjustment_title;
        $job->price_adjustment_amount = $request->price_adjustment_amount;
        $job->is_trucked              = $request->is_trucked;
        $job->truck_services_amount   = $request->truck_services_amount;
        $job->status = 1;

        $job->save();

        Session::flash('success','The Invoice was successfully updated');

        // redirect to another page
        return redirect()->route('invoices.show',$job->id);
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

    /**
     * Calculate grand total for invoices.
     *
     * @param  int  $jobs (from database)
     * @return $grand_totals array
     */
    public function calculateGrandTotal($jobs)
    {
        $grand_totals = array();
        // start pending invoices
        foreach($jobs as $index => $job){
            $total = 0;
            foreach ($job->pendinginvoices as $pendinginvoice){
                // calculate labor cost
                $first_half_hour   = 95;
                $additional_hours  = $pendinginvoice->total_hours-0.5;
                $man_hour_total    = $additional_hours*$pendinginvoice->hourly_rates;

                $other_hours_total = 0;
                $material_total    = 0;
                $subtotal          = 0;

                // start technicians
                foreach($pendinginvoice->technicians as $technician){
                    // calculate other hours
                    $flushing_subtotal    = $technician->flushing_hours*$technician->flushing_hours_cost;
                    $camera_subtotal      = $technician->camera_hours*$technician->camera_hours_cost;
                    $big_auger_subtotal   = $technician->big_auger_hours*$technician->big_auger_hours_cost;
                    $sm_md_auger_subtotal = $technician->small_and_medium_auger_hours*$technician->flushing_hosmall_and_medium_auger_hours_costurs_cost;
                    $other_hours_total   += $flushing_subtotal+$camera_subtotal+$big_auger_subtotal+$sm_md_auger_subtotal;

                    // start materials
                    foreach($technician->materials as $material){
                        // calculate materials
                        $material_total += $material->material_quantity*$material->material_cost;
                    }
                }
                $subtotal = $first_half_hour+$man_hour_total+$other_hours_total+$material_total; // total each pedning invoice
                $total   += $subtotal; // total of all pending invoices
            }
            // calculating grandtotal
            $truck_overhead = 0;
            if($job->is_trucked){
                $truck_overhead = 10;
            }
            $gst_percentage = 0.05;
            $gst = $total*$gst_percentage;
            $grand_totals[$index] = number_format(($total+$truck_overhead+$gst),2,'.',',');
        }
        return $grand_totals;

    }

    /**
     * View for sending invoice for approval
     *
     * @return \Illuminate\Http\Response
     */
    public function approval($id){
        $job = Job::find($id);
        $site   = Site::find($job->site_id);
        $contact = Client::find($job->client_id);

        if(!empty($site)){
            $contact   = Site::find($job->site_id);
        }

        return view('invoices.approval')->withJob($job)->withContact($contact);
    }

    /**
     * Set the job as a pending for approval
     *
     * @param job id, form data
     * @return to view with pending invoice
     */
    public function send($id, Request $request){
        $job = Job::findOrFail($id);
        $job->approval_status = 'pending';
        $job->approval_note = $request->comment;

        $job->save();

        $site   = Site::find($job->site_id);
        $contact = Client::find($job->client_id);

        if(!empty($site)){
            $contact   = Site::find($job->site_id);
        }

        return redirect('/invoices/approval/'.$id)->withJob($job)->withContact($contact);
    }

    public function approve($id, Request $request){
        $job = Job::findOrFail($id);
        $job->approval_status = 'approved';
        $job->approval_note = $request->comment;

        $job->save();

        $site   = Site::find($job->site_id);
        $contact = Client::find($job->client_id);

        if(!empty($site)){
            $contact   = Site::find($job->site_id);
        }

        return redirect('/invoices/approval/'.$id)->withJob($job)->withContact($contact);
    }

    public function decline($id, Request $request){
        $job = Job::findOrFail($id);
        $job->approval_status = 'declined';
        $job->approval_note = $request->comment;

        $job->save();

        $site   = Site::find($job->site_id);
        $contact = Client::find($job->client_id);

        if(!empty($site)){
            $contact   = Site::find($job->site_id);
        }

        return redirect('/invoices/approval/'.$id)->withJob($job)->withContact($contact);
    }

    /**
     * pending invoice view
     */

    public function pending($id){
        $jobs  = Job::orderby('id','asc')->where('approval_status',1)->where('project_manager', $id)->paginate(25);

        $grand_totals = $this->calculateGrandTotal($jobs);

        return view('invoices.pending')->withJobs($jobs)->withTotals($grand_totals);
    }



}
