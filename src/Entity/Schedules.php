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
    private ?\DateTimeInterface $unavailabilityStart = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups("main")]
    private ?\DateTimeInterface $unavailabilityEnd = null;

    #[ORM\ManyToOne(inversedBy: 'schedules')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Professionals $professional = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUnavailabilityStart(): ?\DateTimeInterface
    {
        return $this->unavailabilityStart;
    }

    public function setUnavailabilityStart(\DateTimeInterface $unavailabilityStart): static
    {
        $this->unavailabilityStart = $unavailabilityStart;

        return $this;
    }

    public function getUnavailabilityEnd(): ?\DateTimeInterface
    {
        return $this->unavailabilityEnd;
    }

    public function setUnavailabilityEnd(\DateTimeInterface $unavailabilityEnd): static
    {
        $this->unavailabilityEnd = $unavailabilityEnd;

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
