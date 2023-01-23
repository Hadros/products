<?php

namespace App\Tests\Service;

use App\Entity\Product;
use App\Service\ProductService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProductServiceTest extends KernelTestCase
{

    public function testCreateProducts() {
        self::bootKernel();

        $container = static::getContainer();

        /** @var ProductService $productService */
        $productService = $container->get(ProductService::class);
        $productService->createProducts($this->getProductData());
        $products = $productService->getProductsPaginated();
        $this->assertEquals(2, count($products));
        $this->assertInstanceOf(Product::class, $products[0]);
        $this->assertEquals(5, $products[0]->getRating());
    }

    protected function getProductData() {
        return [
            [
                'productId' => 1,
                'title' => 'product1',
                'description' => 'product1 description',
                'rating' => 5,
                'price' => 25,
                'image' => 'some url',
            ],
            [
                'productId' => 2,
                'title' => 'product2',
                'description' => 'product2 description',
                'rating' => 3,
                'price' => 111,
                'image' => 'some url2',
            ]
        ];
    }

}