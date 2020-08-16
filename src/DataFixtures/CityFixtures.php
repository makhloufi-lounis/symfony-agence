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


namespace App\DataFixtures;


use App\Entity\City;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CityFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i<10; $i++) {
            $city = new City();
            $city->setCapitalName($faker->sentence(1));
            $city->setCityName($faker->city);
            $city->setPostalCode($faker->postcode);
            $city->setAreaCode($faker->numberBetween(1, 48));
            $city->setInseeCode($faker->numberBetween(100, 1000));
            $city->setAttitude($faker->latitude);
            $city->setLongitude($faker->longitude);
            $city->setNumberInhabitants($faker->numberBetween(200, 5000));

            $manager->persist($city);
        }

        $manager->flush();
    }
}