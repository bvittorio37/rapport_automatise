<?php

namespace App\Entity;

use App\Repository\RapportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RapportRepository::class)]
class Rapport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 15)]
    private $numeroVol;

    #[ORM\Column(type: 'datetime')]
    private $dateRapport;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $dateArrive;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $datePrevue;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $dateDepart;

    #[ORM\Column(type: 'text', nullable: true)]
    private $remarque;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'rapports')]
    #[ORM\JoinColumn(nullable: false)]
    private $utilisateur;

    #[ORM\ManyToOne(targetEntity: TypeRapport::class, inversedBy: 'rapports')]
    #[ORM\JoinColumn(nullable: false)]
    private $typeRapport;

    #[ORM\OneToMany(mappedBy: 'rapport', targetEntity: VisaParRapport::class)]
    private $visaParRapports;

    public function __construct()
    {
        $this->visaParRapports = new ArrayCollection();
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

    public function getDateRapport(): ?\DateTimeInterface
    {
        return $this->dateRapport;
    }

    public function setDateRapport(\DateTimeInterface $dateRapport): self
    {
        $this->dateRapport = $dateRapport;

        return $this;
    }

    public function getDateArrive(): ?\DateTimeInterface
    {
        return $this->dateArrive;
    }

    public function setDateArrive(?\DateTimeInterface $dateArrive): self
    {
        $this->dateArrive = $dateArrive;

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

    public function getDateDepart(): ?\DateTimeInterface
    {
        return $this->dateDepart;
    }

    public function setDateDepart(?\DateTimeInterface $dateDepart): self
    {
        $this->dateDepart = $dateDepart;

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
            $this->visaParRapports[] = $visaParRapport;
            $visaParRapport->setRapport($this);
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

   

}
