<?php

namespace App\Service;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;

class ProductService
{

    private EntityManagerInterface $entityManager;

    private ProductRepository $productRepository;

    public function __construct(EntityManagerInterface $entityManager, ProductRepository $productRepository) {
        $this->entityManager = $entityManager;
        $this->productRepository = $productRepository;
    }

    public function createProducts($productsData) {
        foreach ($productsData as $productData) {
            extract($productData);

            $product = $this->productRepository->getProductByProductId($productId);
            if ($product === NULL) {
                $product = new Product();
            }

            $product->setProductId($productId);
            $product->setTitle($title);
            $product->setDescription($description);
            $product->setRating($rating);
            $product->setPrice($price);
            $product->setImage($image);

            $this->entityManager->persist($product);
            $this->entityManager->flush();
        }
    }


}