<?php

namespace App\Service;

use App\Entity\Order;

interface OrderCalculatorInterface
{
    public function calculate(Order $order): array;
}
