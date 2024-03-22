<?php

namespace App\Entity;

use App\Repository\CompaniesRepository;
use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompaniesRepository::class)]
class Companies
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 30)]
    private ?string $type = null;

    #[ORM\Column(length: 100)]
    private ?string $adress = null;

    #[ORM\Column(length: 5)]
    private ?string $zip_code = null;

    #[ORM\Column(length: 50)]
    private ?string $city = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $image = null;

    #[ORM\OneToMany(targetEntity: Users::class, mappedBy: 'fk_company')]
    private Collection $users;

    #[ORM\ManyToMany(targetEntity: Cities::class, mappedBy: 'companies')]
    private Collection $cities;

    #[ORM\ManyToMany(targetEntity: ServicesType::class, mappedBy: 'Companies')]
    private Collection $servicesTypes;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->cities = new ArrayCollection();
        $this->servicesTypes = new ArrayCollection();
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): static
    {
        $this->adress = $adress;

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
     * @return Collection<int, Users>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(Users $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setFkCompany($this);
        }

        return $this;
    }

    public function removeUser(Users $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getFkCompany() === $this) {
                $user->setFkCompany(null);
            }
        }

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
            $city->addCompany($this);
        }

        return $this;
    }

    public function removeCity(Cities $city): static
    {
        if ($this->cities->removeElement($city)) {
            $city->removeCompany($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, ServicesType>
     */
    public function getServicesTypes(): Collection
    {
        return $this->servicesTypes;
    }

    public function addServicesType(ServicesType $servicesType): static
    {
        if (!$this->servicesTypes->contains($servicesType)) {
            $this->servicesTypes->add($servicesType);
            $servicesType->addCompany($this);
        }

        return $this;
    }

    public function removeServicesType(ServicesType $servicesType): static
    {
        if ($this->servicesTypes->removeElement($servicesType)) {
            $servicesType->removeCompany($this);
        }

        return $this;
    }
}
