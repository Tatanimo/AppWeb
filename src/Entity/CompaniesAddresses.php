<?php

namespace App\Entity;

use App\Repository\CompaniesAddressesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompaniesAddressesRepository::class)]
class CompaniesAddresses
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\ManyToOne(inversedBy: 'companiesAddresses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Companies $companies = null;

    #[ORM\ManyToOne(inversedBy: 'companiesAddresses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cities $cities = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getCompanies(): ?Companies
    {
        return $this->companies;
    }

    public function setCompanies(?Companies $companies): static
    {
        $this->companies = $companies;

        return $this;
    }

    public function getCities(): ?Cities
    {
        return $this->cities;
    }

    public function setCities(?Cities $cities): static
    {
        $this->cities = $cities;

        return $this;
    }
}
