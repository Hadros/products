<?php

namespace App\Tests\Controller;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class ProductControllerTest extends ApiTestCase
{

    public function testGetProducts(): void
    {
        static::createClient()->request('GET', '/api/products');
        $this->assertResponseIsSuccessful();
    }
}