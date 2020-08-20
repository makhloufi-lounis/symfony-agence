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

use App\Entity\Option;
use Faker\Factory;
use PHPUnit\Framework\TestCase;

class OptionTest extends TestCase
{

    /**
     * @var Option
     */
    private $option;

    /**
     * @var \Faker\Generator
     */
    private $faker;

    public function setUp(): void
    {
        $this->option = new Option();
        $this->faker = Factory::create('fr_Fr');
    }

    public function testGetId()
    {
        $this->assertNull($this->option->getId());
    }

    public function testNameAccessor()
    {
        $this->assertNull($this->option->getName());
        $this->assertInstanceOf(
            Option::class,
            $this->option->setName($name = $this->faker->name)
        );
        $this->assertSame($name, $this->option->getName());
    }
}
