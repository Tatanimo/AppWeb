<?php

namespace App\Entity;

use App\Repository\AvisUserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AvisUserRepository::class)]
class AvisUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $note = null;

    #[ORM\ManyToOne(inversedBy: 'avisUsers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $fk_user_sender = null;

    #[ORM\ManyToOne(inversedBy: 'avisUsersReceiver')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $fk_user_receiver = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getFkUserSender(): ?User
    {
        return $this->fk_user_sender;
    }

    public function setFkUserSender(?User $fk_user_sender): static
    {
        $this->fk_user_sender = $fk_user_sender;

        return $this;
    }

    public function getFkUserReceiver(): ?User
    {
        return $this->fk_user_receiver;
    }

    public function setFkUserReceiver(?User $fk_user_receiver): static
    {
        $this->fk_user_receiver = $fk_user_receiver;

        return $this;
    }
}