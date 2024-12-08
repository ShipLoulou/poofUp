<?php

namespace App\Controller;

use Twig\Environment;
use App\Form\EventFormType;
use App\Form\PilotFormType;
use InvalidArgumentException;
use App\Form\ConstructorFormType;
use App\Repository\EventRepository;
use App\Repository\PilotRepository;
use App\Repository\SeasonRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ConstructorRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    public function __construct(
        private Environment $twig,
        private EntityManagerInterface $em,
        private EventRepository $eventRepository,
        private PilotRepository $pilotRepository,
        private ConstructorRepository $constructorRepository,
        private CategoryRepository $categoryRepository,
        private SeasonRepository $seasonRepository
    ) {}

    #[Route('/admin', name: 'app_admin')]
    public function showAdmin(Request $request): Response
    {
        return $this->render('admin/admin.html.twig', [
            'currentRoute' => $request->attributes->get('_route'),
            'pathInfo' => $request->getPathInfo()
        ]);
    }

    #[Route('admin/{entity}/{id}', name: 'app_admin_entity', defaults: ['id' => null], priority: -1)]
    public function showAdminCategory(
        string $entity,
        ?int $id,
        Request $request
    ): Response {

        $repository = $this->getRepository($entity);
        $formType = $this->getFormType($entity);
        $item = $id ? $repository->find($id) : null;
        $form = $this->createForm($formType, $item);

        $paramRequest = $request->request->all();

        if ($paramRequest !== [] && count($paramRequest) === 3) {
            $filterCategory = $paramRequest['filterCategory'];
            $filterYears = $paramRequest['filterYears'];
            $filterSort = $paramRequest['filterSort'];
            $items = $this->filterManagement($filterCategory, $filterYears, $filterSort, $entity . 'Repository');
        } else {
            $items = $repository->findAll();
        }

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($form->getData());
            $this->em->flush();
            return $this->redirectToRoute('app_admin_entity', ['entity' => $entity]);
        }

        return $this->render("admin/$entity.html.twig", [
            'formView' => $form->createView(),
            'items' => $items,
            'categories' => $this->categoryRepository->findAll(),
            'seasons' => $this->seasonRepository->findAll(),
            'entity' => $entity,
            'pathInfo' => $request->getPathInfo()
        ]);
    }

    #[Route('/admin/{entity}/delete/{id}', name: 'app_admin_delete')]
    public function deleteEntity(string $entity, int $id): Response
    {
        $repository = $this->getRepository($entity);
        $item = $repository->find($id);

        if (!$item) {
            throw $this->createNotFoundException(ucfirst($entity) . " introuvable");
        }

        $this->em->remove($item);
        $this->em->flush();

        return $this->redirectToRoute('app_admin_entity', ['entity' => $entity]);
    }

    private function getRepository(string $entity): object
    {
        return match ($entity) {
            'event' => $this->eventRepository,
            'pilot' => $this->pilotRepository,
            'constructor' => $this->constructorRepository,
            default => throw new InvalidArgumentException("Invalid entity type: $entity"),
        };
    }

    private function getFormType(string $entity): string
    {
        return match ($entity) {
            'event' => EventFormType::class,
            'pilot' => PilotFormType::class,
            'constructor' => ConstructorFormType::class,
            default => throw new InvalidArgumentException("Invalid form type for entity: $entity"),
        };
    }

    public function filterManagement(
        $category = null,
        $season = null,
        $sort = null,
        $repository
    ): ?array {
        $category_id = null;
        $season_id = null;

        if ($category && $category !== "") {
            $category_id = $this->categoryRepository->findOneBy(['nameUrl' => $category]);
        }
        if ($season && $season !== "") {
            $season_id = $this->seasonRepository->findOneBy(['years' => $season]);
        }

        $arraySort = $this->$repository->findWithFilterParametter($category_id, $season_id, $sort);

        return $arraySort;
    }
}
