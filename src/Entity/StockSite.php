<?php

namespace App\Entity;

use App\Repository\RapportStockRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RapportStockRepository::class)]
class StockSite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: rapport::class)]
    #[ORM\JoinColumn(nullable: true)]
    private $rapport;

    #[ORM\ManyToOne(targetEntity: Materiel::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $materiel;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $consommation;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $abimmees;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $cause;

    #[ORM\ManyToOne(targetEntity: Paf::class)]
    #[ORM\JoinColumn(nullable: true)]
    private $paf;

    #[ORM\Column(type: 'datetime')]
    private $dateStock;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $debutSerie;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $finSerie;

    #[ORM\ManyToOne(targetEntity: Site::class, inversedBy: 'stockSites')]
    private $site;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $entree;

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
        $this->materiel = $materiel;

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

    public function getDateStock(): ?\DateTimeInterface
    {
        return $this->dateStock;
    }

    public function setDateStock(\DateTimeInterface $dateStock): self
    {
        $this->dateStock = $dateStock;

        return $this;
    }

    public function getDebutSerie(): ?int
    {
        return $this->debutSerie;
    }

    public function setDebutSerie(?int $debutSerie): self
    {
        $this->debutSerie = $debutSerie;

        return $this;
    }

    public function getFinSerie(): ?int
    {
        return $this->finSerie;
    }

    public function setFinSerie(?int $finSerie): self
    {
        $this->finSerie = $finSerie;

        return $this;
    }

    public function getSite(): ?Site
    {
        return $this->site;
    }

    public function setSite(?Site $site): self
    {
        $this->site = $site;

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
}
