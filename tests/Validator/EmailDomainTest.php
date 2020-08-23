<?php
/**
 * API Shop
 *
 * @version   1.0
 * @author    Lounis Makhloufi <makhloufi.lounis@gmail.com>
 * @see       https://github.com/makhloufi-lounis/api-shop for the canonical source repository
 * @copyright Copyright (c) 2020.
 */

namespace App\Tests\Validator;

use App\Validator\EmailDomain;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;
use Symfony\Component\Validator\Exception\MissingOptionsException;

class EmailDomainTest extends TestCase
{

    /**
     * Le test return false si la function getRequiredOptions n'est pas implémenter
     * Si aucun option n'est indiqué le test leve une exception de type MissingOptionsException
     */
    public function testRequiredOptions()
    {
        $this->expectException(MissingOptionsException::class);
        new EmailDomain();
    }

    /**
     * Ce test permet de vérifier que l'option blocked est un tableau
     */
    public function testBadShapedBlockedOptions()
    {
        $this->expectException(ConstraintDefinitionException::class);
        new EmailDomain(['blocked' => 'test']);
    }

    /**
     * Ce test permet de vérifier que la propriété blocked sera modifier
     * a l'instanciation avec blocked
     */
    public function testOptionIsSetAsProperty()
    {
        $arr = ['a', 'b'];
        $domain = new EmailDomain(['blocked' => $arr]);
        $this->assertEquals($domain->blocked, $arr);
    }
}
