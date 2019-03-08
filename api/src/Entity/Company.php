<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\CompanyRepository")
 * @UniqueEntity("name")
 */
class Company
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
     * @ORM\OneToMany(targetEntity="App\Entity\Plane", mappedBy="company")
     * @ApiSubresource
     */
    private $planes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Personnal", mappedBy="company")
     */
    private $personnals;

    /**
     * Company constructor.
     */
    public function __construct()
    {
        $this->planes = new ArrayCollection();
        $this->personnals = new ArrayCollection();
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
     * @return Company
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Plane[]
     */
    public function getPlanes(): Collection
    {
        return $this->planes;
    }

    /**
     * @param Plane $plane
     * @return Company
     */
    public function addPlane(Plane $plane): self
    {
        if (!$this->planes->contains($plane)) {
            $this->planes[] = $plane;
            $plane->setCompany($this);
        }

        return $this;
    }

    /**
     * @param Plane $plane
     * @return Company
     */
    public function removePlane(Plane $plane): self
    {
        if ($this->planes->contains($plane)) {
            $this->planes->removeElement($plane);
            // set the owning side to null (unless already changed)
            if ($plane->getCompany() === $this) {
                $plane->setCompany(null);
            }
        }

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
     * @return Company
     */
    public function addPersonnal(Personnal $personnal): self
    {
        if (!$this->personnals->contains($personnal)) {
            $this->personnals[] = $personnal;
            $personnal->setCompany($this);
        }

        return $this;
    }

    /**
     * @param Personnal $personnal
     * @return Company
     */
    public function removePersonnal(Personnal $personnal): self
    {
        if ($this->personnals->contains($personnal)) {
            $this->personnals->removeElement($personnal);
            // set the owning side to null (unless already changed)
            if ($personnal->getCompany() === $this) {
                $personnal->setCompany(null);
            }
        }

        return $this;
    }
}
