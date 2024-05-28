<?php

namespace App\Controller;

use App\Service\MicroserviceClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PdfController extends AbstractController
{
    #[Route('/pdf', name: 'app_pdf', methods: ['GET', 'POST'])]
    public function index(HttpClientInterface $client, ParameterBagInterface $parameterBag, Request $request, MicroserviceClient $microserviceClient): Response
    {

        $form = $this->createFormBuilder()
            ->add('url', null, ['required' => true])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $url = $form->getData()['url'];
            $pdf = $microserviceClient->createPdf($url);

            return $pdf;
        }

        return $this->render('pdf/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
