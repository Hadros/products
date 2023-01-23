<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HomePageController extends AbstractController
{
    #[Route('/', name: 'home_page')]
    public function index(HttpClientInterface $client): Response
    {

        $response = $client->request('GET', 'https://127.0.0.1:8000/api/products');
        $decoded_response = json_decode($response->getContent(), true);
        return new Response('Hello, World!');
    }
}
