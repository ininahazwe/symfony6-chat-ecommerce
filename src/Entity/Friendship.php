<?php

namespace App\Entity;

use App\Repository\FriendshipRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Trait\ResourceId;
use App\Entity\Trait\Timestapable;

#[ORM\Entity(repositoryClass: FriendshipRepository::class)]
class Friendship
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_ACCEPTED = 'accepted';
    public const STATUS_REFUSED = 'refused';
    public const STATUS_BLOCKED = 'blocked';

    use Timestapable;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, type: 'string')]
    private string $status;

    #[ORM\ManyToOne(inversedBy: 'friendships')]
    private ?User $requester = null;

    #[ORM\ManyToOne(inversedBy: 'receiverFriendships')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $receiver = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $friendAt = null;

    public function __construct() {
        $this->status = self::STATUS_PENDING;
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getRequester(): ?User
    {
        return $this->requester;
    }

    public function setRequester(?User $requester): static
    {
        $this->requester = $requester;

        return $this;
    }

    public function getReceiver(): ?User
    {
        return $this->receiver;
    }

    public function setReceiver(?User $receiver): static
    {
        $this->receiver = $receiver;

        return $this;
    }

    public function getFriendAt(): ?\DateTimeInterface
    {
        return $this->friendAt;
    }

    public function setFriendAt(?\DateTimeInterface $friendAt): static
    {
        $this->friendAt = $friendAt;

        return $this;
    }
}
