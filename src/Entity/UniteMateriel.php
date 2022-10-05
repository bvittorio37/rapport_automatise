<?php

namespace App\Entity;

use App\Repository\UniteMaterielRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UniteMaterielRepository::class)]
class UniteMateriel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Unite::class, inversedBy: 'uniteMateriels')]
    private $unite;

    #[ORM\ManyToOne(targetEntity: Materiel::class, inversedBy: 'uniteMateriels', cascade: ['persist'])]
    private $materiel;

    #[ORM\Column(type: 'integer')]
    private $qunatite;

    #[ORM\ManyToOne(targetEntity: TypeUnite::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $typeUnite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUnite(): ?Unite
    {
        return $this->unite;
    }

    public function setUnite(?Unite $unite): self
    {
        $this->unite = $unite;

        return $this;
    }

    public function getMateriel(): ?Materiel
    {
        return $this->materiel;
    }

    public function setMateriel(?Materiel $materiel): self
    {
        $this->materiel = $materiel;

        return $this;
    }

    public function getQunatite(): ?int
    {
        return $this->qunatite;
    }

    public function setQunatite(int $qunatite): self
    {
        $this->qunatite = $qunatite;

        return $this;
    }

    public function getTypeUnite(): ?TypeUnite
    {
        return $this->typeUnite;
    }

    public function setTypeUnite(?TypeUnite $typeUnite): self
    {
        $this->typeUnite = $typeUnite;

        return $this;
    }
}
