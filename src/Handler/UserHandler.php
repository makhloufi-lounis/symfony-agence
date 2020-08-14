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

namespace App\Handler;

use App\Entity\Regulation;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserHandler
 * @package App\Handler
 */
class UserHandler
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var UserPasswordEncoderInterface;
     */
    private $encoder;

    /**
     * UserHandler constructor.
     * @param EntityManagerInterface $entityManager
     * @param LoggerInterface $logger
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(EntityManagerInterface $entityManager, LoggerInterface $logger, UserPasswordEncoderInterface $encoder)
    {
        $this->entityManager= $entityManager;
        $this->logger = $logger;
        $this->encoder = $encoder;
    }

    /**
     * @param FormInterface $form
     * @param User $user
     * @param Request $request
     * @return bool
     */
    public function Handel(FormInterface $form, User $user, Request $request): bool
    {
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $password = $this->encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            try {
                $this->entityManager->persist($user);
                $regulation = new Regulation();
                $regulation->setType(Regulation::REGULATION_TYPE_CGU);
                $regulation->setText(Regulation::REGULATION_TYPE_TEXT);
                $regulation->setStatus(Regulation::REGULATION_STATUS_ENABLE);
                $regulation->setUser($user);
                $this->entityManager->persist($regulation);
            }catch (ORMException $e){
                $this->logger->error($e->getMessage());
                $form->addError(new FormError("Error lors de l'insertion de l'utilisateur en base"));
                return false;
            }
            $this->entityManager->flush();
            return true;
        }
        return false;
    }
}