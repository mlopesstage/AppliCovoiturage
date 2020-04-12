<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PathRepository")
 */
class Path
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateTime;

    /**
     * @ORM\Column(type="integer")
     */
    private $seats;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Place", inversedBy="departurePlace")
     * @ORM\JoinColumn(nullable=false)
     */
    private $departure;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Place", inversedBy="destinationPlace")
     * @ORM\JoinColumn(nullable=false)
     */
    private $destination;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="driverPath")
     * @ORM\JoinColumn(nullable=false)
     */
    private $driver;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="passengerPath")
     */
    private $passenger;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="ride", orphanRemoval=true, cascade={"persist", "remove"})
     */
    private $rideComment;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    public function __construct()
    {
        $this->passenger = new ArrayCollection();
        $this->rideComment = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateTime(): ?\DateTimeInterface
    {
        return $this->dateTime;
    }

    public function setDateTime(\DateTimeInterface $dateTime): self
    {
        $this->dateTime = $dateTime;

        return $this;
    }

    public function getSeats(): ?int
    {
        return $this->seats;
    }

    public function setSeats(int $seats): self
    {
        $this->seats = $seats;

        return $this;
    }

    public function getDeparture(): ?Place
    {
        return $this->departure;
    }

    public function setDeparture(?Place $departure): self
    {
        $this->departure = $departure;

        return $this;
    }

    public function getDestination(): ?Place
    {
        return $this->destination;
    }

    public function setDestination(?Place $destination): self
    {
        $this->destination = $destination;

        return $this;
    }

    public function getDriver(): ?User
    {
        return $this->driver;
    }

    public function setDriver(?User $driver): self
    {
        $this->driver = $driver;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getPassenger(): Collection
    {
        return $this->passenger;
    }

    public function addPassenger(User $passenger): self
    {
        if (!$this->passenger->contains($passenger)) {
            $this->passenger[] = $passenger;
        }

        return $this;
    }

    public function removePassenger(User $passenger): self
    {
        if ($this->passenger->contains($passenger)) {
            $this->passenger->removeElement($passenger);
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getRideComment(): Collection
    {
        return $this->rideComment;
    }

    public function addRideComment(Comment $rideComment): self
    {
        if (!$this->rideComment->contains($rideComment)) {
            $this->rideComment[] = $rideComment;
            $rideComment->setRide($this);
        }

        return $this;
    }

    public function removeRideComment(Comment $rideComment): self
    {
        if ($this->rideComment->contains($rideComment)) {
            $this->rideComment->removeElement($rideComment);
            // set the owning side to null (unless already changed)
            if ($rideComment->getRide() === $this) {
                $rideComment->setRide(null);
            }
        }

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }
}
