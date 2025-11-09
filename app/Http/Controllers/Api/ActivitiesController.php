<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ActivitiesService;
use Illuminate\Http\Request;

class ActivitiesController extends Controller
{
   
    protected $activitiesService;

    public function __construct(ActivitiesService $activitiesService)
    {
        $this->activitiesService = $activitiesService;
    }


    // List all activities
    public function index()
    {
        $activities = $this->activitiesService->all();
        return response()->json($activities);
    }

    // Get a specific activity
    public function show($id)
    {
        $activity = $this->activitiesService->find($id);
        return response()->json($activity);
    }
}
