<?php


namespace App\DataFixtures;


use App\Entity\Option;
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
            $property->setTitle($faker->words(4, true))
                ->setDescription($faker->sentence(5, true))
                ->setArea($faker->numberBetween(20, 350))
                ->setRooms($faker->numberBetween(1, 5))
                ->setBedrooms($faker->numberBetween(1,4))
                ->setFloor($faker->numberBetween(1, 20))
                ->setPrice($faker->numberBetween(50000, 500000))
                ->setHeat(array_rand(Property::HEAT))
                ->setCity($faker->city)
                ->setAddress($faker->address)
                ->setPostalCode($faker->postcode)
                ->setSold($cpt % 3 == 0)
                ->setReference(uniqid('ref_'))
                ->setImageName('noImage.jpg')
                ->setStatus(Property::STATUS_REQUEST_PUBLICATION)
                ->addOption($this->getReference(OptionFixtures::OPTION_REFERENCE.'-'.$faker->numberBetween(1,3)));
            $manager->persist($property);
            $cpt++;
        }while($cpt <= 100);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            OptionFixtures::class,
        );
    }
}