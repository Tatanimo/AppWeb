<?php

namespace App\Entity;

use App\Repository\ReviewsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReviewsRepository::class)]
class Reviews
{
    #[ORM\Column]
    private ?int $rating = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $comment = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'reviews')]
    #[ORM\JoinColumn(nullable: false)]
    private ?users $user = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'reviews')]
    #[ORM\JoinColumn(nullable: false)]
    private ?professionals $professional = null;

    #[ORM\Id]
    #[ORM\Column]
    private ?bool $professional_receiver = null;

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(int $rating): static
    {
        $this->rating = $rating;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    public function getUser(): ?users
    {
        return $this->user;
    }

    public function setUser(?users $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getProfessional(): ?professionals
    {
        return $this->professional;
    }

    public function setProfessional(?professionals $professional): static
    {
        $this->professional = $professional;

        return $this;
    }

    public function isProfessionalReceiver(): ?bool
    {
        return $this->professional_receiver;
    }

    public function setProfessionalReceiver(bool $professional_receiver): static
    {
        $this->professional_receiver = $professional_receiver;

        return $this;
    }
}