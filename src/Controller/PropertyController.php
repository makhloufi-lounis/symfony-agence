<?php


namespace App\Controller;

use App\Entity\Property;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use App\Repository\PropertyRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
{

    /**
     * @var PropertyRepository
     */
    private $repository;

    /**
     * PropertyController constructor.
     * @param PropertyRepository $repository
     */
    public function __construct(PropertyRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/properties", name="property.index")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        // Creation of an entity that will represent our research
        $search = new PropertySearch();
        // Creation of a form
        $form = $this->createForm(PropertySearchType::class,$search, [
            'block_name' => 'intuitive_search'
        ]);
        // Manage processing here
        $form->handleRequest($request);

        $propertiesPagination = $paginator->paginate(
            $this->repository->findAllVisibleQuery($search),
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties',
            'properties' => $propertiesPagination,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/properties/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*", "id": "[0-9]+"})
     * @param Property $property
     * @return Response
     */
    public function show(Property $property, string $slug): Response
    {
        // avec l'ingection de dépendance Property $property
        // symfony vas utiliser la variable id dans url pour faire
        // $this->repository->find($id) et retourner $property

        if ($property->getSlug() !== $slug){
            return $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);
        }
        return $this->render('property/show.html.twig', [
            'current_menu' => 'properties',
            'property' => $property
        ]);
    }

}
