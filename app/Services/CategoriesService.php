<?php

namespace App\Services;

use App\Models\ActivityLogs;
use App\Repositories\CategoriesRepository;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class CategoriesService
{
    public function __construct(
        protected CategoriesRepository $categoriesRepository
    ) {}

    public function all()
    {
        return Cache::remember('categories.all', 3600, function () {
            return $this->categoriesRepository->all();
        });
    }

    public function find($id)
    {
        return Cache::remember('categories.' . $id, 3600, function () use ($id) {
            return $this->categoriesRepository->find($id);
        });
    }

     private function logActivity($action, $model, $modelId, $description = null)
    {
        return ActivityLogs::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'model' => $model,
            'model_id' => $modelId,
            'description' => $description,
            'ip_address' => request()->ip(),
        ]);
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $category = $this->categoriesRepository->create($data);
            $this->logActivity('create', 'Category', $category->id, 'Created new Category');
            Cache::forget('categories.all');
            Cache::forget('categories.' . $category->id);
            return $category;
        });
    }

    public function update(array $data, $id)
    {
        return DB::transaction(function () use ($data, $id) {
            $result = $this->categoriesRepository->find($id)
                ? $this->categoriesRepository->update($id, $data)
                : throw new Exception("Category with ID {$id} not found.");

            $this->logActivity('update', 'Category', $id, 'Updated Category');
            Cache::forget('categories.all');
            Cache::forget('categories.' . $id);
            return $result;
        });
    }

    public function delete($id)
    {
        return DB::transaction(function () use ($id) {
            $result = $this->categoriesRepository->find($id)
                ? $this->categoriesRepository->delete($id)
                : throw new Exception("Category with ID {$id} not found.");

            $this->logActivity('delete', 'Category', $id, 'Deleted category');
            Cache::forget('categories.all');
            Cache::forget('categories.' . $id);
            return $result;
        });
    }
}
