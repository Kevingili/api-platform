<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker\Factory;

class UserFixtures extends Fixture
{
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $user = new User();
        $user->setEmail("kevin@mail.fr");
        $user->setFirstname("kevin");
        $user->setLastname("gilibert");
        $user->setPassword($this->encoder->encodePassword($user, "password"));
        $manager->persist($user);

        $user2 = new User();
        $user2->setEmail("tarshan@mail.fr");
        $user2->setFirstname("tarshan");
        $user2->setLastname("tarshan");
        $user2->setPassword($this->encoder->encodePassword($user, "password"));
        $manager->persist($user2);

        $manager->flush();
    }
}
