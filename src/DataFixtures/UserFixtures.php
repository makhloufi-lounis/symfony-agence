<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $user = new User();
        $user->setLastName('foo');
        $user->setFirstName('bar');
        $user->setEmail('foo@bar.com');
        $user->setPhone($faker->phoneNumber);
        $user->setUsername('demo');
        $user->setPassword($this->encoder->encodePassword($user,'demo'));
        $user->setStatus('waiting');
        $user->setCivility(User::CIVILITY[array_rand(User::CIVILITY)]);
        $user->setUserType(User::USER_TYPES[array_rand(User::USER_TYPES)]);
        $user->setPostalCode($faker->postcode);
        $manager->persist($user);
        $manager->flush();
    }
}
