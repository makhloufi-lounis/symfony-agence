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

use App\Entity\Option;
use App\Entity\Property;
use App\EventSubscriber\ImageCacheSubscriber;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\PreRemove;
use Doctrine\ORM\Mapping\PreUpdate;
use Doctrine\Persistence\ObjectManager;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class ImageCacheSubscriberTest extends TestCase
{


    /**
     * @var ImageCacheSubscriber
     */
    private $subscriber;
    /**
     * @var MockObject|CacheManager
     */
    private $cacheManager;
    /**
     * @var MockObject|UploaderHelper
     */
    private $uploaderHelper;

    public function setUp(): void
    {
        $this->cacheManager = $this->getMockBuilder(CacheManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->uploaderHelper = $this->getMockBuilder(UploaderHelper::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->subscriber = new ImageCacheSubscriber($this->cacheManager, $this->uploaderHelper);
    }

    public function testImageCacheSubscriber()
    {
        $this->assertIsArray($this->subscriber->getSubscribedEvents());
        $this->assertCount(2, $this->subscriber->getSubscribedEvents());
    }

    public function testPreRemoveWithEntityThatIsNotProperty()
    {
        $objectManager = $this->getMockBuilder(ObjectManager::class)
            ->getMock();
        $event = new LifecycleEventArgs(new Entity(), $objectManager);
        $this->assertNull($this->subscriber->preRemove($event));
    }

    public function testPreUpdateWithEntityThatIsNotProperty()
    {
        $em = $this->getMockBuilder(EntityManagerInterface::class)
            ->getMock();
        $changeSet = [];
        $event = new PreUpdateEventArgs(new Entity(), $em, $changeSet);
        $this->assertNull($this->subscriber->preUpdate($event));
    }

    public function testPreRemoveWithEntityThatIsProperty()
    {
        $property = $this->getPropertyEntity();
        $this->uploaderHelper->expects($this->once())
            ->method('asset')
            ->with($property, 'imageFile');
        $this->cacheManager->expects($this->once())
            ->method('remove');

        $objectManager = $this->getMockBuilder(ObjectManager::class)
            ->getMock();
        $event = new LifecycleEventArgs($property, $objectManager);
        $this->subscriber->preRemove($event);
    }

    public function testPreUpdateWithEntityThatIsProperty()
    {
        $property = $this->getPropertyEntity();
        $this->uploaderHelper->expects($this->once())
            ->method('asset')
            ->with($property, 'imageFile');
        $this->cacheManager->expects($this->once())
            ->method('remove');

        $em = $this->getMockBuilder(EntityManagerInterface::class)
            ->getMock();
        $changeSet = [];
        $event = new PreUpdateEventArgs($property, $em, $changeSet);
        $this->subscriber->preUpdate($event);
    }

    private function getPropertyEntity()
    {
        return (new Property())->setImageFile(
            new UploadedFile(
                dirname(__DIR__) .'/../public/images/properties/noImage.jpg',
                'noImage',
                'image/jpeg',
                null,
                true
            )
        );
    }
}
