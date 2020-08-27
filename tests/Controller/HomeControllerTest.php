<?php
/**
 * API Shop
 *
 * @version   1.0
 * @author    Lounis Makhloufi <makhloufi.lounis@gmail.com>
 * @see       https://github.com/makhloufi-lounis/api-shop for the canonical source repository
 * @copyright Copyright (c) 2020.
 */

namespace App\Tests\Controller;

use App\Controller\HomeController;
use App\DataFixtures\OptionFixtures;
use App\DataFixtures\PropertyFixtures;
use App\DataFixtures\RegulationFixtures;
use App\DataFixtures\UserFixtures;
use App\Entity\Property;
use App\Entity\User;
use App\Repository\PropertyRepository;
use App\Tests\NeedLogin;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class HomeControllerTest extends WebTestCase
{

    use FixturesTrait;
    use NeedLogin;

    /**
     * Ce Test permet de vérifier que la fonction index return une réponse avec un status 200
     */
    public function testIndex()
    {
        $client = static::createClient();
        $result = $client->request('GET', '/');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    /**
     * Ce Test permet de vérifier que le contenu returner par la fonction index contient
     * un h1 avec le text Agence BBA
     */
    public function testReturnIndex()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertSelectorTextContains('h1', 'Agence BBA');
    }

    /**
     * Ce Test permet de vérifier que le contenu returner par la fonction index contient
     * un h1 avec le text Agence BBA
     */
    public function testDataIndex()
    {
        $propertys = $this->loadFixtureFiles([dirname(__DIR__) . '/Fixtures/propertyFixture.yaml']);
        self :: ensureKernelShutdown ();
        /** @var Property $property */
        $property = $propertys['property'];
        $client = static::createClient();
        /** @var  HomeController $controller */
        $controller = $client->getContainer()->get(HomeController::class);
        $repository = $this->getMockBuilder(PropertyRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $repository->expects($this->once())
            ->method('findLatest')
            ->willReturn([0=>$property]);
        $result = $controller->index($repository);
       $this->assertInstanceOf(Response::class, $result);
    }

    /**
     * Ce test permet de vérifier que la page /dashboard est bien protéger
     * pour accéder il fau être authentifier
     */
    public function testDashboardIsGranted()
    {
        $client = static::createClient();
        $client->request('GET', '/dashboard');
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $this->assertResponseRedirects('http://localhost/login');
    }

    /**
     * Ce test permet de faire authentifier un utilisateur et
     * lui permet d'accéder a la page dashboard
     */
    public function testLetAuthenticatedUserAccessDashboard()
    {
        self :: ensureKernelShutdown ();
        $client = static::createClient();
        $users = $this->loadFixtureFiles([dirname(__DIR__) . '/Fixtures/users.yaml']);
        /** @var User $user */
        $user = $users['user_user'];

        /** @var Session $session */
        //$session = $client->getContainer()->get('session');
        /**
         * Le main dans le __security_main coréspond au firewall main
         * */
        /*$token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
        $session->set('_security_main', serialize($token));
        $session->save();*/
        /**
         * Creation du cookie pour associer la session créer et sauvgarder précédament
         * pour l'associe au client $client
         * Note il faut utiliser Le cookie du BrowserKit
         **/
       // $cookie = new Cookie($session->getName(), $session->getId());

        /**
         * Stockage du cookie dans le client
         */
        //$client->getCookieJar()->set($cookie);

        /**
         * Remplacement du tout le code commenté par la fonction login de trait NeedLogin
         * pour factorisé le code
         */
        $this->login($client, $user);
        /**
         * Test d'accés a une page protéger (qui demande une authentification)
         */
        $client->request('GET', '/dashboard');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}
