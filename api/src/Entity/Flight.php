<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\FlightRepository")
 */
class Flight
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $number;

    /**
     * @ORM\Column(type="datetime")
     */
    private $departureDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $arrivalDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Plane", inversedBy="flight")
     */
    private $plane;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Personnal", mappedBy="flight")
     */
    private $personnals;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Passenger", mappedBy="flight")
     */
    private $passenger;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Airport", inversedBy="flightsDeparture")
     */
    private $departureAirport;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Airport", inversedBy="flightsArrival")
     */
    private $arrivalAirport;

    public function __construct()
    {
        $this->personnals = new ArrayCollection();
        $this->passenger = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getDepartureDate(): ?\DateTimeInterface
    {
        return $this->departureDate;
    }

    public function setDepartureDate(\DateTimeInterface $departureDate): self
    {
        $this->departureDate = $departureDate;

        return $this;
    }

    public function getArrivalDate(): ?\DateTimeInterface
    {
        return $this->arrivalDate;
    }

    public function setArrivalDate(\DateTimeInterface $arrivalDate): self
    {
        $this->arrivalDate = $arrivalDate;

        return $this;
    }

    public function getPlane(): ?Plane
    {
        return $this->plane;
    }

    public function setPlane(?Plane $plane): self
    {
        $this->plane = $plane;

        return $this;
    }

    /**
     * @return Collection|Personnal[]
     */
    public function getPersonnals(): Collection
    {
        return $this->personnals;
    }

    public function addPersonnal(Personnal $personnal): self
    {
        if (!$this->personnals->contains($personnal)) {
            $this->personnals[] = $personnal;
            $personnal->addFlight($this);
        }

        return $this;
    }

    public function removePersonnal(Personnal $personnal): self
    {
        if ($this->personnals->contains($personnal)) {
            $this->personnals->removeElement($personnal);
            $personnal->removeFlight($this);
        }

        return $this;
    }

    /**
     * @return Collection|Passenger[]
     */
    public function getPassenger(): Collection
    {
        return $this->passenger;
    }

    public function addPassenger(Passenger $passenger): self
    {
        if (!$this->passenger->contains($passenger)) {
            $this->passenger[] = $passenger;
            $passenger->setFlight($this);
        }

        return $this;
    }

    public function removePassenger(Passenger $passenger): self
    {
        if ($this->passenger->contains($passenger)) {
            $this->passenger->removeElement($passenger);
            // set the owning side to null (unless already changed)
            if ($passenger->getFlight() === $this) {
                $passenger->setFlight(null);
            }
        }

        return $this;
    }

    public function getDepartureAirport(): ?Airport
    {
        return $this->departureAirport;
    }

    public function setDepartureAirport(?Airport $departureAirport): self
    {
        $this->departureAirport = $departureAirport;

        return $this;
    }

    public function getArrivalAirport(): ?Airport
    {
        return $this->arrivalAirport;
    }

    public function setArrivalAirport(?Airport $arrivalAirport): self
    {
        $this->arrivalAirport = $arrivalAirport;

        return $this;
    }
}
