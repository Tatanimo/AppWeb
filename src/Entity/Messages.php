<?php

namespace App\Entity;

use App\Repository\MessagesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MessagesRepository::class)]
class Messages
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["message", "main"])]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(["message", "main"])]
    private ?string $content = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(["message", "main"])]
    private ?\DateTimeInterface $publication_date = null;

    #[ORM\ManyToOne(inversedBy: 'fk_messages')]
    #[ORM\JoinColumn(nullable: true, referencedColumnName:"reference")]
    private ?Rooms $rooms = null;

    #[ORM\ManyToOne(inversedBy: 'messages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $author = null;

    #[Groups(["message", "main"])]
    private ?int $authorId = null;

    # 3 types : "message", "image", "appointment"
    #[ORM\Column(length: 20)]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups("message")]
    private ?string $type = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getPublicationDate(): ?\DateTimeInterface
    {
        return $this->publication_date;
    }

    public function setPublicationDate(\DateTimeInterface $publication_date): static
    {
        $this->publication_date = $publication_date;

        return $this;
    }

    public function getRooms(): ?Rooms
    {
        return $this->rooms;
    }

    public function setRooms(?Rooms $rooms): static
    {
        $this->rooms = $rooms;

        return $this;
    }

    public function getAuthorId(): ?int
    {
        return $this->author->getId();
    }

    public function getAuthor(): ?Users
    {
        return $this->author;
    }

    public function setAuthor(?Users $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }
}
