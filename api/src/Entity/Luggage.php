<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\LuggageRepository")
 */
class Luggage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank
     * @Assert\Range(min=1,max=30)
     */
    private $weight;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Passenger", inversedBy="luggage")
     */
    private $passenger;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return float|null
     */
    public function getWeight(): ?float
    {
        return $this->weight;
    }

    /**
     * @param float $weight
     * @return Luggage
     */
    public function setWeight(float $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * @return Passenger|null
     */
    public function getPassenger(): ?Passenger
    {
        return $this->passenger;
    }

    /**
     * @param Passenger|null $passenger
     * @return Luggage
     */
    public function setPassenger(?Passenger $passenger): self
    {
        $this->passenger = $passenger;

        return $this;
    }
}
