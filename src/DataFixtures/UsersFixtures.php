<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UsersFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {

    }

    public function load(ObjectManager $manager): void
    {
        for($i = 1; $i <= 40; $i++){
            $user = new User();
            $user->setUsername("user$i");
            $user->setFirstname("user$i");
            $user->setLastname("user$i");
            $user->setPassword($this->passwordHasher->hashPassword($user, 'password'));
            $user->setEmail("user$i@gmail.com");
            $user->setRoles(['ROLE_USER']);
            $user->setBiographie("Bio$i");
            $user->setConnexionAt(new \DateTime());
            $manager->persist($user);

            $this->addReference("user-" . $i, $user);
        }
        $manager->flush();
    }
}
