<?php
/**
 * Teeps API Server
 *
 * @version   1.0
 * @author    Lounis Makhloufi <makhloufi.lounis@gmail.com>
 * @see       https://github.com/makhloufi-lounis/symfony-agence.git for the canonical source repository
 * @copyright Copyright (c) 2020 Agence.
 */

declare(strict_types=1);


namespace App\Controller\Admin;


use App\Entity\Option;
use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminPropertyController
 * @package App\Controller\Admin
 */
class AdminPropertyController extends AbstractController
{

    /**
     * @var PropertyRepository
     */
    private $repository;


    /**
     * AdminPropertyController constructor.
     * @param PropertyRepository $repository
     */
    public function __construct(PropertyRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/admin", name="admin.property.index", methods={"GET"})
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('admin/property/index.html.twig', [
            'properties' => $this->repository->findAll()
        ]);
    }

    /**
     * @Route("/admin/property/edit/{id}", name="admin.property.edit", methods={"GET", "POST"})
     * @param Property $property
     * @param Request $request
     * @return Response
     */
    public function edit(Property $property, Request $request): Response
    {
        $form = $this->createForm(PropertyType::class, $property, [
            'block_name' => 'admin',
        ]);
        try {
        $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $property->setUpdatedAt(new DateTime());
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $this->addFlash("success", "Votre bien a ete modifier avec succès");
                return $this->redirectToRoute("admin.property.index");
            }
        }catch (\Exception $e){
            dd($e->getMessage());
        }
        return $this->render("admin/property/edit.html.twig", [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/property/create", name="admin.property.new", methods={"GET", "POST"})
     * @param Request $request
     * @return Response
     */
    public function new (Request $request)
    {
        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property, [
            'block_name' => 'admin',
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($property);
            $em->flush();
            $this->addFlash("success", "Votre bien a ete créer avec succès");
            return $this->redirectToRoute("admin.property.index");
        }
        return $this->render("admin/property/new.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/property/delete/{id}", name="admin.property.delete", methods={"POST", "DETETE"})
     * @param Property $property
     * @param Request $request
     * @return Response
     */
    public function delete(Property $property, Request $request): Response
    {
        if($this->isCsrfTokenValid("delete".$property->getId(), $request->get("_token"))){
            $property->setStatus(Property::STATUS_DELETED);
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash("success", "Votre bien a ete supprimé avec succès");
        }
        return $this->redirectToRoute("admin.property.index");
    }
}