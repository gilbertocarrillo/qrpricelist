<?php

namespace App\Http\Controllers;

use App\Models\Pricelist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Pricelist $pricelist)
    {
        $modalId = 'deleteProductModal';

        $categories = $pricelist->categories()
            ->with('subcategories.products')
            ->whereNull('parent_id')
            ->get();

        $products = collect();
        foreach ($categories as $category) {
            $products = $products->merge($category->products);
            foreach ($category->subcategories as $subcategory) {
                $products = $products->merge($subcategory->products);
            }
        }

        if ($request->ajax()) {
            return DataTables::of($products)
                ->editColumn('photo', function (Product $product) {
                    return '<img src="' . Storage::url($product->photo) . '" width="100" height="100" />';
                },)
                ->editColumn('category_id', function (Product $product) {
                    return $product->category->name;
                })
                ->addColumn('action', function (Product $product) use ($modalId) {

                    return '
                    <a class="btn btn-outline-primary btn-sm me-2" href="' . route('products.edit', $product->id) . '">
                    Edit
                    </a>
                    <a class="btn btn-outline-danger btn-sm" href="" data-bs-toggle="modal"
                    data-bs-target="#' . $modalId . '" data-bs-title="Delete product"
                    data-bs-content="Are you sure you want to delete this product?"
                    data-bs-url="' . route('products.destroy', $product->id) . '">
                    Delete
                    </a>
                    ';
                })
                ->rawColumns(['photo', 'action'])
                ->toJson();
        }
        return view('products.index', compact('products', 'modalId'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Pricelist $pricelist)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'price' => ['required', 'numeric'],
            'category_id' => ['required', 'ulid', 'exists:categories,id'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg'],
        ]);

        if ($request->has('photo')) {
            $photo = $request->file('photo');
            $path = Storage::putFile("{$pricelist->id}/products", $photo);
            $validated['photo'] = $path;
        }

        Product::create($validated);
        return to_route('pricelists.products.index',  $pricelist->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'price' => ['required', 'numeric'],
            'category_id' => ['required', 'ulid', 'exists:categories,id'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg'],
        ]);

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

        return to_route('pricelists.products.index',  $product->category->pricelist_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->photo) {
            Storage::delete($product->photo);
        }
        $product->delete();
        return to_route('pricelists.products.index',  $product->category->pricelist_id);
    }
}
