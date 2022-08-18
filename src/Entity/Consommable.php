<?php

namespace App\Entity;

use App\Repository\ConsommableRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConsommableRepository::class)]
class Consommable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 30)]
    private $consommable;

    #[ORM\ManyToOne(targetEntity: Unite::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $unite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConsommable(): ?string
    {
        return $this->consommable;
    }

    public function setConsommable(string $consommable): self
    {
        $this->consommable = $consommable;

        return $this;
    }

    public function getUnite(): ?Unite
    {
        return $this->unite;
    }

    public function setUnite(?Unite $unite): self
    {
        $this->unite = $unite;

        return $this;
    }
}
