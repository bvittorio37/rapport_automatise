<?php

namespace App\Entity;

use App\Repository\HistoriqueAffectationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HistoriqueAffectationRepository::class)]
class HistoriqueAffectation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private $nom;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private $prenom;

    #[ORM\Column(type: 'string', length: 30, nullable: true)]
    private $ancienSite;

    #[ORM\Column(type: 'string', length: 30)]
    private $siteAffectation;

    #[ORM\Column(type: 'datetime')]
    private $dateAffectation;

    #[ORM\Column(type: 'boolean')]
    private $isCourant;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAncienSite(): ?string
    {
        return $this->ancienSite;
    }

    public function setAncienSite(?string $ancienSite): self
    {
        $this->ancienSite = $ancienSite;

        return $this;
    }

    public function getSiteAffectation(): ?string
    {
        return $this->siteAffectation;
    }

    public function setSiteAffectation(string $siteAffectation): self
    {
        $this->siteAffectation = $siteAffectation;

        return $this;
    }


    public function getDateAffectation(): ?\DateTimeInterface
    {
        return $this->dateAffectation;
    }

    public function setDateAffectation(\DateTimeInterface $dateAffectation): self
    {
        $this->dateAffectation = $dateAffectation;

        return $this;
        
    }

    public function isIsCourant(): ?bool
    {
        return $this->isCourant;
    }

    public function setIsCourant(bool $isCourant): self
    {
        $this->isCourant = $isCourant;

        return $this;
    }
}
