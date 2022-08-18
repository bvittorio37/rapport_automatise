<?php

namespace App\Entity;

use App\Repository\PafRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PafRepository::class)]
class Paf
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 6)]
    private $paf;

    #[ORM\ManyToOne(targetEntity: site::class, inversedBy: 'pafs')]
    #[ORM\JoinColumn(nullable: false)]
    private $site;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPaf(): ?string
    {
        return $this->paf;
    }

    public function setPaf(string $paf): self
    {
        $this->paf = $paf;

        return $this;
    }

    public function getSite(): ?site
    {
        return $this->site;
    }

    public function setSite(?site $site): self
    {
        $this->site = $site;

        return $this;
    }
}
