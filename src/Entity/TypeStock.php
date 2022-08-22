<?php

namespace App\Entity;

use App\Repository\TypeStockRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeStockRepository::class)]
class TypeStock
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 7)]
    private $typeStock;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeStock(): ?string
    {
        return $this->typeStock;
    }

    public function setTypeStock(string $typeStock): self
    {
        $this->typeStock = $typeStock;

        return $this;
    }
    public function __toString()
    {
        return $this->typeStock;
    }
}
