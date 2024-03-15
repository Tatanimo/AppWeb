<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $birthdate = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $adress = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $postal_code = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $city = null;

    #[ORM\Column(length: 15, nullable: true)]
    private ?string $phone_number = null;

    #[ORM\Column(length: 34, nullable: true)]
    private ?string $IBAN = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(length: 50, nullable: false)]
    private ?string $first_name = null;

    #[ORM\Column(length: 100, nullable: false)]
    private ?string $last_name = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Company $fk_company = null;

    #[ORM\OneToMany(targetEntity: Publication::class, mappedBy: 'fk_user', orphanRemoval: true)]
    private Collection $publications;

    #[ORM\OneToMany(targetEntity: Commentary::class, mappedBy: 'fk_user', orphanRemoval: true)]
    private Collection $commentaries;

    #[ORM\OneToMany(targetEntity: Animals::class, mappedBy: 'fk_user', orphanRemoval: true)]
    private Collection $animals;

    #[ORM\OneToMany(targetEntity: AvisUser::class, mappedBy: 'fk_user_sender', orphanRemoval: true)]
    private Collection $avisUsers;

    #[ORM\OneToMany(targetEntity: AvisUser::class, mappedBy: 'fk_user_receiver', orphanRemoval: true)]
    private Collection $avisUsersReceiver;

    #[ORM\OneToMany(targetEntity: Agenda::class, mappedBy: 'fk_user_1', orphanRemoval: true)]
    private Collection $AgendaUser1;

    #[ORM\OneToMany(targetEntity: Agenda::class, mappedBy: 'fk_user_2', orphanRemoval: true)]
    private Collection $AgendaUser2;

    #[ORM\OneToMany(targetEntity: Rooms::class, mappedBy: 'fk_user1')]
    private Collection $roomsUser1;

    #[ORM\OneToMany(targetEntity: Rooms::class, mappedBy: 'fk_user2')]
    private Collection $roomsUser2;

    public function __construct()
    {
        $this->publications = new ArrayCollection();
        $this->commentaries = new ArrayCollection();
        $this->animals = new ArrayCollection();
        $this->avisUsers = new ArrayCollection();
        $this->avisUsersReceiver = new ArrayCollection();
        $this->AgendaUser1 = new ArrayCollection();
        $this->AgendaUser2 = new ArrayCollection();
        $this->roomsUser1 = new ArrayCollection();
        $this->roomsUser2 = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeInterface $birthdate): static
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(?string $adress): static
    {
        $this->adress = $adress;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postal_code;
    }

    public function setPostalCode(?string $postal_code): static
    {
        $this->postal_code = $postal_code;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(?string $phone_number): static
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    public function getIBAN(): ?string
    {
        return $this->IBAN;
    }

    public function setIBAN(?string $IBAN): static
    {
        $this->IBAN = $IBAN;

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

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(?string $first_name): static
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(?string $last_name): static
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getFkCompany(): ?Company
    {
        return $this->fk_company;
    }

    public function setFkCompany(?Company $fk_company): static
    {
        $this->fk_company = $fk_company;

        return $this;
    }

    /**
     * @return Collection<int, Publication>
     */
    public function getPublications(): Collection
    {
        return $this->publications;
    }

    public function addPublication(Publication $publication): static
    {
        if (!$this->publications->contains($publication)) {
            $this->publications->add($publication);
            $publication->setFkUser($this);
        }

        return $this;
    }

    public function removePublication(Publication $publication): static
    {
        if ($this->publications->removeElement($publication)) {
            // set the owning side to null (unless already changed)
            if ($publication->getFkUser() === $this) {
                $publication->setFkUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Commentary>
     */
    public function getCommentaries(): Collection
    {
        return $this->commentaries;
    }

    public function addCommentary(Commentary $commentary): static
    {
        if (!$this->commentaries->contains($commentary)) {
            $this->commentaries->add($commentary);
            $commentary->setFkUser($this);
        }

        return $this;
    }

    public function removeCommentary(Commentary $commentary): static
    {
        if ($this->commentaries->removeElement($commentary)) {
            // set the owning side to null (unless already changed)
            if ($commentary->getFkUser() === $this) {
                $commentary->setFkUser(null);
            }
        }

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
            $animal->setFkUser($this);
        }

        return $this;
    }

    public function removeAnimal(Animals $animal): static
    {
        if ($this->animals->removeElement($animal)) {
            // set the owning side to null (unless already changed)
            if ($animal->getFkUser() === $this) {
                $animal->setFkUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AvisUser>
     */
    public function getAvisUsers(): Collection
    {
        return $this->avisUsers;
    }

    public function addAvisUser(AvisUser $avisUser): static
    {
        if (!$this->avisUsers->contains($avisUser)) {
            $this->avisUsers->add($avisUser);
            $avisUser->setFkUserSender($this);
        }

        return $this;
    }

    public function removeAvisUser(AvisUser $avisUser): static
    {
        if ($this->avisUsers->removeElement($avisUser)) {
            // set the owning side to null (unless already changed)
            if ($avisUser->getFkUserSender() === $this) {
                $avisUser->setFkUserSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AvisUser>
     */
    public function getAvisUsersReceiver(): Collection
    {
        return $this->avisUsersReceiver;
    }

    public function addAvisUsersReceiver(AvisUser $avisUsersReceiver): static
    {
        if (!$this->avisUsersReceiver->contains($avisUsersReceiver)) {
            $this->avisUsersReceiver->add($avisUsersReceiver);
            $avisUsersReceiver->setFkUserReceiver($this);
        }

        return $this;
    }

    public function removeAvisUsersReceiver(AvisUser $avisUsersReceiver): static
    {
        if ($this->avisUsersReceiver->removeElement($avisUsersReceiver)) {
            // set the owning side to null (unless already changed)
            if ($avisUsersReceiver->getFkUserReceiver() === $this) {
                $avisUsersReceiver->setFkUserReceiver(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Agenda>
     */
    public function getAgendaUser1(): Collection
    {
        return $this->AgendaUser1;
    }

    public function addAgendaUser1(Agenda $agendaUser1): static
    {
        if (!$this->AgendaUser1->contains($agendaUser1)) {
            $this->AgendaUser1->add($agendaUser1);
            $agendaUser1->setFkUser1($this);
        }

        return $this;
    }

    public function removeAgendaUser1(Agenda $agendaUser1): static
    {
        if ($this->AgendaUser1->removeElement($agendaUser1)) {
            // set the owning side to null (unless already changed)
            if ($agendaUser1->getFkUser1() === $this) {
                $agendaUser1->setFkUser1(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Agenda>
     */
    public function getAgendaUser2(): Collection
    {
        return $this->AgendaUser2;
    }

    public function addAgendaUser2(Agenda $agendaUser2): static
    {
        if (!$this->AgendaUser2->contains($agendaUser2)) {
            $this->AgendaUser2->add($agendaUser2);
            $agendaUser2->setFkUser2($this);
        }

        return $this;
    }

    public function removeAgendaUser2(Agenda $agendaUser2): static
    {
        if ($this->AgendaUser2->removeElement($agendaUser2)) {
            // set the owning side to null (unless already changed)
            if ($agendaUser2->getFkUser2() === $this) {
                $agendaUser2->setFkUser2(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Rooms>
     */
    public function getRoomsUser1(): Collection
    {
        return $this->roomsUser1;
    }

    public function addRoomsUser1(Rooms $roomsUser1): static
    {
        if (!$this->roomsUser1->contains($roomsUser1)) {
            $this->roomsUser1->add($roomsUser1);
            $roomsUser1->setFkUser1($this);
        }

        return $this;
    }

    public function removeRoomsUser1(Rooms $roomsUser1): static
    {
        if ($this->roomsUser1->removeElement($roomsUser1)) {
            // set the owning side to null (unless already changed)
            if ($roomsUser1->getFkUser1() === $this) {
                $roomsUser1->setFkUser1(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Rooms>
     */
    public function getRoomsUser2(): Collection
    {
        return $this->roomsUser2;
    }

    public function addRoomsUser2(Rooms $roomsUser2): static
    {
        if (!$this->roomsUser2->contains($roomsUser2)) {
            $this->roomsUser2->add($roomsUser2);
            $roomsUser2->setFkUser2($this);
        }

        return $this;
    }

    public function removeRoomsUser2(Rooms $roomsUser2): static
    {
        if ($this->roomsUser2->removeElement($roomsUser2)) {
            // set the owning side to null (unless already changed)
            if ($roomsUser2->getFkUser2() === $this) {
                $roomsUser2->setFkUser2(null);
            }
        }

        return $this;
    }
}