<?php

namespace App\Entity;

use App\Repository\AgendaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AgendaRepository::class)]
class Agenda
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $start_date = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $end_date = null;

    #[ORM\ManyToOne(inversedBy: 'AgendaUser1')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $fk_user_1 = null;

    #[ORM\ManyToOne(inversedBy: 'AgendaUser2')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $fk_user_2 = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTimeInterface $start_date): static
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTimeInterface $end_date): static
    {
        $this->end_date = $end_date;

        return $this;
    }

    public function getFkUser1(): ?User
    {
        return $this->fk_user_1;
    }

    public function setFkUser1(?User $fk_user_1): static
    {
        $this->fk_user_1 = $fk_user_1;

        return $this;
    }

    public function getFkUser2(): ?User
    {
        return $this->fk_user_2;
    }

    public function setFkUser2(?User $fk_user_2): static
    {
        $this->fk_user_2 = $fk_user_2;

        return $this;
    }
}
