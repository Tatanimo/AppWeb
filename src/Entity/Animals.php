<?php

namespace App\Entity;

use App\Repository\AnimalsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AnimalsRepository::class)]
class Animals
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("main")]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Groups("main")]
    private ?string $name = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Groups("main")]
    private ?string $race = null;

    #[ORM\Column(nullable: true)]
    #[Groups("main")]
    private ?float $weight = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Groups("main")]
    private ?\DateTimeInterface $birthdate = null;

    #[ORM\Column(nullable: true)]
    #[Groups("main")]
    private ?bool $death = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups("main")]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'animals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CategoryAnimals $fk_category = null;

    #[Groups("main")]
    private ?int $fk_categoryId = null;

    #[ORM\ManyToOne(inversedBy: 'animals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $fk_user = null;

    #[ORM\OneToMany(targetEntity: Schedules::class, mappedBy: 'animals')]
    private Collection $schedules;

    #[Groups("main")]
    private array $images = [];

    public function __construct()
    {
        $this->schedules = new ArrayCollection();
    }

    public function getImages(): array 
    {
        return $this->images;
    }

    public function setImages($value): static 
    {
        $this->images = $value;
        return $this;
    }

    public function getFkCategoryId(): ?int
    {
        return $this->fk_category->getId();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getRace(): ?string
    {
        return $this->race;
    }

    public function setRace(?string $race): static
    {
        $this->race = $race;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(?float $weight): static
    {
        $this->weight = $weight;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(?\DateTimeInterface $birthdate): static
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function isDeath(): ?bool
    {
        return $this->death;
    }

    public function setDeath(?bool $death): static
    {
        $this->death = $death;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getFkCategory(): ?CategoryAnimals
    {
        return $this->fk_category;
    }

    public function setFkCategory(?CategoryAnimals $fk_category): static
    {
        $this->fk_category = $fk_category;

        return $this;
    }

    public function getFkUser(): ?Users
    {
        return $this->fk_user;
    }

    public function setFkUser(?Users $fk_user): static
    {
        $this->fk_user = $fk_user;

        return $this;
    }

    /**
     * @return Collection<int, Schedules>
     */
    public function getSchedules(): Collection
    {
        return $this->schedules;
    }

    public function addSchedule(Schedules $schedule): static
    {
        if (!$this->schedules->contains($schedule)) {
            $this->schedules->add($schedule);
            $schedule->setAnimals($this);
        }

        return $this;
    }

    public function removeSchedule(Schedules $schedule): static
    {
        if ($this->schedules->removeElement($schedule)) {
            // set the owning side to null (unless already changed)
            if ($schedule->getAnimals() === $this) {
                $schedule->setAnimals(null);
            }
        }

        return $this;
    }
}
