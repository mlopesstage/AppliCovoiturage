<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
 * fields={"email"},
 * errorPath="email",
 * message="Cet email existe déjà."
 *)
*/
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Path", mappedBy="driver")
     */
    private $driverPath;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Path", mappedBy="passenger")
     */
    private $passengerPath;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="author")
     */
    private $authorComment;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $theme;

    public function __construct()
    {
        $this->driverPath = new ArrayCollection();
        $this->passengerPath = new ArrayCollection();
        $this->authorComment = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return Collection|Path[]
     */
    public function getDriverPath(): Collection
    {
        return $this->driverPath;
    }

    public function addDriverPath(Path $driverPath): self
    {
        if (!$this->driverPath->contains($driverPath)) {
            $this->driverPath[] = $driverPath;
            $driverPath->setDriver($this);
        }

        return $this;
    }

    public function removeDriverPath(Path $driverPath): self
    {
        if ($this->driverPath->contains($driverPath)) {
            $this->driverPath->removeElement($driverPath);
            // set the owning side to null (unless already changed)
            if ($driverPath->getDriver() === $this) {
                $driverPath->setDriver(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Path[]
     */
    public function getPassengerPath(): Collection
    {
        return $this->passengerPath;
    }

    public function addPassengerPath(Path $passengerPath): self
    {
        if (!$this->passengerPath->contains($passengerPath)) {
            $this->passengerPath[] = $passengerPath;
            $passengerPath->addPassenger($this);
        }

        return $this;
    }

    public function removePassengerPath(Path $passengerPath): self
    {
        if ($this->passengerPath->contains($passengerPath)) {
            $this->passengerPath->removeElement($passengerPath);
            $passengerPath->removePassenger($this);
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getAuthorComment(): Collection
    {
        return $this->authorComment;
    }

    public function addAuthorComment(Comment $authorComment): self
    {
        if (!$this->authorComment->contains($authorComment)) {
            $this->authorComment[] = $authorComment;
            $authorComment->setAuthor($this);
        }

        return $this;
    }

    public function removeAuthorComment(Comment $authorComment): self
    {
        if ($this->authorComment->contains($authorComment)) {
            $this->authorComment->removeElement($authorComment);
            // set the owning side to null (unless already changed)
            if ($authorComment->getAuthor() === $this) {
                $authorComment->setAuthor(null);
            }
        }

        return $this;
    }

    public function getTheme(): ?string
    {
        return $this->theme;
    }

    public function setTheme(string $theme): self
    {
        $this->theme = $theme;

        return $this;
    }
}
