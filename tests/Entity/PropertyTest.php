<?php
/**
 * API Shop
 *
 * @version   1.0
 * @author    Lounis Makhloufi <makhloufi.lounis@gmail.com>
 * @see       https://github.com/makhloufi-lounis/api-shop for the canonical source repository
 * @copyright Copyright (c) 2020.
 */

namespace App\Tests\Entity;

use App\Entity\Option;
use App\Entity\Property;
use Cocur\Slugify\Slugify;
use Faker\Factory;
use Faker\Generator;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\ConstraintViolation;

class PropertyTest extends KernelTestCase
{

    use FixturesTrait;


    /**
     * @var object|null
     */
    private $validator;

    /**
     * @var Generator
     */
    private $faker;

    /**
     * @var Property
     */
    private $property;

    public function setUp()
    {
        self::bootKernel();
        $this->validator = self::$container->get('validator');
        $this->faker = Factory::create('fr_FR');
        $this->property = new Property();
    }

    public function testGetId()
    {
        $this->assertNull($this->property->getId());
    }

    /**
     * @covers \App\Entity\Property::getTitle
     * @covers \App\Entity\Property::setTitle
     */
    public function testTileAccessors ()
    {
        $this->assertNull($this->property->getTitle());
        $this->assertInstanceOf(
            Property::class,
            $this->property->setTitle($title = $this->faker->sentence(5))
        );
        $this->assertSame($title, $this->property->getTitle());
        return $this->property;
    }

    /**
     * @param Property $property
     *
     * @depends testTileAccessors
     */
    public function testSlugAccessors(Property $property) {
        $this->assertIsString($property->getSlug());
    }

    /**
     * @depends testTileAccessors
     * @param Property $property
     * @return Property
     */
    public function testDescriptionAccessors (Property $property)
    {
        $this->assertNull($property->getDescription());
        $this->assertInstanceOf(
            Property::class,
            $property->setDescription($description = $this->faker->text())
        );
        $this->assertSame($description, $property->getDescription());
        return $property;
    }

    /**
     * @depends testDescriptionAccessors
     * @param Property $property
     * @return Property
     */
    public function testAreaAccessors (Property $property)
    {
        $this->assertNull($property->getArea());
        $this->assertInstanceOf(
            Property::class,
            $property->setArea($area = $this->faker->numberBetween(10, 100))
        );
        $this->assertSame($area, $property->getArea());
        return $property;
    }

    /**
     * @depends testAreaAccessors
     * @param Property $property
     * @return Property
     */
    public function testRoomsAccessors (Property $property)
    {
        $this->assertNull($property->getRooms());
        $this->assertInstanceOf(
            Property::class,
            $property->setRooms($rooms = $this->faker->numberBetween(0,0))
        );
        $this->assertSame($rooms, $property->getRooms());
        return $property;
    }

    /**
     * @depends testRoomsAccessors
     * @param Property $property
     * @return Property
     */
    public function testBedroomsAccessors (Property $property)
    {
        $this->assertNull($property->getBedrooms());
        $this->assertInstanceOf(
            Property::class,
            $property->setBedrooms($bedrooms = $this->faker->numberBetween(0,0))
        );
        $this->assertSame($bedrooms, $property->getBedrooms());
        return $property;
    }

    /**
     * @depends testBedroomsAccessors
     * @param Property $property
     * @return Property
     */
    public function testFloorAccessors (Property $property)
    {
        $this->assertEquals(0, $property->getFloor());
        $this->assertInstanceOf(
            Property::class,
            $property->setFloor($floor = $this->faker->numberBetween(0,0))
        );
        $this->assertSame($floor, $property->getFloor());
        return $property;
    }

    /**
     * @depends testFloorAccessors
     * @param Property $property
     * @return Property
     */
    public function testPriceAccessors (Property $property)
    {
        $this->assertNull($property->getPrice());
        $this->assertInstanceOf(
            Property::class,
            $property->setPrice($price = $this->faker->numberBetween(0,0))
        );
        $this->assertSame($price, $property->getPrice());
        return $property;
    }

