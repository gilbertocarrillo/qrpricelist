<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Pricelist;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ProductResource;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Pricelist $pricelist)
    {
        $productsQuery = $pricelist->categories()
            ->with('subcategories.products')
            ->whereNull('parent_id')
            ->select('products.*')
            ->leftJoin('products', function ($join) {
                $join->on('categories.id', '=', 'products.category_id');
            });

        $products = QueryBuilder::for(Product::query()->fromSub($productsQuery, 'products'))
            ->allowedIncludes(['category'])
            ->paginate(10);


        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request, Pricelist $pricelist)
    {
        $this->authorize('create', [Product::class,  $pricelist]);

        $validated = $request->validated();

        if ($request->has('photo')) {
            $photo = $request->file('photo');
            $path = Storage::putFile("{$pricelist->id}/products", $photo);
            $validated['photo'] = $path;
        }

        $product = Product::create($validated);

        return response()->json([
            'data' => new ProductResource($product)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product =  QueryBuilder::for(Product::where('id', $product->id))
            ->allowedIncludes(['category'])
            ->first();

        return response()->json([
            'data' => new ProductResource($product)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreProductRequest $request, Product $product)
    {
        $this->authorize('update', [Product::class, $product]);
        $validated = $request->validated();

        // Delete logo and cover if exist and store new
        if ($request->has('photo')) {
            if ($product->photo) {
                Storage::delete($product->photo);
            }
            $photo = $request->file('photo');
            $path = Storage::putFile("{$product->pricelist_id}/products", $photo);
            $validated['photo'] = $path;
        }
        // Update product
        $product->update($validated);

        return response()->json([
            'data' => new ProductResource($product)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->authorize('delete', [Product::class, $product]);

        if ($product->photo) {
            Storage::delete($product->photo);
        }

        $product->delete();

        return response()->noContent();
    }
}
