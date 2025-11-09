<?php

namespace App\Repositories;

use App\Models\ActivityLogs;

class ActivitiesRepository
{
    public function all()
    {
        return ActivityLogs::all();
    }

    public function find($id)
    {
        return ActivityLogs::find($id);
    }
}