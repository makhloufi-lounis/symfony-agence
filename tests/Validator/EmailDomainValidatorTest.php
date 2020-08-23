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

use App\Repository\ConfigRepository;
use App\Validator\EmailDomain;
use App\Validator\EmailDomainValidator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Violation\ConstraintViolationBuilderInterface;

class EmailDomainValidatorTest extends TestCase
{

    public function getValidator(EmailDomain $constraint, $expectedViolation = false, $dbBlockedDomain = []): EmailDomainValidator
    {
        $repository = $this->getMockBuilder(ConfigRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $repository->expects($this->any())
            ->method('getAsArray')
            ->with('blocked_domains')
            ->willReturn($dbBlockedDomain);

        $validator = new EmailDomainValidator($repository);
        $context = $this->getMockBuilder(ExecutionContextInterface::class)
            ->getMock();
        if($expectedViolation) {
            $constraintViolationBuilder = $this->getMockBuilder(ConstraintViolationBuilderInterface::class)
                ->getMock();
            $constraintViolationBuilder->expects($this->once())
                ->method('setParameter')
                ->with('{{ value }}', 'demo@baddomain.fr')
                ->willReturnSelf();
            $context->expects($this->once())
                ->method('buildViolation')
                ->with($constraint->message)
                ->willReturn($constraintViolationBuilder);
        }else{
            $context->expects($this->never())
                ->method('buildViolation')
                ->with($constraint->message);
        }
        $validator->initialize($context);
        return $validator;
    }

    public function testCatchBadDomain()
    {
        $constraint = new EmailDomain([
            'blocked' => ['baddomain.fr', 'testdomain.fr']
        ]);
        $validator = $this->getValidator($constraint, true);
        $validator->validate('demo@baddomain.fr', $constraint);
    }

    public function testAcceptGodDomain()
    {
        $constraint = new EmailDomain([
            'blocked' => ['baddomain.fr', 'testdomain.fr']
        ]);
        $validator = $this->getValidator($constraint, false);
        $validator->validate('demo@goddomain.fr', $constraint);
    }

    public function testBlockedDomainFromDatabase()
    {
        $constraint = new EmailDomain([
            'blocked' => ['baddomain.fr', 'testdomain.fr']
        ]);
        $validator = $this->getValidator($constraint, true, ['baddomain.fr']);
        $validator->validate('demo@baddomain.fr', $constraint);
    }
}
