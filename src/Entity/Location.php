<?php

namespace App\Entity;

use App\Repository\LocationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocationRepository::class)]
class Location
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $Name;

    #[ORM\JoinColumn(nullable: false)]
    #[ORM\ManyToOne(targetEntity: Organisation::class, inversedBy: 'locations')]
    private $organisation;

    #[ORM\OneToMany(targetEntity: Positions::class, mappedBy: 'Location')]
    #[ORM\OrderBy(['Name' => 'ASC'])]
    private $positions;

    public function __construct()
    {
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

    public function getOrganisation(): ?Organisation
    {
        return $this->organisation;
    }

    public function setOrganisation(?Organisation $organisation): self
    {
        $this->organisation = $organisation;

        return $this;
    }

    public function __toString(): String
    {
        $organisation = $this->getOrganisation()->getName();
        return $this->getName() . " ($organisation)";
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
            $position->setLocation($this);
        }

        return $this;
    }

    public function removePosition(Positions $position): self
    {
        if ($this->positions->contains($position)) {
            $this->positions->removeElement($position);
            // set the owning side to null (unless already changed)
            if ($position->getLocation() === $this) {
                $position->setLocation(null);
            }
        }

        return $this;
    }
}
