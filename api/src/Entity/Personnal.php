<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\PersonnalRepository")
 */
class Personnal
{
    /**
     * @var integer id
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string name
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @var string function
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $function;

    /**
     * @var Flight flight
     * @ORM\ManyToMany(targetEntity="App\Entity\Flight", inversedBy="personnals")
     */
    private $flight;

    /**
     * @var Company company
     * @ORM\ManyToOne(targetEntity="App\Entity\Company", inversedBy="personnals")
     */
    private $company;

    /**
     * Personnal constructor.
     */
    public function __construct()
    {
        $this->flight = new ArrayCollection();
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
     * @return Personnal
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getFunction(): ?string
    {
        return $this->function;
    }

    /**
     * @param string $function
     * @return Personnal
     */
    public function setFunction(string $function): self
    {
        $this->function = $function;

        return $this;
    }

    /**
     * @return Collection|Flight[]
     */
    public function getFlight(): Collection
    {
        return $this->flight;
    }

    /**
     * @param Flight $flight
     * @return Personnal
     */
    public function addFlight(Flight $flight): self
    {
        if (!$this->flight->contains($flight)) {
            $this->flight[] = $flight;
        }

        return $this;
    }

    /**
     * @param Flight $flight
     * @return Personnal
     */
    public function removeFlight(Flight $flight): self
    {
        if ($this->flight->contains($flight)) {
            $this->flight->removeElement($flight);
        }

        return $this;
    }

    /**
     * @return Company|null
     */
    public function getCompany(): ?Company
    {
        return $this->company;
    }

    /**
     * @param Company|null $company
     * @return Personnal
     */
    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }
}
