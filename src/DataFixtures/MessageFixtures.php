<?php

namespace App\DataFixtures;

use App\Entity\Conversation;
use App\Entity\Message;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MessageFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for($i = 1; $i <= 5; $i++){
            $message = new Message();
            /**
             * @var User $user
             */
            $user = $this->getReference('user-' . $i);
            /**
             * @var Conversation $conversation
             */
            $conversation = $this->getReference('conversation-' . $i);
            $message->setSendBy($user);
            $message->setSendAt(new \DateTime());
            $message->setIsRead(true);
            $message->setConversation($conversation);
            $message->setContent('Hello user' . ($i + 5) . 'this is user' . $i);
            $manager->persist($message);
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
