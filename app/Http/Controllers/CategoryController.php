<?php

namespace App\Http\Controllers;

use App\Models\Pricelist;
use App\Models\Category;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use libphonenumber\Leniency\Valid;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Pricelist $pricelist)
    {
        return view('category.index', compact('pricelist'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Pricelist $pricelist)
    {
        return view('category.create', compact('pricelist'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Pricelist $pricelist)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'parent_id' => ['nullable', 'string', 'exists:categories,id'],
        ]);

        // Validate that parent category is not a child category
        if ($validated['parent_id'] != null) {
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
        return to_route('pricelists.categories.index', compact('pricelist'));
    }
    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'parent_id' => ['nullable', 'string', 'exists:categories,id'],
        ]);

        // Validate that we don't have to add a parent category to a parent category
        if ($request->has('parent_id')) {
            if ($validated['parent_id'] != null) {
                if ($category->parent_id == null) {
                    throw ValidationException::withMessages([
                        'parent_id' => 'Parents category should not be added to a parent category'
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
        return to_route('pricelists.categories.index', $category->pricelist_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $pricelist_id = $category->pricelist_id;
        // Delete category
        $category->delete();
        return to_route('pricelists.categories.index', $pricelist_id);
    }
}
