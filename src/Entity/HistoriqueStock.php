<?php

namespace App\Entity;

use App\Repository\HistoriqueStockRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HistoriqueStockRepository::class)]
class HistoriqueStock
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime')]
    private $dateStock;

    #[ORM\Column(type: 'string', length: 7)]
    private $mouvement;

    #[ORM\Column(type: 'string', length: 100)]
    private $materiel;

    #[ORM\Column(type: 'string', length: 100)]
    private $quantite;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $remarque;

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

    public function getMouvement(): ?string
    {
        return $this->mouvement;
    }

    public function setMouvement(string $mouvement): self
    {
        $this->mouvement = $mouvement;

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

    public function getQuantite(): ?string
    {
        return $this->quantite;
    }

    public function setQuantite(string $quantite): self
    {
        $this->quantite = $quantite;

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
}
