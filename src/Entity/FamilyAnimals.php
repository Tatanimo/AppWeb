<?php

namespace App\Entity;

use App\Repository\FamilyAnimalsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FamilyAnimalsRepository::class)]
class FamilyAnimals
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $image = null;

    #[ORM\OneToMany(targetEntity: CategoryAnimals::class, mappedBy: 'fk_family')]
    private Collection $categoryAnimals;

    public function __construct()
    {
        $this->categoryAnimals = new ArrayCollection();
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
     * @return Collection<int, CategoryAnimals>
     */
    public function getCategoryAnimals(): Collection
    {
        return $this->categoryAnimals;
    }

    public function addCategoryAnimal(CategoryAnimals $categoryAnimal): static
    {
        if (!$this->categoryAnimals->contains($categoryAnimal)) {
            $this->categoryAnimals->add($categoryAnimal);
            $categoryAnimal->setFkFamily($this);
        }

        return $this;
    }

    public function removeCategoryAnimal(CategoryAnimals $categoryAnimal): static
    {
        if ($this->categoryAnimals->removeElement($categoryAnimal)) {
            // set the owning side to null (unless already changed)
            if ($categoryAnimal->getFkFamily() === $this) {
                $categoryAnimal->setFkFamily(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
