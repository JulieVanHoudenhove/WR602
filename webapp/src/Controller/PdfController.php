<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PdfController extends AbstractController
{
    #[Route('/pdf', name: 'app_pdf')]
    public function index(HttpClientInterface $client, ParameterBagInterface $parameterBag): Response
    {
        $hostMicroservice = $parameterBag->get('URL_MICROSERVICE_PDF');
        $response =  $client->request('POST', $hostMicroservice . '/generate_pdf', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
//            'body' => json_encode(['key' => 'value']),
        ]);
        dump($response->getContent());
        dd($response);
        return $this->render('pdf/index.html.twig', [
            'controller_name' => 'PdfController',
        ]);
    }
}
