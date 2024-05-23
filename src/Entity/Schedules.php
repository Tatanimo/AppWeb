<?php

namespace App\Entity;

use App\Repository\SchedulesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: SchedulesRepository::class)]
class Schedules
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("main")]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups("main")]
    private ?\DateTimeInterface $unavailability = null;

    #[ORM\ManyToOne(inversedBy: 'schedules')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Professionals $professional = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUnavailability(): ?\DateTimeInterface
    {
        return $this->unavailability;
    }

    public function setUnavailability(\DateTimeInterface $unavailability): static
    {
        $this->unavailability = $unavailability;

        return $this;
    }

    public function getProfessional(): ?Professionals
    {
        return $this->professional;
    }

    public function setProfessional(?Professionals $professional): static
    {
        $this->professional = $professional;

        return $this;
    }
}
