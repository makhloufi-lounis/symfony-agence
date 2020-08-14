<?php
/**
 * Teeps API Server
 *
 * @version   1.0
 * @author    Lounis Makhloufi <makhloufi.lounis@gmail.com>
 * @see       https://github.com/makhloufi-lounis/symfony-agence.git for the canonical source repository
 * @copyright Copyright (c) 2020 Agence.
 */

declare(strict_types=1);


namespace Libs\RecaptchaBundle\Constraints;


use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use ReCaptcha\ReCaptcha;

class RecaptchaValidator extends ConstraintValidator
{

    /**
     * @var RequestStack
     */
    private $requestStack;
    /**
     * @var ReCaptcha
     */
    private $reCaptcha;

    /**
     * RecaptchaValidator constructor.
     * @param RequestStack $requestStack
     * @param ReCaptcha $reCaptcha
     */
    public function __construct(RequestStack $requestStack,  ReCaptcha $reCaptcha)
    {
        $this->requestStack = $requestStack;
        $this->reCaptcha = $reCaptcha;
    }

    /**
     * Checks if the passed value is valid
     *
     * @param mixed $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        $request = $this->requestStack->getCurrentRequest();
        $recaptchaResponse = $request->request->get('g-recaptcha-response');
        if(empty($recaptchaResponse)) {
            $this->addViolation($constraint);
        }
        $response = $this->reCaptcha
            ->setExpectedHostname($request->getHost())
            ->verify($recaptchaResponse, $request->getClientIp());
        if(!$response->isSuccess()){
            $this->addViolation($constraint);
        }
    }

    private function addViolation(Constraint $constraint)
    {
        $this->context->addViolation($constraint->message);
        return;
    }
}