<?php

namespace App\Entity;

use App\Repository\ServicesTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServicesTypeRepository::class)]
class ServicesType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30, nullable: false)]
    private ?string $type = null;

    #[ORM\ManyToMany(targetEntity: Companies::class, inversedBy: 'servicesTypes')]
    private Collection $Companies;

    public function __construct()
    {
        $this->Companies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, Companies>
     */
    public function getCompanies(): Collection
    {
        return $this->Companies;
    }

    public function addCompany(Companies $company): static
    {
        if (!$this->Companies->contains($company)) {
            $this->Companies->add($company);
        }

        return $this;
    }

    public function removeCompany(Companies $company): static
    {
        $this->Companies->removeElement($company);

        return $this;
    }
}