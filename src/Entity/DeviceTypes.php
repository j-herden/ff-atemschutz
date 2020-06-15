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
     * @ORM\OneToMany(targetEntity=Stockings::class, mappedBy="device_type")
     */
    private $stockings;

    public function __construct()
    {
        $this->stockings = new ArrayCollection();
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

    /**
     * @return Collection|Stockings[]
     */
    public function getStockings(): Collection
    {
        return $this->stockings;
    }

    public function addStocking(Stockings $stocking): self
    {
        if (!$this->stockings->contains($stocking)) {
            $this->stockings[] = $stocking;
            $stocking->setDeviceType($this);
        }

        return $this;
    }

    public function removeStocking(Stockings $stocking): self
    {
        if ($this->stockings->contains($stocking)) {
            $this->stockings->removeElement($stocking);
            // set the owning side to null (unless already changed)
            if ($stocking->getDeviceType() === $this) {
                $stocking->setDeviceType(null);
            }
        }

        return $this;
    }

    public function __toString(): String
    {
        return $this->getName();
    }

}
