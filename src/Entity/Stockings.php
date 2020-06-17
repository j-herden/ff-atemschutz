<?php

namespace App\Entity;

use App\Repository\StockingsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StockingsRepository::class)
 */
class Stockings
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $device_id;

    /**
     * @ORM\ManyToOne(targetEntity=Positions::class, inversedBy="Stockings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $position;

    /**
     * @ORM\Column(type="boolean")
     */
    private $removed;

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
}
