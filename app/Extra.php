<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;

class Extra extends Model
{
    //
    use Eloquence;
    protected $searchableColumns = [
        'extras_description' => 15,
        'extras_cost'        => 15,
    ];

    public function estimate()
    {
        return $this->belongsTo('App\Estimate');
    }
}
