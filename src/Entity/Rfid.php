<?php

namespace App\Entity;

use App\Repository\RfidRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RfidRepository::class)]
class Rfid
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $key_number = null;

    #[ORM\Column(length: 255)]
    private ?string $key_code = null;

    #[ORM\OneToMany(mappedBy: 'key_number', targetEntity: Place::class)]
    private Collection $places;

    public function __construct()
    {
        $this->places = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?string
    {
        return $this->key_number;
    }

    public function setNumber(int $key_number): static
    {
        $this->key_number = $key_number;

        return $this;
    }

    public function getKeyCode(): ?string
    {
        return $this->key_code;
    }

    public function setKeyCode(string $key_code): static
    {
        $this->key_code = $key_code;

        return $this;
    }

    /**
     * @return Collection<int, Place>
     */
    public function getPlaces(): Collection
    {
        return $this->places;
    }

    public function addPlace(Place $place): static
    {
        if (!$this->places->contains($place)) {
            $this->places->add($place);
            $place->setKeyNumber($this);
        }

        return $this;
    }

    public function removePlace(Place $place): static
    {
        if ($this->places->removeElement($place)) {
            // set the owning side to null (unless already changed)
            if ($place->getKeyNumber() === $this) {
                $place->setKeyNumber(null);
            }
        }

        return $this;
    }
}
