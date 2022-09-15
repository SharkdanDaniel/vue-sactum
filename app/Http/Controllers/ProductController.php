<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * @OA\Get(
     *     path="/products",
     *     tags={"Products"},
     *     summary="Get product list",
     *     operationId="listProduct",
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Current page",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Number of the data per page",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="order_by",
     *         in="query",
     *         description="Field to be ordered",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="sort",
     *         in="query",
     *         description="Asc or Desc",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Filter the data",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/ProductList")
     *     )
     * )
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
     * @OA\Post(
     *     path="/products",
     *     tags={"Products"},
     *     summary="Create a product",
     *     operationId="createProduct",
     *     @OA\RequestBody(
     *         description="Create product object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreProductRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     )
     * )
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
     * @OA\Get(
     *     path="/products/{productId}",
     *     tags={"Products"},
     *     summary="Get a product",
     *     operationId="getProduct",
     *     @OA\Parameter(
     *         name="productId",
     *         in="path",
     *         description="Product id to be showned",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     )
     * )
     */
    public function show(Product $product)
    {
        return response()->json($product);
    }

    /**
     * @OA\Put(
     *     path="/products/{productId}",
     *     tags={"Products"},
     *     summary="Update a product",
     *     operationId="updateProduct",
     *     @OA\Parameter(
     *         name="productId",
     *         in="path",
     *         description="Product id to be updated",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Update product object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     )
     * )
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
     * @OA\Delete(
     *     path="/products/{productId}",
     *     tags={"Products"},
     *     summary="Delete a product",
     *     operationId="deleteProduct",
     *     @OA\Parameter(
     *         name="productId",
     *         in="path",
     *         description="Product id to be deleted",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product deleted successfully",
     *         @OA\JsonContent(ref="#/components/schemas/ApiResponse")
     *     )
     * )
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully']);
    }

    /**
     * @OA\Patch(
     *     path="/products/delete",
     *     tags={"Products"},
     *     summary="Delete multiples products",
     *     operationId="deleteAllProducts",
     *     @OA\Response(
     *         response=200,
     *         description="Products deleted successfully",
     *         @OA\JsonContent(ref="#/components/schemas/ApiResponse")
     *     )
     * )
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
