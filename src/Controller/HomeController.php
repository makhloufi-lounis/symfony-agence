<?php


namespace App\Controller;

use App\Entity\Tools;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class HomeController extends AbstractController
{

    /**
     * @Route("/", name="home")
     * @param PropertyRepository $repository
     * @return Response
     */
    public function index(PropertyRepository $repository) : Response
    {
        $properties = $repository->findLatest();
        return $this->render('pages/home.html.twig', [
            'properties' => $properties,
            'Tools' => new Tools()
        ]);
    }

    /**
     * @Route("/dashboard", name="dashboard")
     * @return Response
     */
    public function dashboard(): Response
    {
        return new Response("Test connection");
    }

}
