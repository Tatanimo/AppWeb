<?php

namespace App\Entity;

use App\Repository\CategoryAnimalsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CategoryAnimalsRepository::class)]
class CategoryAnimals
{
    #[Groups("main")]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups("main")]
    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[Groups("main")]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[Groups("main")]
    #[ORM\Column(length: 50, nullable: true)]
    private ?string $image = null;

    #[ORM\OneToMany(targetEntity: Animals::class, mappedBy: 'fk_category')]
    private Collection $animals;

    #[ORM\ManyToOne(inversedBy: 'categoryAnimals')]
    #[ORM\JoinColumn(nullable: true)]
    private ?FamilyAnimals $fk_family = null;

    /**
     * @var Collection<int, Professionals>
     */
    #[ORM\ManyToMany(targetEntity: Professionals::class, mappedBy: 'allowed_categories')]
    private Collection $professionals;

    public function __construct()
    {
        $this->animals = new ArrayCollection();
        $this->professionals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, Animals>
     */
    public function getAnimals(): Collection
    {
        return $this->animals;
    }

    public function addAnimal(Animals $animal): static
    {
        if (!$this->animals->contains($animal)) {
            $this->animals->add($animal);
            $animal->setFkCategory($this);
        }

        return $this;
    }

    public function removeAnimal(Animals $animal): static
    {
        if ($this->animals->removeElement($animal)) {
            // set the owning side to null (unless already changed)
            if ($animal->getFkCategory() === $this) {
                $animal->setFkCategory(null);
            }
        }

        return $this;
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

    public function getFkFamily(): ?FamilyAnimals
    {
        return $this->fk_family;
    }

    public function setFkFamily(?FamilyAnimals $fk_family): static
    {
        $this->fk_family = $fk_family;

        return $this;
    }

    /**
     * @return Collection<int, Professionals>
     */
    public function getProfessionals(): Collection
    {
        return $this->professionals;
    }

    public function addProfessional(Professionals $professional): static
    {
        if (!$this->professionals->contains($professional)) {
            $this->professionals->add($professional);
            $professional->addAllowedCategory($this);
        }

        return $this;
    }

    public function removeProfessional(Professionals $professional): static
    {
        if ($this->professionals->removeElement($professional)) {
            $professional->removeAllowedCategory($this);
        }

        return $this;
    }
}