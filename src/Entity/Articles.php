<?php

namespace App\Entity;

use App\Repository\ArticlesRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticlesRepository::class)]
class Articles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?DateTimeInterface $publication_date = null;

    #[ORM\Column(nullable: true)]
    private ?bool $state = null;

    /**
     * @var list<string> The keywords
     */
    #[ORM\Column(nullable: true)]
    private ?array $keyword = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?DateTimeInterface $modification_date = null;

    #[ORM\Column(length: 50)]
    private ?string $slug = null;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    private ?Users $users = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getPublicationDate(): ?DateTimeInterface
    {
        return $this->publication_date;
    }

    public function setPublicationDate(?DateTimeInterface $publication_date): static
    {
        $this->publication_date = $publication_date;

        return $this;
    }

    public function isState(): ?bool
    {
        return $this->state;
    }

    public function setState(?bool $state): static
    {
        $this->state = $state;

        return $this;
    }

    public function getKeyword(): ?array
    {
        if ($this->keyword === null) {
            $keyword = [];
        } else {
            $keyword = $this->keyword;
        }

        return array_unique($keyword);
    }

    public function setKeyword(?array $keyword): static
    {
        $this->keyword = $keyword;

        return $this;
    }

    public function getModificationDate(): ?DateTimeInterface
    {
        return $this->modification_date;
    }

    public function setModificationDate(?DateTimeInterface $modification_date): static
    {
        $this->modification_date = $modification_date;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getUsers(): ?Users
    {
        return $this->users;
    }

    public function setUsers(?Users $users): static
    {
        $this->users = $users;

        return $this;
    }
}
