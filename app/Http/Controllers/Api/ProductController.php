<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

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
 *                 example={"name": "Blusa Feminina", "price": 15.85, "description": "Blusa Feminina tamanho G", "category": "Roupas", "image_url": "https://site.com/imagem.jpg"}
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
 *                 example={"name": "Blusa Masculina", "price": 35.50, "description": "Blusa Masculina tamanho P", "category": "Roupas", "image_url": "https://site.com/imagem.jpg"}
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
     * Lista todos os produtos
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => Product::all(),
        ]);
    }

    /**
     * Cadastra um produto
     *
     * @param ProductRequest $request
     * @return JsonResponse
     */
    public function store(ProductRequest $request): JsonResponse
    {
        $insert = Product::query()->create($request->all());

        return response()->json($insert);
    }

    /**
     * Mostra um produto
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): ?JsonResponse
    {
        $product = Product::query()->find($id);

        if (!$product) {
            return response()->json('Produto inexistente', 400);
        }

        return response()->json([
            'data' => Product::query()->find($id)
        ]);
    }

    /**
     * Editad um produto
     *
     * @param ProductRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(ProductRequest $request, int $id): ?JsonResponse
    {
        $product = Product::query()->find($id);

        if (!$product) {
            return response()->json('Produto inexistente', 400);
        }


        $product = Product::query()
            ->find($id)
            ->update($request->all());

        return response()->json([
            'successo' => $product
        ]);
    }

    /**
     * Exlui um produto
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): ?JsonResponse
    {
        $product = Product::query()->find($id);

        if (!$product) {
            return response()->json('Produto inexistente', 400);
        }

        return response()->json([
            'sucesso' => Product::query()->find($id)->delete()
        ]);
    }


    /**
     * Busca por nome e categoria
     *
     * @param $name
     * @param $category
     * @return JsonResponse
     */
    public function searchNameCategory($name, $category): JsonResponse
    {
        $products = Product::query()
            ->where('name', $name)
            ->where('category', $category)
            ->get();

        if ($products->count() === 0) {
            return response()->json('Nenhum produto encontrado', 400);
        }


        return response()->json([
            'data' => $products
        ]);
    }


    /**
     * Busca por categoria
     *
     * @param $category
     * @return JsonResponse
     */
    public function searchCategory($category): JsonResponse
    {
        $products = Product::query()
            ->where('category', $category)
            ->get();

        if ($products->count() === 0) {
            return response()->json('Nenhum produto encontrado', 400);
        }

        return response()->json([
            'data' => $products
        ]);
    }


    /**
     * Busca produtos com imagem
     *
     * @return JsonResponse
     */
    public function searchWithImage(): JsonResponse
    {
        $products = Product::query()
            ->whereNotNull('image_url')
            ->get();

        if ($products->count() === 0) {
            return response()->json('Nenhum produto encontrado', 400);
        }

        return response()->json([
            'data' => $products
        ]);
    }


    /**
     * Busca produtos sem imagem
     *
     * @return JsonResponse
     */
    public function searchWithoutImage(): JsonResponse
    {
        $products = Product::query()
            ->whereNull('image_url')
            ->get();

        if ($products->count() === 0) {
            return response()->json('Nenhum produto encontrado', 400);
        }

        return response()->json([
            'data' => $products
        ]);
    }
}
