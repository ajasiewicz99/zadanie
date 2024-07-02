<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Product;

class OrderService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private OrderCalculatorInterface $orderCalculator
    )
    {
    }

    public function createOrder(array $items): int
    {
        $order = new Order();

        foreach ($items as $item) {
            $productId = $item['product_id'];
            $quantity = $item['quantity'];

            $product = $this->entityManager->getRepository(Product::class)->find($productId);

            if (!$product) {
                throw new \InvalidArgumentException("Product with ID $productId not found");
            }

            $orderItem = new OrderItem();
            $orderItem->setOrder($order);
            $orderItem->setProduct($product);
            $orderItem->setQuantity($quantity);

            $order->addOrderItem($orderItem);

            $this->entityManager->persist($orderItem);
        }

        $orderCalculation = $this->orderCalculator->calculate($order);
        $order->setTotalPrice($orderCalculation['totalPrice']);

        $this->entityManager->persist($order);
        $this->entityManager->flush();

        return $order->getId();
    }

    public function getOrderDetails(int $orderId): array
    {
        $order = $this->entityManager->getRepository(Order::class)->find($orderId);

        if (!$order) {
            throw new \InvalidArgumentException("Order with ID $orderId not found");
        }

        $orderCalculation = $this->orderCalculator->calculate($order);

        $orderDetails = [
            'id' => $order->getId(),
            'createdAt' => $order->getOrderDate()->format('Y-m-d H:i:s'),
            'items' => [],
            'netPrice' => $orderCalculation['netPrice'],
            'vatAmount' => $orderCalculation['vatAmount'],
            'totalPrice' => $order->getTotalPrice(),
        ];

        foreach ($order->getOrderItems() as $item) {
            $orderDetails['items'][] = [
                'product_id' => $item->getProduct()->getId(),
                'quantity' => $item->getQuantity(),
                'product_name' => $item->getProduct()->getName(),
                'unit_price' => $item->getProduct()->getPrice(),
            ];
        }

        return $orderDetails;
    }
}
