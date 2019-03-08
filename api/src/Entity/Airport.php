<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Aéroport
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\AirportRepository")
 * @UniqueEntity("name")
 */
class Airport
{
    /**
     * @var integer id
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string name nom de l'aéroport
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @var string city ville
     * @ORM\ManyToOne(targetEntity="App\Entity\City", inversedBy="airports")
     */
    private $city;

    /**
     * @var Flight flightsDeparture
     * @ORM\OneToMany(targetEntity="App\Entity\Flight", mappedBy="departureAirport")
     */
    private $flightsDeparture;

    /**
     * @var Flight flightsArrival
     * @ORM\OneToMany(targetEntity="App\Entity\Flight", mappedBy="arrivalAirport")
     */
    private $flightsArrival;

    /**
     * Airport constructor.
     */
    public function __construct()
    {
        $this->flightsDeparture = new ArrayCollection();
        $this->flightsArrival = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Airport
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return City|null
     */
    public function getCity(): ?City
    {
        return $this->city;
    }

    /**
     * @param City|null $city
     * @return Airport
     */
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

    /**
     * @param Flight $flightsDeparture
     * @return Airport
     */
    public function addFlightsDeparture(Flight $flightsDeparture): self
    {
        if (!$this->flightsDeparture->contains($flightsDeparture)) {
            $this->flightsDeparture[] = $flightsDeparture;
            $flightsDeparture->setDepartureAirport($this);
        }

        return $this;
    }

    /**
     * @param Flight $flightsDeparture
     * @return Airport
     */
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

    /**
     * @param Flight $flightsArrival
     * @return Airport
     */
    public function addFlightsArrival(Flight $flightsArrival): self
    {
        if (!$this->flightsArrival->contains($flightsArrival)) {
            $this->flightsArrival[] = $flightsArrival;
            $flightsArrival->setArrivalAirport($this);
        }

        return $this;
    }

    /**
     * @param Flight $flightsArrival
     * @return Airport
     */
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
