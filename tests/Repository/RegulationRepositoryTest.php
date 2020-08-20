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
use App\Entity\Regulation;
use App\Repository\RegulationRepository;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RegulationRepositoryTest extends KernelTestCase
{

    use FixturesTrait;

    /**
     * @var RegulationRepository
     */
    private $repository;

    /**
     * @var Regulation
     */
    private $regulation;

    public function setUp()
    {
        self::bootKernel();
        $this->loadFixtures([RegulationFixtures::class]);
        $this->repository = self::$container->get(RegulationRepository::class);
        $this->regulation = new Regulation();
    }

    public function testCount()
    {
        $regulationCount = $this->repository->count([]);
        $this->assertEquals(1, $regulationCount);
    }

    public function testFindOneByTypeAndStatus()
    {
        $arrayRegulation = $this->repository->findOneByTypeAndStatus(
            Regulation::REGULATION_TYPE_CGU,
            Regulation::REGULATION_STATUS_ENABLE
        );
        $this->assertIsArray($arrayRegulation);
        $regulation = $arrayRegulation[0];
        $this->assertInstanceOf(Regulation::class, $regulation);
    }
}
