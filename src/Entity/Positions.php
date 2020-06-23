<?php

namespace App\Entity;

use App\Repository\PositionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PositionsRepository::class)
 */
class Positions
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $Name;

    /**
     * @ORM\ManyToOne(targetEntity=Location::class, inversedBy="positions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Location;

    /**
     * @ORM\ManyToOne(targetEntity=DeviceTypes::class, inversedBy="positions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $deviceType;

    /**
     * @ORM\OneToMany(targetEntity=Stockings::class, mappedBy="position", fetch="EAGER")
     * @ORM\OrderBy({"date" = "DESC"})
     */
    private $Stockings;

    public function __construct()
    {
        $this->Stockings = new ArrayCollection();
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

    public function getLocation(): ?Location
    {
        return $this->Location;
    }

    public function setLocation(?Location $Location): self
    {
        $this->Location = $Location;

        return $this;
    }

    public function getDeviceType(): ?DeviceTypes
    {
        return $this->deviceType;
    }

    public function setDeviceType(?DeviceTypes $deviceType): self
    {
        $this->deviceType = $deviceType;

        return $this;
    }

    public function __toString(): String
    {
        return $this->getName() . " / $this->Location";
    }

    /**
     * @return Collection|Stockings[]
     */
    public function getStockings(): Collection
    {
        return $this->Stockings;
    }

    public function addStocking(Stockings $stocking): self
    {
        if (!$this->Stockings->contains($stocking)) {
            $this->Stockings[] = $stocking;
            $stocking->setPosition($this);
        }

        return $this;
    }

    public function removeStocking(Stockings $stocking): self
    {
        if ($this->Stockings->contains($stocking)) {
            $this->Stockings->removeElement($stocking);
            // set the owning side to null (unless already changed)
            if ($stocking->getPosition() === $this) {
                $stocking->setPosition(null);
            }
        }

        return $this;
    }
}
