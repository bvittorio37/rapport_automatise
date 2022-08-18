<?php

namespace App\Entity;

use App\Repository\StockRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StockRepository::class)]
class Stock
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Consommable::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $consommable;

    #[ORM\ManyToOne(targetEntity: typeStock::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $typeStock;

    #[ORM\Column(type: 'datetime')]
    private $dateStock;



    #[ORM\Column(type: 'integer', nullable: true)]
    private $entree;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $sortie;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConsommable(): ?Consommable
    {
        return $this->consommable;
    }

    public function setConsommable(?Consommable $consommable): self
    {
        $this->consommable = $consommable;

        return $this;
    }

    public function getTypeStock(): ?typeStock
    {
        return $this->typeStock;
    }

    public function setTypeStock(?typeStock $typeStock): self
    {
        $this->typeStock = $typeStock;

        return $this;
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



    public function getEntree(): ?int
    {
        return $this->entree;
    }

    public function setEntree(?int $entree): self
    {
        $this->entree = $entree;

        return $this;
    }

    public function getSortie(): ?int
    {
        return $this->sortie;
    }

    public function setSortie(?int $sortie): self
    {
        $this->sortie = $sortie;
        
        return $this;
    }
}
