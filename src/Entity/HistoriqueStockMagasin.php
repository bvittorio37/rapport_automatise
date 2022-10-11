<?php

namespace App\Entity;

use App\Repository\HistoriqueStockMagasinRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HistoriqueStockMagasinRepository::class)]
class HistoriqueStockMagasin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime')]
    private $dateStock;

    #[ORM\Column(type: 'string', length: 100)]
    private $materiel;

    #[ORM\Column(type: 'string', length: 255)]
    private $string;

    #[ORM\Column(type: 'string', length: 150)]
    private $libelle;

    #[ORM\Column(type: 'string', length: 150)]
    private $quantite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateStock(): ?\DateTimeInterface
    {
        return $this->dateStock;
    }

    public function setDateStock(\DateTimeInterface $dateStock): self
    {
        $this->dateStock = $dateStock;

        return $this;
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

    public function getString(): ?string
    {
        return $this->string;
    }

    public function setString(string $string): self
    {
        $this->string = $string;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getQuantite(): ?string
    {
        return $this->quantite;
    }

    public function setQuantite(string $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }
}
