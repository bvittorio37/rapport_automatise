<?php

namespace App\Entity;

use App\Repository\RapportStockRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RapportStockRepository::class)]
class RapportStock
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: rapport::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $rapport;

    #[ORM\ManyToOne(targetEntity: Materiel::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $materiel;

    #[ORM\Column(type: 'integer')]
    private $consommation;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $abimmees;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $cause;

    #[ORM\ManyToOne(targetEntity: paf::class)]
    #[ORM\JoinColumn(nullable: true)]
    private $paf;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRapport(): ?rapport
    {
        return $this->rapport;
    }

    public function setRapport(?rapport $rapport): self
    {
        $this->rapport = $rapport;

        return $this;
    }

    public function getMateriel(): ?Materiel
    {
        return $this->materiel;
    }

    public function setmateriel(?Materiel $materiel): self
    {
        $this->matriel = $materiel;

        return $this;
    }

    public function getConsommation(): ?int
    {
        return $this->consommation;
    }

    public function setConsommation(int $consommation): self
    {
        $this->consommation = $consommation;

        return $this;
    }

    public function getAbimmees(): ?int
    {
        return $this->abimmees;
    }

    public function setAbimmees(?int $abimmees): self
    {
        $this->abimmees = $abimmees;

        return $this;
    }

    public function getCause(): ?string
    {
        return $this->cause;
    }

    public function setCause(?string $cause): self
    {
        $this->cause = $cause;

        return $this;
    }

    public function getPaf(): ?paf
    {
        return $this->paf;
    }

    public function setPaf(?paf $paf): self
    {
        $this->paf = $paf;

        return $this;
    }
}
