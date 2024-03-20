<?php

namespace App\Entity;

use App\Repository\RoomsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoomsRepository::class)]
class Rooms
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'roomsUser1')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $fk_user1 = null;

    #[ORM\ManyToOne(inversedBy: 'roomsUser2')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $fk_user2 = null;

    #[ORM\OneToMany(targetEntity: Messages::class, mappedBy: 'rooms', orphanRemoval: true)]
    private Collection $fk_message;

    public function __construct()
    {
        $this->fk_message = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFkUser1(): ?Users
    {
        return $this->fk_user1;
    }

    public function setFkUser1(?Users $fk_user1): static
    {
        $this->fk_user1 = $fk_user1;

        return $this;
    }

    public function getFkUser2(): ?Users
    {
        return $this->fk_user2;
    }

    public function setFkUser2(?Users $fk_user2): static
    {
        $this->fk_user2 = $fk_user2;

        return $this;
    }

    /**
     * @return Collection<int, Messages>
     */
    public function getFkMessage(): Collection
    {
        return $this->fk_message;
    }

    public function addFkMessage(Messages $fkMessage): static
    {
        if (!$this->fk_message->contains($fkMessage)) {
            $this->fk_message->add($fkMessage);
            $fkMessage->setRooms($this);
        }

        return $this;
    }

    public function removeFkMessage(Messages $fkMessage): static
    {
        if ($this->fk_message->removeElement($fkMessage)) {
            // set the owning side to null (unless already changed)
            if ($fkMessage->getRooms() === $this) {
                $fkMessage->setRooms(null);
            }
        }

        return $this;
    }
}
