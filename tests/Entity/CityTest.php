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

use App\Entity\City;
use Faker\Factory;
use PHPUnit\Framework\TestCase;

class CityTest extends TestCase
{

    /**
     * @var City
     */
    private $city;

    /**
     * @var \Faker\Generator
     */
    private $faker;

    public function setUp(): void
    {
       $this->city = new City();
       $this->faker = Factory::create('fr_FR');
    }

    public function testGetId()
    {
        $this->assertNull($this->city->getId());
    }

    public function testCapitalNameAccessor()
    {
        $this->assertNull($this->city->getCapitalName());
        $this->assertInstanceOf(
            City::class,
            $this->city->setCapitalName($capitalName = $this->faker->word)
        );
        $this->assertSame($capitalName, $this->city->getCapitalName());
    }

    public function testCityNameAccessor()
    {
        $this->assertNull($this->city->getCityName());
        $this->assertInstanceOf(
            City::class,
            $this->city->setCityName($cityName = $this->faker->city)
        );
        $this->assertSame($cityName, $this->city->getCityName());
    }

    public function testPostalCodeAccessor()
    {
        $this->assertNull($this->city->getPostalCode());
        $this->assertInstanceOf(
            City::class,
            $this->city->setPostalCode($postalCode = $this->faker->postcode)
        );
        $this->assertSame($postalCode, $this->city->getPostalCode());
    }

    public function testAreaCodeAccessor()
    {
        $this->assertNull($this->city->getAreaCode());
        $this->assertInstanceOf(
            City::class,
            $this->city->setAreaCode($areaCode = $this->faker->numberBetween(10, 100))
        );
        $this->assertSame($areaCode, $this->city->getAreaCode());
    }

    public function testInseeCodeAccessor()
    {
        $this->assertNull($this->city->getInseeCode());
        $this->assertInstanceOf(
            City::class,
            $this->city->setInseeCode($inseeCode = $this->faker->numberBetween(100, 1000))
        );
        $this->assertSame($inseeCode, $this->city->getInseeCode());
    }

    public function testAttitudeAccessor()
    {
        $this->assertNull($this->city->getAttitude());
        $this->assertInstanceOf(
            City::class,
            $this->city->setAttitude($attitude = $this->faker->latitude)
        );
        $this->assertSame($attitude, $this->city->getAttitude());
    }

    public function testLongitudeAccessor()
    {
        $this->assertNull($this->city->getLongitude());
        $this->assertInstanceOf(
            City::class,
            $this->city->setLongitude($longitude = $this->faker->longitude)
        );
        $this->assertSame($longitude, $this->city->getLongitude());
    }

    public function testNumberInhabitantsAccessor()
    {
        $this->assertNull($this->city->getNumberInhabitants());
        $this->assertInstanceOf(
            City::class,
            $this->city->setNumberInhabitants($numberInhabitants = $this->faker->numberBetween(100, 2000))
        );
        $this->assertSame($numberInhabitants, $this->city->getNumberInhabitants());
    }
}
