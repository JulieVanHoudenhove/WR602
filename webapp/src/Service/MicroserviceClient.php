<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MicroserviceClient extends AbstractController
{

    public function __construct(private HttpClientInterface $client, private ParameterBagInterface $parameterBag)
    {
    }

    public function createPdf(string $url ): Response
    {
        $hostMicroservice = $this->parameterBag->get('URL_MICROSERVICE_PDF');

        $response =  $this->client->request('POST', $hostMicroservice . '/generate_pdf',
            [
                'body' => ['url' => $url],
            ]
        );

        $response = new Response($response->getContent());

        $response->headers->set('Content-Type', 'application/pdf');

        return $response;
    }
}
