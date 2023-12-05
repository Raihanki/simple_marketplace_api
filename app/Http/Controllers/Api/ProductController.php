<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * ProductController constructor.
     */
    public function __construct()
    {
        $this->middleware(["auth:sanctum", "ability:seller"])->except("index", "show");
    }

    /**
     * API for get all products
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $limit = $request->has('limit') ? $request->get('limit') : 10;
        try {
            if ($request->has('search')) {
                $products = ProductResource::collection(Product::query()
                    ->with('user')
                    ->where('name', 'like', '%' . $request->get('search') . '%')
                    ->latest()
                    ->paginate($limit));
            } else {
                $products = ProductResource::collection(Product::query()
                    ->with('user')
                    ->where('name', 'like', '%' . $request->get('search') . '%')
                    ->latest()
                    ->paginate($limit));
            }

            return response()->json([
                "success" => true,
                "message" => "Products retrieved successfully",
                "data" => $products
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }

    /**
     * API for create product
     *
     * @param ProductRequest $request
     *
     * @return JsonResponse
     */
    public function store(ProductRequest $request): JsonResponse
    {
        $this->authorize("create", Product::class);

        $data = $request->validated();
        try {
            $data['slug'] = str()->slug($data['name']) . '-' . time();
            $product = $request->user()->products()->create($data);
            return response()->json([
                "success" => true,
                "message" => "Product created successfully",
                "data" => new ProductResource($product->load('user'))
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }

    /**
     * API for get single product by slug
     *
     * @param Product $product
     *
     * @return JsonResponse
     */
    public function show(Product $product): JsonResponse
    {
        try {
            return response()->json([
                "success" => true,
                "message" => "Product retrieved successfully",
                "data" => new ProductResource($product->load('user'))
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }

    /**
     * API for update product
     *
     * @param ProductRequest $request
     * @param Product $product
     *
     * @return JsonResponse
     */
    public function update(ProductRequest $request, Product $product): JsonResponse
    {
        $this->authorize("update", $product);

        $data = $request->validated();
        try {
            $data['slug'] = str()->slug($data['name']) . '-' . time();
            $product->update($data);
            return response()->json([
                "success" => true,
                "message" => "Product updated successfully",
                "data" => new ProductResource($product->load('user'))
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }

    /**
     * API for delete product
     *
     * @param Product $product
     *
     * @return JsonResponse
     */
    public function destroy(Product $product): JsonResponse
    {
        $this->authorize("delete", $product);

        try {
            $product->delete();
            return response()->json([
                "success" => true,
                "message" => "Product deleted successfully",
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
