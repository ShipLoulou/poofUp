<?php

namespace App\Controller;

use App\Service\RankingService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RankingController extends AbstractController
{
    public function __construct(
        private RankingService $rankingService
    ) {}

    #[Route('/event/{category}', name: 'app_event')]
    public function showEvent(string $category): Response
    {
        $categories = $this->rankingService->getCategoryByUrl($category);

        if (!$categories) {
            throw $this->createNotFoundException('Category not found.');
        }

        $events = $this->rankingService->getEventsByCategory($categories);

        return $this->render('ranking/event.html.twig', [
            'category' => $category,
            'arrayEvent' => $events,
            'categories' => $categories
        ]);
    }

    #[Route('/pilote/{category}', name: 'app_pilot')]
    public function showRankingPilot(string $category): Response
    {
        $categories = $this->rankingService->getCategoryByUrl($category);

        if (!$categories) {
            throw $this->createNotFoundException('Category not found.');
        }

        $pilots = $this->rankingService->getPilotsByCategory($categories);

        return $this->render('ranking/pilot.html.twig', [
            'category' => $category,
            'arrayPilots' => $pilots,
            'categories' => $categories
        ]);
    }

    #[Route('/construteur/{category}', name: 'app_constructor')]
    public function showRankingConstructor(string $category): Response
    {
        $categories = $this->rankingService->getCategoryByUrl($category);

        if (!$categories) {
            throw $this->createNotFoundException('Category not found.');
        }

        $constructors = $this->rankingService->getConstructorsByCategory($categories);

        return $this->render('ranking/constructor.html.twig', [
            'category' => $category,
            'arrayConstructors' => $constructors,
            'categories' => $categories
        ]);
    }
}
