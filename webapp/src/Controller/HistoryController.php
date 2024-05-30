<?php

namespace App\Controller;

use App\Entity\Pdf;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HistoryController extends AbstractController
{
    public function __construct(private Security $security, private string $microserviceClient)
    {
    }

    #[Route('/history', name: 'app_history')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Récupérer l'utilisateur connecté
        $user = $this->security->getUser();

        // Récupérer les PDF pour l'utilisateur connecté
        $pdfs = $entityManager->getRepository(PDF::class)->findBy(['user' => $user]);

        $pdfData = array_map(function (PDF $pdf) {
            return [
                'title' => $pdf->getTitle(),
                'filename' => $pdf->getFilename(),
                'createdAt' => $pdf->getCreatedAt()->format('Y-m-d H:i:s'),
                'downloadUrl' => $this->microserviceClient . '/uploads/' . $pdf->getFilename(),
            ];
        }, $pdfs);

        return $this->render('history/index.html.twig', [
            'pdfs' => $pdfData,
        ]);
    }
}
