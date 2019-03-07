<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\AirportRepository")
 */
class Airport
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
     * @ORM\ManyToOne(targetEntity="App\Entity\City", inversedBy="airports")
     */
    private $city;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Flight", mappedBy="departureAirport")
     */
    private $flightsDeparture;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Flight", mappedBy="arrivalAirport")
     */
    private $flightsArrival;

    public function __construct()
    {
        $this->flightsDeparture = new ArrayCollection();
        $this->flightsArrival = new ArrayCollection();
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

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return Collection|Flight[]
     */
    public function getFlightsDeparture(): Collection
    {
        return $this->flightsDeparture;
    }

    public function addFlightsDeparture(Flight $flightsDeparture): self
    {
        if (!$this->flightsDeparture->contains($flightsDeparture)) {
            $this->flightsDeparture[] = $flightsDeparture;
            $flightsDeparture->setDepartureAirport($this);
        }

        return $this;
    }

    public function removeFlightsDeparture(Flight $flightsDeparture): self
    {
        if ($this->flightsDeparture->contains($flightsDeparture)) {
            $this->flightsDeparture->removeElement($flightsDeparture);
            // set the owning side to null (unless already changed)
            if ($flightsDeparture->getDepartureAirport() === $this) {
                $flightsDeparture->setDepartureAirport(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Flight[]
     */
    public function getFlightsArrival(): Collection
    {
        return $this->flightsArrival;
    }

    public function addFlightsArrival(Flight $flightsArrival): self
    {
        if (!$this->flightsArrival->contains($flightsArrival)) {
            $this->flightsArrival[] = $flightsArrival;
            $flightsArrival->setArrivalAirport($this);
        }

        return $this;
    }

    public function removeFlightsArrival(Flight $flightsArrival): self
    {
        if ($this->flightsArrival->contains($flightsArrival)) {
            $this->flightsArrival->removeElement($flightsArrival);
            // set the owning side to null (unless already changed)
            if ($flightsArrival->getArrivalAirport() === $this) {
                $flightsArrival->setArrivalAirport(null);
            }
        }

        return $this;
    }
}
