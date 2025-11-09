<?php

namespace App\Services;

use App\Models\ActivityLogs;
use App\Repositories\BranchRepository;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class BranchService
{
    public function __construct(
        protected BranchRepository $branchRepository
    ) {}

    public function all()
    {
       return Cache::remember('branches', 60, function () {
            return $this->branchRepository->all();
        });
    }

    public function find($id)
    {
        return Cache::remember('branch_' . $id, 60, function () use ($id) {
            return $this->branchRepository->find($id);
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
            $branch = $this->branchRepository->create($data);
            $this->logActivity('create', 'Branch', $branch->id, 'Created new branch');
            Cache::forget('branches');
            return $branch;
        });
    }

    public function update(array $data, $id)
    {
        return DB::transaction(function () use ($data, $id) {
            $branch = $this->branchRepository->find($id)
                ? $this->branchRepository->update($id, $data)
                : throw new Exception("Branch with ID {$id} not found.");

            $this->logActivity('update', 'Branch', $branch->id, 'Updated branch');
            Cache::forget('branches');
            Cache::forget('branch_' . $id);
            return $branch;
        });
    }

    public function delete($id)
    {
        return DB::transaction(function () use ($id) {
            $result = $this->branchRepository->find($id)
                ? $this->branchRepository->delete($id)
                : throw new Exception("Branch with ID {$id} not found.");

            $this->logActivity('delete', 'Branch', $id, 'Deleted branch');
            Cache::forget('branches');
            Cache::forget('branch_' . $id);
            return $result;
        });
    }
}
