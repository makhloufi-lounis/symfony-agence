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
use App\Repository\AdminOptionRepository;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AdminOptionRepositoryTest extends KernelTestCase
{

    use FixturesTrait;

    public function testCount() {
        self::bootKernel();
        $this->loadFixtures([OptionFixtures::class]);
        $option = self::$container->get(AdminOptionRepository::class)->count([]);
        $this->assertEquals(3, $option);
    }
}
