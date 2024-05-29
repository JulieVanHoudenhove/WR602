<?php

namespace App\Controller;

use App\Entity\Subscription;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SubscriptionController extends AbstractController
{
    #[Route('/subscription', name: 'app_subscription')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $userSubscription = $user->getSubscription();
        $subscriptions = $entityManager->getRepository(Subscription::class)->findAll();

        return $this->render('subscription/index.html.twig', [
            'user' => $user,
            'subscriptions' => $subscriptions,
            'user_subscription' => $userSubscription,
        ]);
    }

    #[Route('/subscription_change/{id}', name: 'app_subscription_change')]
    public function subscription_change(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $subscription = $entityManager->getRepository(Subscription::class)->find($id);

        if ($subscription) {
            $user->setSubscription($subscription);
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Votre abonnement a bien été modifié.');
        } else {
            $this->addFlash('error', 'L\'abonnement sélectionné n\'existe pas.');
        }

        return $this->redirectToRoute('app_subscription');
    }
}
