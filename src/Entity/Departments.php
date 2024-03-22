<?php

namespace App\Entity;

use App\Repository\DepartmentsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DepartmentsRepository::class)]
class Departments
{
    #[ORM\ManyToOne(inversedBy: 'departments')]
    #[ORM\JoinColumn(name:"region_code", referencedColumnName:"code")]
    private ?Regions $region_code = null;

    #[ORM\Id]
    #[ORM\GeneratedValue('NONE')]
    #[ORM\Column(length: 3, nullable: false)]
    private ?string $code = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $slug = null;

    #[ORM\OneToMany(targetEntity: Cities::class, mappedBy: 'department_code')]
    private Collection $cities;

    public function __construct()
    {
        $this->cities = new ArrayCollection();
    }

    public function getRegionCode(): ?Regions
    {
        return $this->region_code;
    }

    public function setRegionCode(?Regions $region_code): static
    {
        $this->region_code = $region_code;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection<int, Cities>
     */
    public function getCities(): Collection
    {
        return $this->cities;
    }

    public function addCity(Cities $city): static
    {
        if (!$this->cities->contains($city)) {
            $this->cities->add($city);
            $city->setDepartmentCode($this);
        }

        return $this;
    }

    public function removeCity(Cities $city): static
    {
        if ($this->cities->removeElement($city)) {
            // set the owning side to null (unless already changed)
            if ($city->getDepartmentCode() === $this) {
                $city->setDepartmentCode(null);
            }
        }

        return $this;
    }
}
