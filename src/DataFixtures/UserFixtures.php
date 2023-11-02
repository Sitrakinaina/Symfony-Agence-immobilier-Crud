<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{

    private  $passwordHasher;
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }


    public function load(ObjectManager $manager): void
    {

        $user = new User();
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            'demo2'
        );


        $user->setUsername('demo2')
            ->setPassword($hashedPassword);

        $manager->persist($user);
        $manager->flush();
    }
}
