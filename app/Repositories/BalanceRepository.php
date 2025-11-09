<?php

namespace App\Repositories;

use App\Models\Balance;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BalanceRepository
{
    public function all()
    {
        return Balance::all();
    }

    public function find($id)
    {
        return Balance::find($id);
    }

    public function getByBranch($branch_id)
    {
        return Balance::where('branch_id', $branch_id)->first();
    }

    public function create(array $data)
    {
        return Balance::create($data);
    }

    public function update($id, array $data)
    {
        return Balance::where('id', $id)->update($data);
    }

    public function updateAfterTransaction(Transaction $transaction)
    {
        return DB::transaction(function () use ($transaction) {

            $balance = $this->getByBranch($transaction->branch_id);

            // Create if not found
            if (!$balance) {
                $balance = $this->create([
                    'branch_id' => $transaction->branch_id,
                    'current_balance' => 0,
                ]);
            }

            // Check for expense logic
            if ($transaction->type === 'expense' && $balance->current_balance < $transaction->amount) {
                throw new \Exception("Insufficient balance in branch #{$transaction->branch_id} for this expense.");
            }

            // Update
            $balance->current_balance = $transaction->type === 'income'
                ? $balance->current_balance + $transaction->amount
                : $balance->current_balance - $transaction->amount;

            $balance->save();

            return $balance;
        });
    }


    public function recalculateBranchBalance($branch_id)
    {

        $income = Transaction::where('branch_id', $branch_id)
            ->where('type', 'income')
            ->sum('amount');

        $expense = Transaction::where('branch_id', $branch_id)
            ->where('type', 'expense')
            ->sum('amount');

        $balance = Balance::firstOrCreate(['branch_id' => $branch_id]);
        $balance->current_balance = $income - $expense;
        $balance->save();
    }

    public function delete($id)
    {
        return Balance::destroy($id);
    }
}
