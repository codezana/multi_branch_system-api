<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\BalanceService;
use Illuminate\Support\Facades\Auth;

class BalanceController extends Controller
{
    protected $balanceService;

    public function __construct(BalanceService $balanceService)
    {
        $this->balanceService = $balanceService;
    }

    // Display all Balance ( Admin only )

    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            $balances = $this->balanceService->all();
            return response()->json($balances, 200);
        } else {
            $balances = $this->balanceService->getByBranch($user->branch_id);
            return response()->json($balances, 200);
        }
    }

    // Display a specific Balance

    public function show($id)
    {
        $balance = $this->balanceService->find($id);
        if (!$balance) {
            return response()->json(['message' => 'Balance not found'], 404);
        }

        // Authorization: Only admin can view balances of other branches 
        $user = Auth::user();
        if ($user->role !== 'admin' || $user->branch_id !== $balance->branch_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($balance, 200);
    }

 
}
