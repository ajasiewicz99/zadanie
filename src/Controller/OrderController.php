<?php

namespace App\Controller;

use App\Service\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{

    public function __construct(private readonly OrderService $orderService)
    {
    }

    #[Route('/order', name: 'create_order', methods: ['POST'])]
    public function createOrder(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        try {
            $orderId = $this->orderService->createOrder($data['items']);

            return $this->json([
                'id' => $orderId,
                'message' => 'Order created successfully',
            ]);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/order/{orderId}', name: 'get_order', methods: ['GET'])]
    public function getOrder(int $orderId): JsonResponse
    {
        try {
            $order = $this->orderService->getOrderDetails($orderId);

            return $this->json($order);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }
}
