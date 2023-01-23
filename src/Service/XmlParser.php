<?php

namespace App\Service;

class XmlParser
{

    /**
     * @throws \Exception
     */
    public function getProductsData(string $url): array {
        $productsData = [];
        try {
            $xml = simplexml_load_file($url);
            foreach ($xml->products->product as $product) {
                $productId = (int) $product->product_id->__toString();
                $title = $product->title->__toString();
                $description = $product->description->__toString();
                $rating = (float) $product->rating->__toString();
                $inet_price = (int) $product->inet_price->__toString();
                $price = $inet_price ? (int) $product->price->__toString() : 0;
                $image = $product->image->__toString();
                $productsData[] = [
                    'productId' => $productId,
                    'title' => $title,
                    'description' => $description,
                    'rating' => $rating,
                    'price' => $price,
                    'image' => $image,
                ];
            }
        }
        catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }

        return $productsData;
    }

}