<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?bool $energy = null;

    #[ORM\Column(nullable: true)]
    private ?bool $fuel = null;

    #[ORM\Column(nullable: true)]
    private ?bool $water = null;

    #[ORM\Column(nullable: true)]
    private ?bool $waste = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'services')]
    private ?User $user_id = null;

    #[ORM\Column(nullable: true)]
    private ?bool $crane = null;

    #[ORM\Column(length: 255)]
    private ?string $boat_name = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isEnergy(): ?bool
    {
        return $this->energy;
    }

    public function setEnergy(?bool $energy): static
    {
        $this->energy = $energy;

        return $this;
    }

    public function isFuel(): ?bool
    {
        return $this->fuel;
    }

    public function setFuel(?bool $fuel): static
    {
        $this->fuel = $fuel;

        return $this;
    }

    public function isWater(): ?bool
    {
        return $this->water;
    }

    public function setWater(?bool $water): static
    {
        $this->water = $water;

        return $this;
    }

    public function isWaste(): ?bool
    {
        return $this->waste;
    }

    public function setWaste(?bool $waste): static
    {
        $this->waste = $waste;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function isCrane(): ?bool
    {
        return $this->crane;
    }

    public function setCrane(?bool $crane): static
    {
        $this->crane = $crane;

        return $this;
    }

    public function getBoatName(): ?string
    {
        return $this->boat_name;
    }

    public function setBoatName(string $boat_name): static
    {
        $this->boat_name = $boat_name;

        return $this;
    }
}
