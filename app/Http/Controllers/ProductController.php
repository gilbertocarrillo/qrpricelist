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
        $this->authorize('viewAny', [Product::class, $pricelist]);

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
                    return '<img src="' . ($product->photo ? Storage::url($product->photo) : Storage::url('default.jpeg')) . '" width="100" height="100" />';
                },)
                ->editColumn('category_id', function (Product $product) {
                    return $product->category->name;
                })
                ->addColumn('action', function (Product $product) use ($modalId) {

                    return '
                    <a class="btn btn-outline-primary btn-sm me-2 mb-2" href="' . route('products.edit', $product->id) . '">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                        fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                        <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z" />
                    </svg>
                    </a>
                    <a class="btn btn-outline-danger btn-sm mb-2" href="" data-bs-toggle="modal"
                    data-bs-target="#' . $modalId . '" data-bs-title="Delete product"
                    data-bs-content="Are you sure you want to delete this product?"
                    data-bs-url="' . route('products.destroy', $product->id) . '">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                <path
                                                    d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z" />
                                                <path
                                                    d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z" />
                                            </svg>
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
    public function create(Pricelist $pricelist)
    {
        $this->authorize('create', [Product::class, $pricelist]);

        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Pricelist $pricelist)
    {
        $this->authorize('create', [Product::class, $pricelist]);

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
        $this->authorize('update', [Product::class, $product]);

        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $this->authorize('update', [Product::class, $product]);

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
        $this->authorize('delete', [Product::class, $product]);

        if ($product->photo) {
            Storage::delete($product->photo);
        }
        $product->delete();
        return to_route('pricelists.products.index',  $product->category->pricelist_id);
    }
}
