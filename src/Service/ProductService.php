<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Product;

class ProductService
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function createProduct(array $data): int
    {
        $product = new Product();
        $product->setName($data['name']);
        $product->setPrice($data['price']);

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return $product->getId();
    }

    public function getAllProducts(): array
    {
        $repository = $this->entityManager->getRepository(Product::class);
        $products = $repository->findAll();

        $formattedProducts = [];
        foreach ($products as $product) {
            $formattedProducts[] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'price' => $product->getPrice(),
            ];
        }

        return $formattedProducts;
    }
}
