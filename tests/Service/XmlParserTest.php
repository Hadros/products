<?php

namespace App\Tests\Service;

use App\Service\XmlParser;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class XmlParserTest extends KernelTestCase
{
    public function testGetProductsData()
    {
        self::bootKernel();

        $container = static::getContainer();

        /** @var XmlParser $xmlParser */
        $xmlParser = $container->get(XmlParser::class);

        $url = __DIR__ . '/../products.xml';
        $productsData = $xmlParser->getProductsData($url);
        $this->assertEquals(132, count($productsData));
        $this->assertEquals(30013810, $productsData[0]['productId']);
    }

}
