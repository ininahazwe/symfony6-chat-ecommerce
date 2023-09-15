<?php

namespace App\DataFixtures;

use App\Entity\Friendship;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class FriendShipFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for($i = 1; $i <= 5; $i++){
            $friendship = new Friendship();
            /**
             * @var User $user
             */
            $user = $this->getReference('user-' . $i);
            $friendship->setRequester($user);
            $friendship->setReceiver($user);
            $manager->persist($friendship);

            $this->addReference("user" . $i, $friendship);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
                UsersFixtures::class,
        ];
    }
}
