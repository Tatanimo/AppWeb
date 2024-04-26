<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
#[ORM\Table(name: '`users`')]
class Users implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("main")]
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
    private ?string $address = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $phone_number = null;

    #[ORM\Column(length: 34, nullable: true)]
    private ?string $iban = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(length: 50, nullable: false)]
    private ?string $first_name = null;

    #[ORM\Column(length: 100, nullable: false)]
    private ?string $last_name = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Companies $fk_company = null;

    #[ORM\OneToMany(targetEntity: Posts::class, mappedBy: 'fk_user', orphanRemoval: true)]
    private Collection $posts;

    #[ORM\OneToMany(targetEntity: Commentaries::class, mappedBy: 'fk_user', orphanRemoval: true)]
    private Collection $commentaries;

    #[ORM\OneToMany(targetEntity: Animals::class, mappedBy: 'fk_user', orphanRemoval: true)]
    private Collection $animals;

    #[ORM\OneToMany(targetEntity: Reviews::class, mappedBy: 'fk_user_sender', orphanRemoval: true)]
    private Collection $reviewsSender;

    #[ORM\OneToMany(targetEntity: Reviews::class, mappedBy: 'fk_user_receiver', orphanRemoval: true)]
    private Collection $reviewsReceiver;

    #[ORM\ManyToOne(inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cities $cities = null;

    #[ORM\OneToMany(targetEntity: Messages::class, mappedBy: 'author')]
    private Collection $messages;

    #[ORM\OneToMany(targetEntity: Schedules::class, mappedBy: 'users')]
    private Collection $schedules;

    #[ORM\OneToMany(targetEntity: Articles::class, mappedBy: 'users')]
    private Collection $articles;

    #[ORM\OneToMany(targetEntity: Reactions::class, mappedBy: 'users', orphanRemoval: true)]
    private Collection $reactions;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $created_date = null;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
        $this->commentaries = new ArrayCollection();
        $this->animals = new ArrayCollection();
        $this->reviewsSender = new ArrayCollection();
        $this->reviewsReceiver = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->schedules = new ArrayCollection();
        $this->articles = new ArrayCollection();
        $this->reactions = new ArrayCollection();
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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(?string $phone_number): static
    {
        $phone_number = str_replace(' ', '', $phone_number);
        $this->phone_number = $phone_number;

        return $this;
    }

    public function getIban(): ?string
    {
        return $this->iban;
    }

    public function setIban(?string $iban): static
    {
        $this->iban = $iban;

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

    public function getFkCompany(): ?Companies
    {
        return $this->fk_company;
    }

    public function setFkCompany(?Companies $fk_company): static
    {
        $this->fk_company = $fk_company;

        return $this;
    }

    /**
     * @return Collection<int, Posts>
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPosts(Posts $posts): static
    {
        if (!$this->posts->contains($posts)) {
            $this->posts->add($posts);
            $posts->setFkUser($this);
        }

        return $this;
    }

    public function removePosts(Posts $posts): static
    {
        if ($this->posts->removeElement($posts)) {
            // set the owning side to null (unless already changed)
            if ($posts->getFkUser() === $this) {
                $posts->setFkUser(null);
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

    public function addCommentary(Commentaries $commentaries): static
    {
        if (!$this->commentaries->contains($commentaries)) {
            $this->commentaries->add($commentaries);
            $commentaries->setFkUser($this);
        }

        return $this;
    }

    public function removeCommentary(Commentaries $commentaries): static
    {
        if ($this->commentaries->removeElement($commentaries)) {
            // set the owning side to null (unless already changed)
            if ($commentaries->getFkUser() === $this) {
                $commentaries->setFkUser(null);
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
    public function getReviewsSender(): Collection
    {
        return $this->reviewsSender;
    }

    public function addReviewsSender(Reviews $reviews): static
    {
        if (!$this->reviewsSender->contains($reviews)) {
            $this->reviewsSender->add($reviews);
            $reviews->setFkUserSender($this);
        }

        return $this;
    }

    public function removeReviewsSender(Reviews $reviews): static
    {
        if ($this->reviewsSender->removeElement($reviews)) {
            // set the owning side to null (unless already changed)
            if ($reviews->getFkUserSender() === $this) {
                $reviews->setFkUserSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AvisUser>
     */
    public function getReviewsReceiver(): Collection
    {
        return $this->reviewsReceiver;
    }

    public function addReviewsReceiver(Reviews $reviews): static
    {
        if (!$this->reviewsReceiver->contains($reviews)) {
            $this->reviewsReceiver->add($reviews);
            $reviews->setFkUserReceiver($this);
        }

        return $this;
    }

    public function removeReviewsReceiver(Reviews $reviews): static
    {
        if ($this->reviewsReceiver->removeElement($reviews)) {
            // set the owning side to null (unless already changed)
            if ($reviews->getFkUserReceiver() === $this) {
                $reviews->setFkUserReceiver(null);
            }
        }

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

    /**
     * @return Collection<int, Messages>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Messages $message): static
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setAuthor($this);
        }

        return $this;
    }

    public function removeMessage(Messages $message): static
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getAuthor() === $this) {
                $message->setAuthor(null);
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
            $schedule->setUsers($this);
        }

        return $this;
    }

    public function removeSchedule(Schedules $schedule): static
    {
        if ($this->schedules->removeElement($schedule)) {
            // set the owning side to null (unless already changed)
            if ($schedule->getUsers() === $this) {
                $schedule->setUsers(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Articles>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Articles $article): static
    {
        if (!$this->articles->contains($article)) {
            $this->articles->add($article);
            $article->setUsers($this);
        }

        return $this;
    }

    public function removeArticle(Articles $article): static
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getUsers() === $this) {
                $article->setUsers(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reactions>
     */
    public function getReactions(): Collection
    {
        return $this->reactions;
    }

    public function addReaction(Reactions $reaction): static
    {
        if (!$this->reactions->contains($reaction)) {
            $this->reactions->add($reaction);
            $reaction->setUsers($this);
        }

        return $this;
    }

    public function removeReaction(Reactions $reaction): static
    {
        if ($this->reactions->removeElement($reaction)) {
            // set the owning side to null (unless already changed)
            if ($reaction->getUsers() === $this) {
                $reaction->setUsers(null);
            }
        }

        return $this;
    }

    public function getCreatedDate(): ?\DateTimeInterface
    {
        return $this->created_date;
    }

    public function setCreatedDate(\DateTimeInterface $created_date): static
    {
        $this->created_date = $created_date;

        return $this;
    }
}