    /**
     * @depends testPriceAccessors
     * @param Property $property
     * @return Property
     */
    public function testHeatAccessors (Property $property)
    {
        $this->assertNull($property->getHeat());
        $this->assertInstanceOf(
            Property::class,
            $property->setHeat($heat = $this->faker->numberBetween(1,0))
        );
        $this->assertSame($heat, $property->getHeat());
        return $property;
    }

    /**
     * @param Property $property
     * @depends testHeatAccessors
     */
    public function testHeatTypeAccessors (Property $property)
    {
        $this->assertSame(Property::HEAT[$property->getHeat()], $property->getHeatType());
    }

    /**
     * @depends testHeatAccessors
     * @param Property $property
     * @return Property
     */
    public function testCityAccessors (Property $property)
    {
        $this->assertNull($property->getCity());
        $this->assertInstanceOf(
            Property::class,
            $property->setCity($city = $this->faker->city)
        );
        $this->assertSame($city, $property->getCity());
        return $property;
    }

    /**
     * @depends testCityAccessors
     * @param Property $property
     * @return Property
     */
    public function testAddressAccessors (Property $property)
    {
        $this->assertNull($property->getAddress());
        $this->assertInstanceOf(
            Property::class,
            $property->setAddress($address = $this->faker->address)
        );
        $this->assertSame($address, $property->getAddress());
        return $property;
    }

    /**
     * @depends testAddressAccessors
     * @param Property $property
     * @return Property
     */
    public function testPostalCodeAccessors (Property $property)
    {
        $this->assertNull($property->getPostalCode());
        $this->assertInstanceOf(
            Property::class,
            $property->setPostalCode($postalCode = str_ireplace(' ', '', $this->faker->postcode))
        );
        $this->assertSame($postalCode, $property->getPostalCode());
        return $property;
    }

    /**
     * @depends testPostalCodeAccessors
     * @param Property $property
     * @return Property
     */
    public function testSoldAccessors (Property $property)
    {
        $this->assertEquals(false, $property->getSold());
        $this->assertInstanceOf(
            Property::class,
            $property->setSold($sold = true)
        );
        $this->assertSame($sold, $property->getSold());
        return $property;
    }

    /**
     * @depends testSoldAccessors
     * @param Property $property
     * @return Property
     */
    public function testStatusAccessors (Property $property)
    {
        $this->assertEquals(Property::STATUS_PUBLIC, $property->getStatus());
        $this->assertInstanceOf(
            Property::class,
            $property->setStatus($status = Property::STATUS_PUBLIC)
        );
        $this->assertSame($status, $property->getStatus());
        return $property;
    }

    /**
     * @param Property $property
     * @depends testStatusAccessors
     */
    public function testCreatedAtAccessors (Property $property)
    {
        $this->assertInstanceOf(\DateTime::class, $property->getCreatedAt());
        $this->assertInstanceOf(
            Property::class,
            $property->setCreatedAt($createdAt = new \DateTime('now'))
        );
        $this->assertSame($createdAt, $property->getCreatedAt());
    }

    /**
     * @param Property $property
     * @depends testStatusAccessors
     */
    public function testUpdatedAtAccessors (Property $property)
    {
        $this->assertNull($property->getUpdatedAt());
        $this->assertInstanceOf(
            Property::class,
            $property->setUpdatedAt($updateAt = new \DateTime('now'))
        );
        $this->assertSame($updateAt, $property->getUpdatedAt());
    }

    /**
     * @param Property $property
     * @depends testStatusAccessors
     */
    public function testReferenceAccessors (Property $property)
    {
        $this->assertNull($property->getReference());
        $this->assertInstanceOf(
            Property::class,
            $property->setReference($ref = "ref_01")
        );
        $this->assertSame($ref, $property->getReference());
        return $property;
    }

    /**
     * @param Property $property
     * @depends testReferenceAccessors
     */
    public function testActivityAccessors (Property $property)
    {
        $this->assertEquals(Property::DEFAULT_ACTIVITY,$property->getActivity());
        $this->assertInstanceOf(
            Property::class,
            $property->setActivity($activity = "test_real_estate")
        );
        $this->assertSame($activity, $property->getActivity());
    }

