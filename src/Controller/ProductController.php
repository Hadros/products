<?php

namespace App\Controller;

use App\Entity\Product;
use App\Service\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\SerializerInterface;

class ProductController extends AbstractController
{
    const PAGE_SIZE = 10;

    #[Route('/api/products', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Returns products',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: Product::class))
        )
    )]
    #[OA\Parameter(
        name: 'page',
        description: 'Paginator',
        in: 'query',
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Tag(name: 'products')]
    public function getProducts(ProductService $productService, SerializerInterface $serializer, Request $request): JsonResponse
    {
        $page = $request->query->get('page') ?: 0;
        $products = $productService->getProductsPaginated(static::PAGE_SIZE, $page);

        $responseStr = $serializer->serialize($products, 'json');

        $response = new JsonResponse($responseStr, 200, ['Content-Type' => 'application/json'], true);
        $response->setEncodingOptions(JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        return $response;
    }
}
