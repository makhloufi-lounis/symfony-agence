<?php
/**
 * API Shop
 *
 * @version   1.0
 * @author    Lounis Makhloufi <makhloufi.lounis@gmail.com>
 * @see       https://github.com/makhloufi-lounis/api-shop for the canonical source repository
 * @copyright Copyright (c) 2020.
 */

namespace App\Tests\Repository;

use App\DataFixtures\OptionFixtures;
use App\DataFixtures\PropertyFixtures;
use App\Entity\Option;
use App\Entity\Property;
use App\Entity\PropertySearch;
use App\Repository\PropertyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PropertyRepositoryTest extends KernelTestCase
{

    use FixturesTrait;

    /**
     * @var PropertyRepository
     */
    private $repository;

    public function setUp()
    {
        self::bootKernel();
        $this->loadFixtures([OptionFixtures::class, PropertyFixtures::class]);
        $this->repository = self::$container->get(PropertyRepository::class);
    }

    public function testCount() {
        $propertyCount = $this->repository->count([]);
        $this->assertEquals(101, $propertyCount);
    }

    public function testFindAllVisibleQuery()
    {
        $option = new Option();
        $collection = new ArrayCollection();
        $collection->add($option);
        $search = new PropertySearch();
        $search->setMaxPrice(10000);
        $search->setMinArea(50);
        $search->setOptions($collection);
        $this->assertInstanceOf(Query::class, $this->repository->findAllVisibleQuery($search));
    }

    public function testFindLatest ()
    {
        $arrayProperty = $this->repository->findLatest();
        $this->assertIsArray($arrayProperty);
        if(count($arrayProperty) > 0) {
            $property = $arrayProperty[0];
            $this->assertInstanceOf(Property::class, $property);
        }
    }
}
