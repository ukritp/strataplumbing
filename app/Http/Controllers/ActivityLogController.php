<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    //
    public function index()
    {
        $activities = Activity::orderby('id','desc')->paginate(25);;

        return view('activitylogs.index')->withActivities($activities);
    }

    public function show($id)
    {
        $activity = Activity::find($id);

        return view('activitylogs.show')->withActivity($activity);
    }
}
