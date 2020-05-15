<?php


namespace App\DataFixtures;


use App\Entity\Property;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PropertyFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $cpt = 0;
        do {
            $property = new Property();
            $property->setTitle($faker->sentence(10));
            $property->setDescription($faker->sentence(100));
            $property->setArea($faker->numberBetween(20, 100));
            $property->setRooms($faker->numberBetween(1, 5));
            $property->setBedrooms($faker->numberBetween(1,4));
            $property->setFloor($faker->numberBetween(1, 20));
            $property->setPrice($faker->numberBetween(50000, 500000));
            $property->setHeat(array_rand(Property::HEAT));
            $property->setCity($faker->city);
            $property->setAddress($faker->address);
            $property->setPostalCode($faker->postcode);
            $property->setSold($cpt % 3 == 0 ? true : false);
            $property->setStatus(Property::STATUS_REQUEST_PUBLICATION);
            $manager->persist($property);
            $cpt++;
        }while($cpt <= 10);

        $manager->flush();
    }
}