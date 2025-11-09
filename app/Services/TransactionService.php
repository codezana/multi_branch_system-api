<?php

namespace App\Services;

use App\Events\TransactionCreated;
use App\Models\ActivityLogs;
use App\Repositories\BalanceRepository;
use App\Repositories\TransactionRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Exception;
use Illuminate\Support\Facades\Auth;

class TransactionService
{
  public function __construct(
    protected TransactionRepository $transactionRepository,
    protected BalanceRepository $balanceRepository
  ) {}

  public function all()
  {
    return $this->transactionRepository->all();
  }

  public function find($id)
  {
    return Cache::remember('transaction.' . $id, 3600, function () use ($id) {
      return $this->transactionRepository->find($id);
    });
  }

  public function getbybranch($branch_id)
  {
    return $this->transactionRepository->getbybranch($branch_id);
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
      $transaction = $this->transactionRepository->create($data);
      $this->balanceRepository->updateAfterTransaction($transaction);
      $this->logActivity('create', 'Transaction', $transaction->id, `Created transaction with ID $transaction->id `);

      // Clear relevant caches
      Cache::forget('transaction.' . $transaction->id);

      event(new TransactionCreated($transaction));
      return $transaction;
    });
  }

  public function update(array $data, $id)
  {
    return DB::transaction(function () use ($data, $id) {
      $transaction = $this->transactionRepository->find($id);
      if (!$transaction) {
        throw new Exception("Transaction not found");
      }

      $this->transactionRepository->update($id, $data);
      $updatedTransaction = $this->transactionRepository->find($id);
      $this->balanceRepository->recalculateBranchBalance($updatedTransaction->branch_id);
      $this->logActivity('update', 'Transaction', $updatedTransaction->id, `Updated transaction with ID $updatedTransaction->id `);

      // Clear relevant caches
      Cache::forget('transaction.' . $id);

      return $updatedTransaction;
    });
  }

  public function delete($id)
  {
    return DB::transaction(function () use ($id) {
      $transaction = $this->transactionRepository->find($id);
      if (!$transaction) {
        throw new Exception("Transaction not found");
      }

      $this->transactionRepository->delete($id);
      $this->balanceRepository->recalculateBranchBalance($transaction->branch_id);
      $this->logActivity('delete', 'Transaction', $transaction->id, `Deleted transaction with ID $transaction->id `);

      // Clear relevant caches
      Cache::forget('transaction.' . $id);

      return true;
    });
  }
}
