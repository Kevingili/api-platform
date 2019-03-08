<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Validator\Constraints\CorrectName; // A custom constraint
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ApiResource
 * @ORM\Entity(repositoryClass="App\Repository\PlaneRepository")
 * @UniqueEntity("model")
 */
class Plane
{
    /**
     * @var integer id
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string model
     * @ORM\Column(type="string", length=255)
     * @CorrectName
     * @Assert\Length(min="6", minMessage="Minimum 6 characters")
     * @Assert\NotBlank
     */
    private $model;

    /**
     * @var integer seatNumber
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\GreaterThan(0)
     *
     */
    private $seatNumber;

    /**
     * @var DateTime dateCommissioning
     * @ORM\Column(type="datetime")
     * @Assert\DateTime
     */
    private $dateCommissioning;

    /**
     * @var Flight flight
     * @ORM\OneToMany(targetEntity="App\Entity\Flight", mappedBy="plane")
     */
    private $flight;

    /**
     * @var Company company
     * @ORM\ManyToOne(targetEntity="App\Entity\Company", inversedBy="planes")
     */
    private $company;

    /**
     * Plane constructor.
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
    public function getModel(): ?string
    {
        return $this->model;
    }

    /**
     * @param string $model
     * @return Plane
     */
    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getSeatNumber(): ?int
    {
        return $this->seatNumber;
    }

    /**
     * @param int $seatNumber
     * @return Plane
     */
    public function setSeatNumber(int $seatNumber): self
    {
        $this->seatNumber = $seatNumber;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDateCommissioning(): ?\DateTimeInterface
    {
        return $this->dateCommissioning;
    }

    /**
     * @param \DateTimeInterface $dateCommissioning
     * @return Plane
     */
    public function setDateCommissioning(\DateTimeInterface $dateCommissioning): self
    {
        $this->dateCommissioning = $dateCommissioning;

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
     * @return Plane
     */
    public function addFlight(Flight $flight): self
    {
        if (!$this->flight->contains($flight)) {
            $this->flight[] = $flight;
            $flight->setPlane($this);
        }

        return $this;
    }

    /**
     * @param Flight $flight
     * @return Plane
     */
    public function removeFlight(Flight $flight): self
    {
        if ($this->flight->contains($flight)) {
            $this->flight->removeElement($flight);
            // set the owning side to null (unless already changed)
            if ($flight->getPlane() === $this) {
                $flight->setPlane(null);
            }
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
     * @return Plane
     */
    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

}
