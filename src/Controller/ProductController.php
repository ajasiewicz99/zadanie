<?php

namespace App\Controller;

use App\Service\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    public function __construct(private ProductService $productService)
    {
    }

    #[Route('/products', name: 'post_product', methods: ['POST'])]
    public function createProduct(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $productId = $this->productService->createProduct($data);
        return new JsonResponse([
            'id' => $productId,
            'message' => 'Product created successfully',
        ], Response::HTTP_CREATED);
    }

    #[Route('/products', name: 'get_products', methods: ['GET'])]
    public function getAllProducts(): Response
    {
        $products = $this->productService->getAllProducts();

        return new JsonResponse($products, Response::HTTP_OK);
    }
}
