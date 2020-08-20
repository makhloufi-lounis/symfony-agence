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

use App\DataFixtures\RegulationFixtures;
use App\DataFixtures\UserFixtures;
use App\Repository\UserRepository;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRepositoryTest extends KernelTestCase
{

    use FixturesTrait;

    public function testCount() {
        self::bootKernel();
        $this->loadFixtures([RegulationFixtures::class, UserFixtures::class]);
        $users = self::$container->get(UserRepository::class)->count([]);
        $this->assertEquals(1, $users);
    }
}
