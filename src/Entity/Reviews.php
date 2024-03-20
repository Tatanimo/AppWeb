<?php

namespace App\Entity;

use App\Repository\ReviewsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReviewsRepository::class)]
class Reviews
{
    #[ORM\Column]
    private ?int $rating = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'avisUsers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $fk_user_sender = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'avisUsersReceiver')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $fk_user_receiver = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $comment = null;

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(int $rating): static
    {
        $this->rating = $rating;

        return $this;
    }

    public function getFkUserSender(): ?Users
    {
        return $this->fk_user_sender;
    }

    public function setFkUserSender(?Users $fk_user_sender): static
    {
        $this->fk_user_sender = $fk_user_sender;

        return $this;
    }

    public function getFkUserReceiver(): ?Users
    {
        return $this->fk_user_receiver;
    }

    public function setFkUserReceiver(?Users $fk_user_receiver): static
    {
        $this->fk_user_receiver = $fk_user_receiver;

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
}