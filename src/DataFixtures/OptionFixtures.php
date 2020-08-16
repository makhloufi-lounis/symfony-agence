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


use App\Entity\Option;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class OptionFixtures extends Fixture
{

    public const OPTION_REFERENCE = 'option-ref';

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for ($i = 1; $i <= 3; $i++) {
            $option = new Option();
            $option->setName($faker->sentence(1));
            $manager->persist($option);
            $this->addReference(self::OPTION_REFERENCE.'-'.$i, $option);
        }
        $manager->flush();
    }
}