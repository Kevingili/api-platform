<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\FlightRepository")
 * @UniqueEntity("number")
 */
class Flight
{
    /**
     * @var integer id
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var integer number
     * @ORM\Column(type="integer")
     * @Assert\Length(min=4, max=8)
     */
    private $number;

    /**
     * @var DateTime departureDate
     * @ORM\Column(type="datetime")
     * @Assert\DateTime
     */
    private $departureDate;

    /**
     * @var DateTime arrivalDate
     * @ORM\Column(type="datetime")
     * @Assert\DateTime
     * @Assert\GreaterThanOrEqual(propertyPath="departureDate")
     *
     */
    private $arrivalDate;

    /**
     * @var Plane plane
     * @ORM\ManyToOne(targetEntity="App\Entity\Plane", inversedBy="flight")
     */
    private $plane;

    /**
     * @var Personnal personnals
     * @ORM\ManyToMany(targetEntity="App\Entity\Personnal", mappedBy="flight")
     */
    private $personnals;

    /**
     * @var Passenger passenger
     * @ORM\OneToMany(targetEntity="App\Entity\Passenger", mappedBy="flight")
     */
    private $passenger;

    /**
     * @var Airport departureAirport
     * @ORM\ManyToOne(targetEntity="App\Entity\Airport", inversedBy="flightsDeparture")
     */
    private $departureAirport;

    /**
     * @var Airport arrivalAirport
     * @ORM\ManyToOne(targetEntity="App\Entity\Airport", inversedBy="flightsArrival")
     */
    private $arrivalAirport;

    /**
     * Flight constructor.
     */
    public function __construct()
    {
        $this->personnals = new ArrayCollection();
        $this->passenger = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getNumber(): ?int
    {
        return $this->number;
    }

    /**
     * @param int $number
     * @return Flight
     */
    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDepartureDate(): ?\DateTimeInterface
    {
        return $this->departureDate;
    }

    /**
     * @param \DateTimeInterface $departureDate
     * @return Flight
     */
    public function setDepartureDate(\DateTimeInterface $departureDate): self
    {
        $this->departureDate = $departureDate;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getArrivalDate(): ?\DateTimeInterface
    {
        return $this->arrivalDate;
    }

    /**
     * @param \DateTimeInterface $arrivalDate
     * @return Flight
     */
    public function setArrivalDate(\DateTimeInterface $arrivalDate): self
    {
        $this->arrivalDate = $arrivalDate;

        return $this;
    }

    /**
     * @return Plane|null
     */
    public function getPlane(): ?Plane
    {
        return $this->plane;
    }

    /**
     * @param Plane|null $plane
     * @return Flight
     */
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

    /**
     * @param Personnal $personnal
     * @return Flight
     */
    public function addPersonnal(Personnal $personnal): self
    {
        if (!$this->personnals->contains($personnal)) {
            $this->personnals[] = $personnal;
            $personnal->addFlight($this);
        }

        return $this;
    }

    /**
     * @param Personnal $personnal
     * @return Flight
     */
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

    /**
     * @param Passenger $passenger
     * @return Flight
     */
    public function addPassenger(Passenger $passenger): self
    {
        if (!$this->passenger->contains($passenger)) {
            $this->passenger[] = $passenger;
            $passenger->setFlight($this);
        }

        return $this;
    }

    /**
     * @param Passenger $passenger
     * @return Flight
     */
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

    /**
     * @return Airport|null
     */
    public function getDepartureAirport(): ?Airport
    {
        return $this->departureAirport;
    }

    /**
     * @param Airport|null $departureAirport
     * @return Flight
     */
    public function setDepartureAirport(?Airport $departureAirport): self
    {
        $this->departureAirport = $departureAirport;

        return $this;
    }

    /**
     * @return Airport|null
     */
    public function getArrivalAirport(): ?Airport
    {
        return $this->arrivalAirport;
    }

    /**
     * @param Airport|null $arrivalAirport
     * @return Flight
     */
    public function setArrivalAirport(?Airport $arrivalAirport): self
    {
        $this->arrivalAirport = $arrivalAirport;

        return $this;
    }
}
