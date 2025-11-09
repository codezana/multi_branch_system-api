<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Services\CategoriesService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
   protected $categoriesService;

    public function __construct(CategoriesService $categoriesService)
    {
        $this->categoriesService = $categoriesService;
    }

    //Get all categories
    public function index()
    {
        $categories = $this->categoriesService->all();
        return response()->json($categories);
    }

    //Get single category
    public function show($id)
    {
        $category = $this->categoriesService->find($id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }
        return response()->json($category);
    }

    //Create new category
    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();
        $category = $this->categoriesService->create($data);
        return response()->json([
            'message' => 'Category created successfully',
            'data' => $category
        ]);
    }

    //Update existing category
    public function update(StoreCategoryRequest $request, $id)
    {
        $findCategory = $this->categoriesService->find($id);
        if (!$findCategory) {
            return response()->json(['message' => 'Category not found'], 404);
        }
        $data = $request->validated();
        try {
            $this->categoriesService->update($data, $id);
            $updatedCategory = $this->categoriesService->find($id);
            return response()->json([
                'message' => 'Category updated successfully',
                'data' => $updatedCategory
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    //Delete category
    public function destroy($id)
    {
        try {
            $findCategory = $this->categoriesService->find($id);
            if (!$findCategory) {
                return response()->json(['message' => 'Category not found'], 404);
            }
            $this->categoriesService->delete($id);
            return response()->json(['message' => 'Category deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }
}
