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

use App\DataFixtures\CityFixtures;
use App\Repository\CityRepository;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CityRepositoryTest extends KernelTestCase
{


    use FixturesTrait;

    public function testCount() {
        self::bootKernel();
        $this->loadFixtures([CityFixtures::class]);
        $cityCount = self::$container->get(CityRepository::class)->count([]);
        $this->assertEquals(10, $cityCount);
    }
}
