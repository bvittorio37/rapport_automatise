<?php

namespace App\Entity;

use App\Repository\RapportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RapportRepository::class)]
class Rapport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private $numeroVol;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $datePrevue;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $dateVol;

    #[ORM\Column(type: 'text', nullable: true)]
    private $remarque;

    
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'rapports')]
    #[ORM\JoinColumn(nullable: false)]
    private $utilisateur;

    #[ORM\ManyToOne(targetEntity: TypeRapport::class, inversedBy: 'rapports')]
    #[ORM\JoinColumn(nullable: false)]
    private $typeRapport;

    #[ORM\OneToMany(mappedBy: 'rapport', targetEntity: VisaParRapport::class, cascade: ['persist'])]
    private $visaParRapports;

    #[ORM\OneToMany(mappedBy: 'rapport', targetEntity: StockSite::class, cascade: ['persist'])]
    private $stockSites;
    
    #[ORM\Column(type: 'datetime')]
    private $debutService;

    #[ORM\Column(type: 'datetime')]
    private $finService;

    #[ORM\Column(type: 'string', length: 150, nullable: true)]
    private $nomPdf;

    #[Assert\NotNull(['message'=> 'Vous de vevez choisir une site'])]
    #[ORM\ManyToOne(targetEntity: Site::class, inversedBy: 'rapports')]
    #[ORM\JoinColumn(nullable: false)]
    private $site;

    public function __construct()
    {
        $this->visaParRapports = new ArrayCollection();
        $this->stockSites= new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroVol(): ?string
    {
        return $this->numeroVol;
    }

    public function setNumeroVol(string $numeroVol): self
    {
        $this->numeroVol = $numeroVol;

        return $this;
    }


    public function getDatePrevue(): ?\DateTimeInterface
    {
        return $this->datePrevue;
    }

    public function setDatePrevue(?\DateTimeInterface $datePrevue): self
    {
        $this->datePrevue = $datePrevue;

        return $this;
    }

    public function getDateVol(): ?\DateTimeInterface
    {
        return $this->dateVol;
    }

    public function setDateVol(?\DateTimeInterface $dateVol): self
    {
        $this->dateVol = $dateVol;

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

    public function getUtilisateur(): ?User
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?User $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getTypeRapport(): ?typeRapport
    {
        return $this->typeRapport;
    }

    public function setTypeRapport(?typeRapport $typeRapport): self
    {
        $this->typeRapport = $typeRapport;

        return $this;
    }

    /**
     * @return Collection<int, VisaParRapport>
     */
    public function getVisaParRapports(): Collection
    {
        return $this->visaParRapports;
    }

    public function addVisaParRapport(VisaParRapport $visaParRapport): self
    {
        if (!$this->visaParRapports->contains($visaParRapport)) {
            $visaParRapport->setRapport($this);
            $this->visaParRapports[] = $visaParRapport;
            
        }

        return $this;
    }

    public function removeVisaParRapport(VisaParRapport $visaParRapport): self
    {
        if ($this->visaParRapports->removeElement($visaParRapport)) {
            // set the owning side to null (unless already changed)
            if ($visaParRapport->getRapport() === $this) {
                $visaParRapport->setRapport(null);
            }
        }

        return $this;
    }
    /**
     * @return Collection<int, StockSite>
     */
    public function getStockSites(): Collection
    {
        return $this->stockSites;
    }

    public function addStockSite( StockSite $stockSite): self
    {
        if (!$this->stockSites->contains($stockSite)) {
            $stockSite->setRapport($this);
            $this->stockSites[] = $stockSite;
            
        }

        return $this;
    }

    public function removeStockSite(StockSite $stockSite): self
    {
        if ($this->stockSites->removeElement($stockSite)) {
            // set the owning side to null (unless already changed)
            if ($stockSite->getRapport() === $this) {
                $stockSite->setRapport(null);
            }
        }

        return $this;
    }

    public function getDebutService(): ?\DateTimeInterface
    {
        return $this->debutService;
    }

    public function setDebutService(\DateTimeInterface $debutService): self
    {
        $this->debutService = $debutService;

        return $this;
    }

    public function getFinService(): ?\DateTimeInterface
    {
        return $this->finService;
    }

    public function setFinService(\DateTimeInterface $finService): self
    {
        $this->finService = $finService;

        return $this;
    }

    public function getNomPdf(): ?string
    {
        return $this->nomPdf;
    }

    public function setNomPdf(?string $nomPdf): self
    {
        $this->nomPdf = $nomPdf;

        return $this;
    }
    public function getDateRapport(): ?\DateTimeInterface
    {
        return $this->debutService;
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

   

}
