<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ConstructorRepository;
use App\Repository\EventRepository;
use App\Repository\PilotRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class HomeController extends AbstractController
{
    public function __construct(
        private Environment $twig,
        private CategoryRepository $categoryRepository,
        private EventRepository $eventRepository,
        private PilotRepository $pilotRepository,
        private ConstructorRepository $constructorRepository
    ) {}

    #[Route('/', name: 'app_home')]
    public function showHome(): Response
    {
        $categories = $this->categoryRepository->findAll();

        return $this->render('home/home.html.twig', [
            'categories' => $categories
        ]);
    }

    #[Route('/{category}', name: 'app_home_category', priority: -10)]
    public function showHomeCategory(string $category): Response
    {
        $categories = $this->categoryRepository->findAll();

        $categoryEntity = $this->categoryRepository->findOneBy(['nameUrl' => $category]);

        if (!$categoryEntity) {
            throw $this->createNotFoundException('Catégorie introuvable');
        }

        $event = $this->eventRepository->findNextEvent($categoryEntity->getId());
        $arrayPilots = $this->formatEntities($this->pilotRepository->findByCategory($categoryEntity, 10));
        $arrayConstructors = $this->formatEntities($this->constructorRepository->findByCategory($categoryEntity, 10));

        return $this->render("home/category-home.html.twig", [
            'categories' => $categories,
            'category' => $category,
            'event' => $event,
            'arrayPilots' => $arrayPilots,
            'arrayConstructors' => $arrayConstructors
        ]);
    }

    private function formatEntities(array $entities): array
    {
        return array_map(function ($entity, $index) {
            return [
                'position' => $index + 1,
                'fullName' => $entity->getFullName(),
                'seasonTotalPoint' => $entity->getSeasonTotalPoint(),
            ];
        }, $entities, array_keys($entities));
    }
}
