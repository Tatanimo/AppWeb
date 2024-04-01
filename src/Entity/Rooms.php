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
    #[ORM\GeneratedValue('NONE')]
    #[ORM\Column(length:255, nullable:false)]
    private ?string $reference = null;

    #[ORM\OneToMany(targetEntity: Messages::class, mappedBy: 'rooms', orphanRemoval: true)]
    private Collection $fk_messages;

    public function __construct()
    {
        $this->fk_messages = new ArrayCollection();
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): static
    {
        $this->reference = $reference;
        return $this;
    }

    /**
     * @return Collection<int, Messages>
     */
    public function getFkMessage(): Collection
    {
        return $this->fk_messages;
    }

    public function addFkMessage(Messages $fkMessage): static
    {
        if (!$this->fk_messages->contains($fkMessage)) {
            $this->fk_messages->add($fkMessage);
            $fkMessage->setRooms($this);
        }

        return $this;
    }

    public function removeFkMessage(Messages $fkMessage): static
    {
        if ($this->fk_messages->removeElement($fkMessage)) {
            // set the owning side to null (unless already changed)
            if ($fkMessage->getRooms() === $this) {
                $fkMessage->setRooms(null);
            }
        }

        return $this;
    }
}
