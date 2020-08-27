<?php
/**
 * API Shop
 *
 * @version   1.0
 * @author    Lounis Makhloufi <makhloufi.lounis@gmail.com>
 * @see       https://github.com/makhloufi-lounis/api-shop for the canonical source repository
 * @copyright Copyright (c) 2020.
 */

namespace App\Tests\Controller\Security;

use App\Controller\Security\SecurityController;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class SecurityControllerTest extends WebTestCase
{

    use FixturesTrait;

    /**
     * Ce Test vérifier le retour de la fonction login
     * du controller Security
     */
    public function testDisplayLogin()
    {
        $client = static::createClient();
        $client->request('GET', '/login');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('title', 'Se connecter');
        $this->assertSelectorNotExists('.alert.alert-danger');
    }

    /**
     * Ce test vérifier le login avec des fausses identifiants
     */
    public function testLoginWithBadCredentials()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form([
            '_username' => 'john',
            '_password' => 'fakepassword'
        ]);
        $client->submit($form);
        $this->assertResponseRedirects('http://localhost/login');
        $client->followRedirect();
        $this->assertSelectorExists('.alert.alert-danger');
    }

    /**
     * Ce Test vérifier le login avec des bon identifiants
     */
    public function testSuccessFullLogin()
    {
        $this->loadFixtureFiles([dirname(__DIR__) . '/../Fixtures/users.yaml']);
        self :: ensureKernelShutdown ();
        $client = self::createClient();
        $crawler = $client->request('GET', '/login');
        /*$form = $crawler->selectButton('Se connecter')->form([
            '_username' => 'demo',
            '_password' => 'demo'
        ]);
        $client->submit($form);*/
        $csrfToken = $client->getContainer()->get('security.csrf.token_manager')->getToken('authenticate');
        $client->request('POST', '/login', [
            '_username' => 'demo',
            '_password' => 'demo',
            'csrf_token' => $csrfToken
        ]);
        $this->assertResponseRedirects('http://localhost/');
        $client->followRedirect();
        $this->assertSelectorTextContains('h1', 'Agence BBA');
    }
}