    /**
     * @param Property $property
     * @depends testReferenceAccessors
     */
    public function testOptionsAccessors (Property $property)
    {
        $option = new Option();
        $this->assertInstanceOf(
            Property::class,
            $property->addOption($option)
        );
        $this->assertIsArray($property->getOptions()->toArray());
        $this->assertSame(false, $property->getOptions()->isEmpty());
        $this->assertInstanceOf(
            Property::class,
            $property->removeOption($option)
        );
        $this->assertSame(true, $property->getOptions()->isEmpty());
    }

    /**
     * @depends testReferenceAccessors
     * @param Property $property
     * @return Property
     */
    public function testImageNameAccessors (Property $property)
    {
        $this->assertNull($property->getImageName());
        $this->assertInstanceOf(
            Property::class,
            $property->setImageName($imageName = 'noImage')
        );
        $this->assertSame($imageName, $property->getImageName());
        return $property;
    }

    /**
     * @depends testImageNameAccessors
     * @param Property $property
     * @return Property
     */
    public function testImageFileAccessors (Property $property)
    {
        $this->assertNull($property->getImageFile());
        $this->assertInstanceOf(
            Property::class,
            $property->setImageFile($imageFile = new UploadedFile(
                self::$container->getParameter('kernel.project_dir') . '/public/images/properties/noImage.jpg',
                'noImage',
                'image/jpeg',
                null,
                true
            ))
        );
        $this->assertSame($imageFile, $property->getImageFile());
        return $property;
    }

    /**
     * @param Property $property
     * @param int $number
     */
    public function assertHasErrors(Property $property, int $number = 0)
    {
        $errors = $this->validator->validate($property);
        $messages = [];
        /** @var ConstraintViolation $error */
        foreach ($errors as $error) {
            $messages[] = $error->getPropertyPath() . ' => '.$error->getMessage();
        }
        $this->assertCount($number, $errors, implode(', ', $messages));
    }


    /**
     * @depends testImageFileAccessors
     * @param Property $property
     */
    public function testValidEntity(Property $property)
    {
        $this->assertHasErrors($property, 0);
    }

    /**
     * @depends testImageFileAccessors
     * @param Property $property
     */
    public function testInvalidPropertyEntity(Property $property)
    {
        $property->setTitle('')
            ->setStatus('invalidStatus')
            ->setPostalCode('invalidPostCode');
        $this->assertHasErrors($property, 3);
    }

    /**
     * @depends testImageFileAccessors
     * @param Property $property
     */
    public function testInvalidBlankProperty(Property $property)
    {
        $property->setPostalCode('');
        $this->assertHasErrors($property, 2);
    }

    /**
     * Un exemple de test qui peut tester L'unicité d'une entity
     */
    public function testInvalideUsePropertyReference()
    {
        $property  = (new Property())
        ->setTitle($this->faker->sentence(5))
        ->setDescription($this->faker->text())
        ->setArea($this->faker->numberBetween(10, 100))
        ->setRooms($this->faker->numberBetween(0, 0))
        ->setBedrooms($this->faker->numberBetween(0, 0))
        ->setFloor($this->faker->numberBetween(0,0))
        ->setPrice($this->faker->numberBetween(0,0))
        ->setHeat($this->faker->numberBetween(1, 10))
        ->setCity($this->faker->city)
        ->setAddress($this->faker->address)
        ->setPostalCode(str_replace(' ', '', $this->faker->postcode))
        ->setSold(true)
        ->setStatus(Property::STATUS_PUBLIC)
        ->setImageName('noImage.jpg')
        ->setImageFile(
            new UploadedFile(
                self::$container->getParameter('kernel.project_dir') . '/public/images/properties/noImage.jpg',
                'noImage',
                'image/jpeg',
                null,
                true
            )
        );
        $property->setReference('ref_5f3eabe369e70');
        $this->loadFixtureFiles([dirname(__DIR__). '/Fixtures/propertyFixture.yml']);
        $this->assertHasErrors($property, 1);
    }
}
