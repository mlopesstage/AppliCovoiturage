<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlaceRepository")
 */
class Place
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Path", mappedBy="departure")
     */
    private $departurePlace;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Path", mappedBy="destination")
     */
    private $destinationPlace;

    public function __construct()
    {
        $this->departurePlace = new ArrayCollection();
        $this->destinationPlace = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Path[]
     */
    public function getDeparturePlace(): Collection
    {
        return $this->departurePlace;
    }

    public function addDeparturePlace(Path $departurePlace): self
    {
        if (!$this->departurePlace->contains($departurePlace)) {
            $this->departurePlace[] = $departurePlace;
            $departurePlace->setDeparture($this);
        }

        return $this;
    }

    public function removeDeparturePlace(Path $departurePlace): self
    {
        if ($this->departurePlace->contains($departurePlace)) {
            $this->departurePlace->removeElement($departurePlace);
            // set the owning side to null (unless already changed)
            if ($departurePlace->getDeparture() === $this) {
                $departurePlace->setDeparture(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Path[]
     */
    public function getDestinationPlace(): Collection
    {
        return $this->destinationPlace;
    }

    public function addDestinationPlace(Path $destinationPlace): self
    {
        if (!$this->destinationPlace->contains($destinationPlace)) {
            $this->destinationPlace[] = $destinationPlace;
            $destinationPlace->setDestination($this);
        }

        return $this;
    }

    public function removeDestinationPlace(Path $destinationPlace): self
    {
        if ($this->destinationPlace->contains($destinationPlace)) {
            $this->destinationPlace->removeElement($destinationPlace);
            // set the owning side to null (unless already changed)
            if ($destinationPlace->getDestination() === $this) {
                $destinationPlace->setDestination(null);
            }
        }

        return $this;
    }
}
