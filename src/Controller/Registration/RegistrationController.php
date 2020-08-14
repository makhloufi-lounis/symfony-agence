<?php
/**
 * API Shop
 *
 * @version   1.0
 * @author    Lounis Makhloufi <makhloufi.lounis@gmail.com>
 * @see       https://github.com/makhloufi-lounis/api-shop for the canonical source repository
 * @copyright Copyright (c) 2020.
 */

declare(strict_types=1);


namespace App\Controller\Registration;

use App\Entity\Tools;
use App\Entity\User;
use App\Form\UserType;
use App\Handler\UserHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RegistrationController
 * @package App\Controller
 */
class RegistrationController extends AbstractController
{
    /**
     * @Route("/inscription", name="register")
     * @param Request $request
     * @param UserHandler $userHandler
     * @return Response
     */
    public function register( Request $request, UserHandler $userHandler)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        if($userHandler->Handel($form, $user, $request)){
            $this->addFlash("success", "Votre inscription est effectuée avec succès.");
            return $this->redirectToRoute("login");
        }
        return $this->render('register/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
