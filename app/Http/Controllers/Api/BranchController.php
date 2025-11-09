<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBranchRequest;
use App\Models\Branch;
use App\Services\BranchService;
use Illuminate\Support\Facades\Auth;

class BranchController extends Controller
{
    protected $branchService;

    public function __construct(BranchService $branchService)
    {
        $this->branchService = $branchService;
    }

    // List all branches

    public function index()
    {
        $user = Auth::user();

        $branches = $user->role === 'admin'
            ? $this->branchService->all()
            : [$user->branch];

        return response()->json($branches);
    }

    // Get a specific branch

    public function show($id)
    {
        $branch = $this->branchService->find($id);

        if (!$branch) {
            return response()->json(['error' => 'Branch not found'], 404);
        }

        return response()->json($branch);
    }

    // Create a new branch

    public function store(StoreBranchRequest $request)
    {

       $this->authorize('create', Branch::class);


        $branch = $this->branchService->create($request->validated());
        return response()->json([
            'message' => 'Branch created successfully',
            'data' => $branch
        ], 201);
    }

    // Update an existing branch

    public function update(StoreBranchRequest $request, $id)
    {
        $this->authorize('update', Branch::class);


        $branch = $this->branchService->find($id);
        if (!$branch) {
            return response()->json(['error' => 'Branch not found'], 404);
        }

        $this->branchService->update($request->validated(), $id);
        $updatedBranch = $this->branchService->find($id);
        
        return response()->json([
            'message' => 'Branch updated successfully',
            'data' => $updatedBranch
        ]);
    }

    // Delete a branch

    public function destroy($id)
    {
        $this->authorize('delete', Branch::class);


        $branch = $this->branchService->find($id);
        if (!$branch) {
            return response()->json(['error' => 'Branch not found'], 404);
        }
        
        $this->branchService->delete($id);
        return response()->json([
            'message' => 'Branch deleted successfully'
        ]);;
    }
}
