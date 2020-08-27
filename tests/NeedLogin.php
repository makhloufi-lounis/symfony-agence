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


namespace App\Tests;


use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

trait NeedLogin
{

    public function login(KernelBrowser $client, User $user)
    {
        /** @var Session $session */
        $session = $client->getContainer()->get('session');
        /**
         * Le main dans le __security_main coréspond au firewall main
         * */
        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
        $session->set('_security_main', serialize($token));
        $session->save();

        /**
         * Creation du cookie pour associer la session créer et sauvgarder précédament
         * pour l'associe au client $client
         * Note il faut utiliser Le cookie du BrowserKit
         **/
        $cookie = new Cookie($session->getName(), $session->getId());

        /**
         * Stockage du cookie dans le client
         */
        $client->getCookieJar()->set($cookie);
    }
}