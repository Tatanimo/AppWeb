<?php

namespace App\Entity;

use App\Repository\CitiesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CitiesRepository::class)]
class Cities
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("main")]
    private ?int $id = null;

    #[Groups("main")]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Groups("main")]
    #[ORM\Column(length: 5)]
    private ?string $zip_code = null;

    #[ORM\ManyToMany(targetEntity: Companies::class, inversedBy: 'cities')]
    private Collection $companies;

    #[ORM\OneToMany(targetEntity: Users::class, mappedBy: 'cities')]
    private Collection $users;

    #[ORM\ManyToOne(inversedBy: 'cities')]
    #[ORM\JoinColumn(name:"department_code", referencedColumnName:"code")]
    private ?Departments $department_code = null;

    #[Groups("main")]
    #[ORM\Column(length: 5, nullable: true)]
    private ?string $insee_code = null;

    #[Groups("main")]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $slug = null;

    public function __construct()
    {
        $this->companies = new ArrayCollection();
        $this->users = new ArrayCollection();
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

    public function getZipCode(): ?string
    {
        return $this->zip_code;
    }

    public function setZipCode(string $zip_code): static
    {
        $this->zip_code = $zip_code;

        return $this;
    }

    /**
     * @return Collection<int, Company>
     */
    public function getCompanies(): Collection
    {
        return $this->companies;
    }

    public function addCompany(Companies $company): static
    {
        if (!$this->companies->contains($company)) {
            $this->companies->add($company);
        }

        return $this;
    }

    public function removeCompany(Companies $company): static
    {
        $this->companies->removeElement($company);

        return $this;
    }

    public function getDepartmentCode(): ?Departments
    {
        return $this->department_code;
    }

    public function setDepartmentCode(?Departments $department_code): static
    {
        $this->department_code = $department_code;

        return $this;
    }

    public function getInseeCode(): ?string
    {
        return $this->insee_code;
    }

    public function setInseeCode(?string $insee_code): static
    {
        $this->insee_code = $insee_code;

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

}
