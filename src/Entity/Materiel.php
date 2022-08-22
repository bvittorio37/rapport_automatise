<?php

namespace App\Entity;

use App\Repository\MaterielRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MaterielRepository::class)]
class Materiel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 30)]
    private $materiel;

    #[ORM\ManyToOne(targetEntity: Unite::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $unite;

    #[ORM\ManyToOne(targetEntity: CategorieMateriel::class, inversedBy: 'materiels')]
    #[ORM\JoinColumn(nullable: false)]
    private $categorie;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMateriel(): ?string
    {
        return $this->materiel;
    }

    public function setMateriel(string $materiel): self
    {
        $this->materiel = $materiel;

        return $this;
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

    public function getCategorie(): ?CategorieMateriel
    {
        return $this->categorie;
    }

    public function setCategorie(?CategorieMateriel $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }
    public function __toString()
    {
        return $this->materiel;
    }
}
