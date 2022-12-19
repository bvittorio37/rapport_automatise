<?php

namespace App\Entity;

use App\Repository\TypeRapportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeRapportRepository::class)]
class TypeRapport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 7)]
    private $typeRapport;

    #[ORM\OneToMany(mappedBy: 'typeRapport', targetEntity: Rapport::class)]
    private $rapports;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private $remarque;

    public function __construct()
    {
        $this->rapports = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeRapport(): ?string
    {
        return $this->typeRapport;
    }

    public function setTypeRapport(string $typeRapport): self
    {
        $this->typeRapport = $typeRapport;

        return $this;
    }

    /**
     * @return Collection<int, Rapport>
     */
    public function getRapports(): Collection
    {
        return $this->rapports;
    }

    public function addRapport(Rapport $rapport): self
    {
        if (!$this->rapports->contains($rapport)) {
            $this->rapports[] = $rapport;
            $rapport->setTypeRapport($this);
        }

        return $this;
    }

    public function removeRapport(Rapport $rapport): self
    {
        if ($this->rapports->removeElement($rapport)) {
            // set the owning side to null (unless already changed)
            if ($rapport->getTypeRapport() === $this) {
                $rapport->setTypeRapport(null);
            }
        }

        return $this;
    }

    public function getRemarque(): ?string
    {
        return $this->remarque;
    }

    public function setRemarque(?string $remarque): self
    {
        $this->remarque = $remarque;

        return $this;
    }
    public function __toString()
    {
        return $this->typeRapport;
    }
}
