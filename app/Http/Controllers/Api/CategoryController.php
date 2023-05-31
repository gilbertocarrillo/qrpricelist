<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoryRequest;
use App\Models\Pricelist;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Pricelist $pricelist)
    {
        $this->authorize('viewAny', [Category::class, $pricelist]);

        $query = Category::where('pricelist_id', $pricelist->id);
        $categories = QueryBuilder::for($query)
            ->allowedIncludes(['pricelist', 'parent', 'subcategories', 'products'])
            ->get();

        return response()->json([
            'data' => CategoryResource::collection($categories),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Pricelist $pricelist, StoreCategoryRequest $request)
    {
        $this->authorize('create', [Category::class, $pricelist]);
        $validated = $request->validated();

        if ($request->has('parent_id') && $validated['parent_id'] != null) {
            $parent = Category::find($validated['parent_id']);
            if ($parent->parent_id != null) {
                throw ValidationException::withMessages([
                    'parent_id' => 'Parent category should not be a child category'
                ]);
            }
        }

        // Create category
        $validated['pricelist_id'] = $pricelist->id;
        $category = Category::create($validated);

        return response()->json([
            'data' => new CategoryResource($category),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $this->authorize('view', [Category::class, $category]);

        $category = QueryBuilder::for(Category::where('id', $category->id))
            ->allowedIncludes(['pricelist', 'parent', 'subcategories', 'products'])
            ->first();

        return response()->json([
            'data' => new CategoryResource($category),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCategoryRequest $request, Category $category)
    {
        $this->authorize('update', [Category::class, $category]);

        $validated = $request->validated();

        if ($request->has('parent_id')) {
            if ($validated['parent_id'] != null) {
                if ($category->parent_id == null) {
                    throw ValidationException::withMessages([
                        'parent_id' => 'Category cannot be a child category'
                    ]);
                }
            }
        }

        // Validate that parent category is not a child category
        if ($request->has('parent_id')) {
            if ($validated['parent_id'] != null) {
                $parent = Category::find($validated['parent_id']);
                if ($parent->parent_id != null) {
                    throw ValidationException::withMessages([
                        'parent_id' => 'Parent category should not be a child category'
                    ]);
                }
            }
        }
        // Update category
        $category->update($validated);

        return  response()->json([
            'data' => new CategoryResource($category),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $this->authorize('delete', [Category::class, $category]);
        $category->delete();

        return response()->noContent();
    }
}
