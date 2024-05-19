<?php

namespace App\Entity;

use App\Repository\ProfessionalsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: ProfessionalsRepository::class)]
class Professionals
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("main")]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups("main")]
    private ?string $LiveIn = null;

    #[ORM\Column]
    #[Groups("main")]
    private ?float $price = null;

    #[ORM\Column(length: 255)]
    #[Groups("main")]
    private ?string $address = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups("main")]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    #[Groups("main")]
    private ?array $criteria = null;

    #[ORM\OneToOne(inversedBy: 'professionals', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups("main")]
    private ?Users $user = null;

    #[ORM\ManyToOne(inversedBy: 'professionals')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups("main")]
    private ?Cities $city = null;

    /**
     * @var Collection<int, Reviews>
     */
    #[ORM\OneToMany(targetEntity: Reviews::class, mappedBy: 'professional')]
    #[Groups("main")]
    private Collection $reviews;

    #[ORM\ManyToOne(inversedBy: 'professionals')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups("main")]
    private ?ServicesType $service = null;

    /**
     * @var Collection<int, Appointments>
     */
    #[ORM\OneToMany(targetEntity: Appointments::class, mappedBy: 'professional')]
    private Collection $appointments;

    /**
     * @var Collection<int, Schedules>
     */
    #[ORM\OneToMany(targetEntity: Schedules::class, mappedBy: 'professional', orphanRemoval: true)]
    private Collection $schedules;

    /**
     * @var Collection<int, CategoryAnimals>
     */
    #[ORM\ManyToMany(targetEntity: CategoryAnimals::class, inversedBy: 'professionals')]
    private Collection $allowed_categories;

    public function __construct()
    {
        $this->reviews = new ArrayCollection();
        $this->appointments = new ArrayCollection();
        $this->schedules = new ArrayCollection();
        $this->allowed_categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLiveIn(): ?string
    {
        return $this->LiveIn;
    }

    public function setLiveIn(string $LiveIn): static
    {
        $this->LiveIn = $LiveIn;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCriteria(): ?array
    {
        return $this->criteria;
    }

    public function setCriteria(?array $criteria): static
    {
        $this->criteria = $criteria;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(Users $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getCity(): ?Cities
    {
        return $this->city;
    }

    public function setCity(?Cities $city): static
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return Collection<int, Reviews>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Reviews $review): static
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews->add($review);
            $review->setProfessional($this);
        }

        return $this;
    }

    public function removeReview(Reviews $review): static
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getProfessional() === $this) {
                $review->setProfessional(null);
            }
        }

        return $this;
    }

    public function getService(): ?ServicesType
    {
        return $this->service;
    }

    public function setService(?ServicesType $service): static
    {
        $this->service = $service;

        return $this;
    }

    /**
     * @return Collection<int, Appointments>
     */
    public function getAppointments(): Collection
    {
        return $this->appointments;
    }

    public function addAppointment(Appointments $appointment): static
    {
        if (!$this->appointments->contains($appointment)) {
            $this->appointments->add($appointment);
            $appointment->setProfessional($this);
        }

        return $this;
    }

    public function removeAppointment(Appointments $appointment): static
    {
        if ($this->appointments->removeElement($appointment)) {
            // set the owning side to null (unless already changed)
            if ($appointment->getProfessional() === $this) {
                $appointment->setProfessional(null);
            }
        }

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
            $schedule->setProfessional($this);
        }

        return $this;
    }

    public function removeSchedule(Schedules $schedule): static
    {
        if ($this->schedules->removeElement($schedule)) {
            // set the owning side to null (unless already changed)
            if ($schedule->getProfessional() === $this) {
                $schedule->setProfessional(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CategoryAnimals>
     */
    public function getAllowedCategories(): Collection
    {
        return $this->allowed_categories;
    }

    public function addAllowedCategory(CategoryAnimals $allowedCategory): static
    {
        if (!$this->allowed_categories->contains($allowedCategory)) {
            $this->allowed_categories->add($allowedCategory);
        }

        return $this;
    }

    public function removeAllowedCategory(CategoryAnimals $allowedCategory): static
    {
        $this->allowed_categories->removeElement($allowedCategory);

        return $this;
    }
}
