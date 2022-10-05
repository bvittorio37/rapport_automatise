<?php

namespace App\Entity;

use App\Repository\VisaParRapportRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VisaParRapportRepository::class)]
class VisaParRapport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: rapport::class, inversedBy: 'visaParRapports', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private $rapport;

    #[ORM\ManyToOne(targetEntity: Visa::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $visa;

    #[ORM\Column(type: 'integer')]
    private $nombre;

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

    public function getVisa(): ?visa
    {
        return $this->visa;
    }

    public function setVisa(?visa $visa): self
    {
        $this->visa = $visa;

        return $this;
    }

    public function getNombre(): ?int
    {
        return $this->nombre;
    }

    public function setNombre(int $nombre): self
    {
        $this->nombre = $nombre;
        return $this;
    }
    
}
