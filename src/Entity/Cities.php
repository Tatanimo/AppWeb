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
    #[ORM\Column(nullable: true)]
    private ?int $zip_code = null;

    #[ORM\OneToMany(targetEntity: Users::class, mappedBy: 'cities')]
    private Collection $users;

    #[ORM\ManyToOne(inversedBy: 'cities')]
    #[ORM\JoinColumn(name:"department_code", referencedColumnName:"code")]
    private ?Departments $department_code = null;

    #[Groups("main")]
    #[ORM\Column(nullable: true)]
    private ?float $latitude = null;
    #[Groups("main")]
    #[ORM\Column(nullable: true)]
    private ?float $longitude = null;

    #[Groups("main")]
    #[ORM\Column(nullable: true)]
    private ?int $insee_code = null;

    #[Groups("main")]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $slug = null;

    #[ORM\OneToMany(targetEntity: CompaniesAddresses::class, mappedBy: 'cities', orphanRemoval: true)]
    private Collection $companiesAddresses;

    /**
     * @var Collection<int, Professionals>
     */
    #[ORM\OneToMany(targetEntity: Professionals::class, mappedBy: 'city')]
    private Collection $professionals;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->companiesAddresses = new ArrayCollection();
        $this->professionals = new ArrayCollection();
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

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getZipCode(): ?int
    {
        return $this->zip_code;
    }

    public function setZipCode(int $zip_code): static
    {
        $this->zip_code = $zip_code;

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

    public function getInseeCode(): ?int
    {
        return $this->insee_code;
    }

    public function setInseeCode(?int $insee_code): static
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

    /**
     * @return Collection<int, CompaniesAddresses>
     */
    public function getCompaniesAddresses(): Collection
    {
        return $this->companiesAddresses;
    }

    public function addCompaniesAddress(CompaniesAddresses $companiesAddress): static
    {
        if (!$this->companiesAddresses->contains($companiesAddress)) {
            $this->companiesAddresses->add($companiesAddress);
            $companiesAddress->setCities($this);
        }

        return $this;
    }

    public function removeCompaniesAddress(CompaniesAddresses $companiesAddress): static
    {
        if ($this->companiesAddresses->removeElement($companiesAddress)) {
            // set the owning side to null (unless already changed)
            if ($companiesAddress->getCities() === $this) {
                $companiesAddress->setCities(null);
            }
        }

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
            $professional->setCity($this);
        }

        return $this;
    }

    public function removeProfessional(Professionals $professional): static
    {
        if ($this->professionals->removeElement($professional)) {
            // set the owning side to null (unless already changed)
            if ($professional->getCity() === $this) {
                $professional->setCity(null);
            }
        }

        return $this;
    }

}
