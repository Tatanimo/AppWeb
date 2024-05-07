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

    /**
     * @var Collection<int, Professionals>
     */
    #[ORM\OneToMany(targetEntity: Professionals::class, mappedBy: 'service')]
    private Collection $professionals;

    public function __construct()
    {
        $this->Companies = new ArrayCollection();
        $this->professionals = new ArrayCollection();
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
            $professional->setService($this);
        }

        return $this;
    }

    public function removeProfessional(Professionals $professional): static
    {
        if ($this->professionals->removeElement($professional)) {
            // set the owning side to null (unless already changed)
            if ($professional->getService() === $this) {
                $professional->setService(null);
            }
        }

        return $this;
    }
}