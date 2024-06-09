<?php

namespace App\Entity;

use App\Repository\RatingsWebsiteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: RatingsWebsiteRepository::class)]
class RatingsWebsite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups("main")]
    private ?int $rating = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups("main")]
    private ?string $comment = null;

    #[ORM\OneToOne(inversedBy: 'ratingsWebsite', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups("main")]
    private ?Users $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

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

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(Users $user): static
    {
        $this->user = $user;

        return $this;
    }
}
