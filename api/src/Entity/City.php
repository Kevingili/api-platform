<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use ApiPlatform\Core\Annotation\ApiSubresource;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\CityRepository")
 * @UniqueEntity(fields={"name"})
 *
 */
class City
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $country;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Airport", mappedBy="city")
     * @ApiSubresource()
     */
    private $airports;

    /**
     * City constructor.
     */
    public function __construct()
    {
        $this->airports = new ArrayCollection();
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
     * @return City
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param string $country
     * @return City
     */
    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return Collection|Airport[]
     */
    public function getAirports(): Collection
    {
        return $this->airports;
    }

    /**
     * @param Airport $airport
     * @return City
     */
    public function addAirport(Airport $airport): self
    {
        if (!$this->airports->contains($airport)) {
            $this->airports[] = $airport;
            $airport->setCity($this);
        }

        return $this;
    }

    /**
     * @param Airport $airport
     * @return City
     */
    public function removeAirport(Airport $airport): self
    {
        if ($this->airports->contains($airport)) {
            $this->airports->removeElement($airport);
            // set the owning side to null (unless already changed)
            if ($airport->getCity() === $this) {
                $airport->setCity(null);
            }
        }

        return $this;
    }
}
