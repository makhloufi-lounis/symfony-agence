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


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class SecurityController
 * @package App\Controller
 */
class SecurityController extends AbstractController
{

    /**
     * @Route("/login", name="login", methods={"GET", "POST"})
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login (AuthenticationUtils $authenticationUtils): Response
    {
        $lastUserName = $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig', [
            'last_username' => $lastUserName,
            'error' => $authenticationUtils->getLastAuthenticationError()
        ]);
    }
}