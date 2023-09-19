<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Trait\ResourceId;
use App\Entity\Trait\Timestapable;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use Timestapable;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    /**
     * @var array<string>
     */
    #[ORM\Column]
    private array $roles = ['ROLE_USER'];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = '';

    #[ORM\Column(type: 'boolean')]
    private bool $isVerified = false;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $firstname = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $biographie = null;

    #[ORM\OneToMany(mappedBy: 'requester', targetEntity: Friendship::class)]
    private Collection $friendships;

    #[ORM\OneToMany(mappedBy: 'receiver', targetEntity: Friendship::class)]
    private Collection $receiverFriendships;

    #[ORM\OneToMany(mappedBy: 'sendBy', targetEntity: Message::class)]
    private Collection $messages;

    #[ORM\OneToMany(mappedBy: 'createdBy', targetEntity: Conversation::class)]
    private Collection $conversations;

    #[ORM\ManyToMany(targetEntity: Conversation::class, mappedBy: 'participants')]
    private Collection $conversationsParticipants;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $connexiondAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime('now');
        $this->friendships = new ArrayCollection();
        $this->receiverFriendships = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->conversations = new ArrayCollection();
        $this->conversationsParticipants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getBiographie(): ?string
    {
        return $this->biographie;
    }

    public function setBiographie(string $biographie): static
    {
        $this->biographie = $biographie;

        return $this;
    }

    /**
     * @return Collection<int, Friendship>
     */
    public function getFriendships(): Collection
    {
        return $this->friendships;
    }

    public function addFriendship(Friendship $friendship): static
    {
        if (!$this->friendships->contains($friendship)) {
            $this->friendships->add($friendship);
            $friendship->setRequester($this);
        }

        return $this;
    }

    public function removeFriendship(Friendship $friendship): static
    {
        if ($this->friendships->removeElement($friendship)) {
            // set the owning side to null (unless already changed)
            if ($friendship->getRequester() === $this) {
                $friendship->setRequester(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Friendship>
     */
    public function getReceiverFriendships(): Collection
    {
        return $this->receiverFriendships;
    }

    public function addReceiverFriendship(Friendship $receiverFriendship): static
    {
        if (!$this->receiverFriendships->contains($receiverFriendship)) {
            $this->receiverFriendships->add($receiverFriendship);
            $receiverFriendship->setReceiver($this);
        }

        return $this;
    }

    public function removeReceiverFriendship(Friendship $receiverFriendship): static
    {
        if ($this->receiverFriendships->removeElement($receiverFriendship)) {
            // set the owning side to null (unless already changed)
            if ($receiverFriendship->getReceiver() === $this) {
                $receiverFriendship->setReceiver(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): static
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setSendBy($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): static
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getSendBy() === $this) {
                $message->setSendBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Conversation>
     */
    public function getParticipants(): Collection
    {
        return $this->conversations;
    }

    public function addConversation(Conversation $conversation): static
    {
        if (!$this->conversations->contains($conversation)) {
            $this->conversations->add($conversation);
            $conversation->setCreatedBy($this);
        }

        return $this;
    }

    public function removeConversation(Conversation $conversation): static
    {
        if ($this->conversations->removeElement($conversation)) {
            // set the owning side to null (unless already changed)
            if ($conversation->getCreatedBy() === $this) {
                $conversation->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Conversation>
     */
    public function getConversationsParticipants(): Collection
    {
        return $this->conversationsParticipants;
    }

    public function addConversationsParticipant(Conversation $conversationsParticipant): static
    {
        if (!$this->conversationsParticipants->contains($conversationsParticipant)) {
            $this->conversationsParticipants->add($conversationsParticipant);
            $conversationsParticipant->addParticipant($this);
        }

        return $this;
    }

    public function removeConversationsParticipant(Conversation $conversationsParticipant): static
    {
        if ($this->conversationsParticipants->removeElement($conversationsParticipant)) {
            $conversationsParticipant->removeParticipant($this);
        }

        return $this;
    }

    public function getConnexionAt(): ?\DateTimeInterface
    {
        return $this->connexiondAt;
    }

    public function setConnexionAt(?\DateTimeInterface $connexiondAt): static
    {
        $this->connexiondAt = $connexiondAt;

        return $this;
    }
}
