<?php

namespace App\Entity;

use App\Repository\DeviceTypesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DeviceTypesRepository::class)
 */
class DeviceTypes
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
    private $Name;

    /**
     * @ORM\OneToMany(targetEntity=Positions::class, mappedBy="deviceType")
     */
    private $positions;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $color;

    public function __construct()
    {
        $this->stockings = new ArrayCollection();
        $this->positions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function __toString(): String
    {
        return $this->getName();
    }

    /**
     * @return Collection|Positions[]
     */
    public function getPositions(): Collection
    {
        return $this->positions;
    }

    public function addPosition(Positions $position): self
    {
        if (!$this->positions->contains($position)) {
            $this->positions[] = $position;
            $position->setDeviceType($this);
        }

        return $this;
    }

    public function removePosition(Positions $position): self
    {
        if ($this->positions->contains($position)) {
            $this->positions->removeElement($position);
            // set the owning side to null (unless already changed)
            if ($position->getDeviceType() === $this) {
                $position->setDeviceType(null);
            }
        }

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

}
