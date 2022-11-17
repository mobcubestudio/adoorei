<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Adoorei",
 *     description="Documentação com todos os métodos de acesso à API da prova de avaliação",
 *     @OA\Contact(
 *          email="irwingcg@gmail.com"
 *     )
 * )
 *
 * @OA\Server(
 *          url="http://localhost:8000"
 *      )
 *
 * @OA\Get(
 *     path="/api/products",
 *     tags={"Produtos"},
 *     summary="Listar todos os produtos",
 *     @OA\Response(
 *          response="200",
 *          description="Ok"
 *      )
 * )
 *
 * @OA\Post(
 *     path="/api/products",
 *     tags={"Produtos"},
 *     summary="Adicona um novo produto",
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="name",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="price",
 *                     type="float"
 *                 ),
 *                 @OA\Property(
 *                     property="description",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="category",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="image_url",
 *                     type="url"
 *                 ),
 *                 example={"name": "Blusa Feminina", "price": 15.85, "description": "Blusa Feminina tamanho G", "category": "Roupas", "image_url": "http://site.com/imagem.jpg"}
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Put(
 *     path="/api/products/{id}",
 *     tags={"Produtos"},
 *     summary="Editar um produto",
 *     @OA\Parameter(
 *         description="ID do produto",
 *         in="path",
 *         name="id",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *     ),
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="name",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="price",
 *                     type="float"
 *                 ),
 *                 @OA\Property(
 *                     property="description",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="category",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="image_url",
 *                     type="url"
 *                 ),
 *                 example={"name": "Blusa Masculina", "price": 35.50, "description": "Blusa Masculina tamanho P", "category": "Roupas", "image_url": "http://site.com/imagem.jpg"}
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Produto Inexistente"
 *     )
 * )
 *
 * @OA\Delete(
 *     path="/api/products/{id}",
 *     tags={"Produtos"},
 *     summary="Excluir um produto",
 *     @OA\Parameter(
 *         description="ID do produto",
 *         in="path",
 *         name="id",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Produto Inexistente"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/products/{id}",
 *     tags={"Produtos"},
 *     summary="Mostrar um produto",
 *     @OA\Parameter(
 *         description="ID do produto",
 *         in="path",
 *         name="id",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Produto Inexistente"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/search/namecategory/{name}/{category}",
 *     tags={"Busca"},
 *     summary="Buscar um produto por nome e categoria",
 *     @OA\Parameter(
 *         description="Nome do produto",
 *         in="path",
 *         name="name",
 *         required=true,
 *         @OA\Schema(type="string"),
 *     ),
 *     @OA\Parameter(
 *         description="Categoria do produto",
 *         in="path",
 *         name="category",
 *         required=true,
 *         @OA\Schema(type="string"),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Nenhum produto encontrado"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/search/category/{category}",
 *     tags={"Busca"},
 *     summary="Buscar um produto por categoria",
 *     @OA\Parameter(
 *         description="Categoria do produto",
 *         in="path",
 *         name="category",
 *         required=true,
 *         @OA\Schema(type="string"),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Nenhum produto encontrado"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/search/withimage",
 *     tags={"Busca"},
 *     summary="Buscar produtos com imagem",
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/search/withoutimage",
 *     tags={"Busca"},
 *     summary="Buscar produtos sem imagem",
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 */
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
