<?php

namespace App\Entity;

use App\Repository\PlaceRepository;
<<<<<<< HEAD
use Doctrine\DBAL\Types\Types;
=======
>>>>>>> e5013eb6b8c81c84604e5b8b3319ba00fb869302
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlaceRepository::class)]
class Place
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

<<<<<<< HEAD
    #[ORM\Column]
=======
    #[ORM\Column(length: 10, unique: true)]
>>>>>>> e5013eb6b8c81c84604e5b8b3319ba00fb869302
    private ?int $number = null;

    #[ORM\Column(length: 10)]
    private ?string $size = null;

<<<<<<< HEAD

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $start_date = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $end_date = null;
=======
    #[ORM\Column]
    private ?bool $isTaken = null;

    #[ORM\ManyToOne(inversedBy: 'places')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Boats $boat = null;
>>>>>>> e5013eb6b8c81c84604e5b8b3319ba00fb869302

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): static
    {
        $this->number = $number;

        return $this;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(string $size): static
    {
        $this->size = $size;

        return $this;
    }

<<<<<<< HEAD


    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(?\DateTimeInterface $start_date): static
    {
        $this->start_date = $start_date;
=======
    public function isIsTaken(): ?bool
    {
        return $this->isTaken;
    }

    public function setIsTaken(bool $isTaken): static
    {
        $this->isTaken = $isTaken;
>>>>>>> e5013eb6b8c81c84604e5b8b3319ba00fb869302

        return $this;
    }

<<<<<<< HEAD
    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(?\DateTimeInterface $end_date): static
    {
        $this->end_date = $end_date;
=======
    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getBoat(): ?Boats
    {
        return $this->boat;
    }

    public function setBoat(Boats $boat): static
    {
        $this->boat = $boat;
>>>>>>> e5013eb6b8c81c84604e5b8b3319ba00fb869302

        return $this;
    }
}
