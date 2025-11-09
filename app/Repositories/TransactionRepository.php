<?php

namespace App\Repositories;

use App\Models\Transaction;

class TransactionRepository
{
    public function all()
    {
      return Transaction::all();
    }

    public function find($id)
    {
      return Transaction::find($id);
    }

    public function getbybranch($branch_id)
    {
      return Transaction::where('branch_id', $branch_id)->get();
    }

    public function getbyuser($user_id)
    {
      return Transaction::where('user_id', $user_id)->get();
    }

    public function create(array $data)
    {
        return Transaction::create($data);
    }

    public function update($id, array $data)
    {
      return Transaction::where('id', $id)->update($data);
    }

    public function delete($id)
    {
        return Transaction::destroy($id);
    }
}