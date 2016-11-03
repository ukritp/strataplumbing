<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;
use Spatie\Activitylog\Traits\LogsActivity;

use Carbon\Carbon;
use DB;

//https://github.com/jarektkaczyk/eloquence/wiki/Builder-searchable-and-more
//https://softonsofa.com/laravel-searchable-the-best-package-for-eloquent/

class Job extends Model
{
    //
    use Eloquence;

    protected $searchableColumns = [
        'project_manager'           => 20,
        'purchase_order_number'     => 15,
        'client.company_name'       => 20,
        'client.first_name'         => 20,
        'client.last_name'          => 20,
        'client.mailing_address'    => 20,
        'site.mailing_address'      => 20,
        'client.mailing_city'       => 20,
        'site.mailing_city'         => 20,
        'site.contacts.first_name'  => 15,
        'site.contacts.last_name'   => 15,
        'site.contacts.cell_number' => 15,
        'site.contacts.home_number' => 15,
        'site.contacts.fax_number'  => 15,
        'site.contacts.work_number' => 15,
        'first_name'                => 5,
        'last_name'                 => 5,
        'cell_number'               => 5,
    ];

    // Log activity
    use LogsActivity;
    protected $fillable = [
        'project_manager',
        'scope_of_works',
        'purchase_order_number',
        'first_name',
        'last_name',
        'cell_number',
        'labor_discount',
        'material_discount',
        'price_adjustment_title',
        'price_adjustment_amount',
        'status',
        'invoiced_at',
        'is_trucked',
        'truck_services_amount',
        'site_id',
        'client_id',
        'approval_status',
        'approval_note'
    ];
    protected static $logAttributes = [
        'project_manager',
        'scope_of_works',
        'purchase_order_number',
        'first_name',
        'last_name',
        'cell_number',
        'labor_discount',
        'material_discount',
        'price_adjustment_title',
        'price_adjustment_amount',
        'status',
        'invoiced_at',
        'is_trucked',
        'truck_services_amount',
        'site_id',
        'client_id',
    ];

    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function site()
    {
        return $this->belongsTo('App\Site');
    }

    public function technicians()
    {
        return $this->hasMany('App\Technician');
    }

    public function estimates()
    {
        return $this->hasMany('App\Estimate');
    }

    // return Queries from Technician table where Job ID and group by Date
    public function techniciansGroupByDate()
    {
        return $this->hasMany('App\Technician')->orderBy('pendinginvoiced_at', 'asc');
    }

    public function techniciansCountByDate($date)
    {
        $day = date('d', strtotime($date));
        $month = date('m', strtotime($date));
        $year = date('Y', strtotime($date));
        return $this->hasMany('App\Technician')->whereBetween('pendinginvoiced_at',[
            Carbon::create($year, $month, $day)->startOfDay(),
            Carbon::create($year, $month, $day)->endOfDay()
            ])->get();
    }

    public function invoicesByDateRange($date_from,$date_to)
    {
        if($date_from!='' && $date_to==''){
            return $this->where('status',1)->whereBetween('invoiced_at',[
                Carbon::createFromFormat('Y-m-d',$date_from)->startOfDay(),
                Carbon::now()->endOfDay()
                ])->paginate(25)->appends(['date_from' => $date_from,'date_to'=>$date_to]);
        }else if($date_from =='' && $date_to!=''){
            return $this->where('status',1)->whereBetween('invoiced_at',[
                '',
                Carbon::createFromFormat('Y-m-d',$date_to)->endOfDay()
                ])->paginate(25)->appends(['date_from' => $date_from,'date_to'=>$date_to]);
        }else{
            return $this->where('status',1)->whereBetween('invoiced_at',[
                Carbon::createFromFormat('Y-m-d',$date_from)->startOfDay(),
                Carbon::createFromFormat('Y-m-d',$date_to)->endOfDay()
                ])->paginate(25)->appends(['date_from' => $date_from,'date_to'=>$date_to]);
        }
    }

    public function techniciansGroupByDateCount()
    {
        return $this->hasMany('App\Technician')->groupBy(DB::raw('DATE(pendinginvoiced_at)'));
    }

    public function pendinginvoices()
    {
        return $this->hasMany('App\PendingInvoice')->orderby('month','asc');
    }

    public function jobSearchByKeyword($keyword)
    {
        $query = '';
        if ($keyword!='') {
            $status = 0;
            if($keyword == 'pending'){
                $status = 0;
            }else if($keyword == 'complete' || $keyword == 'completed'){
                $status = 1;
            }
            $query = $this->where("scope_of_works",     "LIKE", "%$keyword%")
                    ->orWhere("first_name",            "LIKE", "%$keyword%")
                    ->orWhere("last_name",             "LIKE", "%$keyword%")
                    ->orWhere("purchase_order_number", "LIKE", "%$keyword%")
                    ->orWhere("cell_number",           "LIKE", "%$keyword%")
                    ->orWhere("status",                "LIKE", "%$status%");
                    //->orWhere("created_at",            "LIKE", "%$keyword%")
                    //->orWhere("updated_at",            "LIKE", "%$keyword%");
        }
        return $query;
    }
}
