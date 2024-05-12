<?php

namespace App\Entity;

use App\Repository\ReviewsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: ReviewsRepository::class)]
class Reviews
{
    #[ORM\Column]
    #[Groups("main")]
    private ?int $rating = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups("main")]
    private ?string $comment = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'reviews')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups("main")]
    private ?users $user = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'reviews')]
    #[ORM\JoinColumn(nullable: false)]
    private ?professionals $professional = null;

    #[ORM\Id]
    #[ORM\Column]
    #[Groups("main")]
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