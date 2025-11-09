<?php

namespace App\Services;

use App\Repositories\BalanceRepository;
use Illuminate\Support\Facades\Cache;

class BalanceService
{
    public function __construct(
        protected BalanceRepository $balanceRepository
    ) {}

    public function all()
    {
        return Cache::remember('balances.all', 3600, function () {
            return $this->balanceRepository->all();
        });
    }

    public function find($id)
    {
        return Cache::remember('balance.' . $id, 3600, function () use ($id) {
            return $this->balanceRepository->find($id);
        });
    }

    public function getByBranch($branch_id)
    {
        return Cache::remember('balance.branch.' . $branch_id, 3600, function () use ($branch_id) {
            return $this->balanceRepository->getByBranch($branch_id);
        });
    }
}
