<?php

namespace App\Entity;

use App\Repository\StockingsRepository;
use DateTime;
use Gedmo\Mapping\Annotation as Gedmo; // this will be like an alias for Gedmo extensions annotations
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StockingsRepository::class)]
class Stockings
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'date')]
    private $date;

    #[ORM\Column(type: 'string', length: 20)]
    private $device_id;

    #[ORM\Column(type: 'date', nullable: true)]
    private $maintenance;

    #[ORM\JoinColumn(nullable: false)]
    #[ORM\ManyToOne(targetEntity: Positions::class, inversedBy: 'Stockings')]
    private $position;

    #[ORM\Column(type: 'boolean')]
    private $removed = false;

    #[ORM\JoinColumn(nullable: false)]
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'stockings')]
    private $user;

    /**
     * @var \DateTime
     */
    #[Gedmo\Timestampable(on: 'create')]
    #[ORM\Column(type: 'datetime')]
    private $created;

    /**
     * @var \DateTime
     */
    #[Gedmo\Timestampable(on: 'update')]
    #[ORM\Column(type: 'datetime')]
    private $updated;

    public function getCreated(): ?\DateTime
    {
        return $this->created;
    }

    public function getUpdated(): ?\DateTime
    {
        return $this->updated;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDeviceId(): ?string
    {
        return $this->device_id;
    }

    public function setDeviceId(string $device_id): self
    {
        $this->device_id = $device_id;

        return $this;
    }
    
    public function getMaintenance(): ?\DateTimeInterface
    {
        return $this->maintenance;
    }

    public function setMaintenance(\DateTimeInterface $maintenance): self
    {
        if ( is_null($maintenance) ) 
        {
            $this->maintenance = '';
        }
        else {
            $date = DateTime::createFromInterface( $maintenance );
            $date->modify('last day of this month');
            $this->maintenance = $date;
        }

        return $this;
    }

    public function getPosition(): ?Positions
    {
        return $this->position;
    }

    public function setPosition(?Positions $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function __toString(): String
    {
        $date = $this->getDate()->format('Y-m-d');
        return $date . ' ' . $this->getDeviceId();
    }

    public function getRemoved(): ?bool
    {
        return $this->removed;
    }

    public function setRemoved(bool $removed): self
    {
        $this->removed = $removed;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function isOlderThan( \DateTimeInterface $date ) : bool
    {
        return $this->getDate() < $date;
    }

}
