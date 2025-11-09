<?php

namespace App\Services;

use App\Repositories\ActivitiesRepository;
use Illuminate\Support\Facades\Cache;

class ActivitiesService
{
    public function __construct(
        protected ActivitiesRepository $activitiesRepository
    ) {}

    public function all()
    {
        return Cache::remember('activities.all', 3600, function () {
            return $this->activitiesRepository->all();
        });
    }

    public function find($id)
    {
        return Cache::remember('activities.' . $id, 3600, function () use ($id) {
            return $this->activitiesRepository->find($id);
        });
    }
}
