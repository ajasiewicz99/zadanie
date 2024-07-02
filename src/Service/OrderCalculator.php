<?php

namespace App\Service;

use App\Entity\Order;
use App\Entity\OrderItem;

class OrderCalculator implements OrderCalculatorInterface
{
    private const VAT_RATE = 0.23;

    public function calculate(Order $order): array
    {
        $totalNetPrice = 0;
        $totalVatAmount = 0;

        /** @var OrderItem $orderItem */
        foreach ($order->getOrderItems() as $orderItem) {
            $netPrice = $orderItem->getProduct()->getPrice() * $orderItem->getQuantity();
            $vatAmount = $netPrice * self::VAT_RATE;
            $totalNetPrice += $netPrice;
            $totalVatAmount += $vatAmount;
        }

        $totalPrice = $totalNetPrice + $totalVatAmount;

        return [
            'netPrice' => (float) number_format($totalNetPrice,2,'.',''),
            'vatAmount' => (float) number_format($totalVatAmount,2,'.',''),
            'totalPrice' => $totalPrice,
        ];
    }
}
