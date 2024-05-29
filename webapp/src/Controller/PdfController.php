<?php

namespace App\Controller;

use App\Entity\Pdf;
use App\Repository\PdfRepository;
use App\Service\MicroserviceClient;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use DateTimeImmutable;

class PdfController extends AbstractController
{
    #[Route('/pdf', name: 'app_pdf', methods: ['GET', 'POST'])]
    public function index(Request $request, MicroserviceClient $microserviceClient, PdfRepository $pdfRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $userSubscription = $user->getSubscription();
        $pdfLimitPerDay = $userSubscription->getPdfLimit();

        $userId = $user->getId();
        $startOfDay = new \DateTime('today');
        $endOfDay = new \DateTime('tomorrow');
        $endOfDay->modify('-1 second');

        $pdfCount = $pdfRepository->countPdfGeneratedByUserOnDate($userId, $startOfDay, $endOfDay);

        $form = $this->createFormBuilder()
            ->add('title', TextType::class, ['required' => false, 'label' => 'Pdf title'])
            ->add('url', UrlType::class, ['required' => true])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $url = $form->getData()['url'];

            if ($pdfCount >= $pdfLimitPerDay) {
                $this->addFlash('danger', 'You have reached the limit of PDFs you can generate per day.');
            } else {
                $pdf = $microserviceClient->createPdf($url);
                $filename = json_decode($pdf->getContent(), true);
                $filename = $filename['filename'];
                $title = $form->getData()['title'];
                $pdfEntity = new Pdf();
                $pdfEntity->setTitle($title);
                $pdfEntity->setFilename($filename);
                $pdfEntity->setUser($user);
                $pdfEntity->setCreatedAt(new DateTimeImmutable());
                $entityManager->persist($pdfEntity);
                $entityManager->flush();
                $this->addFlash('success', 'PDF generated successfully.');
            }

            return $this->redirectToRoute('app_pdf');
        }

        return $this->render('pdf/index.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'pdf_limit' => $pdfLimitPerDay,
            'pdf_count' => $pdfCount,
        ]);
    }
}
