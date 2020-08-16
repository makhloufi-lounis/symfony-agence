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


use App\Entity\Regulation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class RegulationFixtures extends Fixture
{

    public const REGULATION_REFERENCE = 'regulation-ref';

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $regulation = new Regulation();

        $regulation->setType(Regulation::REGULATION_TYPE_CGU);
        $regulation->setText(Regulation::REGULATION_TYPE_TEXT);
        $regulation->setStatus(Regulation::REGULATION_STATUS_ENABLE);
        $regulation->setCreatedAt(new \DateTime('now'));
        $manager->persist($regulation);
        $manager->flush();
        $this->addReference(self::REGULATION_REFERENCE, $regulation);
    }
}