<?php

namespace App\DataFixtures;

use App\Entity\Conversation;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ConversationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for($i = 1; $i <= 5; $i++){
            $conversation = new Conversation();
            $conversation->setTitle('Conversation' . $i);
            /**
             * @var User $user
             */
            $user = $this->getReference('user-' . $i);
            $conversation->setCreatedBy($user);
            $conversation->addParticipant($user);
            $conversation->addParticipant($user);
            $manager->persist($conversation);

            $this->addReference("conversation" . $i, $conversation);
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
