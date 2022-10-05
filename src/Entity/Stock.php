<?php

namespace App\Entity;

use App\Repository\StockRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StockRepository::class)]
class Stock
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Materiel::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $materiel;

    #[ORM\ManyToOne(targetEntity: TypeStock::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $typeStock;

    #[ORM\Column(type: 'datetime')]
    private $dateStock;



    #[ORM\Column(type: 'integer', nullable: true)]
    private $entree;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $sortie;

 
    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private $intitule;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $debutSerie;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $finSerie;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $dispo;

    #[ORM\Column(type: 'string', nullable: true)]
    private $reference;

    private $options;

    #[ORM\Column(type: 'string', nullable: true)]
    private $numBobine;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $dateIndispo;

    public function getId(): ?int
    {
        return $this->id;
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


    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(string $intitule): self
    {
        $this->intitule = $intitule;

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

    public function isDispo(): ?bool
    {
        return $this->dispo;
    }

    public function setDispo(?bool $dispo): self
    {
        $this->dispo = $dispo;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

   
    public function getOptions(): ?array
    {
        return $this->options;
       
    }

    public function setOptions(?array $options): self
    {
        $this->options= $options;
        return $this;
    }

    public function getNumBobine(): ?int
    {
        return $this->numBobine;
    }

    public function setNumBobine(?int $numBobine): self
    {
        $this->numBobine = $numBobine;

        return $this;
    }

    public function getDateIndispo(): ?\DateTimeInterface
    {
        return $this->dateIndispo;
    }

    public function setDateIndispo(?\DateTimeInterface $dateIndispo): self
    {
        $this->dateIndispo = $dateIndispo;

        return $this;
    }                          
}
