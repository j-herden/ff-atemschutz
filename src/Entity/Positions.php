<?php

namespace App\Entity;

use App\Entity\Stockings;
use App\Repository\PositionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PositionsRepository::class)]
class Positions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 20)]
    private $Name;

    #[ORM\JoinColumn(nullable: false)]
    #[ORM\ManyToOne(targetEntity: Location::class, inversedBy: 'positions')]
    private $Location;

    #[ORM\JoinColumn(nullable: false)]
    #[ORM\ManyToOne(targetEntity: DeviceTypes::class, inversedBy: 'positions')]
    private $deviceType;

    #[ORM\OneToMany(targetEntity: Stockings::class, mappedBy: 'position')]
    #[ORM\OrderBy(['date' => 'DESC', 'updated' => 'DESC'])]
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
     *  set for all stockings in this position: removed = true
     */
    public function setStockingsRemoved()
    {
        foreach ($this->Stockings as $s)
        {
            $s->setRemoved( true );
        }
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
        if ( ! $this->Stockings->contains($stocking) )
        {
            //  mark older stockings removed if the new one is not removed yet
            if ( ! $stocking->getRemoved() )
            {
                $this->setStockingsRemoved();
            }
            // now add it
            $this->Stockings[] = $stocking;
            $stocking->setPosition($this);

            // keep sorting correct
            // Collect an array iterator.
            $iterator = $this->Stockings->getIterator();

            // Do sort the new iterator.
            $iterator->uasort( function ($a, $b) {
                                    $order = ( $b->getDate() <=> $a->getDate() );
                                    if ( $order !== 0 )
                                    {
                                        return $order;
                                    }
                                    return ( $b->getUpdated() <=> $a->getUpdated() );
                                });

            // pass sorted array to ArrayCollection.
            $this->Stockings = new \Doctrine\Common\Collections\ArrayCollection(iterator_to_array($iterator));
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

    /*
     *   calculate the number of stockings matching a device_id on this position
     *
     *   $deviceId may be emtpy, then the total numbers of stockings is replied
     */
    public function countStockings(string $deviceId): int
    {
        if ( $deviceId === '' )
        {
            return count( $this->getStockings() );
        }

        $count = 0;
        foreach ($this->getStockings() as $stocking)
        {
            if ( $stocking->getDeviceId() == $deviceId )
            {
                ++$count;
            }
        }
        return $count;
    }

}
