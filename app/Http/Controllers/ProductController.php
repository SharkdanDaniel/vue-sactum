<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::where(function ($query) use ($request) {
            $query->where('name', 'like', '%' . str_replace(' ', '%', $request->input(key:'search')) . '%')
                ->orWhere('price', 'like', '%' . str_replace(' ', '%', $request->input(key:'search')) . '%')
                ->orWhere('description', 'like', '%' . str_replace(' ', '%', $request->input(key:'search')) . '%');
        })
            ->orderBy($request->input(key:'orderBy'), $request->input(key:'sort'))
            ->paginate($request->input(key:'per_page'));
        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $input = $request->validated();
        $product = Product::create([
            'name' => $input['name'],
            'price' => $input['price'],
            'description' => $input['description'] ?? null,
        ]);
        return response()->json($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProductRequest $request, Product $product)
    {
        $input = $request->validated();
        $product->name = $input['name'];
        $product->price = $input['price'];
        $product->description = $input['description'] ?? null;
        $product->save();
        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully']);
    }

    /**
     * Remove multiple resources from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroyAll(Request $request)
    {
        $products = $request->all();
        DB::transaction(function () use ($products) {
            foreach ($products as $product) {
                Product::where('id', $product['id'])->delete();
            }
        });
        return response()->json(['message' => 'Products deleted successfully']);
    }
}
