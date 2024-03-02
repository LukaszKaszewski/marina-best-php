<?php

namespace App\Entity;

use App\Repository\WinteringRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WinteringRepository::class)]
class Wintering
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $boat_name = null;

    #[ORM\Column]
    private ?int $boat_length = null;

    #[ORM\Column]
    private ?int $boat_width = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $start_date = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $end_date = null;

    #[ORM\ManyToOne(inversedBy: 'winterings')]
    private ?User $user_id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getBoatLength(): ?int
    {
        return $this->boat_length;
    }

    public function setBoatLength(int $boat_length): static
    {
        $this->boat_length = $boat_length;

        return $this;
    }

    public function getBoatWidth(): ?int
    {
        return $this->boat_width;
    }

    public function setBoatWidth(int $boat_width): static
    {
        $this->boat_width = $boat_width;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTimeInterface $start_date): static
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTimeInterface $end_date): static
    {
        $this->end_date = $end_date;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }
}
