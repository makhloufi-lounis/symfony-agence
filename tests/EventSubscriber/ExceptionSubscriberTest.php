<?php
/**
 * API Shop
 *
 * @version   1.0
 * @author    Lounis Makhloufi <makhloufi.lounis@gmail.com>
 * @see       https://github.com/makhloufi-lounis/api-shop for the canonical source repository
 * @copyright Copyright (c) 2020.
 */

namespace App\Tests\EventSubscriber;

use App\EventSubscriber\ExceptionSubscriber;
use http\Env\Request;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class ExceptionSubscriberTest extends TestCase
{

    public function testEventSubscription()
    {
        $this->assertArrayHasKey(ExceptionEvent::class, ExceptionSubscriber::getSubscribedEvents());
    }

    /**
     * Ce Test permet de vérifier que la methode onException a bien été appeler
     */
    public function testOnExceptionSendEmail()
    {
        $mailer = $this->getMockBuilder(\Swift_Mailer::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mailer->expects($this->once())
            ->method('send');
        $this->dispatch($mailer);
    }

    /**
     * Ce Test permet de vérifier que le mail a été envoyer au bonne personne et de la part du bonne personne
     */
    public function testOnExceptionSendEmailToTheAdmin()
    {
        $mailer = $this->getMockBuilder(\Swift_Mailer::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mailer->expects($this->once())
            ->method('send')
            ->with($this->callback(function(\Swift_Message $message){
                return
                    array_key_exists('from@domain.fr', $message->getFrom()) &&
                    array_key_exists('to@domain.fr', $message->getTo());
            }));
        $this->dispatch($mailer);
    }

    /**
     * Ce Test permet de vérifier que le bon contenu (message) qui a été envoyer
     */
    public function testOnExceptionSendEmailWithTheTrace()
    {
        $mailer = $this->getMockBuilder(\Swift_Mailer::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mailer->expects($this->once())
            ->method('send')
            ->with($this->callback(function(\Swift_Message $message){
                return strpos($message->getBody(), 'ExceptionSubscriberTest') &&
                    strpos($message->getBody(), 'Hello world');
            }));
        $this->dispatch($mailer);
    }

    private function dispatch($mailer)
    {
        $subscriber = new ExceptionSubscriber($mailer, 'from@domain.fr', 'to@domain.fr');
        $kernel = $this->getMockBuilder(HttpKernelInterface::class)
            ->getMock();
        $event = new ExceptionEvent($kernel, new \Symfony\Component\HttpFoundation\Request(), 1, new \Exception('Hello world'));
        /**
         * Premier Approche
         **/
        // $subscriber->onException($event);

        /**
         * Deuxiem Approche avec l'utilisation du EventDispatcher pour vérifier
         * que l'évenement est bien cablé a la fonction onException
         **/
        $dispatcher = new EventDispatcher();
        $dispatcher->addSubscriber($subscriber);
        $dispatcher->dispatch($event);
    }

}
