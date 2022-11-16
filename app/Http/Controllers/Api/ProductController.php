<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'data' => Product::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $insert = Product::query()->create($request->all());

        return response()->json($insert);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $product = Product::query()->find($id);

        if (!$product) {
            return response()->json('Produto inexistente', 400);
        } else {
            return response()->json([
                'data' => Product::query()->find($id)
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function update(ProductRequest $request, int $id)
    {
        $product = Product::query()->find($id);

        if (!$product) {
            return response()->json('Produto inexistente', 400);
        } else {
            $product = Product::query()
                ->find($id)
                ->update($request->all());
            return response()->json([
                'successo' => $product
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $product = Product::query()->find($id);

        if (!$product) {
            return response()->json('Produto inexistente', 400);
        } else {
            return response()->json([
                'sucesso' => Product::query()->find($id)->delete()
            ]);
        }
    }


    /**
     * @param $name
     * @param $category
     * @return JsonResponse
     */
    public function searchNameCategory($name, $category)
    {
        $products = Product::query()
            ->where('name', $name)
            ->where('category', $category)
            ->get();

        if ($products->count() === 0) {
            return response()->json('Nenhum produto encontrado', 400);
        } else {
            return response()->json([
                'data' => $products
            ]);
        }
    }


    /**
     * @param $category
     * @return JsonResponse
     */
    public function searchCategory($category)
    {
        $products = Product::query()
            ->where('category', $category)
            ->get();

        if ($products->count() === 0) {
            return response()->json('Nenhum produto encontrado', 400);
        } else {
            return response()->json([
                'data' => $products
            ]);
        }
    }


    /**
     * @return JsonResponse
     */
    public function searchWithImage()
    {
        $products = Product::query()
            ->whereNotNull('image_url')
            ->get();

        if ($products->count() === 0) {
            return response()->json('Nenhum produto encontrado', 400);
        } else {
            return response()->json([
                'data' => $products
            ]);
        }
    }


    /**
     * @return JsonResponse
     */
    public function searchWithoutImage()
    {
        $products = Product::query()
            ->whereNull('image_url')
            ->get();

        if ($products->count() === 0) {
            return response()->json('Nenhum produto encontrado', 400);
        } else {
            return response()->json([
                'data' => $products
            ]);
        }
    }
}
