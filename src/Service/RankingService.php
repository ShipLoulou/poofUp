<?php

namespace App\Service;

use App\Repository\CategoryRepository;
use App\Repository\ConstructorRepository;
use App\Repository\EventRepository;
use App\Repository\PilotRepository;

class RankingService
{
    public function __construct(
        private CategoryRepository $categoryRepository,
        private EventRepository $eventRepository,
        private PilotRepository $pilotRepository,
        private ConstructorRepository $constructorRepository
    ) {}

    public function getCategoryByUrl(string $nameUrl)
    {
        return $this->categoryRepository->findOneBy(['nameUrl' => $nameUrl]);
    }

    public function getEventsByCategory($category): array
    {
        $events = $this->eventRepository->findByCategory($category->getId());
        return array_map(fn($event) => [
            'name' => $event->getName(),
            'startDate' => $event->getStartDateToString(),
            'endDate' => $event->getEndDateToString(),
        ], $events);
    }

    public function getPilotsByCategory($category): array
    {
        $pilots = $this->pilotRepository->findAllByCategory($category);
        return array_map(fn($pilot, $index) => [
            'position' => $index + 1,
            'fullName' => $pilot->getFullName(),
            'seasonTotalPoint' => $pilot->getSeasonTotalPoint(),
        ], $pilots, array_keys($pilots));
    }

    public function getConstructorsByCategory($category): array
    {
        $constructors = $this->constructorRepository->findAllByCategory($category);
        return array_map(fn($constructor, $index) => [
            'position' => $index + 1,
            'fullName' => $constructor->getFullName(),
            'seasonTotalPoint' => $constructor->getSeasonTotalPoint(),
        ], $constructors, array_keys($constructors));
    }
}
