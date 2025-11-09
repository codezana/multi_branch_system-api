<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTransactionRequest;
use App\Services\TransactionService;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    protected $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    // Get all transactions for admin only 
    public function index()
    {
        $user = Auth::user();
        if ($user->role !== 'admin') {
            return $this->transactionService->getbybranch($user->branch_id);
        }
        return $this->transactionService->all();
    }

    // Get transactions for a specific user
    public function find($id)
    {


        $user = Auth::user();
        if ($user->role !== 'admin' && $user->id != $id) {
            return $this->transactionService->getbyuser($user->id);
        }
        return $this->transactionService->find($id);
    }

    // Create a new transaction
    public function store(StoreTransactionRequest $request)
    {
        $data = $request->validated();
        $transaction = $this->transactionService->create($data);
        return response()->json([
            'message' => 'Transaction created successfully',
            'data' => $transaction
        ]);
    }

    // update specific transaction

    public function update(StoreTransactionRequest $request, $id)
    {
        $findTransaction = $this->transactionService->find($id);
        if (!$findTransaction) {
            return response()->json([
                'message' => 'Transaction not found'
            ], 404);
        }
        $data = $request->validated();
        $transaction = $this->transactionService->update($data, $id);
        return response()->json([
            'message' => 'Transaction updated successfully',
            'data' => $transaction
        ]);
    }
    // Delete a transaction
    public function destroy($id)
    {
        $this->transactionService->delete($id);
        return response()->json([
            'message' => 'Transaction deleted successfully'
        ]);;
    }
}
