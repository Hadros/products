<?php

namespace App\Service;

class XmlParser
{

    public function getProductsData(string $url) {
        $productsData = [];
        try {
            $xml = simplexml_load_file($url);
            foreach ($xml->products->product as $product) {
                $productId = (int) $product->product_id->__toString();
                $title = $product->title->__toString();
                $description = $product->description->__toString();
                $rating = (float) $product->rating->__toString();
                $inet_price = (int) $product->inet_price->__toString();
                if ($inet_price) {
                    $price = (int) $product->price->__toString();
                }
                $image = $product->image->__toString();
                $productsData[] = [
                    'productId' => $productId,
                    'title' => $title,
                    'description' => $description,
                    'rating' => $rating,
                    'price' => $inet_price ? $price : 0,
                    'image' => $image,
                ];
            }
        }
        catch (\Exception $exception) {

        }

        return $productsData;
    }

}